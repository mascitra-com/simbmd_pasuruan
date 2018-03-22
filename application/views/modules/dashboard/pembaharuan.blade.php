@layout('commons/index')
@section('title')Pembaharuan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Pembaharuan</li>
@end

@section('content')
<div class="card">
	<!-- <div class="card-header"></div> -->
	<div class="card-body">
		<h4 class="card-title">1.0.1</h4>
		<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam modi odio dolore sed eveniet quae aspernatur, mollitia impedit adipisci perferendis, molestiae ex eos porro, esse nemo enim iusto, ipsam consectetur!</p>
	</div>
</div>
@end

@section('style')
<style type="text/css">
	.card-title{font-size: 1.5em;font-weight: bold;margin-right: 7px}
	.card-date{font-size: 1em;font-weight: bold;}
	ul{list-style: circle;}
</style>
@end

@section('script')
<script type="text/javascript" src="{{base_url('res/scripts/update.json')}}"></script>
<script type="text/javascript">
	theme.activeMenu('.nav-pembaharuan');
	$(".card-body").empty();
	$.each(update.reverse(), function(index, item){
		var html = "<span class='card-title'>"+item.version+"</span><span class='card-date'>("+item.date+")</span>";
		html += "<ul class='card-text ml-5'>";
		item.detail = item.detail.sort(function(a,b) {return (a.type < b.type) ? -1 : ((b.type < a.type) ? 1 : 0);} );
		for(var i=0; i<item.detail.length; i++){
			html += "<li>("+item.detail[i].type+") "+item.detail[i].description+"</li>";
		}

		html += "</ul>";
		$(".card-body").append(html);
	});
</script>
@end