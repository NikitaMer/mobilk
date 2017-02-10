<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!empty($arResult["CATEGORIES"])) { ?>
	<ul class="product_popup">
		<? foreach ($arResult["CATEGORIES"] as $category_id => $arCategory) { ?>
			<? foreach($arCategory["ITEMS"] as $i => $arItem) { ?>
				<? // отметаем надписи типа "Все результаты" и разделы ?>
				<? if ($arItem['MODULE_ID'] && !preg_match('/\D/', $arItem["ITEM_ID"])) { ?>
				<li>
					<a data-item-id="<?= $arItem["ITEM_ID"] ?>" href="javascript:void(0)">
						<?= $arItem["NAME"] ?>
					</a>
				</li>
				<? } ?>
			<? } ?>
		<? } ?>
	</ul>
<? } ?>