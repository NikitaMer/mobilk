<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

global $USER;
// узнаем статус пользователя
if (isUserHaveGoldenStatus()) {
	$arResult['STATUS'] = GetMessage("GOLD");
} else {
	$arResult['STATUS'] = GetMessage("SILVER");
}

// получаем кол-во баллов
$user_balance = CSaleUserAccount::GetByUserID($USER->GetID(), "RUB");
$arResult['BALANCE'] = (int)$user_balance['CURRENT_BUDGET'];

$this->IncludeComponentTemplate();
?>