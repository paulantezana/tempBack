$(window).on('load',function(){var inst=new ClassAlmacen();$("#IdAlmacenPri").css("display","none");
	inst.getList_Mante_Almacen();
	$("#btnNewAlmacen").on('click',function(e){
		inst.Create_Mante_Almacen("-1");
	});
	

});
function ClassAlmacen(){
	this.getList_Mante_Almacen=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Almacen"},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				var inst=new ClassAlmacen();inst.Build_Mante_Almacen(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Mante_Almacen=function(Datos){
		$("#IdTableManteAlmacen tbody").html("");var inst=new ClassAlmacen();	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdAlmacen"];
			$('#IdTableManteAlmacen tbody').append('<tr>'+
					'<td id="editManteAlmacen_'+ids+'" class="center">'+
						'<i class="fas fa-edit f-18"></i>'+
					'</td>'+
					'<td>'+Datos[i]["Almacen"]+'</td>'+
					'<td>'+Datos[i]["Simbolo"]+'</td> '+
					'<td>'+Datos[i]["Descripcion"]+'</td> '+
					'<td>'+Datos[i]["Ruc"]+'</td> '+
					'<td>'+Datos[i]["RazonSocial"]+'</td> '+
					'<td>'+Datos[i]["Direccion"]+'</td> '+
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
		
		var altM=parseFloat($(window).height())-parseFloat(270);;
		$(".table-responsive").css({"overflow-y":"scroll","height":altM+"px"});
		
		$('#IdTableManteAlmacen tbody').unbind("click");
		$('#IdTableManteAlmacen tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteAlmacen'){inst.Create_Mante_Almacen(id[1]);}
		});
	}
	this.Create_Mante_Almacen=function(pId){var inst=new ClassAlmacen();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Mante_Almacen);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		if(pId!="-1"){inst.getList_Mante_Almacen_Edit(pId);}
		
		$("#txtSave_Almc").on('click',function(e){
			var Alm=$("#txtAlmacen_Almc").val();
			var Simbolo=$("#txtSimbolo_Almc").val();
			var Descrip=$("#txtDescrip_Almc").val();
			var Ruc=$("#txtRuc_Almc").val();
			var RazonSocial=$("#txtRazonSocial_Almc").val();
			var Direccion=$("#txtDireccion_Almc").val();
			var ColorFondo=$("#colorFondo_Almc").val();
			var ColorTexto=$("#colorTexto_Almc").val();
			var IdEst=$("#chkHabilitado_Almc").is(':checked') ? 1 : 0;
			
			if(Alm!="" && Simbolo!=""){
				inst.Save_Mante_Almacen([pId,Alm,Simbolo,Descrip,Ruc,RazonSocial,Direccion,ColorFondo,ColorTexto,IdEst]);
			}else{
				alertify.error("Alerta, Completar Datos.");
			}
		});
	}
	this.getList_Mante_Almacen_Edit=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Almacen_Edit",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e;
				if(Dato.length>0){
					$("#txtAlmacen_Almc").prop("value",Dato[0]["Almacen"]);
					$("#txtSimbolo_Almc").prop("value",Dato[0]["Simbolo"]);
					$("#txtDescrip_Almc").prop("value",Dato[0]["Descripcion"]);
					$("#txtRuc_Almc").prop("value",Dato[0]["Ruc"]);
					$("#txtRazonSocial_Almc").prop("value",Dato[0]["RazonSocial"]);
					$("#txtDireccion_Almc").prop("value",Dato[0]["Direccion"]);
					$("#colorFondo_Almc").prop("value",Dato[0]["ColorFondo"]);
					$("#colorTexto_Almc").prop("value",Dato[0]["ColorTexto"]);
					
					if(parseInt(Dato[0]["Estado"])===1){$("#chkHabilitado_Almc").prop('checked', true);}else{$("#chkHabilitado_Almc").prop('checked', false);}
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.Save_Mante_Almacen=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Mante_Almacen",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					  $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassAlmacen();inst.getList_Mante_Almacen();
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Delete_Mante_Almacen=function(pId,IdReg){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Delete_Mante_Almacen",array:[pId,IdReg]},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassAlmacen();inst.Build_Mante_Almacen(e["Dato"]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){}
		});
	}
}