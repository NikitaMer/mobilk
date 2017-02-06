$(document).ready(function(){
	// при клике на поле с календарем открываем скрытый битриксовый календарь
	$(".date-range input").on("click", function() {
		$(this).next("img").click();
	})
})