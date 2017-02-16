<?
CModule::IncludeModule("main");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

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
 * @param int $user_id
 * @return bool
 * */
function isUserHaveSilverStatus($user_id) {
	$user_groups = getUserGroupList($user_id);
	if (in_array(SALERS_GROUP_ID, $user_groups) && in_array(SILVER_SALER_GROUP_ID, $user_groups)) {
		return true;
	}
}

/**
 * 
 * ���������, ����� �� ������������ ������ �������� ��������
 * 
 * @param int $user_id
 * @return bool
 * */
function isUserHaveGoldenStatus($user_id) {
	$user_groups = getUserGroupList($user_id);
	if (in_array(SALERS_GROUP_ID, $user_groups) && in_array(GOLDEN_SALER_GROUP_ID, $user_groups)) {
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
 * �������� ������ ����� ������������
 * 
 * @param int $user_id
 * @return array $groups
 * */
function getUserGroupList($user_id) {
	$groups = array();
	$groups_result = CUser::GetUserGroupList($user_id);
	while($group = $groups_result->Fetch()) {
	    array_push($groups, $group['GROUP_ID']);
	}
	return $groups;
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
 * �������� ����� ���������� ������ � ������������ �� ��� �����
 * 
 * @param int $user_id
 * @return int $current_points
 * */
function getTotalUserPoints($user_id) {
	$users = CUser::GetList(
		($by = "id"),
		($order = "asc"),
		array(
			"ID" => $user_id
		),
		array(
			"SELECT" => array("UF_TOTAL_POINTS"),
			"FIELDS" => array("ID")
		)
	);
	if ($user = $users->Fetch()) {
		$current_points = $user['UF_TOTAL_POINTS'];
	}
	return $current_points;
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

/**
 * 
 * �������� ���-�� ������ �� ����� � ������ ������ ������������
 * 
 * @param int $product_id
 * @param int $user_id
 * @return int $cost
 * 
 * */
 
function getProductPointCost($product_id, $user_id) {
	$lvl_property = isUserHaveGoldenStatus($user_id) ? "GOLDEN_LVL_POINTS" : "SILVER_LVL_POINTS";
	$additional_points = 0;
	
	$products = CIBlockElement::GetList(
		Array(),
		Array(
			"ID" => $product_id
		), 
		false, 
		Array(
			"nPageSize" => 1
		),
		array("ID", "PROPERTY_" . $lvl_property, "PROPERTY_ACTION_PRODUCT", "PROPERTY_ADDITIONAL_POINTS")
	);
	
	if ($product = $products->Fetch()) {
		// ���� �� �������� ����� �� ������ �����
		if ($product['PROPERTY_ACTION_PRODUCT_VALUE']) {
			$additional_points = $product['PROPERTY_ADDITIONAL_POINTS_VALUE'];
		}
		
		$cost = $product['PROPERTY_' . $lvl_property . '_VALUE'] + $additional_points;
	}
	return $cost;
}

/**
 * 
 * �������� ����� �� ���������� ���� ������������
 * 
 * @param int $user_id
 * @param int $points
 * @return void
 * 
 * */

function updateUserAccountPoints($user_id, $points) {
	CSaleUserAccount::UpdateAccount(
        $user_id,
        $points,
        "RUB"
    );
}

/**
 * 
 * �������� ����� �� ����� ���� ������������
 * 
 * @param int $user_id
 * @param int $points
 * @return void
 * 
 * */

function updateUserTotalPoints($user_id, $points) {
	// �������� ������� ���-�� ������ ������������
	$current_points = getTotalUserPoints($user_id);
	// ��������� ����� ����� ������������
	$user_object = new CUser;
	$user_object->Update(
		$user_id,
		Array(
			"UF_TOTAL_POINTS" => intval($current_points + $points)
		)
	);
}

/**
 * 
 * ���������� ������� ��� ������� ���������
 * 
 * @return array $result
 * 
 * */

function getLevelsBorders() {
	$result = array();
	$lvls = CIBlockElement::GetList(
		Array(),
		Array(
			"IBLOCK_ID" => SALERS_LVLS_IBLOCK_ID
		), 
		false, 
		false,
		array("ID", "NAME", "PROPERTY_FROM", "PROPERTY_TO")
	);
	while ($lvl = $lvls->Fetch()) {
		$result[$lvl['ID']] = array(
			"from" => $lvl['PROPERTY_FROM_VALUE'],
			"to"   => $lvl['PROPERTY_TO_VALUE']
		);
	}
	return $result;
}

/**
 * 
 * ��������� ������� ������������ �, ���� ������ ����������, �� ������������ ��� ������
 * 
 * @param int $user_id
 * @return void
 * 
 * */

function checkUserLvl($user_id) {
	$borders = getLevelsBorders();
	$total = getTotalUserPoints($user_id);
	if ($total >= $borders[GOLDEN_LVL_ID]['from']) {
		// ��������� ��� � ������ ������� ���������
		$groups_ids = array();
		$groups = CUser::GetUserGroupList($user_id);
		while ($group = $groups->Fetch()){
		   array_push($groups_ids, $group['GROUP_ID']);
		}
		array_push($groups_ids, GOLDEN_SALER_GROUP_ID);
		
		$user = new CUser;
		$fields = Array(
			"GROUP_ID"=> $groups_ids
		);
		$user->Update($user_id, $fields);
	}
}
?>