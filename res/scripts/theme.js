var theme = (function(){

	$(".alert").fadeTo(2000, 500).fadeOut(500, function(){
		$(".alert").fadeOut(500);
	});

	$(".btn-refresh").on('click', function(){
		location.reload();
	});

	$("form").on("submit", function(){
		$("button").prop("disabled", true);
	});

	$("select.select-chosen").chosen();

	function activeMenu(el) {
		$(".sidebar-nav "+el).addClass('active');
	}

	return {
		activeMenu :activeMenu
	}
})();