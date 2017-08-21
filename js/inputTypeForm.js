$("input[type='checkbox']").on("click", function() {
	this.value = this.checked ? '1' : '0';
});