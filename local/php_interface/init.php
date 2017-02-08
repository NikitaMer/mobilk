<?
// ����������� lang �����
include(GetLangFileName(dirname(__FILE__) . "/", "/init.php"));
// ����������� �������� � ���������� �������
if (file_exists(dirname(__FILE__) . "/include/constants.php")) { require_once(dirname(__FILE__) . "/include/constants.php"); } else { trigger_error(GetMessage("CONSTANTS_FILE_MISSED"), E_USER_ERROR); };
if (file_exists(dirname(__FILE__) . "/include/debug.php")) { require_once(dirname(__FILE__) . "/include/debug.php"); } else { trigger_error(GetMessage("DEBUG_FILE_MISSED"), E_USER_ERROR); };
if (file_exists(dirname(__FILE__) . "/include/handlers.php")) { require_once(dirname(__FILE__) . "/include/handlers.php"); } else { trigger_error(GetMessage("HANDLERS_FILE_MISSED"), E_USER_ERROR); };


/**
 * 
 * ���������, ����������� �� ������������ � ������ ���������
 * 
 * @return bool
 * */
function isUserSaler() {
	global $USER;
	if ($USER->IsAuthorized() && CSite::InGroup(array(SALERS_GROUP_ID))) {
		return true;
	}
}

/**
 * 
 * ���������, ����� �� ������������ ������ ����������� ��������
 * 
 * @return bool
 * */
function isUserHaveSilverStatus() {
	global $USER;
	// ��� ������ ������ CSite ����������, �.�. ����� � 2 id � ������� �������� �� �������� ���
	if ($USER->IsAuthorized() && CSite::InGroup(array(SALERS_GROUP_ID)) && CSite::InGroup(array(SILVER_SALER_GROUP_ID))) {
		return true;
	}
}

/**
 * 
 * ���������, ����� �� ������������ ������ �������� ��������
 * 
 * @return bool
 * */
function isUserHaveGoldenStatus() {
	global $USER;
	// ��� ������ ������ CSite ����������, �.�. ����� � 2 id � ������� �������� �� �������� ���
	if ($USER->IsAuthorized() && CSite::InGroup(array(SALERS_GROUP_ID)) && CSite::InGroup(array(GOLDEN_SALER_GROUP_ID))) {
		return true;
	}
}

/**
 * 
 * ���������, ���� �� � ������������ �������� ������ �� ��������
 * 
 * @return bool
 * */
function isUserHaveActiveRequests() {
	global $USER;
	$requests = CIBlockElement::GetList(
		Array(),
		Array(
			"IBLOCK_ID"  => SALERS_REQUESTS_IBLOCK_ID,
			"ACTIVE"     => "Y",
			"CREATED_BY" => $USER->GetID()
		), 
		false, 
		Array(
			"nPageSize" => 1
		),
		array("ID")
	);
	if ($request = $requests->Fetch()) {
		return true;
	}
}

/**
*
* @param int $photo_id
* @param int $width
* @param int $height
* @param string $type
* @param int $quantity
* @return string $src
*
* */
function getResizedImage($photo_id, $width, $height, $type, $quantity) {
    $file_path = CFile::GetPath($photo_id);
    if ($file_path && (int)$width && (int)$height && strval($width)) {
        $preview_img_file = CFile::ResizeImageGet($photo_id, array('width' => $width, 'height' => $height), $type, true, false, false, $quantity);
        return $preview_img_file['src'];
    }
}

/**
 * 
 * ���������, �������� �� ������� �������� �������
 * 
 * @param int $iblock_id
 * @return bool
 * */
function isItBonusProduct($iblock_id) {
	return $iblock_id == BONUS_CATALOG_IBLOCK_ID;
}

/**
 * 
 * �������� ���������� ������ � ������������
 * 
 * @param int $user_id
 * @return int $balance
 * */
function getUserPoints($user_id) {
	$user_balance = CSaleUserAccount::GetByUserID($user_id, "RUB");
	$balance = (int)$user_balance['CURRENT_BUDGET'];
	return $balance;
}

/**
 * 
 * �������� ��� �������
 * ��������� ��������:
 * - product - ������ ������ �� ������
 * - bonus - ������ ������ �� �����
 * - mixed - ������ ������ ���������
 * - empty - ������
 * 
 * @return string $type
 * 
 * */
function getBasketType() {
	// �������� ������ � ������� ��� �������� ������������
	$type = "empty";
	$products_ids = array();
	$basket_products = CSaleBasket::GetList(
		array(
			"ID" => "ASC"
		),
		array(
			"FUSER_ID" => CSaleBasket::GetBasketUserID()
		),
		false,
		false,
		array("PRODUCT_ID")
	);
	
	if ($basket_products->SelectedRowsCount()) {
		while ($basket_product = $basket_products->Fetch()) {
			array_push($products_ids, $basket_product['PRODUCT_ID']);
		}
		// �.�. � ������� � ������� ��� id ���������, �� ������� ��� ��� ���� ������� � �������
		$iblock_ids = array();
		$iblock_elements = CIBlockElement::GetList(
			Array(),
			Array(
				"ID" => $products_ids
			), 
			false, 
			false,
			array("IBLOCK_ID")
		);
		while ($iblock_element = $iblock_elements->Fetch()) {
			array_push($iblock_ids, $iblock_element['IBLOCK_ID']);
		}
		// ���������, ��� � �������
		if (in_array(BONUS_CATALOG_IBLOCK_ID, $iblock_ids) && (in_array(CATALOG_IBLOCK_ID, $iblock_ids) || in_array(SKU_CATALOG_IBLOCK_ID, $iblock_ids))) {
			$type = "mixed";
		} else if (in_array(CATALOG_IBLOCK_ID, $iblock_ids) || in_array(SKU_CATALOG_IBLOCK_ID, $iblock_ids)) {
			$type = "product";
		} else if (in_array(BONUS_CATALOG_IBLOCK_ID, $iblock_ids)) {
			$type = "bonus";
		}
	}
	
	return $type;
}
?>