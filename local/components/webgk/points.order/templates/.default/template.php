<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if ($arResult["ERROR"]) { ?>
	<p class="order_message"><?= $arResult["MESSAGE"] ?></p>
<? } else if ($arResult["SUCCESS"]) { ?>
	<p class="order_message"><?= $arResult["MESSAGE"] ?></p>
<? } else { ?>
	<form action="" method="post">
		<table class="points_order_form">
			<tr>
				<td><?= GetMessage("COMMENT_FILED") ?>:</td>
				<td><textarea name="comment" id="" cols="70" rows="15"></textarea></td>
			</tr>
			<tr>
				<td><?= GetMessage("ORDER_SUM") ?>: <span><?= $arResult["POINTS_SUM"] ?></span></td>
				<td>
					<input name="form_submitted" type="hidden" value="Y"/>
					<input type="submit" value="<?= GetMessage("SUBMIT") ?>"/>
				</td>
			</tr>
		</table>
	</form>
<? } ?>

