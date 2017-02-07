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
?>