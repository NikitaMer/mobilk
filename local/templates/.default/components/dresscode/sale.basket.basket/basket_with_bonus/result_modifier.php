<?
$arResult['BONUS_PRODUCTS_IN_BASKET'] = false;
foreach ($arResult['ITEMS'] as $item) {
	if (isItBonusProduct($item['INFO']['IBLOCK_ID'])) {
		$arResult['BONUS_PRODUCTS_IN_BASKET'] = true;
		break;
	}
}
?>
