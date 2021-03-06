<?
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
		die();

	$arResult["SELECTED"] = !empty($_GET["where"]) ? intval($_GET["where"]) : 0;
	$cacheID = !empty($_GET["q"]) || !empty($_GET["where"]) ? time() : 0;

	if ($this->StartResultCache($arParams["CACHE_TIME"], $cacheID)){

		$arResult["SECTIONS"] = array();

		if(CModule::IncludeModule("iblock") && CModule::IncludeModule("catalog") && CModule::IncludeModule("sale")){
			$arFilter = Array('IBLOCK_TYPE' => $arParams["IBLOCK_TYPE"], 'IBLOCK_ID' => $arParams["IBLOCK_ID"], 'GLOBAL_ACTIVE' => 'Y', 'DEPTH_LEVEL' => 1);
			$res = CIBlockSection::GetList(Array(), $arFilter, true);
			while($arRes = $res->GetNext()){
				if($arResult["SELECTED"] == $arRes["ID"]){
					$arRes["SELECTED"] = "Y";
				}
				$arResult["SECTIONS"][] = $arRes;
			}
		}

		if(!empty($_GET["q"]) && $_GET["r"] == Y){
			$arResult["q"] = htmlspecialchars($_GET["q"]);
			$this->AbortResultCache();
		}

		$this->IncludeComponentTemplate();
	}

?>