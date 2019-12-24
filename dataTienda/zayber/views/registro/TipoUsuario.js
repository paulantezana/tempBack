$(window).on('load',function(){var inst=new ClassTipoUser();$("#IdAlmacenPri").css("display","none");
	inst.getList_Mante_TipoUsuario();
	
	$("#btnNewTipoUser").on('click',function(e){inst.Create_Mante_TipoUser("-1");});
});
function ClassTipoUser(){
	this.getList_Mante_TipoUsuario=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"getList_Mante_TipoUsuario"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassTipoUser();
				inst.Build_Mante_TipoUsuario(e);	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Mante_TipoUsuario=function(Datos){
		$("#IdTableTipoUser tbody").html("");var inst=new ClassTipoUser();	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdTipoUsuario"];
			$('#IdTableTipoUser tbody').append('<tr>'+
					'<td>'+Datos[i]["TipoUsuario"]+'</td>'+
					'<td>'+Datos[i]["Simbolo"]+'</td> '+
					'<td>'+Datos[i]["Est"]+'</td> '+
					/* '<td id="editManteTipoUser_'+ids+'">'+
						'<i class="ion-compose f-18"></i>'+
					'</td>'+ */
				'</tr>');
		}
		
		var altM=parseFloat($(window).height())-parseFloat(160);;
		$(".table-responsive").css({"overflow-y":"scroll","height":altM+"px"});
		/*
		$('#IdTableTipoUser tbody').unbind("click");
		$('#IdTableTipoUser tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteTipoUser'){inst.Create_Mante_TipoUser(id[1]);}
		}); */
	}
	this.Create_Mante_TipoUser=function(pId){var inst=new ClassTipoUser();
		/*$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Guia);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		
		if(pId!="-1"){inst.getList_Mante_Guia_Edit(pId);}
		
		$("#btnSave_ManteGuia").on('click',function(e){
			var Res=$("#txtGuia_ManteGuia").val();
			var Telef=$("#txtTelefono_ManteGuia").val();
			var Email=$("#txtEmail_ManteGuia").val();
			var IdEst=$("#chkHabilitado_ManteGuia").is(':checked') ? 1 : 0;
			var IdReg=$("select#cboRegionGuia option:selected").val();
			if(Res!="" && IdReg!="-1"){
				inst.Save_Mante_Guia([pId,Res,Telef,Email,IdEst,IdReg]);
			}else{
				alertify.error("Alerta, Completar Datos.");
			}
		});*/
	}
	this.getList_Mante_Combo_Guia=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"getList_Mante_Combo_Guia"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var Datos=e;
				if(Datos.length>0){
					$("#cboRegionGuia").empty();
					$("#cboRegionGuia").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Datos.length;i++){
						$("#cboRegionGuia").append('<option value="'+Datos[i]["IdRegion"]+'">'+Datos[i]["Region"]+'</option>');					
					}
					$("#cboRegionGuia").chosen({width: "100%"})
				}else{
					$("#cboRegionGuia").empty();
					$("#cboRegionGuia").append('<option value="-1">Seleccione</option>');
					$("#cboRegionGuia").chosen({width: "100%"})
					$('#cboRegionGuia').val(Datos[3]).trigger('chosen:updated')
				}
					
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
	this.getList_Mante_Guia_Edit=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"getList_Mante_Guia_Edit",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();
				if(e.length>0){
					$("#txtGuia_ManteGuia").prop("value",e[0]["Guia"]);
					$("#txtTelefono_ManteGuia").prop("value",e[0]["Telefono"]);
					$("#txtEmail_ManteGuia").prop("value",e[0]["Email"]);
					if(parseInt(e[0]["Estado"])===1){$("#chkHabilitado_ManteGuia").prop('checked', true);}else{$("#chkHabilitado_ManteGuia").prop('checked', false);}
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.Save_Mante_Guia=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"Save_Mante_Guia",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e["Val"]){
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					  $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassTipoUser();inst.Build_Mante_Guia(e["Dato"]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Delete_Mante_Guia=function(pId,IdReg){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"Delete_Mante_Guia",array:[pId,IdReg]},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassTipoUser();inst.Build_Mante_Guia(e["Dato"]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){}
		});
	}
}