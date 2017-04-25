<?
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "sendMailAboutNewSailerRequest");

/**
 * 
 * �������� ������ � ���, ��� ������ ����� ������ �� ��������
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
 * ����������� ������ "�� ������������" ��� ������ � ��������
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
 * �������� ������ � ���, ��� ������ ����� ����� �� ��������
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
 * ���������, ��� � �������. ���� ���-�� �� ���, �� ������� ��, �.�. � ������� �� ����� ���� ������ ������� ����
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
				|| ($basket_type == "product" && $iblock_element['IBLOCK_ID'] == BONUS_CATALOG_IBLOCK_ID) // � ������� ������, � �������� �������� �����
				|| ($basket_type == "bonus" && ($iblock_element['IBLOCK_ID'] == CATALOG_IBLOCK_ID || $iblock_element['IBLOCK_ID'] == SKU_CATALOG_IBLOCK_ID)) // � ������� �����, � �������� �������� �����
			) {
				// ���� � ������� �����-�� ������� ��������� ������ ������, �� �������
				CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
			}
		}
	}
}

//AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "addPointsForSaler");

/**
 * 
 * ��������� ����� ��������, ���� ��� ������� ������������
 * 
 * @param array $fields
 * @return void
 * */
function addPointsForSaler($fields) {
	if ($fields['IBLOCK_ID'] == SALERS_REPORTS_IBLOCK_ID) {
		$product_id = "";
		$status_id = "";
		$new_status_value = $fields['PROPERTY_VALUES'][SALER_REPORT_STATUS_PROPERTY_ID][0]['VALUE'];
		// ��� ���������� ������ ��������� �������, ��������� ��� ������� ��������
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
		// �������, ���������� �� ���
		if ($status_id != $new_status_value) {
			// ���� ����������, �� ������� �� ���������� �� ������ "������"
			if ($new_status_value == SALER_REPORT_STATUS_ACCEPTED_ID) {
				// ��������� ���� �����
				// �������� ���-�� ������ ��� ������
				$item_cost = getProductPointCost($product_id, $user_id);
				// ��������� ���������� ����
				updateUserAccountPoints($user_id, $item_cost);
				// ��������� ����� ����
				updateUserTotalPoints($user_id, $item_cost);
				// ��������� ������� ������������
				checkUserLvl($user_id);
			}
		}
	}	
}

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "removePointsForSaler");

/**
 * 
 * ��������� ����� ��������, ���� ��� ������� ���������. 
 * ���� ����� ������ ������� ���������� ����� �������������, �� ����� ����� ������� ������ �������,
 * ������������ � addPointsForSaler
 * 
 * @param array $fields
 * @return void
 * */
function removePointsForSaler($fields) {
	if ($fields['IBLOCK_ID'] == SALERS_REPORTS_IBLOCK_ID) {
		$product_id = "";
		$status_id = "";
		$new_status_value = $fields['PROPERTY_VALUES'][SALER_REPORT_STATUS_PROPERTY_ID][0]['VALUE'];
		// ��� ���������� ������ ��������� �������, ��������� ��� ������� ��������
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
		// �������, ���������� �� ���
		if ($status_id != $new_status_value) {
			// ���� ����������, �� ������� �� ���������� �� ������ "���������"
			if ($new_status_value == SALER_REPORT_STATUS_DENIED_ID) {
				// ��������� ���� �����
				// �������� ���-�� ������ ��� ������
				$item_cost = getProductPointCost($product_id, $user_id) * -1;
				// ��������� ���������� ����
				updateUserAccountPoints($user_id, $item_cost);
				// ��������� ����� ����
				updateUserTotalPoints($user_id, $item_cost);
				// ��������� ������� ������������
				checkUserLvl($user_id);
			}
		}
	}	
}

/**
 * 
 * ��������� ����� ��������, ���� ��� ������� ������������
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

	// ��������� ���� �����
	// �������� ���-�� ������ ��� ������
	$item_cost = getProductPointCost($product_id, $user_id);
	// ��������� ���������� ����
	updateUserAccountPoints($user_id, $item_cost);
	// ��������� ����� ����
	updateUserTotalPoints($user_id, $item_cost);
	// ��������� ������� ������������
	checkUserLvl($user_id);
}

AddEventHandler("main", "OnBeforeUserUpdate", "createUserBill");

/**
 * 
 * ������� ���������� ���� ������������ ��� ���������� ��� � ������ ���������
 * 
 * @param array $fields
 * @return void
 * */
function createUserBill(&$fields) {
	$groups_ids = array();
	$new_groups_ids = array();
	// ������� ������� ������ ������������
	$user_groups = CUser::GetUserGroupList($fields["ID"]);
	while ($user_group = $user_groups->Fetch()){
	   array_push($groups_ids, $user_group['GROUP_ID']);
	}
	// ������� ����� id �����
	foreach ($fields['GROUP_ID'] as $group) {
		array_push($new_groups_ids, $group['GROUP_ID']);
	}
	// ���� ������������ �������� �������� � ������ ���������, �� �������� ����
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
* �������� ������ ��� ����������� ������������
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
* ��������� ����� ������ ��� �������� ������ ������
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
        $arFields["DELIVERY"] = "�������� ��������";
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