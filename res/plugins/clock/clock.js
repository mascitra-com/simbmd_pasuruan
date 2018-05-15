var clock = (function(){
	function setClock()
	{
		var today = new Date();
		var h = addZero(today.getHours());
		var m = addZero(today.getMinutes());
		var s = addZero(today.getSeconds());
		$('.clock-placeholder').empty().html(h+":"+m+":"+s);
		setTimeout(setClock, 500);
	}

	function addZero(t){
		if(t<10){t='0'+t;}
		return t;
	}

	return {
		setClock : setClock
	}
})();