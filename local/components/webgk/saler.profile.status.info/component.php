<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

global $USER;
// ������ ������ ������������
if (isUserHaveGoldenStatus()) {
	$arResult['STATUS'] = GetMessage("GOLD");
} else {
	$arResult['STATUS'] = GetMessage("SILVER");
}

// �������� ���-�� ������
$user_balance = CSaleUserAccount::GetByUserID($USER->GetID(), "RUB");
$arResult['BALANCE'] = (int)$user_balance['CURRENT_BUDGET'];

$this->IncludeComponentTemplate();
?>