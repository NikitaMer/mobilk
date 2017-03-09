<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<select name="PROPERTY[<?= SALER_REPORT_PRODUCT_ID_PROPERTY_ID ?>][0]" id="">
<? foreach ($arResult["PRODUCTS"] as $arItem) { ?>
	<option value="<?= $arItem['id'] ?>"><?= $arItem['title'] ?></option>
<? } ?>
</select>