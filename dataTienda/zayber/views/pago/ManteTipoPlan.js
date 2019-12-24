$(window).on('load',function(){var inst=new ClassPlan();$("#IdAlmacenPri").css("display","none");
	inst.getList_Mante_Plan();
	$("#btnNewPlan").on('click',function(e){
		inst.Create_Mante_Plan("-1");
	});
});
function ClassPlan(){
	this.getList_Mante_Plan=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objPago",action:"getList_Mante_Plan"},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				var inst=new ClassPlan();inst.Build_Mante_Plan(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Mante_Plan=function(Datos){var inst=new ClassPlan();
		$("#IdTableMantePlan tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["Id"];
			$('#IdTableMantePlan tbody').append('<tr>'+
					'<td id="editMantePlan_'+ids+'" class="center">'+
						'<i class="fas fa-edit f-18"></i>'+
					'</td>'+
					'<td>'+Datos[i]["Tipo"]+'</td>'+
					'<td>'+Datos[i]["Simbolo"]+'</td> '+
					'<td>'+Datos[i]["Monto"]+'</td> '+
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
		
		$('#IdTableMantePlan tbody').unbind("click");
		$('#IdTableMantePlan tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editMantePlan'){
				inst.Create_Mante_Plan(id[1]);
			}
		});
	}
	this.Create_Mante_Plan=function(pId){var inst=new ClassPlan();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Mante_Plan);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		if(pId!="-1"){inst.getList_Mante_Plan_Edit(pId);}
		
		$("#txtSave_Plan").on('click',function(e){
			var Plan=$("#txtTipo_Plan").val();
			var Simbol=$("#txtSimbolo_Plan").val();
			var Monto=$("#txtMonto_Plan").val();
			var IdEst=$("#chkHabilitado_Plan").is(':checked') ? 1 : 0;
			if(Plan!=""){
				inst.Save_Mante_Plan([pId,Plan,Simbol,IdEst,Monto]);
			}else{
				alertify.error("Alerta, Completar Datos.");
			}
		});
	}
	this.getList_Mante_Plan_Edit=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objPago",action:"getList_Mante_Plan_Edit",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e;
				if(Dato.length>0){
					$("#txtTipo_Plan").prop("value",Dato[0]["Tipo"]);
					$("#txtSimbolo_Plan").prop("value",Dato[0]["Simbolo"]);
					$("#txtMonto_Plan").prop("value",Dato[0]["Monto"]);
					if(parseInt(Dato[0]["Estado"])===1){$("#chkHabilitado_Plan").prop('checked', true);}else{$("#chkHabilitado_Plan").prop('checked', false);}
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.Save_Mante_Plan=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objPago",action:"Save_Mante_Plan",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					  $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassPlan();inst.getList_Mante_Plan(e);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Delete_Mante_Plan=function(pId,IdReg){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objPago",action:"Delete_Mante_Plan",array:[pId,IdReg]},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassPlan();inst.Build_Mante_Plan(e["Dato"]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){}
		});
	}
}