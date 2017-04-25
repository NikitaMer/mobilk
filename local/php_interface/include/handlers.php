<?
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "sendMailAboutNewSailerRequest");

/**
 * 
 * Посылаем письмо о том, что пришла новая заявка на продавца
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
 * Проставляем статус "на рассмотрении" для отчета о продажах
 * 
 * @param array $fields
 * @return void
 * */
function setDefaultStatusToSalerReport(&$fields) {
    if ($fields["IBLOCK_ID"] == SALERS_REPORTS_IBLOCK_ID) {
		CIBlockElement::SetPropertyValuesEx($fields['ID'], false, array(SALER_REPORT_STATUS_PROPERTY_ID => SALER_REPORT_STATUS_ACCEPTED_ID));
		addPointsForSalerWithoutEvent($fields);
    }
}

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "sendMailAboutNewSailerReport");

/**
 * 
 * Посылаем письмо о том, что пришел новый отчет от продавца
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
 * Проверяем, что в корзине. Если что-то не так, то очищаем ее, т.к. в корзине не могут быть товары разного типа
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
				|| ($basket_type == "product" && $iblock_element['IBLOCK_ID'] == BONUS_CATALOG_IBLOCK_ID) // в корзине товары, а пытаются положить бонус
				|| ($basket_type == "bonus" && ($iblock_element['IBLOCK_ID'] == CATALOG_IBLOCK_ID || $iblock_element['IBLOCK_ID'] == SKU_CATALOG_IBLOCK_ID)) // в корзине бонус, а пытаются положить товар
			) {
				// если в корзине каким-то образом оказались разные товары, то очищаем
				CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
			}
		}
	}
}

//AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "addPointsForSaler");

/**
 * 
 * Зачисляем баллы продавцу, если его продажа подтверждена
 * 
 * @param array $fields
 * @return void
 * */
function addPointsForSaler($fields) {
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
			// если изменилось, то смотрим не проставили ли статус "Принят"
			if ($new_status_value == SALER_REPORT_STATUS_ACCEPTED_ID) {
				// обновляем счет юзера
				// получаем кол-во баллов для товара
				$item_cost = getProductPointCost($product_id, $user_id);
				// обновляем внутренний счет
				updateUserAccountPoints($user_id, $item_cost);
				// обновляем общий счет
				updateUserTotalPoints($user_id, $item_cost);
				// проверяем уровень пользователя
				checkUserLvl($user_id);
			}
		}
	}	
}

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "removePointsForSaler");

/**
 * 
 * Списываем баллы продавцу, если его продажа отклонена. 
 * Если будет решено вернуть начисление после подтверждения, то нужно будет сделать единый хендлер,
 * объединенный с addPointsForSaler
 * 
 * @param array $fields
 * @return void
 * */
function removePointsForSaler($fields) {
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
			// если изменилось, то смотрим не проставили ли статус "Отклонено"
			if ($new_status_value == SALER_REPORT_STATUS_DENIED_ID) {
				// обновляем счет юзера
				// получаем кол-во баллов для товара
				$item_cost = getProductPointCost($product_id, $user_id) * -1;
				// обновляем внутренний счет
				updateUserAccountPoints($user_id, $item_cost);
				// обновляем общий счет
				updateUserTotalPoints($user_id, $item_cost);
				// проверяем уровень пользователя
				checkUserLvl($user_id);
			}
		}
	}	
}

/**
 * 
 * Зачисляем баллы продавцу, если его продажа подтверждена
 * 
 * @param array $fields
 * @return void
 * */
function addPointsForSalerWithoutEvent($fields) {
	$product_id = "";
	$reports = CIBlockElement::GetList(
		Array(),
		Array(
			"ID"        => $fields['ID'],
			"IBLOCK_ID" => SALERS_REPORTS_IBLOCK_ID
		), 
		false, 
		false,
		array("ID", "CREATED_BY",  "PROPERTY_product")
	);
	if ($report = $reports->Fetch()) {
		$user_id = $report['CREATED_BY'];
		$product_id = $report['PROPERTY_PRODUCT_VALUE'];
	}

	// обновляем счет юзера
	// получаем кол-во баллов для товара
	$item_cost = getProductPointCost($product_id, $user_id);
	// обновляем внутренний счет
	updateUserAccountPoints($user_id, $item_cost);
	// обновляем общий счет
	updateUserTotalPoints($user_id, $item_cost);
	// проверяем уровень пользователя
	checkUserLvl($user_id);
}

AddEventHandler("main", "OnBeforeUserUpdate", "createUserBill");

/**
 * 
 * Создаем внутренний счет пользователя при добавлении его в группу продавцов
 * 
 * @param array $fields
 * @return void
 * */
