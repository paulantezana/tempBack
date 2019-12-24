$(window).on('load',function(){var inst=new ClassUserSystem();
	$("#IdAlmacenPri").css("display","none");
	inst.getList_Mante_UserSystem();

	$("#btnNewUserSystem").on('click',function(e){
		inst.Create_Mante_UserSystem("-1");
	});
});
function ClassUserSystem(){
	this.getList_Mante_UserSystem=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"getList_Mante_UserSystem"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassUserSystem();
				inst.Build_Mante_UserSystem(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Mante_UserSystem=function(Datos){var inst=new ClassUserSystem();
		$("#IdTableManteUserSystem tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdUsuario"];
			$('#IdTableManteUserSystem tbody').append('<tr>'+
					'<td id="editManteUserSystem_'+ids+'" class="center">'+
						'<i class="fas fa-edit f-18"></i>'+
					'</td>'+
					'<td>'+Datos[i]["TipoDoc"]+'</td>'+
					'<td>'+Datos[i]["NroDocumento"]+'</td> '+
					'<td>'+Datos[i]["Nombres"]+' '+Datos[i]["ApPaterno"]+' '+Datos[i]["ApMaterno"]+'</td> '+
					'<td>'+Datos[i]["FechaNac"]+'</td> '+
					'<td>'+Datos[i]["Sex"]+'</td> '+
					'<td>'+Datos[i]["Direccion"]+'</td> '+
					'<td>'+Datos[i]["Telefono"]+'</td> '+
					'<td>'+Datos[i]["Email"]+'</td> '+
					'<td>'+Datos[i]["CodUsuario"]+'</td> '+
					'<td>'+Datos[i]["TipoUser"]+'</td> '+
					'<td class="center">'+Datos[i]["Est"]+'</td> '+
					'<td id="ventManteUserSystem_'+ids+'" class="center">'+
						'<i class="fas fa-calendar-check f-20"></i>'+
					'</td>'+
				'</tr>');
		}
		$('#filtrar').keyup(function(){
            var rex = new RegExp($(this).val(), 'i');
            $('.buscar tr').hide();
            $('.buscar tr').filter(function (){
                return rex.test($(this).text());
            }).show();
        });
		
		var altM=parseFloat($(window).height())-parseFloat(270);;
		$(".table-responsive").css({"overflow-y":"scroll","height":altM+"px"});
		
		$('#IdTableManteUserSystem tbody').unbind("click");
		$('#IdTableManteUserSystem tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteUserSystem'){inst.Create_Mante_UserSystem(id[1]);}
			else if(id[0]==='ventManteUserSystem'){inst.Create_Mante_UserSystem_Alm(id[1]);}
		});
	}
	this.Create_Mante_UserSystem=function(pId){var inst=new ClassUserSystem();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_UserSystem);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		inst.getList_Mante_UserSystem_Edit(pId);
		
		$("#txtFechaNac_ManteSystem").datepicker({
			defaultDate: +1,changeMonth: true,numberOfMonths: 1,disableTextInput:true,changeYear:true,onClose: function( selectedDate ){}
		}); 
		$("#txtFechaNac_ManteSystem").datepicker( "option", "dateFormat", "dd/mm/yy" );
		
		$("#btnSave_ManteSystem").on('click',function(e){
			var IdTipoDoc=$("select#cboTipoDoc_ManteSystem option:selected").val();
			var NroDoc=$("#txtNroDoc_ManteSystem").val();
			var Nombres=$("#txtNombre_ManteSystem").val();
			var Paterno=$("#txtApPaterno_ManteSystem").val();
			var Materno=$("#txtApMaterno_ManteSystem").val();
			var FechaNac=$("#txtFechaNac_ManteSystem").val();
			var Sex=$("input[name='genderSystem']:checked").val();
			var Direccion=$("#txtDireccion_ManteSystem").val();
			var Telef=$("#txtTelefono_ManteSystem").val();
			var Email=$("#txtEmail_ManteSystem").val();
			var CodUser=$("#txtCodUser_ManteSystem").val();
			var Passw=$("#txtPassword_ManteSystem").val();
			var IdTipoUser=$("select#cboTipoUser_ManteSystem option:selected").val();
			var Firma=Passw;
			var IdEst=$("#chkHabilitado_ManteSystem").is(':checked') ? 1 : 0;
			var Nivel=3;
			if(NroDoc!="" && Nombres!="" && Paterno!="" && FechaNac!="" && CodUser!=""){
				FechaNac=fecha_Barra_Guion(FechaNac);
				inst.Save_Mante_UserSystem([pId,Nivel,IdTipoDoc,NroDoc,Nombres,Paterno,Materno,FechaNac,Sex,Direccion,Telef,Email,CodUser,Passw,IdTipoUser,Firma,IdEst]);
			}else{
				alertify.error("Alerta, Completar Datos.");
			}
		});
	}
	this.getList_Mante_UserSystem_Edit=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"getList_Mante_UserSystem_Edit",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();var TipoDoc=e["TipoDoc"],TipoUser=e["TipoUser"],User=e["User"];
				if(TipoDoc.length>0){
					$("#cboTipoDoc_ManteSystem").empty();
					//$("#cboTipoDoc_ManteSystem").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<TipoDoc.length;i++){
						$("#cboTipoDoc_ManteSystem").append('<option value="'+TipoDoc[i]["IdTipoDocumento"]+'">'+TipoDoc[i]["TipoDocumento"]+'</option>');					
					}
					$("#cboTipoDoc_ManteSystem").chosen({width: "100%"})
				}else{
					$("#cboTipoDoc_ManteSystem").empty();
					$("#cboTipoDoc_ManteSystem").append('<option value="-1">Seleccione</option>');
					$("#cboTipoDoc_ManteSystem").chosen({width: "100%"})
					$('#cboTipoDoc_ManteSystem').val("-1").trigger('chosen:updated')
				}
				if(TipoUser.length>0){
					$("#cboTipoUser_ManteSystem").empty();
					//$("#cboTipoUser_ManteSystem").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<TipoUser.length;i++){
						$("#cboTipoUser_ManteSystem").append('<option value="'+TipoUser[i]["IdTipoUsuario"]+'">'+TipoUser[i]["Simbolo"]+'</option>');					
					}
					$("#cboTipoUser_ManteSystem").chosen({width: "100%"})
				}else{
					$("#cboTipoUser_ManteSystem").empty();
					$("#cboTipoUser_ManteSystem").append('<option value="-1">Seleccione</option>');
					$("#cboTipoUser_ManteSystem").chosen({width: "100%"})
					$('#cboTipoUser_ManteSystem').val("-1").trigger('chosen:updated')
				}
				if(User.length>0){
					$("#txtNroDoc_ManteSystem").prop("value",User[0]["NroDocumento"]);
					$("#txtNombre_ManteSystem").prop("value",User[0]["Nombres"]);
					$("#txtApPaterno_ManteSystem").prop("value",User[0]["ApPaterno"]);
					$("#txtApMaterno_ManteSystem").prop("value",User[0]["ApMaterno"]);
					$("#txtFechaNac_ManteSystem").prop("value",User[0]["FechaNac"]);
					$("#txtDireccion_ManteSystem").prop("value",User[0]["Direccion"]);
					$("#txtTelefono_ManteSystem").prop("value",User[0]["Telefono"]);
					$("#txtEmail_ManteSystem").prop("value",User[0]["Email"]);
					$("#txtCodUser_ManteSystem").prop("value",User[0]["CodUsuario"]);
					
					$("#txtPassword_ManteSystem").prop("value","");
					$('#cboTipoDoc_ManteSystem').val(User[0]["IdTipoDocumento"]).trigger('chosen:updated');
					$('#cboTipoUser_ManteSystem').val(User[0]["IdTipoUsuario"]).trigger('chosen:updated');
					if(parseInt(User[0]["Estado"])===1){$("#chkHabilitado_ManteSystem").prop('checked', true);}else{$("#chkHabilitado_ManteSystem").prop('checked', false);}
					if(parseInt(User[0]["Sexo"])===1){$("#rbtMS").prop('checked', true);}else{$("#rbtFS").prop('checked', false);}
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});	
	}
	this.Save_Mante_UserSystem=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"Save_Mante_UserSystem",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e["Val"]){
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					 $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassUserSystem();inst.Build_Mante_UserSystem(e["Dato"]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Create_Mante_UserSystem_Alm=function(pId){var inst=new ClassUserSystem();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_UserVenta_System);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		inst.getList_Mante_UserSystem_Venta(pId);
		
		$("#btnSave_ManteHabUserSystemAlm").on('click',function(e){
			var arrayDat=[];
			$(".chkConfUserAlmSystem").each(function(e){
				var ids=($(this)[0].id).split('_')[1],chkk=$(this)[0].checked;
				if(chkk){arrayDat.push({"aId":ids}); }
			});
			inst.Save_Config_UserSystem_Alm([pId,arrayDat]);
		});
	}
	this.getList_Mante_UserSystem_Venta=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"getList_Mante_UserSystem_Venta",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Alm=e["Alm"],Dat=e["Dat"];var inst=new ClassUserSystem();
				if(Alm.length>0){
					inst.Build_Mante_User_Alm(Alm,Dat);
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});	
	}
	this.Build_Mante_User_Alm=function(Datos,Hab){
		$("#IdTableConfHabUserSystemAlm tbody").html("");
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdAlmacen"];
			$('#IdTableConfHabUserSystemAlm tbody').append('<tr>'+
				'<td>'+Datos[i]["Almacen"]+'</td>'+
				'<td id="delManteRegion_'+ids+'" class="center">'+
					'<input type="checkbox" class="chk2020 chkConfUserAlmSystem" id="chkHabUserAlmSystem_'+ids+'">'+
				'</td> '+
			'</tr>');
		}
		if(Hab.length>0){
			for(var i=0;i<Hab.length;i++){
				var ids=Hab[i]["IdAlmacen"];
				$("#chkHabUserAlmSystem_"+ids).prop('checked', true);
			}
		}
	}
	this.Save_Config_UserSystem_Alm=function(params){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"Save_Config_UserSystem_Alm",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
				}else{alertify.error("Error, Proceso Incorrecto.");}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});	
	}
}