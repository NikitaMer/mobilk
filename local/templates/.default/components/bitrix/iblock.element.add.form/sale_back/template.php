<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(false);

if (!empty($arResult["ERRORS"])):?>
	<?ShowError(implode("<br />", $arResult["ERRORS"]))?>
<?endif;?>
<form name="iblock_add" action="<?= POST_FORM_ACTION_URI ?>" method="post" enctype="multipart/form-data">
	<?=bitrix_sessid_post()?>
	<table class="data-table">
		<thead>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
		</thead>
		<?if (is_array($arResult["PROPERTY_LIST"]) && !empty($arResult["PROPERTY_LIST"])):?>
		<tbody>
			<? foreach ($arResult["PROPERTY_LIST"] as $propertyID) { ?>
				<tr style="<?= $propertyID == "NAME" ? "display: none" : "" ?>">
					<td>
						<? if (intval($propertyID) > 0) { ?>
							<?= $arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"] ?>
						<? } else { ?>
							<?= !empty($arParams["CUSTOM_TITLE_" . $propertyID]) ? $arParams["CUSTOM_TITLE_" . $propertyID] : GetMessage("IBLOCK_FIELD_" . $propertyID) ?>
						<? } ?>
					</td>
					<td>
						<?
						if (intval($propertyID) > 0)
						{
							if (
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "T"
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] == "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "S";
							elseif (
								(
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "S"
									||
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "N"
								)
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] > "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "T";
						}
						elseif (($propertyID == "TAGS") && CModule::IncludeModule('search'))
							$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "TAGS";

						if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y")
						{
							$inputNum = ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) ? count($arResult["ELEMENT_PROPERTIES"][$propertyID]) : 0;
							$inputNum += $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE_CNT"];
						}
						else
						{
							$inputNum = 1;
						}

						if($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"])
							$INPUT_TYPE = "USER_TYPE";
						else
							$INPUT_TYPE = $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"];

						switch ($INPUT_TYPE) {
							case "S":
							case "N":
								for ($i = 0; $i<$inputNum; $i++)
								{
									if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];

									}
									else
									{
										$value = "";
									}
								?>
								<?
								// для поля название всегда подставляем ФИО пользователя
								if ($propertyID == "NAME") {
									$value = $arResult['USER_FULL_NAME'];
								}
								?>
								<input type="text" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" size="25" value="<?=$value?>" /><?
								}
							break;
						} ?>
					</td>
				</tr>
			<? } ?>
		</tbody>
		<?endif?>
		<tfoot>
			<tr>
				<td colspan="2">
					<input type="submit" name="iblock_submit" value="<?=GetMessage("IBLOCK_FORM_SUBMIT")?>" />
					<? if (strlen($arParams["LIST_URL"]) > 0) { ?>
						<input type="submit" name="iblock_apply" value="<?=GetMessage("IBLOCK_FORM_APPLY")?>" />
						<input
							type="button"
							name="iblock_cancel"
							value="<? echo GetMessage('IBLOCK_FORM_CANCEL'); ?>"
							onclick="location.href='<? echo CUtil::JSEscape($arParams["LIST_URL"])?>';"
						>
					<? } ?>
				</td>
			</tr>
		</tfoot>
	</table>
</form>