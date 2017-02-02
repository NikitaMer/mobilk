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
?>