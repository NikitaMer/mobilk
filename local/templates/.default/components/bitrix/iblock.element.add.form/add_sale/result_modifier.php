<?
global $USER;
// сначала проверяем, что у пользователя нет активных заявок на данный момент
if (isUserHaveActiveRequests()) {
	$arResult['USER_HAVE_ACTIVE_REQUESTS'] = true;
}

$arResult['USER_FULL_NAME'] = $USER->GetFullName();
?>