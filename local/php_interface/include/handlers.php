<?
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "sendMailAboutNewSailerRequest");

/**
 * 
 * ѕосылаем письмо о том, что пришла нова€ за€вка на продавца
 * 
 * @param array $fields
 * @return void
 * */
function sendMailAboutNewSailerRequest(&$fields) {
    if ($fields["IBLOCK_ID"] == SALERS_REQUESTS_IBLOCK_ID) {
		$data = array(
			"ID"   => $fields['ID'],
			"NAME" => $fields['NAME']
		);
        CEvent::Send(NEW_SALER_REQUEST_EVENT_TYPE, "s1", $data, "N", NEW_SALER_REQUEST_TEMPLATE_ID);
    }
}

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "setDefaultStatusToSalerReport");

/**
 * 
 * ѕроставл€ем статус "на рассмотрении" дл€ отчета о продажах
 * 
 * @param array $fields
 * @return void
 * */
function setDefaultStatusToSalerReport(&$fields) {
    if ($fields["IBLOCK_ID"] == SALERS_REPORTS_IBLOCK_ID) {
		CIBlockElement::SetPropertyValuesEx($fields['ID'], false, array(SALER_REPORT_STATUS_PROPERTY_ID => SALER_REPORT_STATUS_UNDER_CONSIDERATION_ID));
    }
}

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "sendMailAboutNewSailerReport");

/**
 * 
 * ѕосылаем письмо о том, что пришел новый отчет от продавца
 * 
 * @param array $fields
 * @return void
 * */
function sendMailAboutNewSailerReport(&$fields) {
    if ($fields["IBLOCK_ID"] == SALERS_REPORTS_IBLOCK_ID) {
		$data = array(
			"ID"   => $fields['ID'],
			"NAME" => $fields['NAME']
		);
        CEvent::Send(NEW_SALER_REPORT_EVENT_TYPE, "s1", $data, "N", NEW_SALER_REPORT_TEMPLATE_ID);
    }
}

AddEventHandler("sale", "OnBeforeBasketAdd", "checkBasket");

/**
 * 
 * ѕровер€ем, что в корзине. ≈сли что-то не так, то очищаем ее, т.к. в корзине не могут быть товары разного типа
 * 
 * @param array $fields
 * @return void
 * */
function checkBasket(&$fields) {
	if ($fields['PRODUCT_ID']) {
		$iblock_elements = CIBlockElement::GetList(
			Array(),
			Array(
				"ID" => $fields['PRODUCT_ID']
			), 
			false, 
			false,
			array("IBLOCK_ID")
		);
		if ($iblock_element = $iblock_elements->Fetch()) {
			$basket_type = getBasketType();
			if (
				$basket_type == "mixed"
				|| ($basket_type == "product" && $iblock_element['IBLOCK_ID'] == BONUS_CATALOG_IBLOCK_ID) // в корзине товары, а пытаютс€ положить бонус
				|| ($basket_type == "bonus" && ($iblock_element['IBLOCK_ID'] == CATALOG_IBLOCK_ID || $iblock_element['IBLOCK_ID'] == SKU_CATALOG_IBLOCK_ID)) // в корзине бонус, а пытаютс€ положить товар
			) {
				// если в корзине каким-то образом оказались разные товары, то очищаем
				CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
			}
		}
	}
}

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "addPointsForSaler");

/**
 * 
 * «ачисл€ем баллы продавцу, если его продажа подтверждена
 * 
 * @param array $fields
 * @return void
 * */
function addPointsForSaler(&$fields) {
	if ($fields['IBLOCK_ID'] == SALERS_REPORTS_IBLOCK_ID) {
		$product_id = "";
		$status_id = "";
		$new_status_value = $fields['PROPERTY_VALUES'][SALER_REPORT_STATUS_PROPERTY_ID][0]['VALUE'];
		// нас интересует только изменение статуса, посмотрим его текущее значение
		$reports = CIBlockElement::GetList(
			Array(),
			Array(
				"ID"        => $fields['ID'],
				"IBLOCK_ID" => SALERS_REPORTS_IBLOCK_ID
			), 
			false, 
			false,
			array("ID", "CREATED_BY", "PROPERTY_status", "PROPERTY_product")
		);
		if ($report = $reports->Fetch()) {
			$user_id = $report['CREATED_BY'];
			$product_id = $report['PROPERTY_PRODUCT_VALUE'];
			$status_id = $report['PROPERTY_STATUS_ENUM_ID'];
		}
		// смотрим, изменилось ли оно
		if ($status_id != $new_status_value) {
			// если изменилось, то смотрим не проставили ли статус "ѕрин€т"
			if ($new_status_value == SALER_REPORT_STATUS_ACCEPTED_ID) {
				// обновл€ем счет юзера
				// получаем кол-во баллов дл€ товара
				$item_cost = getProductPointCost($product_id);
				// обновл€ем внутренний счет
				updateUserAccountPoints($user_id, $item_cost);
				// обновл€ем общий счет
				updateUserTotalPoints($user_id, $item_cost);
				// провер€ем уровень пользовател€
				checkUserLvl($user_id);
			}
		}
	}	
}
?>