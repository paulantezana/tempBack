$(window).on('load',function(){
	$(".claRsva").on('click',function(e){
		var IdA=$("select#IdAlmacenPri option:selected").val();
		var hr=$(this)[0].href;
		$(this).attr("href", hr+"&alm="+IdA);
		//window.location = $("#aHrefId").attr("href");
	});
	
});
