<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

global $USER;
// ������ ������ ������������
if (isUserHaveGoldenStatus($USER->GetID())) {
	$arResult['STATUS'] = GetMessage("GOLD");
} else {
	$arResult['STATUS'] = GetMessage("SILVER");
}

// �������� ���-�� ������
$arResult['BALANCE'] = getUserPoints($USER->GetID());

$this->IncludeComponentTemplate();
?>