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
<? if (is_array($arResult["REQUESTS"]) && !empty($arResult["REQUESTS"])) { ?>
	<div class="sales_reports_list">
		<? foreach($arResult["REQUESTS"] as $request) { ?>
		<table class="sale_report <?= $request['status_id'] ? $request['status_id'] : "under_consideration" ?>">
			<tr>
				<td><?= GetMessage("STATUS") ?>:</td>
				<td><?= $request["status"] ? $request["status"] : GetMessage("DEFAULT_STATUS") ?></td>
			</tr>
			<tr>
				<td><?= GetMessage("REQUEST_DATE_CREATE") ?>:</td>
				<td><?= $request["date_create"] ?></td>
			</tr>
			<tr>
				<td><?= GetMessage("SALE_DATE") ?>:</td>
				<td><?= $request["sale_date"] ?></td>
			</tr>
			<tr>
				<td><?= GetMessage("PRODUCT") ?>:</td>
				<td><?= $arResult["PRODUCTS_TITLES"][$request["product"]] ?></td>
			</tr>
			<tr>
				<td><?= GetMessage("SERIAL_NUMBER") ?>:</td>
				<td><?= $request["serial_number"] ?></td>
			</tr>
			<tr>
				<td><?= GetMessage("SALE_PRICE") ?>:</td>
				<td><?= $request["price"] ?> руб.</td>
			</tr>
			<? // если админ оставил текстовое примечание, то выведем его ?>
			<? if ($request["text_note"]) { ?>
			<tr>
				<td><?= GetMessage("MESSAGE") ?>:</td>
				<td><?= $request["text_note"] ?></td>
			</tr>
			<? } ?>
		</table>
		<? } ?>
	</div>
<? } else { ?>
	<p><?= GetMessage("NO_REPORTS") ?></p>
<? } ?>