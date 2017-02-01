<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;
global $USER;
$aMenuNativeExt = array();



if (!$GLOBALS["USER"]->IsAuthorized())
{
	$arParamsToDelete = array(
		"login",
		"logout",
		"register",
		"forgot_password",
		"change_password",
		"confirm_registration",
		"confirm_code",
		"confirm_user_id",
	);

	$loginPath = SITE_DIR."login/?backurl=".urlencode($APPLICATION->GetCurPageParam("", array_merge($arParamsToDelete, array("backurl")), $get_index_page=false));
	$aMenuNativeExt = array(
		Array(
			"�����",
			$loginPath,
			Array(),
			Array(),
			""
		)
	);
}
else
{
	$aMenuNativeExt = Array(
		Array(
			"�������� �������",
			SITE_DIR."personal/profile/",
			Array(),
			Array(),
			""
		),
		Array(
			"������",
			SITE_DIR."personal/order/",
			Array(),
			Array(),
			""
		),
		Array(
			"�����",
			$APPLICATION->GetCurPageParam("logout=yes", Array("logout")),
			Array(),
			Array(),
			""
		),
	);
}
$aMenuLinks = array_merge($aMenuLinks, $aMenuNativeExt);
?>