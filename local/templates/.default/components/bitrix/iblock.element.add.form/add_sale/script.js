$(document).ready(function(){
	// при клике на поле с календарем открываем скрытый битриксовый календарь
	$("input[data-field-type='calendar']").on("click", function() {
		$(".sale_date_calendar img").click();
	})
})
