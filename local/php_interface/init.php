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
?>