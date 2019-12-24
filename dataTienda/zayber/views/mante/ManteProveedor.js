$(window).on('load',function(){var inst=new ClassProveedor();$("#IdAlmacenPri").css("display","none");
	inst.getList_Mante_Proveedor();
	$("#btnNewProveedor").on('click',function(e){inst.Create_Mante_Proveedor("-1");});
});
function ClassProveedor(){
	this.getList_Mante_Proveedor=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Proveedor"},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				var inst=new ClassProveedor();inst.Build_Mante_Proveedor(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Mante_Proveedor=function(Datos){var inst=new ClassProveedor();
		$("#IdTableManteProveedor tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdProveedor"];
			$('#IdTableManteProveedor tbody').append('<tr>'+
					'<td id="editManteProveedor_'+ids+'" class="center">'+
						'<i class="fas fa-edit f-18"></i>'+
					'</td>'+
					'<td>'+Datos[i]["Comercial"]+'</td>'+
					'<td>'+Datos[i]["Ruc"]+'</td> '+
					'<td>'+Datos[i]["RazonSocial"]+'</td> '+
					'<td>'+Datos[i]["Direccion"]+'</td> '+
					'<td>'+Datos[i]["Telefono"]+'</td> '+
					'<td>'+Datos[i]["Email"]+'</td> '+
					'<td>'+Datos[i]["Responsable"]+'</td> '+
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
		
		$('#IdTableManteProveedor tbody').unbind("click");
		$('#IdTableManteProveedor tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteProveedor'){inst.Create_Mante_Proveedor(id[1]);}
		});
	}
	this.Create_Mante_Proveedor=function(pId){var inst=new ClassProveedor();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Proveedor);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		if(pId!="-1"){inst.getList_Mante_Proveedor_Edit(pId);}
		
		$("#btnSave_ManteProveedor").on('click',function(e){
			var comer=$("#txtNComercial_ManteProveedor").val();
			var Ruc=$("#txtRuc_ManteProveedor").val();
			var RS=$("#txtRazonSocial_ManteProveedor").val();
			var Direccion=$("#txtDireccionFiscal_ManteProveedor").val();
			var Telef=$("#txtTelefono_ManteProveedor").val();
			var Email=$("#txtEmail_ManteProveedor").val();
			var Repre=$("#txtRepresentante_ManteProveedor").val();
			var Obs=$("#txtObs_ManteProveedor").val();
			var IdEst=$("#chkHabilitado_Manteproveedor").is(':checked') ? 1 : 0;
			if(comer!="" && Ruc!="" && RS!="" && (Ruc.length===11 || Ruc.length===8)){
				inst.Save_Mante_Proveedor([pId,comer,Ruc,RS,Direccion,Telef,Email,Repre,Obs,IdEst]);
			}else{
				alertify.error("Alerta, Completar Datos.");
			}
		});
		$("#txtRuc_ManteProveedor").keyup(function (e){
			if(e.which == 13){
				var nroR=$("#txtRuc_ManteProveedor").val();
				if(nroR!="" && nroR.length===11){
					inst.getList_NroRuc_Client([nroR]);
				}
			}
		});
	}
	this.getList_Mante_Proveedor_Edit=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Proveedor_Edit",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();
				if(e.length>0){
					$("#txtNComercial_ManteProveedor").prop("value",e[0]["Comercial"]);
					$("#txtRuc_ManteProveedor").prop("value",e[0]["Ruc"]);
					$("#txtRazonSocial_ManteProveedor").prop("value",e[0]["RazonSocial"]);
					$("#txtDireccionFiscal_ManteProveedor").prop("value",e[0]["Direccion"]);
					$("#txtTelefono_ManteProveedor").prop("value",e[0]["Telefono"]);
					$("#txtEmail_ManteProveedor").prop("value",e[0]["Email"]);
					$("#txtRepresentante_ManteProveedor").prop("value",e[0]["Responsable"]);
					$("#txtObs_ManteProveedor").prop("value",e[0]["Obs"]);
					if(parseInt(e[0]["Estado"])===1){$("#chkHabilitado_Manteproveedor").prop('checked', true);}else{$("#chkHabilitado_Manteproveedor").prop('checked', false);}
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.Save_Mante_Proveedor=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Mante_Proveedor",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					  $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassProveedor();inst.getList_Mante_Proveedor();
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_NroRuc_Client=function(params){console.log(params);
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_RecuperarRS_Nubefact",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e[0]["Dato"];console.log(e);
				if(e[0]["success"]){
					$("#txtRazonSocial_ManteProveedor").prop("value",Dato["nombre_o_razon_social"]);
					$("#txtDireccionFiscal_ManteProveedor").prop("value",Dato["direccion_completa"]);
				}else{
					$("#txtRazonSocial_ManteProveedor").prop("value","");
					$("#txtDireccionFiscal_ManteProveedor").prop("value","");
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});	
	}
}
