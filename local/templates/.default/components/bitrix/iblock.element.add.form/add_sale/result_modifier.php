<?
global $USER;
// ������� ���������, ��� � ������������ ��� �������� ������ �� ������ ������
if (isUserHaveActiveRequests()) {
	$arResult['USER_HAVE_ACTIVE_REQUESTS'] = true;
}

$arResult['USER_FULL_NAME'] = $USER->GetFullName();
?>