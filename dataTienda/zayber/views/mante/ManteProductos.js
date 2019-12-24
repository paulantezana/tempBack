$(window).on('load',function(){var inst=new ClassProductos();$("#IdAlmacenPri").css("display","none");
	inst.getList_Mante_Productos();
	$("#btnNewProductos").on('click',function(e){inst.Create_Mante_Productos("-1");});
	
});
function ClassProductos(){
	this.getList_Mante_Productos=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Productos"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassProductos();
				inst.Build_Mante_Productos(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Mante_Productos=function(Datos){
		$("#IdTableManteProductos tbody").html("");var inst=new ClassProductos();	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdProducto"];
			$('#IdTableManteProductos tbody').append('<tr>'+
					'<td id="editManteProduct_'+ids+'" class="center">'+
						'<i class="fas fa-edit f-18"></i>'+
					'</td>'+
					'<td>'+Datos[i]["Codigo"]+'</td>'+
					'<td>'+Datos[i]["Producto"]+'</td>'+
					'<td>'+Datos[i]["Categoria"]+'</td>'+
					'<td>'+Datos[i]["Marca"]+'</td>'+
					'<td class="center">'+Datos[i]["Est"]+'</td>'+
				'</tr>');
		}
		$('#filtrar').keyup(function(){
            var rex = new RegExp($(this).val(), 'i');
            $('.buscar tr').hide();
            $('.buscar tr').filter(function (){
                return rex.test($(this).text());
            }).show();
        });
		
		var altM=parseFloat($(window).height())-parseFloat(230);;
		$("#IdContentManteProductos").css({"overflow-y":"scroll","height":altM+"px"});
		
		$('#IdTableManteProductos tbody').unbind("click");
		$('#IdTableManteProductos tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteProduct'){
				inst.Create_Mante_Productos(id[1]);
				/*(function(){vex.defaultOptions.className = 'vex-theme-os';})();
				vex.dialog.confirm({ message:'Desea Editar?', 
					callback: function(ee){
						if(ee){inst.Create_Mante_Productos(id[1]);}
				}});*/
			}
		});
	}
	this.Create_Mante_Productos=function(pId){var inst=new ClassProductos();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Mante_Productos);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		$("#cboMarca_ManteProductos").empty();$("#cboMarca_ManteProductos").append('<option value="-1">Seleccione</option>');
		$("#cboMarca_ManteProductos").chosen({width: "100%"});
		$("#cboCategoria_ManteProductos").empty();$("#cboCategoria_ManteProductos").append('<option value="-1">Seleccione</option>');
		$("#cboCategoria_ManteProductos").chosen({width: "100%"});
		
		inst.getList_ManteProductos_Edit(pId);
		
		$("#txtSave_ManteProductos").on('click',function(e){
			var Codigo=$("#txtCodigo_ManteProductos").val();
			var Prodc=$("#txtProducto_ManteProductos").val();
			var IdMarca=$("select#cboMarca_ManteProductos option:selected").val();
			var IdCategoria=$("select#cboCategoria_ManteProductos option:selected").val();
			var IdEst=$("#chkHabilitado_MantProducto").is(':checked') ? 1 : 0;
			
			if(Codigo!="" && Prodc!="" && IdMarca!="-1" && IdCategoria!="-1"){
				inst.Save_Mante_Productos([pId,Codigo,Prodc,IdMarca,IdCategoria,IdEst]);
			}else{
				alertify.error("Alerta, Completar Datos.");
			}
		});
		
	}
	this.getList_ManteProductos_Edit=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_ManteProductos_Edit",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Categoria=e["Categoria"],Marca=e["Marca"],Unidad=e["Unidad"],Dato=e["Produ"];var inst=new ClassProductos();
				if(Categoria.length>0){
					$("#cboCategoria_ManteProductos").empty();
					$("#cboCategoria_ManteProductos").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Categoria.length;i++){
						$("#cboCategoria_ManteProductos").append('<option value="'+Categoria[i]["IdCategoria"]+'">'+Categoria[i]["Categoria"]+'</option>');
					}
					$("#cboCategoria_ManteProductos").chosen({width: "100%"});$('#cboCategoria_ManteProductos').val("-1").trigger('chosen:updated');
				}else{
					$("#cboCategoria_ManteProductos").empty();
					$("#cboCategoria_ManteProductos").append('<option value="-1">Seleccione</option>');
					$("#cboCategoria_ManteProductos").chosen({width: "100%"});$('#cboCategoria_ManteProductos').val("-1").trigger('chosen:updated');
				}
				if(Marca.length>0){
					$("#cboMarca_ManteProductos").empty();
					$("#cboMarca_ManteProductos").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Marca.length;i++){
						$("#cboMarca_ManteProductos").append('<option value="'+Marca[i]["IdMarca"]+'">'+Marca[i]["Marca"]+'</option>');
					}
					$("#cboMarca_ManteProductos").chosen({width: "100%"});$('#cboMarca_ManteProductos').val("-1").trigger('chosen:updated');
				}else{
					$("#cboMarca_ManteProductos").empty();
					$("#cboMarca_ManteProductos").append('<option value="-1">Seleccione</option>');
					$("#cboMarca_ManteProductos").chosen({width: "100%"});$('#cboMarca_ManteProductos').val("-1").trigger('chosen:updated');
				}
				
				if(Dato.length>0){
					$('#cboCategoria_ManteProductos').val(Dato[0]["IdCategoria"]).trigger('chosen:updated');
					$('#cboMarca_ManteProductos').val(Dato[0]["IdMarca"]).trigger('chosen:updated');
					$("#txtCodigo_ManteProductos").prop("value",Dato[0]["Codigo"]);
					$("#txtProducto_ManteProductos").prop("value",Dato[0]["Producto"]);
					
					if(parseInt(Dato[0]["Estado"])===1){$("#chkHabilitado_MantProducto").prop('checked', true);}else{$("#chkHabilitado_MantProducto").prop('checked', false);}
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});	
	}
	this.Save_Mante_Productos=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Mante_Productos",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassProductos();inst.getList_Mante_Productos();
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
}