$(window).on('load',function(){var inst=new ClassUnidad();$("#IdAlmacenPri").css("display","none");
	inst.getList_Mante_Unidad();
	$("#btnNewUnidad").on('click',function(e){
		inst.Create_Mante_Unidad("-1");
	});
});
function ClassUnidad(){
	this.getList_Mante_Unidad=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Unidad"},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				var inst=new ClassUnidad();inst.Build_Mante_Unidad(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Mante_Unidad=function(Datos){var inst=new ClassUnidad();
		$("#IdTableManteUnidad tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdUnidad"];
			$('#IdTableManteUnidad tbody').append('<tr>'+
					'<td id="editManteUnidad_'+ids+'" class="center">'+
						'<i class="fas fa-edit f-18"></i>'+
					'</td>'+
					'<td>'+Datos[i]["Unidad"]+'</td>'+
					'<td>'+Datos[i]["Simbolo"]+'</td> '+
					'<td class="center">'+Datos[i]["Est"]+'</td> '+
				'</tr>');
		}
		$('#filtrar').keyup(function(){
            var rex = new RegExp($(this).val(), 'i');
            $('.buscar tr').hide();
            $('.buscar tr').filter(function (){
                return rex.test($(this).text());
            }).show();
        });
		
		var altM=parseFloat($(window).height())-parseFloat(250);;
		$(".table-responsive").css({"overflow-y":"scroll","height":altM+"px"});
		
		$('#IdTableManteUnidad tbody').unbind("click");
		$('#IdTableManteUnidad tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteUnidad'){
				inst.Create_Mante_Unidad(id[1]);
			}
		});
	}
	this.Create_Mante_Unidad=function(pId){var inst=new ClassUnidad();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Mante_Unidad);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		if(pId!="-1"){inst.getList_Mante_Unidad_Edit(pId);}
		
		$("#txtSave_Unid").on('click',function(e){
			var Unidad=$("#txtUnidad_Unid").val();
			var SImbo=$("#txtSimbolo_Unid").val();
			var IdEst=$("#chkHabilitado_Unid").is(':checked') ? 1 : 0;
			if(Unidad!="" && SImbo!=""){
				inst.Save_Mante_Unidad([pId,Unidad,SImbo,IdEst]);
			}else{
				alertify.error("Alerta, Completar Datos.");
			}
		});
	}
	this.getList_Mante_Unidad_Edit=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Unidad_Edit",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();
				if(e.length>0){
					$("#txtUnidad_Unid").prop("value",e[0]["Unidad"]);
					$("#txtSimbolo_Unid").prop("value",e[0]["Simbolo"]);
					if(parseInt(e[0]["Estado"])===1){$("#chkHabilitado_Unid").prop('checked', true);}else{$("#chkHabilitado_Unid").prop('checked', false);}
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.Save_Mante_Unidad=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Mante_Unidad",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					  $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassUnidad();inst.getList_Mante_Unidad();
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Delete_Mante_Unidad=function(pId,IdReg){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Delete_Mante_Unidad",array:[pId,IdReg]},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassUnidad();inst.Build_Mante_Unidad(e["Dato"]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){}
		});
	}
}