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
?>