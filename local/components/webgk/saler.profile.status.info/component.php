<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

global $USER;

$total_points = getTotalUserPoints($USER->GetID());
// узнаем статус пользователя
if (isUserHaveGoldenStatus($USER->GetID())) {
	$arResult['STATUS'] = GetMessage("GOLD");
} else {
	$arResult['STATUS'] = GetMessage("SILVER");
	// получаем кол-во баллов до следующего уровня
	$borders = getLevelsBorders();
	$arResult['POINTS_TO_NEXT_LVL'] = $borders[SILVER_LVL_ID]['to'] - $total_points;
}
// общее кол-во баллов за все время
$arResult['TOTAL_POINTS'] = $total_points;

// получаем кол-во баллов
$arResult['BALANCE'] = getUserPoints($USER->GetID());

$this->IncludeComponentTemplate();
?>