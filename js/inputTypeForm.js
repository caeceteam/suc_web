$(".checkbox-component").on("click", function() {
	$(this).find("input[type='checkbox']")[0].value = $(this).find("input[type='checkbox']")[0].checked ? '1' : '0';
});