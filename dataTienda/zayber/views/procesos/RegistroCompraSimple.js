$(window).on('load',function(){var inst=new ClassCompraSimple();
	$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmCompSimple").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmCompSimple").html();
	$("#cboUnidad_ProcCompra").chosen({width: "100%"});
	inst.getList_combo_Compra([IdAlm]);
	$("#txtCodigo_ProcCS").keyup(function (e){if(e.which == 13){var CP=$("#txtCodigo_ProcCS").val();if(IdAlm!="-1" && CP!="" && CP.length>2){inst.getList_Producto_Codigo_CS([IdAlm,CP]);}}});
	$('input:radio[name=rbtTipoPrecioCS]').on('click',function(e){inst.Calcular_Importe_CS();});
	$("#txtCantidad_ProcCS").focusout(function(){inst.Calcular_Importe_CS();});
	$("#txtCantidad_ProcCS").keyup(function (e){if(e.which == 13){$("#txtPCompra_ProcCS").focus();inst.Calcular_Importe_CS();}});
	$("#txtPCompra_ProcCS").keyup(function (e){if(e.which == 13){$("#txtPPublico_ProcCS").focus();inst.Calcular_Importe_CS();}});
	$("#txtPPublico_ProcCS").keyup(function (e){if(e.which == 13){$("#btnAdd_ProcCS").focus();inst.Calcular_Importe_CS();}});
	$("#btnSearchProd_ProcCS").on('click',function(e){inst.Build_Modal_Productos_CS();});
	
	$("#btnAdd_ProcCS").on('click',function(e){
		if(IdAlm!="-1"){
			var IdProd=$("#lblIdProductoProcCS").html();
			var Cod=$("#txtCodigo_ProcCS").val();
			var producto=$("#txtProducto_ProcCS").val();
			var Marca=$("#txtMarca_ProcCS").val();
			var Modelo=$("#txtModelo_ProcCS").val();
			//var Unidad=$("#cboUnidad_ProcCompra").val();
			var Unidad=$('#cboUnidad_ProcCompra option:selected').text();
			var IdUnidad=$("#cboUnidad_ProcCompra").val();
			var Cant=$("#txtCantidad_ProcCS").val();
			var PCompra=$("#txtPCompra_ProcCS").val();
			var Importe=$("#txtImporte_ProcCS").val();
			var PPublic=$("#txtPPublico_ProcCS").val();
			var PMenor=$("#txtPMenor_ProcCS").val();
			var PMayor=$("#txtPMayor_ProcCS").val();
			var TC=$("#txtTC_ProcCS").val();
			
			if(IdProd!="-1" && Cant!="" && producto!="" && Cod!="" && Importe!="" && PPublic!="" && PMenor!="" && PMayor!="" && PCompra!="" && TC!=""){
				var EP=inst.Verificar_Existe_Product_Detail_CS(IdProd);
				if(EP){
					inst.Build_Detail_VentaAdd_CS([IdProd,Cod,producto+' '+Marca+' '+Modelo,Unidad,Cant,PCompra,Importe,PPublic,PMenor,PMayor,TC,IdUnidad]);
					inst.Clear_Detail_VentaAdd_CS();
					$("#txtCodigo_ProcCS").focus();
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Producto ya existe en detalle.");
				}
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");
			}
		}else{
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Error en proceso.");
		}
	});	

	$("#txtPCompra_ProcCS").focusout(function(){inst.Calcular_Importe_CS();});
	$("#txtPCompra_ProcCS").keyup(function (e){if(e.which == 13){$("#txtPPublico_ProcCS").focus();inst.Calcular_Importe_CS();}});
	
	//$("#txtPPublico_ProcCS").keyup(function (e){if(e.which == 13){$("#txtPMenor_ProcCS").focus();}});
	//$("#txtPMenor_ProcCS").keyup(function (e){if(e.which == 13){$("#txtPMayor_ProcCS").focus();}});
	//$("#txtPMayor_ProcCS").keyup(function (e){if(e.which == 13){$("#btnAdd_ProcCS").focus();}});
	$("#btnComprar_ProcCS").on('click',function(e){
		var Respo=$("#txtObs_ProcCS").val();
		var Total=$("#txtTotal_ProcCS").val();
		var Detail=[];
		$("#IdTable_DetalleC_ProcCS tbody tr").each(function (index){
			var aCantidad=$(this).find("td").eq(1).html();
			var aCodigo=$(this).find("td").eq(2).html();
			var aDescripcion=$(this).find("td").eq(3).html();
			var aUnidad=$(this).find("td").eq(4).html();
			var aPCompra=$(this).find("td").eq(5).html();
			var aImporte=$(this).find("td").eq(6).html();
			var aPPublico=$(this).find("td").eq(7).html();
			var aPMenor=$(this).find("td").eq(8).html();
			var aPMayor=$(this).find("td").eq(9).html();
			var aIdProducto=$(this).find("td").eq(10).html();
			var aTC=$(this).find("td").eq(11).html();
			var aIdUnidad=$(this).find("td").eq(12).html();
			
			Detail.push({"aCantidad":aCantidad,"aCodigo":aCodigo,"aDescripcion":aDescripcion,"aUnidad":aUnidad,
							"aPCompra":aPCompra,"aImporte":aImporte,"aIdProducto":aIdProducto,
							"aPPublico":aPPublico,"aPMenor":aPMenor,"aPMayor":aPMayor,"aTC":aTC,"aidUnidad":aIdUnidad});
		});
		if(Detail.length>0 && Respo!="" && Total!=""){
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.confirm({ message:'Desea Guardar?', 
					callback: function(ee){if(ee){
						var pa=[];
						pa.push({"aRespo":Respo,"aTotal":Total,"aIdAlm":IdAlm,"aAlm":Alm,"aDetail":Detail});
						inst.Save_Datos_CompraSimple(pa);
					}}});
		}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");}
	});
	$("#btnClear_ProcCS").on('click',function(e){
		(function(){vex.defaultOptions.className = 'vex-theme-os';})();
		vex.dialog.confirm({ message:'Desea Limpiar Compra Simple?',callback: function(ee){
			if(ee){
				$("#IdTable_DetalleC_ProcCS tbody").html("");$("#txtObs_ProcCS").prop("value","");inst.Clear_Detail_VentaAdd_CS();$("#txtTotal_ProcCS").prop("value","0");
			}
		}});
	});
});
function ClassCompraSimple(){
	this.getList_combo_Compra=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_combo_Compra",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();Compro=e["Compro"],Prove=e["Prove"];Unida=e["Unidad"];var inst=new ClassCompraSimple();
				if(Unida.length>0){
					$("#cboUnidad_ProcCompra").empty();
					for(var i=0;i<Unida.length;i++){$("#cboUnidad_ProcCompra").append('<option value="'+Unida[i]["IdUnidad"]+'">'+Unida[i]["Unidad"]+'</option>');}
					$("#cboUnidad_ProcCompra").chosen({width: "100%"});
					$('#cboUnidad_ProcCompra').val("59").trigger('chosen:updated');
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_Producto_Codigo_CS=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Producto_Codigo_CS",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassCompraSimple();
				var Dato=e;
				if(Dato.length>0){
					$("#lblIdProductoProcCS").html(Dato[0]["IdProducto"]);
					$("#txtProducto_ProcCS").prop("value",Dato[0]["Producto"]);
					$("#txtMarca_ProcCS").prop("value",Dato[0]["Marca"]);
					$("#txtModelo_ProcCS").prop("value",Dato[0]["Modelo"]);
					$("#txtUnidad_ProcCS").prop("value",Dato[0]["Unidad"]);
					$("#txtPPublico_ProcCS").prop("value",Dato[0]["PrecioPublico"]);
					$("#txtPMenor_ProcCS").prop("value",Dato[0]["PrecioMenor"]);
					$("#txtPMayor_ProcCS").prop("value",Dato[0]["PrecioMayor"]);
					$("#txtPCompra_ProcCS").prop("value",Dato[0]["PrecioCompra"]);
					$("#txtStock_ProcCS").prop("value",Dato[0]["Stock"]);
					//$("#txtTC_ProcCS").prop("value",Dato[0]["TipoCambio"]);
					inst.Calcular_Importe_CS();
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Calcular_Importe_CS=function(){
		var Cantid=$("#txtCantidad_ProcCS").val();
		var PCompra=$("#txtPCompra_ProcCS").val();
		var PU=0;
		if(Cantid!="" && PCompra!=""){
			PU=PCompra;
			var Totl=parseFloat(PU)*parseFloat(Cantid);
			$("#txtImporte_ProcCS").prop("value",parseFloat(Totl).toFixed(2));
		}else{
			$("#txtImporte_ProcCS").prop("value","");
		}
	}
	this.Build_Modal_Productos_CS=function(){var inst=new ClassCompraSimple();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Productos_Modal_CSF);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		var IdAlm=$("#IdAlmCompSimple").html();
		if(IdAlm!="-1"){inst.getList_Productos_AlmComp_CS([IdAlm]);}
	}
	this.getList_Productos_AlmComp_CS=function(params){var inst=new ClassCompraSimple();
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Productos_AlmComp_CS",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e;var IdAlm=$("#IdAlmCompSimple").html();
				if(Dato.length>0){
					$("#IdTableproduct_AddCompra tbody").html("");		
					for(var i=0;i<Dato.length;i++){
						var ids=Dato[i]["IdProducto"];
						$('#IdTableproduct_AddCompra tbody').append('<tr id="idtr_'+ids+'">'+
							'<td id="codProdAlmD_'+ids+'">'+
								'<input type="radio" name="IdSelPVentaNP" value="'+ids+'" class="chk2020">'+
							'</td>'+
							'<td id="codProdAlmD_'+ids+'">'+Dato[i]["Codigo"]+'</td>'+
							'<td id="uniProdAlmD_'+ids+'">'+Dato[i]["Producto"]+'</td> '+
						'</tr>');
					}
					$('#filtrar').keyup(function(){
						var rex = new RegExp($(this).val(), 'i');
						$('.buscar tr').hide();
						$('.buscar tr').filter(function (){
							return rex.test($(this).text());
						}).show();
					});
					
					$('input:radio[name=IdSelPVentaNP]').on('click',function(e){
						var idP=$(this)[0].value;
						inst.getList_Producto_Id_modal_CS([IdAlm,idP]);
					});
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.getList_Producto_Id_modal_CS=function(params){var inst=new ClassCompraSimple();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Producto_Id_CS",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();Producto=e;console.log(e);
				if(Producto.length>0){
					$("#txtCodigo_ProcCS").prop("value",Producto[0]["Codigo"]);
					$("#txtProducto_ProcCS").prop("value",Producto[0]["Producto"]);
					$("#txtMarca_ProcCS").prop("value",Producto[0]["Marca"]);
					$("#txtModelo_ProcCS").prop("value",Producto[0]["Modelo"]);
					//$("#cboUnidad_ProcCompra").prop("value",Producto[0]["IdUnidad"]);
					if (Producto[0]["IdUnidad"]==null){
						$('#cboUnidad_ProcCompra').val("59").trigger('chosen:updated');
					}else{
						$('#cboUnidad_ProcCompra').val(Producto[0]["IdUnidad"]).trigger('chosen:updated');
					}
					$("#txtCantidad_ProcCS").prop("value","1");
					$("#txtPPublico_ProcCS").prop("value",Producto[0]["PrecioPublico"]);
					$("#txtPMenor_ProcCS").prop("value",Producto[0]["PrecioMenor"]);
					$("#txtPMayor_ProcCS").prop("value",Producto[0]["PrecioMayor"]);
					$("#txtStock_ProcCS").prop("value",Producto[0]["Stock"]);
					$("#txtPCompra_ProcCS").prop("value",Producto[0]["PrecioCompra"]);
					$("#lblIdProductoProcCS").html(Producto[0]["IdProducto"]);
					//$("#txtTC_ProcCS").prop("value",Producto[0]["TipoCambio"]);
					inst.Calcular_Importe_CS();
					$('#myModal').modal('hide');$('#modal_Manten').html("");
					$(".modal-open").removeClass('modal-open');
					$("#txtCantidad_ProcCS").focus();
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Detail_VentaAdd_CS=function(Datos){var inst=new ClassCompraSimple();
		$('#IdTable_DetalleC_ProcCS tbody').append('<tr>'+
			'<td id="editManteDetail_0">'+
				'<i class="fas fa-times-circle f-18"></i>'+
			'</td>'+
			'<td>'+Datos[4]+'</td>'+
			'<td>'+Datos[1]+'</td>'+
			'<td>'+Datos[2]+'</td>'+
			'<td>'+Datos[3]+'</td>'+//unidad
			'<td>'+Datos[5]+'</td>'+
			'<td>'+Datos[6]+'</td>'+//importe
			'<td>'+Datos[7]+'</td>'+
			'<td>'+Datos[8]+'</td>'+
			'<td>'+Datos[9]+'</td>'+
			'<td style="display:none">'+Datos[0]+'</td>'+
			'<td>'+Datos[10]+'</td>'+/* TC*/
			'<td style="display:none">'+Datos[11]+'</td>'+/* TC*/
		'</tr>');
		inst.TotalMonto_Table_DetailVentaFi_CS();
		$('#IdTable_DetalleC_ProcCS tbody').unbind("click");
		$('#IdTable_DetalleC_ProcCS tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteDetail'){
				var add=$(this).parent("tr:first");
				add.remove();
				inst.TotalMonto_Table_DetailVentaFi_CS();
			}
		});
	}
	this.Verificar_Existe_Product_Detail_CS=function(pIdProd){
		var vald=true;
		$("#IdTable_DetalleC_ProcCS tbody tr").each(function (index){
			var aIdprod=$(this).find("td").eq(10).html();
			if(pIdProd===aIdprod){
				vald=false;
			}
		});
		return vald;
	}
	this.TotalMonto_Table_DetailVentaFi_CS=function(){
		var TotaMon=0.00;
		$("#IdTable_DetalleC_ProcCS tbody tr").each(function (index){
			var importe=$(this).find("td").eq(6).html();
			TotaMon=parseFloat(TotaMon)+parseFloat(importe);
		});
		$("#txtTotal_ProcCS").prop("value",parseFloat(TotaMon).toFixed(2));
	}
	this.Clear_Detail_VentaAdd_CS=function(){
		$("#lblIdProductoProcCS").html("-1");
		$("#txtCantidad_ProcCS").prop("value","1");
		$("#txtCodigo_ProcCS").prop("value","");
		$("#txtProducto_ProcCS").prop("value","");
		$("#txtMarca_ProcCS").prop("value","");
		$("#txtModelo_ProcCS").prop("value","");
		$("#txtUnidad_ProcCS").prop("value","");
		$("#txtPPublico_ProcCS").prop("value","");
		$("#txtPMenor_ProcCS").prop("value","");
		$("#txtPMayor_ProcCS").prop("value","");
		$("#txtImporte_ProcCS").prop("value","");
		$("#txtPCompra_ProcCS").prop("value","");
		$("#txtStock_ProcCS").prop("value","");
		$("#txtTC_ProcCS").prop("value","1");
	}
	this.Save_Datos_CompraSimple=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"Save_Datos_CompraSimple",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassCompraSimple();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					$("#IdTable_DetalleC_ProcCS tbody").html("");$("#txtObs_ProcCS").prop("value","");inst.Clear_Detail_VentaAdd_CS();
					$("#txtTotal_ProcCS").prop("value","0");
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
}




