$(document).ready(function(){
	// при клике на результат выпадающего списка заполняем значение инпута строкой, а ID переносим в инпут product
	$(".title-search-result").on("click", ".product_popup li", function() {
		var product_link = $(this).children();
		// вырезаем из текста <b>, которыми битрикс помечает совпадения и табы
		$("#title-search-input").val(product_link.text().replace(/(<([^>]+)>)|(\t)/ig,""));
		$("input[name='PROPERTY[127][0]']").val(product_link.data("item-id"));
	})
})