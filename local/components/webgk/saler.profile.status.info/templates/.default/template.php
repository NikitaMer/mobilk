<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<table class="saler_table_info">
	<tr>
		<td><?= GetMessage("YOUR_STATUS") ?>:</td>
		<td><?= $arResult['STATUS'] ?></td>
	</tr>
	<tr>
		<td><?= GetMessage("YOUR_BALANCE") ?>:</td>
		<td><?= $arResult['BALANCE'] ?></td>
	</tr>
	<? if ($arResult['POINTS_TO_NEXT_LVL']) { ?>
	<tr>
		<td><?= GetMessage("POINTS_TO_NEXT_LVL") ?>:</td>
		<td><?= $arResult['POINTS_TO_NEXT_LVL'] . GetMessage("POINTS") ?></td>
	</tr>
	<? } ?>
	<tr>
		<td><?= GetMessage("TOTAL_POINTS") ?>:</td>
		<td><?= $arResult['TOTAL_POINTS'] . GetMessage("POINTS") ?></td>
	</tr>
</table>

