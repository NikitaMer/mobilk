<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

global $USER;

$total_points = getTotalUserPoints($USER->GetID());
// ������ ������ ������������
if (isUserHaveGoldenStatus($USER->GetID())) {
	$arResult['STATUS'] = GetMessage("GOLD");
} else {
	$arResult['STATUS'] = GetMessage("SILVER");
	// �������� ���-�� ������ �� ���������� ������
	$borders = getLevelsBorders();
	$arResult['POINTS_TO_NEXT_LVL'] = $borders[SILVER_LVL_ID]['to'] - $total_points;
}
// ����� ���-�� ������ �� ��� �����
$arResult['TOTAL_POINTS'] = $total_points;

// �������� ���-�� ������
$arResult['BALANCE'] = getUserPoints($USER->GetID());

$this->IncludeComponentTemplate();
?>