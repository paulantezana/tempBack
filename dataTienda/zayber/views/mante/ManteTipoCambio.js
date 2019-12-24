$(window).on('load',function(){var inst=new ClassTC();$("#IdAlmacenPri").css("display","none");
	inst.getList_Mante_TC();
	$("#btnSaveTC").on('click',function(e){
		TC=$("#txtTC_ManteTipoCambio").val();
		if(TC!=""){inst.Save_Mante_TC([TC]);}
	});
});
function ClassTC(){
	this.getList_Mante_TC=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_TC"},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e.length>0){
					$("#txtTC_ManteTipoCambio").prop("value",e[0]["Cambio"]);
				}else{
					$("#txtTC_ManteTipoCambio").prop("value","0.00");
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Save_Mante_TC=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Mante_TC",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassTC();inst.getList_Mante_TC();
				}else{alertify.error("Error, Proceso Incorrecto.");}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
}