$(window).on('load',function(){var inst=new ClassCliente();$("#IdAlmacenPri").css("display","none");
	inst.getList_Mante_Cliente();
	$("#btnNewCliente").on('click',function(e){inst.Create_Mante_Cliente("-1");});

});
function ClassCliente(){
	this.getList_Mante_Cliente=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Cliente"},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				var inst=new ClassCliente();inst.Build_Mante_Cliente(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Mante_Cliente=function(Datos){var inst=new ClassCliente();
		$("#IdTableManteCliente tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdCliente"];
			$('#IdTableManteCliente tbody').append('<tr>'+
					'<td id="editManteCliente_'+ids+'" class="center">'+
						'<i class="fas fa-edit f-18"></i>'+
					'</td>'+
					'<td>'+Datos[i]["NroDocumento"]+'</td>'+
					'<td>'+Datos[i]["NombreRS"]+'</td> '+
					'<td>'+Datos[i]["Direccion"]+'</td> '+
					'<td>'+Datos[i]["Telefono"]+'</td> '+
					'<td>'+Datos[i]["Email"]+'</td> '+
					'<td>'+Datos[i]["Obs"]+'</td> '+
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
		
		var altM=parseFloat($(window).height())-parseFloat(240);;
		$(".table-responsive").css({"overflow-y":"scroll","height":altM+"px"});
		
		$('#IdTableManteCliente tbody').unbind("click");
		$('#IdTableManteCliente tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteCliente'){inst.Create_Mante_Cliente(id[1]);}
		});
	}
	this.Create_Mante_Cliente=function(pId){var inst=new ClassCliente();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Cliente);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		if(pId!="-1"){inst.getList_Mante_Cliente_Edit(pId);}
		$("#txtRuc_ManteCliente").keyup(function (e){
			if(e.which == 13){
				var nroR=$("#txtRuc_ManteCliente").val();
				if(nroR!="" && nroR.length===11){
					inst.getList_NroRuc_Client([nroR]);
				}
			}
		});
		
		$("#btnSave_ManteCliente").on('click',function(e){
			var Ruc=$("#txtRuc_ManteCliente").val();
			var RS=$("#txtRazonSocial_ManteCliente").val();
			var Direccion=$("#txtDireccionFiscal_ManteCliente").val();
			var Telef=$("#txtTelefono_ManteCliente").val();
			var Email=$("#txtEmail_ManteCliente").val();
			var Obs=$("#txtObs_ManteCliente").val();
			var IdEst=$("#chkHabilitado_ManteCliente").is(':checked') ? 1 : 0;
			if(Ruc!="" && RS!="" && (Ruc.length===11 || Ruc.length===8)){
				inst.Save_Mante_Cliente([pId,Ruc,RS,Direccion,Telef,Email,Obs,IdEst]);
			}else{
				alertify.error("Alerta, Completar Datos.");
			}
		});
	}
	this.getList_Mante_Cliente_Edit=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Cliente_Edit",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();
				if(e.length>0){
					$("#txtRuc_ManteCliente").prop("value",e[0]["NroDocumento"]);
					$("#txtRazonSocial_ManteCliente").prop("value",e[0]["NombreRS"]);
					$("#txtDireccionFiscal_ManteCliente").prop("value",e[0]["Direccion"]);
					$("#txtTelefono_ManteCliente").prop("value",e[0]["Telefono"]);
					$("#txtEmail_ManteCliente").prop("value",e[0]["Email"]);
					$("#txtObs_ManteCliente").prop("value",e[0]["Obs"]);
					if(parseInt(e[0]["Estado"])===1){$("#chkHabilitado_ManteCliente").prop('checked', true);}else{$("#chkHabilitado_ManteCliente").prop('checked', false);}
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.Save_Mante_Cliente=function(params){var inst=new ClassCliente();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Mante_Cliente",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					  $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					inst.getList_Mante_Cliente();
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_NroRuc_Client=function(params){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_RecuperarRS_Nubefact",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e[0]["Dato"];console.log(e);
				if(e[0]["success"]){
					$("#txtRazonSocial_ManteCliente").prop("value",Dato["nombre_o_razon_social"]);
					$("#txtDireccionFiscal_ManteCliente").prop("value",Dato["direccion_completa"]);
				}else{
					$("#txtRazonSocial_ManteCliente").prop("value","");
					$("#txtDireccionFiscal_ManteCliente").prop("value","");
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}

}