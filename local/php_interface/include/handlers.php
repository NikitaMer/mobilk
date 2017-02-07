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
		CIBlockElement::SetPropertyValuesEx($fields['ID'], false, array(SALER_REPORT_STATUS_PROPERTY_ID => SALER_REPORT_STATUS_UNDER_CONSIDERATION_ID));
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
?>