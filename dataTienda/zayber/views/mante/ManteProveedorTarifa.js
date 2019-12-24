$(window).on('load',function(){$("#IdAlmacenPri").css("display","none");var inst=new ClassProductoAlm();
	inst.getList_Mante_ProductoAlm();
	$("#cboAlmacen_ProductoAlm").empty();$("#cboAlmacen_ProductoAlm").append('<option value="-1">Seleccione</option>');
	$("#cboAlmacen_ProductoAlm").chosen({width: "100%"});
					
	$("#btnNewProductoAlm").on('click',function(e){
		var IdAlm=$("select#cboAlmacen_ProductoAlm option:selected").val();if(IdAlm!="-1"){inst.Create_Mante_Conductor("-1");}
	});
	$("#cboAlmacen_ProductoAlm").on('change',function(e){$("#IdTableManteProductoAlm tbody").html("");
		var IdAlm=$("select#cboAlmacen_ProductoAlm option:selected").val();if(IdAlm!="-1"){inst.getList_Datos_ProductoAlm(IdAlm);}
	});
});
function ClassProductoAlm(){
	this.getList_Mante_ProductoAlm=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_ProductoAlm"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var Datos=e;
				if(Datos.length>0){
					$("#cboAlmacen_ProductoAlm").empty();$("#cboAlmacen_ProductoAlm").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Datos.length;i++){
						$("#cboAlmacen_ProductoAlm").append('<option value="'+Datos[i]["IdAlmacen"]+'">'+Datos[i]["Almacen"]+'</option>');					
					}
					$("#cboAlmacen_ProductoAlm").chosen({width: "100%"});$('#cboAlmacen_ProductoAlm').val("-1").trigger('chosen:updated');
				}else{
					$("#cboAlmacen_ProductoAlm").empty();$("#cboAlmacen_ProductoAlm").append('<option value="-1">Seleccione</option>');
					$("#cboAlmacen_ProductoAlm").chosen({width: "100%"});$('#cboAlmacen_ProductoAlm').val("-1").trigger('chosen:updated');
				}	
				$("#cboAFP_ManteConductor").chosen({width: "100%"});
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_Datos_ProductoAlm=function(pId){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Datos_ProductoAlm",array:[pId]},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassProductoAlm();
				inst.Build_Mante_ProductoAlm(e);	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Mante_ProductoAlm=function(Datos){var inst=new ClassProductoAlm();
		$("#IdTableManteProductoAlm tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdProducto"];
			$('#IdTableManteProductoAlm tbody').append('<tr>'+
					'<td id="editManteProdAlm_'+ids+'">'+
						'<i class="ion-compose f-18"></i>'+
					'</td>'+
					'<td>'+Datos[i]["Categoria"]+'</td>'+
					'<td>'+Datos[i]["Codigo"]+'</td>'+
					'<td>'+Datos[i]["Producto"]+'</td>'+
					'<td>'+Datos[i]["Unidad"]+'</td>'+
					'<td>'+Datos[i]["PrecioCompra"]+'</td>'+
					'<td>'+Datos[i]["PrecioVenta"]+'</td>'+
					'<td>'+Datos[i]["Stock"]+'</td>'+
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
		
		$('#IdTableManteProductoAlm tbody').unbind("click");
		$('#IdTableManteProductoAlm tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteProdAlm'){inst.Create_Mante_Conductor(id[1]);}
		});
	}
	this.Create_Mante_Conductor=function(pId){var inst=new ClassProductoAlm();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Producto_Alm);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		var IdAlm=$("select#cboAlmacen_ProductoAlm option:selected").val();
		inst.getList_Mante_ProductoAlm_Edit([pId,IdAlm]);
	
		$("#btnSave_ProductoAlm").on('click',function(e){
			var IdProd=$("select#txtProducto_ProdAlm option:selected").val();
			var PC=$("#txtPrecioCompra_ProdAlm").val();
			var PV=$("#txtPrecioVenta_ProdAlm").val();
			if(PC!="" && PV!="" && IdProd!="-1"){
				inst.Save_Mante_ProductoAlm([pId,IdAlm,IdProd,PC,PV]);
			}else{
				alertify.error("Alerta, Completar Datos.");
			}
		});
		$("#txtProducto_ProdAlm").on('change',function(e){
			var IdP=$("select#txtProducto_ProdAlm option:selected").val();
			if(IdAlm!="-1"){
				inst.getList_cbo_ProductoAlm_IdProd([IdP,IdAlm]);
			}else{
				$("#txtPrecioCompra_ProdAlm").prop("value","0");
				$("#txtPrecioVenta_ProdAlm").prop("value","0");
			}
		});
		
	}
	this.getList_Mante_ProductoAlm_Edit=function(params){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_ProductoAlm_Edit",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Produ=e["Produ"],PA=e["PA"];var inst=new ClassProductoAlm();
				if(Produ.length>0){
					$("#txtProducto_ProdAlm").empty();
					$("#txtProducto_ProdAlm").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Produ.length;i++){
						$("#txtProducto_ProdAlm").append('<option value="'+Produ[i]["IdProducto"]+'">'+Produ[i]["Categoria"]+' '+Produ[i]["Producto"]+' '+Produ[i]["Unidad"]+'</option>');					
					}
					$("#txtProducto_ProdAlm").chosen({width: "100%"});
				}else{
					$("#txtProducto_ProdAlm").empty();
					$("#txtProducto_ProdAlm").append('<option value="-1">Seleccione</option>');
					$("#txtProducto_ProdAlm").chosen({width: "100%"});
					$('#txtProducto_ProdAlm').val("-1").trigger('chosen:updated');
				}
				if(PA.length>0){
					$("#txtPrecioCompra_ProdAlm").prop("value",PA[0]["PrecioCompra"]);
					$("#txtPrecioVenta_ProdAlm").prop("value",PA[0]["PrecioVenta"]);
					$('#txtProducto_ProdAlm').val(PA[0]["IdProducto"]).trigger('chosen:updated');			
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.Save_Mante_ProductoAlm=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Mante_ProductoAlm",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					$('#myModal').modal('hide');$('#modal_Manten').html("");
					 $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassProductoAlm();inst.getList_Datos_ProductoAlm(params[1]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_cbo_ProductoAlm_IdProd=function(params){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_cbo_ProductoAlm_IdProd",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();PA=e;var inst=new ClassProductoAlm();
				if(PA.length>0){
					$("#txtPrecioCompra_ProdAlm").prop("value",PA[0]["PrecioCompra"]);
					$("#txtPrecioVenta_ProdAlm").prop("value",PA[0]["PrecioVenta"]);			
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	
}