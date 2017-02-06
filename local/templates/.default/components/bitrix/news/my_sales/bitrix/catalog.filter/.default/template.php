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
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
	<? foreach($arResult["ITEMS"] as $arItem) {
		if(array_key_exists("HIDDEN", $arItem)) {
			echo $arItem["INPUT"];
		}
	} ?>
	<? //arshow($arResult["ITEMS"]) ?>
	<div class="webFormItems">
		<? foreach($arResult["ITEMS"] as $arItem) { ?>
			<? if(!array_key_exists("HIDDEN", $arItem)) { ?>
				<div class="webFormItem">
					<div class="webFormItemCaption">
						<div class="webFormItemLabel">
						<?= $arItem["NAME"] ?>
						</div>
					</div>
					<div class="webFormItemField <? if ($arItem["TYPE"] == "DATE_RANGE") { echo "date-range" ;} ?> ">
						<?= $arItem["INPUT"] ?>
					</div>
				</div>
			<? } ?>
		<? } ?>
	</div>
	<div class="webFormTools">
		<div class="tb">
			<div class="tc salers_reports_buttons">
				<input type="submit" name="set_filter" value="<?=GetMessage("IBLOCK_SET_FILTER")?>" />
				<input type="hidden" name="set_filter" value="Y" />
				<input type="submit" name="del_filter" value="<?=GetMessage("IBLOCK_DEL_FILTER")?>" />
			</div>
		</div>
	</div>
</form>
