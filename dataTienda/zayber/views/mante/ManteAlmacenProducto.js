$(window).on('load',function(){var inst=new ClassProductoAlm();
	$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmPrdAlm").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmPrdAlm").html();
					
	$("#btnNewProductoAlm").on('click',function(e){if(IdAlm!="-1"){inst.Create_Mante_ProductoAlm("-1","-1");}});
	if(IdAlm!="-1"){inst.getList_Datos_ProductoAlm(IdAlm);}
	$("#cboExportar_RVenta").on('click',function(e){
		//window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdTableManteProductoAlm').html()));
		
	});
});
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
function ClassProductoAlm(){
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
			var ids=Datos[i]["IdProducto"]+'_'+Datos[i]["IdUnidad"];
			$('#IdTableManteProductoAlm tbody').append('<tr>'+
					'<td id="editManteProdAlm_'+ids+'" class="center">'+
						'<i class="fas fa-edit f-18"></i>'+
					'</td>'+
					'<td>'+Datos[i]["Codigo"]+' .</td>'+
					'<td>'+Datos[i]["Producto"]+'</td>'+
					'<td>'+Datos[i]["Marc"]+'</td>'+
					'<td>'+Datos[i]["Categ"]+'</td>'+
					'<td>'+Datos[i]["Unidad"]+'</td>'+
					'<td>'+Datos[i]["PrecioCompra"]+'</td>'+
					'<td>'+Datos[i]["PrecioBase"]+'</td>'+
					'<td>'+Datos[i]["PrecioDistribuido"]+'</td>'+
					'<td>'+Datos[i]["PrecioPublico"]+'</td>'+
					'<td>'+Datos[i]["Moneda"]+'</td>'+
					'<td>'+Datos[i]["Stock"]+'</td>'+
					'<td>'+Datos[i]["Est"]+'</td>'+
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
		$(".table-responsive").css({"overflow-y":"scroll","height":altM+"px"});
		
		$('#IdTableManteProductoAlm tbody').unbind("click");
		$('#IdTableManteProductoAlm tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteProdAlm'){inst.Create_Mante_ProductoAlm(id[1],id[2]);}
		});
	}
	this.Create_Mante_ProductoAlm=function(pId,pIdUnidad){var inst=new ClassProductoAlm();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Producto_Alm);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		var IdAlm=$("#IdAlmPrdAlm").html();
		inst.getList_Mante_ProductoAlm_Edit([pId,pIdUnidad,IdAlm]);
	
		$("#btnSave_ProductoAlm").on('click',function(e){
			var IdProd=$("select#txtProducto_ProdAlm option:selected").val();
			var IdUnidad=$("select#txtUnidad_ProdAlm option:selected").val();
			var IdMoneda=$("select#txtMoneda_ProdAlm option:selected").val();
			var PComp=$("#txtPrecioCompra_ProdAlm").val();
			var PBase=$("#txtPrecioBase_ProdAlm").val();
			var PDistribuido=$("#txtPrecioDistribuido_ProdAlm").val();
			var PPublico=$("#txtPrecioPublico_ProdAlm").val();
			var TC=$("#txtTipoCambio_ProdAlm").val();
			var IdEst=$("#chkHabilitado_ProdAlm").is(':checked') ? 1 : 0;
			if(PComp!="" && PBase!="" && PDistribuido!="" && PPublico!="" && IdProd!="-1" && IdUnidad!="-1" && IdMoneda!="-1" && TC!=""){
				inst.Save_Mante_ProductoAlm([pId,IdAlm,IdProd,PComp,PBase,PDistribuido,PPublico,IdUnidad,IdMoneda,IdEst,TC]);
			}else{
				alertify.error("Alerta, Completar Datos.");
			}
		});
		$("#txtProducto_ProdAlm").on('change',function(e){
			$("#txtPrecioCompra_ProdAlm").prop("value","0");
			$("#txtPrecioBase_ProdAlm").prop("value","0");
			$("#txtPrecioDistribuido_ProdAlm").prop("value","0");
			$("#txtPrecioPublico_ProdAlm").prop("value","0");
			var IdP=$("select#txtProducto_ProdAlm option:selected").val();
			var IdUnidad=$("select#txtUnidad_ProdAlm option:selected").val();
			if(IdP!="-1" && IdUnidad!="-1"){
				inst.getList_cbo_ProductoAlm_IdProd([IdP,IdAlm,IdUnidad]);
			}
		});
		$("#txtUnidad_ProdAlm").on('change',function(e){
			$("#txtPrecioCompra_ProdAlm").prop("value","0");
			$("#txtPrecioBase_ProdAlm").prop("value","0");
			$("#txtPrecioDistribuido_ProdAlm").prop("value","0");
			$("#txtPrecioPublico_ProdAlm").prop("value","0");
			var IdP=$("select#txtProducto_ProdAlm option:selected").val();
			var IdUnidad=$("select#txtUnidad_ProdAlm option:selected").val();
			if(IdP!="-1" && IdUnidad!="-1"){
				inst.getList_cbo_ProductoAlm_IdProd([IdP,IdAlm,IdUnidad]);
			}
		});
	}
	this.getList_Mante_ProductoAlm_Edit=function(params){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_ProductoAlm_Edit",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Produ=e["Produ"],PA=e["PA"],Unidad=e["Unidad"],Moneda=e["Moneda"];var inst=new ClassProductoAlm();
				if(Unidad.length>0){
					$("#txtUnidad_ProdAlm").empty();
					for(var i=0;i<Unidad.length;i++){
						$("#txtUnidad_ProdAlm").append('<option value="'+Unidad[i]["IdUnidad"]+'">'+Unidad[i]["Unidad"]+'</option>');					
					}
					$("#txtUnidad_ProdAlm").chosen({width: "100%"});
				}else{
					$("#txtUnidad_ProdAlm").empty();
					$("#txtUnidad_ProdAlm").append('<option value="-1">Seleccione</option>');
					$("#txtUnidad_ProdAlm").chosen({width: "100%"});
					$('#txtUnidad_ProdAlm').val("-1").trigger('chosen:updated');
				}
				if(Moneda.length>0){
					$("#txtMoneda_ProdAlm").empty();
					for(var i=0;i<Moneda.length;i++){
						$("#txtMoneda_ProdAlm").append('<option value="'+Moneda[i]["IdMoneda"]+'">'+Moneda[i]["Simbolo"]+'</option>');					
					}
					$("#txtMoneda_ProdAlm").chosen({width: "100%"});
				}else{
					$("#txtMoneda_ProdAlm").empty();
					$("#txtMoneda_ProdAlm").append('<option value="-1">Seleccione</option>');
					$("#txtMoneda_ProdAlm").chosen({width: "100%"});
					$('#txtMoneda_ProdAlm').val("-1").trigger('chosen:updated');
				}
				if(Produ.length>0){
					$("#txtProducto_ProdAlm").empty();
					$("#txtProducto_ProdAlm").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Produ.length;i++){
						$("#txtProducto_ProdAlm").append('<option value="'+Produ[i]["IdProducto"]+'">'+Produ[i]["Codigo"]+'  '+Produ[i]["Producto"]+'</option>');					
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
					$("#txtPrecioBase_ProdAlm").prop("value",PA[0]["PrecioBase"]);
					$("#txtTipoCambio_ProdAlm").prop("value",PA[0]["TipoCambio"]);
					$("#txtPrecioDistribuido_ProdAlm").prop("value",PA[0]["PrecioDistribuido"]);
					$("#txtPrecioPublico_ProdAlm").prop("value",PA[0]["PrecioPublico"]);
					$('#txtProducto_ProdAlm').val(PA[0]["IdProducto"]).trigger('chosen:updated');			
					$('#txtUnidad_ProdAlm').val(PA[0]["IdUnidad"]).trigger('chosen:updated');			
					$('#txtMoneda_ProdAlm').val(PA[0]["IdMoneda"]).trigger('chosen:updated');	
					if(parseInt(PA[0]["Estado"])===1){$("#chkHabilitado_ProdAlm").prop('checked', true);}else{$("#chkHabilitado_ProdAlm").prop('checked', false);}
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
	this.Delete_Mante_ProductoAlm=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Delete_Mante_ProductoAlm",array:params},
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
					$("#txtPrecioBase_ProdAlm").prop("value",PA[0]["PrecioBase"]);
					$("#txtPrecioDistribuido_ProdAlm").prop("value",PA[0]["PrecioDistribuido"]);
					$("#txtPrecioPublico_ProdAlm").prop("value",PA[0]["PrecioPublico"]);
					$("#txtTipoCambio_ProdAlm").prop("value",PA[0]["TipoCambio"]);
					$('#txtMoneda_ProdAlm').val(PA[0]["IdMoneda"]).trigger('chosen:updated');
					if(parseInt(PA[0]["Estado"])===1){$("#chkHabilitado_ProdAlm").prop('checked', true);}else{$("#chkHabilitado_ProdAlm").prop('checked', false);}					
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	
}