function createUserBill(&$fields) {
	$groups_ids = array();
	$new_groups_ids = array();
	// получим текущие группы пользователя
	$user_groups = CUser::GetUserGroupList($fields["ID"]);
	while ($user_group = $user_groups->Fetch()){
	   array_push($groups_ids, $user_group['GROUP_ID']);
	}
	// соберем новые id групп
	foreach ($fields['GROUP_ID'] as $group) {
		array_push($new_groups_ids, $group['GROUP_ID']);
	}
	// если пользователя пытаются добавить в группу продавцов, то создадим счет
	if (!in_array(SALERS_GROUP_ID, $groups_ids) && in_array(SALERS_GROUP_ID, $new_groups_ids)) {
		CSaleUserAccount::Add(
			array(
				"USER_ID"        => $fields['ID'],
				"CURRENCY"       => "RUB",
				"CURRENT_BUDGET" => 0
			)
		); 
	}
}

AddEventHandler("main", "OnAfterUserRegister", "changeMailRegistration");

/**
* Отправка письма при регистрации пользователя
* 
* @param array $arFields
* @return void
*/
function changeMailRegistration(&$arFields){
    $EVENT_TYPE = 'NEW_USER_CONFIRM_WITH_PASS';
    $arMailFields = array(
        'LOGIN' => $arFields['LOGIN'],
        'ID' => $arFields['USER_ID'],
        'NAME' => $arFields['NAME'],
        'LAST_NAME' => $arFields['LAST_NAME'],
        'PASSWORD' => $arFields['PASSWORD'],
        'SERVER_NAME' => $_SERVER['HTTP_HOST'],
        'CONFIRM_CODE' => $arFields['CONFIRM_CODE'],
        'EMAIL' => $arFields['EMAIL']
    );
    CEvent::Send($EVENT_TYPE, $arFields['LID'], $arMailFields);
}

AddEventHandler("sale", "OnOrderNewSendEmail", "changeMailOrder");

/**
* Изменение полей письма при создании нового заказа
* 
* @param array $arFields
* @param string $eventName
* @param integer $orderID
* @return void
*/
function changeMailOrder($orderID, &$eventName, &$arFields){
    $arOrder = CSaleOrder::GetByID($orderID);
    $arSystem = CSalePaySystem::GetByID($arOrder['PAY_SYSTEM_ID']);
    $order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
    $delivery = CSaleDelivery::GetByID($arOrder['DELIVERY_ID']);
    $arFields["PHONE"]="";
    $arFields["COUNTRY_NAME_ORIG"] = ""; 
    $arFields["ZIP"] = "";
    $arFields["ADDRESS"] = "";  
    $arFields["CITY_NAME_ORIG"] = "";
    while ($arProps = $order_props->Fetch())
    {
        if ($arProps["CODE"] == "PHONE")
        {
           $arFields["PHONE"] = htmlspecialchars($arProps["VALUE"]);
        }
        if ($arProps["CODE"] == "LOCATION")
        {
            $arLocs = CSaleLocation::GetByID($arProps["VALUE"]);
            $arFields["COUNTRY_NAME_ORIG"] =  $arLocs["COUNTRY_NAME_ORIG"];
            $arFields["CITY_NAME_ORIG"] = $arLocs["CITY_NAME_ORIG"];
        }

        if ($arProps["CODE"] == "ZIP")
        {
          $arFields["ZIP"] = $arProps["VALUE"];   
        }

        if ($arProps["CODE"] == "ADDRESS")
        {
          $arFields["ADDRESS"] = $arProps["VALUE"];
        }           
    }
    $arFields["PRICE_DELIVERY"] = $arOrder["PRICE_DELIVERY"];       
    $arFields["PAY_SISTEM_NAME"] = $arSystem["NAME"];
    if($delivery["NAME"]){
        $arFields["DELIVERY"] =  $delivery["NAME"];
    }else{
        $arFields["DELIVERY"] = "Доставка курьером";
    }
    $dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC","ID" => "ASC"), array("LID" => SITE_ID, "ORDER_ID" => $orderID));
    while ($arItems = $dbBasketItems->Fetch())
    {
        $arFields["ALL_PRICE"] = $arFields["ALL_PRICE"]+($arItems["BASE_PRICE"]*$arItems["QUANTITY"]);              
        
    }    
    $arFields["DISCOUNT_VALUE"] = (($arFields["ALL_PRICE"]-($arOrder["PRICE"]-$arFields["PRICE_DELIVERY"]))/$arFields["ALL_PRICE"])*100;
    $arFields["DISCOUNT_VALUE"] = $arFields["DISCOUNT_VALUE"]."%";    
    $arFields["ORDER_ACCOUNT_NUMBER_ENCODE"] = '<a href="http://'.$_SERVER["HTTP_HOST"].'/personal/order/detail/'.$orderID.'/">http://'.$_SERVER["HTTP_HOST"].'/personal/order/detail/'.$orderID.'/</a>';    
}
?>