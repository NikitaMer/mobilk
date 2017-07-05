<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Доставка");
?><h1>Доставка</h1>
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
<div class="global-block-container">
	<div class="global-content-block">
		<h3 class="bold">Доставка по Москве и Московской области</h3>
		<p>
			Доставка по Москве и области производится силами собственной курьерской службы, а также с помощью сторонних служб доставки.
		</p>
		<h3 class="bold">Стоимость доставки</h3>
		<p>
		</p>
		<table border="1" style="border: solid; text-align: center;">
		<tbody>
		<tr>
			<td style="width: 120px;">
				Доставка
			</td>
			<td style="width: 100px;">
				До 999 руб.
			</td>
			<td style="width: 110px;">
				От 1000 до 4999 руб.
			</td>
			<td style="width: 110px;">
				От 5000 до 9999 руб.
			</td>
			<td style="width: 110px;">
				От 10000 до 19999 руб.
			</td>
			<td style="width: 110px;">
				От 20000 до 49999 руб.
			</td>
			<td style="width: 110px;">
				От 50000 руб.
			</td>
		</tr>
		<tr>
			<td>
				Москва в пределах МКАД
			</td>
			<td rowspan="6">
				Доставка<br>
				 не производится
			</td>
			<td rowspan="4">
				Не производится&nbsp;
			</td>
			<td>
				300 руб.
			</td>
			<td colspan="3" style="font-weight: bold; color: red;">
				Бесплатно
			</td>
		</tr>
		<tr>
			<td>
				До 20 км от МКАД
			</td>
			<td>
				300 руб. + 250 руб./10 км
			</td>
			<td>
				250 руб./10 км
			</td>
			<td rowspan="2" colspan="2">
				250 руб./10 км
			</td>
		</tr>
		<tr>
			<td>
				21 - 50 км от МКАД
			</td>
			<td rowspan="2" colspan="2">
				Не производится&nbsp;
			</td>
		</tr>
		<tr>
			<td>
				51 - 100 км от МКАД
			</td>
			<td>
				Не производится&nbsp;
			</td>
			<td>
				250 руб./10 км (по согласованию)*
			</td>
		</tr>
		<tr>
			<td>
				В транспортную компанию в Москве
			</td>
			<td>
				500 руб.
			</td>
			<td>
				300 руб.
			</td>
			<td colspan="3" style="font-weight: bold; color: red;">
				Бесплатно
			</td>
		</tr>
		<tr>
			<td>
				Доставка Почтой России
			</td>
			<td colspan="5">
				500 р. (только для заказов массой до 3 кг и габаритами до 40х25х35см)
			</td>
		</tr>
		</tbody>
		</table>
		<p>
		</p>
		<h3 class="bold">Сроки и время доставки</h3>
		<ul>
			<li>Доставка осуществляется 7 дней в неделю (в т.ч. в выходные и праздничные дни).</li>
			<li>Срок доставки зависит от наличия товара на складах, а также адреса получателя и составляет, как правило, от 1 до 3 рабочих дней.</li>
			<li>По Москве в пределах МКАД можно выбрать интервал доставки: с 9:00 до 16:00 или с 16:00 до 23:00.</li>
			<li>По Московской области доставка происходит во второй половине дня с 14:00 до 23:00. Время доставки может быть увеличено в зависимости от удаленности от МКАД.</li>
			<li>Также при заказе Вы можете указать более точный четырехчасовой временной интервал доставки (начиная с 9.00). В этом случае служба доставки постарается учесть Ваши пожелания. Возможность доставки в четырехчасовой интервал подтверждается утром в день доставки.</li>
			<li>Утром в день доставки с Вами свяжется сотрудник транспортного отдела, подтвердит информацию по доставке. За час до доставки с Вами свяжется наш водитель.</li>
		</ul>
		<h3 class="bold">Срочная доставка в день заказа</h3>
		<ul>
			<li>При наличии товара на складе в г. Москве и наличии свободного автотранспорта возможна срочная доставка в день заказа.</li>
			<li>Стоимость услуги: стандартная стоимость доставки + 500 руб.</li>
			<li>Внимание! Срочная доставка не является гарантированной услугой.</li>
		</ul>
	</div>
	<div class="global-information-block">
		 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	".default",
	Array(
		"AREA_FILE_RECURSIVE" => "Y",
		"AREA_FILE_SHOW" => "sect",
		"AREA_FILE_SUFFIX" => "information_block",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_TEMPLATE" => ""
	)
);?>
	</div>
</div>
<br>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>