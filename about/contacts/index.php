<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Г‡Г Г¤Г Г©ГІГҐ ГўГ®ГЇГ°Г®Г±");
?><h1>Контактная информация</h1>
 <?$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "personal",
    Array(
        "ALLOW_MULTI_SELECT" => "N",
        "CHILD_MENU_TYPE" => "",
        "COMPONENT_TEMPLATE" => "personal",
        "DELAY" => "N",
        "MAX_LEVEL" => "1",
        "MENU_CACHE_GET_VARS" => array(),
        "MENU_CACHE_TIME" => "3600000",
        "MENU_CACHE_TYPE" => "A",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "ROOT_MENU_TYPE" => "about",
        "USE_EXT" => "N"
    )
);?>
<ul>
    <li>
    <table>
    <tbody>
    <tr>
        <td>
 <img alt="cont1.png" src="/local/templates/dresscode/images/cont1.png" title="cont1.png">
		</td>
		<td>
			 +7 (800) 333-92-14<br>
		</td>
	</tr>
	</tbody>
	</table>
 </li>
    <li>
    <table>
    <tbody>
    <tr>
        <td>
 <img alt="cont2.png" src="/local/templates/dresscode/images/cont2.png" title="cont2.png">
        </td>
        <td>
 <a href="mailto:shop@mobilk.ru">shop@mobilk.ru</a>
        </td>
    </tr>
    </tbody>
    </table>
 </li>
	<li>
	<table>
	<tbody>
	<tr>
		<td>
 <img alt="cont3.png" src="/local/templates/dresscode/images/cont3.png" title="cont3.png">&nbsp;
		</td>
		<td>
			 Смоленская обл., Гагаринский р-н, д. Поличня, ул. Новая
		</td>
	</tr>
	</tbody>
	</table>
 </li>
    <li>
    <table>
    <tbody>
    <tr>
        <td>
 <img alt="cont4.png" src="/local/templates/dresscode/images/cont4.png" title="cont4.png">
		</td>
		<td>
			 Пн-Пт : с 10:00 до 20:00<br>
			 Сб : с 10:00 до 15:00<br>
			 Вс : выходной<br>
		</td>
	</tr>
	</tbody>
	</table>
 </li>
</ul>
 <br>
 <?$APPLICATION->IncludeComponent(
	"bitrix:map.yandex.view",
	".default",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"CONTROLS" => array(0=>"ZOOM",1=>"TYPECONTROL",2=>"SCALELINE",),
		"INIT_MAP_TYPE" => "MAP",
		"MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:55.72971020403258;s:10:\"yandex_lon\";d:36.11911075723283;s:12:\"yandex_scale\";i:7;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:3:\"LON\";d:34.981607371689;s:3:\"LAT\";d:55.580656255493;s:4:\"TEXT\";s:7:\"Мобил К\";}}}",
		"MAP_HEIGHT" => "500",
		"MAP_ID" => "",
		"MAP_WIDTH" => "100%",
		"OPTIONS" => array(0=>"ENABLE_DBLCLICK_ZOOM",1=>"ENABLE_DRAGGING",)
	)
);?><br>
 <br>
        <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	".default",
	Array(
		"CACHE_TIME" => "360000",
		"CACHE_TYPE" => "Y",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
		"WEB_FORM_ID" => "2"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>