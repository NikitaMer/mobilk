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
		<td colspan="2"><?= str_replace("points", $arResult['POINTS_TO_NEXT_LVL'], GetMessage("POINTS_TO_NEXT_LVL")) ?></td>
	</tr>
	<? } ?>
	<tr>
		<td colspan="2"><?= str_replace("points", $arResult['TOTAL_POINTS'], GetMessage("TOTAL_POINTS")) ?></td>
	</tr>
</table>

