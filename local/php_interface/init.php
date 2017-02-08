<?
// подключение lang файла
include(GetLangFileName(dirname(__FILE__) . "/", "/init.php"));
// подключение констант и отладочных функций
if (file_exists(dirname(__FILE__) . "/include/constants.php")) { require_once(dirname(__FILE__) . "/include/constants.php"); } else { trigger_error(GetMessage("CONSTANTS_FILE_MISSED"), E_USER_ERROR); };
if (file_exists(dirname(__FILE__) . "/include/debug.php")) { require_once(dirname(__FILE__) . "/include/debug.php"); } else { trigger_error(GetMessage("DEBUG_FILE_MISSED"), E_USER_ERROR); };
if (file_exists(dirname(__FILE__) . "/include/handlers.php")) { require_once(dirname(__FILE__) . "/include/handlers.php"); } else { trigger_error(GetMessage("HANDLERS_FILE_MISSED"), E_USER_ERROR); };


/**
 * 
 * Проверяем, принадлежит ли пользователь к группе продавцов
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
 * Проверяем, имеет ли пользователь статус серебряного партнера
 * 
 * @return bool
 * */
function isUserHaveSilverStatus() {
	global $USER;
	// два разных вызова CSite необходимо, т.к. вызов с 2 id в массиве работает по принципу ИЛИ
	if ($USER->IsAuthorized() && CSite::InGroup(array(SALERS_GROUP_ID)) && CSite::InGroup(array(SILVER_SALER_GROUP_ID))) {
		return true;
	}
}

/**
 * 
 * Проверяем, имеет ли пользователь статус золотого партнера
 * 
 * @return bool
 * */
function isUserHaveGoldenStatus() {
	global $USER;
	// два разных вызова CSite необходимо, т.к. вызов с 2 id в массиве работает по принципу ИЛИ
	if ($USER->IsAuthorized() && CSite::InGroup(array(SALERS_GROUP_ID)) && CSite::InGroup(array(GOLDEN_SALER_GROUP_ID))) {
		return true;
	}
}

/**
 * 
 * Проверяем, есть ли у пользователя активные заявки на продавца
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
 * Проверяем, является ли элемент бонусным товаром
 * 
 * @param int $iblock_id
 * @return bool
 * */
function isItBonusProduct($iblock_id) {
	return $iblock_id == BONUS_CATALOG_IBLOCK_ID;
}

/**
 * 
 * Получить количество баллов у пользователя
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
 * Получить тип корзины
 * Возможные варианты:
 * - product - только товары за деньги
 * - bonus - только товары за баллы
 * - mixed - товары разных категорий
 * - empty - пустая
 * 
 * @return string $type
 * 
 * */
function getBasketType() {
	// получаем товары в корзине для текущего пользователя
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
		// т.к. у товаров в корзине нет id инфоблока, то получим его для всех товаров в корзине
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
		// проверяем, что в корзине
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