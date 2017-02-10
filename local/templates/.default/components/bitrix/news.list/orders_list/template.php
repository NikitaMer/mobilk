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
<? if (is_array($arResult["ORDERS"]) && !empty($arResult["ORDERS"])) { ?>
	<div class="points_orders_list">
		<? foreach($arResult["ORDERS"] as $order) { ?>
		<table class="points_order">
			<tr>
				<td><?= GetMessage("ORDER_DATE_CREATE") ?>:</td>
				<td><?= $order["date_create"] ?></td>
			</tr>
			<tr>
				<td><?= GetMessage("PRODUCTS_LIST") ?>:</td>
				<td><?= $order["products"] ?></td>
			</tr>
			<tr>
				<td><?= GetMessage("COMMENT") ?>:</td>
				<td><?= $order["comment"] ?></td>
			</tr>
			<tr>
				<td><?= GetMessage("ORDER_SUMM") ?>:</td>
				<td><?= $order["summ"] . " " . GetMessage("POINTS") ?></td>
			</tr>
		</table>
		<? } ?>
	</div>
<? } else { ?>
	<p><?= GetMessage("NO_ORDERS") ?></p>
<? } ?>
