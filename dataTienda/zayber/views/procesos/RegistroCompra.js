$(window).on('load',function(){var inst=new ClassRsvaCompra();$("#IdAlmacenPri").css("display","none");
	$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmRComp").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRComp").html();

	$("#cboComprobante_ProcCompra").chosen({width: "100%"});$("#cboProveedor_ProcCompra").chosen({width: "100%"});
	$("#cboMoneda_ProcCompra").chosen({width: "100%"});$("#cboUnidad_ProcCompra").chosen({width: "100%"});

	$("#txtFechaEmision_ProcCompra").datepicker({
		defaultDate: +1,changeMonth: true,numberOfMonths: 1,disableTextInput:true,changeYear:true,onClose: function( selectedDate ){}
	});$("#txtFechaEmision_ProcCompra").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#txtFechaPago_ProcCompra").datepicker({
		defaultDate: +1,changeMonth: true,numberOfMonths: 1,disableTextInput:true,changeYear:true,onClose: function( selectedDate ){inst.NroDiasFPCompra();}
	});$("#txtFechaPago_ProcCompra").datepicker( "option", "dateFormat", "dd/mm/yy" );
	var FeH=current_date();
	$("#txtFechaEmision_ProcCompra").prop("value",FeH);
	$("#txtFechaPago_ProcCompra").prop("value",FeH);
	$("#txtFechaPago_ProcCompra").datepicker( "option", "minDate",FeH);
	if(IdAlm!="-1"){inst.getList_combo_Compra([IdAlm]);}
	
	$("#txtCodigo_ProcCompra").keyup(function (e){if(e.which == 13){inst.Clear_Detail_Producto_MenosCod();
		var CP=$("#txtCodigo_ProcCompra").val();if(IdAlm!="-1" && CP!="" && CP.length>2){inst.getList_Producto_Codigo_Compra([IdAlm,CP]);}}});
	$("#btnmasProducto_ProcCompra").on('click',function(e){inst.Build_Modal_Productos_Compra();});
	$("#cboProveedor_ProcCompra").on('change',function(e){
		var IdProveed=$("select#cboProveedor_ProcCompra option:selected").val();
		$("#txtRuc_ProcCompra").prop("value","");
		$("#txtRSocial_ProcCompra").prop("value","");
		if(IdProveed!="-1" && IdAlm!="-1"){inst.getList_Proveedor_Id([IdProveed]);}
	});
	$("#txtCantidad_ProcCompra").focusout(function(){inst.Calcular_Importe_Compra();});
	$("#txtCantidad_ProcCompra").keyup(function (e){if(e.which == 13){$("#txtPCompra_ProcCompra").focus();inst.Calcular_Importe_Compra();}});
	$("#txtPCompra_ProcCompra").focusout(function(){inst.Calcular_Importe_Compra();});
	$("#txtPCompra_ProcCompra").keyup(function (e){if(e.which == 13){$("#txtImporte_ProcCompra").focus();inst.Calcular_Importe_Compra();}});
	$("#btnNewProveedor_ProcCompra").on('click',function(e){inst.Build_Modal_NewProveedor();});
	$("#rbtTipoPagoCredito").on('click',function(e){$("#IdFechaPagoCompra").css("display","block");});
	$("#rbtTipoPagoContado").on('click',function(e){$("#IdFechaPagoCompra").css("display","none");$("#txtFechaPago_ProcCompra").prop("value",FeH);$("#IdNroDiasFPCompra").prop("value","0");});
	$("#btnNewProduc_ProcCompra").on('click',function(e){inst.Build_Modal_NewProducto_Compra();});
	$("#IdChkIGVPCompra").on('click',function(){inst.TotalMonto_Table_DetailCompraFi();});
	$("#IdTipoCambio").on('click',function(e){inst.getList_TipoCambio();});
	$("#btnAdd_ProcCompra").on('click',function(e){
		var IdProd=$("#lblIdProductoProcCompra").html();
		var Cant=$("#txtCantidad_ProcCompra").val();
		var Cod=$("#txtCodigo_ProcCompra").val();
		var producto=$("#txtProducto_ProcCompra").val();
		var Marca=$("#txtMarca_ProcCompra").val();
		var Modelo=$("#txtModelo_ProcCompra").val();
		var IdUnidad=$("#cboUnidad_ProcCompra").val();
		var Unidad=$('#cboUnidad_ProcCompra option:selected').text();
		var PU=$("#txtPCompra_ProcCompra").val();
		var Importe=$("#txtImporte_ProcCompra").val();
		var PPublico=$("#txtPPublico_ProcCompra").val();
		var PMenor=$("#txtPMenor_ProcCompra").val();
		var PMayor=$("#txtPMayor_ProcCompra").val();
		//var TC=$("#txtTC_ProcCompra").val();
		var TC=1;
		if(IdAlm!="-1" && IdProd!="-1" && Cant!="" && producto!="" && Cod!="" && PU!="" && Importe!="" && PPublico!="" && PMenor!="" && PMayor!="" && TC!=""){
			inst.Build_Detail_Compra([IdProd,Cod,producto+Marca+Modelo,Unidad,Cant,PU,Importe,PPublico,PMenor,PMayor,TC,IdUnidad]);
			inst.Clear_Detail_Producto_Add();
		}else{
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");
		}
	});
	$("#btnComprar_ProcCompra").on('click',function(e){
		var IdComprob=$("select#cboComprobante_ProcCompra option:selected").val();
		var Serie=$("#txtSerie_ProcCompra").val();
		var Numero=$("#txtNumero_ProcCompra").val();
		var FechaEm=$("#txtFechaEmision_ProcCompra").val();
		var IdProv=$("select#cboProveedor_ProcCompra option:selected").val();
		var Obs='';
			
		var Totaal=$("#txtTotal_ProcCompra").val();
		
		var SubTotal=$("#txtSubTotal_ProcCompra").val();
		var IGV=$("#txtIGV_ProcCompra").val();
		var TipoPago=$('input:radio[name=rbtTipoPago]:checked').val();
		var FechaPago=$("#txtFechaPago_ProcCompra").val();
		
		var aNroDias=$("#IdNroDiasFPCompra").val();
		var aIdMoneda=$("select#cboMoneda_ProcCompra option:selected").val();
		
		var Detail=[];
		var aComp=$("select#cboComprobante_ProcCompra option:selected").text()+' '+Serie+'-'+Numero;
		
		$("#IdTable_DetalleC_ProcCompra tbody tr").each(function (index){
			var aCantidad=$(this).find("td").eq(1).html();
			var aCodigo=$(this).find("td").eq(2).html();
			var aDescripcion=$(this).find("td").eq(3).html();
			var aUnidad=$(this).find("td").eq(4).html();
			var aPCompra=$(this).find("td").eq(5).html();
			var aImporte=$(this).find("td").eq(6).html();
			var aPPublico=$(this).find("td").eq(7).html();
			var aPMenor=$(this).find("td").eq(8).html();
			var aPMayor=$(this).find("td").eq(9).html();
			var aIdprod=$(this).find("td").eq(10).html();
			var aTC=$(this).find("td").eq(11).html();
			var aIdUnidad=$(this).find("td").eq(12).html();
				
			Detail.push({"aCantidad":aCantidad,"aCodigo":aCodigo,"aDescripcion":aDescripcion,"aUnidad":aUnidad,"aPCompra":aPCompra,
							"aImporte":aImporte,"aPPublico":aPPublico,"aPMenor":aPMenor,"aPMayor":aPMayor,"aIdProducto":aIdprod,"aTC":aTC,"aidUnidad":aIdUnidad});
		});
			if(Detail.length>0 && FechaEm!="" && FechaPago!="" && Totaal!="" && Totaal!="0.00" && SubTotal!="" && IGV!="" && IdProv!="-1"){
				(function(){
					vex.defaultOptions.className = 'vex-theme-os';
				})();
				vex.dialog.confirm({ message:'Desea Guardar?', 
					callback: function(ee){
						if(ee){
							FechaEm=FechaEm.split('/')[2]+'-'+FechaEm.split('/')[1]+'-'+FechaEm.split('/')[0];
							FechaPago=FechaPago.split('/')[2]+'-'+FechaPago.split('/')[1]+'-'+FechaPago.split('/')[0];
							var pa=[];
							pa.push({"aIdComprob":IdComprob,"aSerie":Serie,"aNumero":Numero,"aFechaEm":FechaEm,"aIdProv":IdProv,"aFechaPago":FechaPago,
							"aTotaal":Totaal,"aObs":Obs,"aTipoPago":TipoPago,"aSubTotal":SubTotal,"aIGV":IGV,"aIdAlm":IdAlm,"aAlm":Alm,"aComp":aComp,
							"aIdMoneda":aIdMoneda,"aNroDias":aNroDias,"aDetail":Detail});
							inst.Save_Datos_Compra(pa);
						}
				}});
			}else{
				(function(){
					vex.defaultOptions.className = 'vex-theme-os';
				})();
				vex.dialog.alert("Faltan completar datos");
			}
	});
	
});
function ClassRsvaCompra(){
	this.getList_combo_Compra=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_combo_Compra",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();Compro=e["Compro"],Prove=e["Prove"];Unida=e["Unidad"];var inst=new ClassRsvaCompra();
				if(Compro.length>0){
					$("#cboComprobante_ProcCompra").empty();$("#cboComprobante_ProcCompra").append('<option value="-1">Otros</option>');
					for(var i=0;i<Compro.length;i++){$("#cboComprobante_ProcCompra").append('<option value="'+Compro[i]["IdComprobante"]+'">'+Compro[i]["Comprobante"]+'</option>');}
					$("#cboComprobante_ProcCompra").chosen({width: "100%"});
					$('#cboComprobante_ProcCompra').val("-1").trigger('chosen:updated');
				}
				if(Prove.length>0){
					$("#cboProveedor_ProcCompra").empty();$("#cboProveedor_ProcCompra").append('<option value="-1">Otros</option>');
					for(var i=0;i<Prove.length;i++){$("#cboProveedor_ProcCompra").append('<option value="'+Prove[i]["IdProveedor"]+'">'+Prove[i]["Ruc"]+' '+Prove[i]["Comercial"]+'</option>');}
					$("#cboProveedor_ProcCompra").chosen({width: "100%"});
					$('#cboProveedor_ProcCompra').val("-1").trigger('chosen:updated');
				}
				if(Unida.length>0){
					$("#cboUnidad_ProcCompra").empty();
					for(var i=0;i<Unida.length;i++){$("#cboUnidad_ProcCompra").append('<option value="'+Unida[i]["IdUnidad"]+'">'+Unida[i]["Unidad"]+'</option>');}
					$("#cboUnidad_ProcCompra").chosen({width: "100%"});
					$('#cboUnidad_ProcCompra').val("59").trigger('chosen:updated');
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_Producto_Codigo_Compra=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Producto_Codigo_CS",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRsvaCompra();console.log(e);
				var Dato=e;
				if(Dato.length>0){
					$("#lblIdProductoProcCompra").html(Dato[0]["IdProducto"]);
					$("#txtProducto_ProcCompra").prop("value",Dato[0]["Producto"]);
					$("#txtMarca_ProcCompra").prop("value",Dato[0]["Marca"]);
					$("#txtModelo_ProcCompra").prop("value",Dato[0]["Modelo"]);
					$("#txtUnidad_ProcCompra").prop("value",Dato[0]["Unidad"]);
					$("#txtPPublico_ProcCompra").prop("value",Dato[0]["PrecioPublico"]);
					$("#txtPMenor_ProcCompra").prop("value",Dato[0]["PrecioMenor"]);
					$("#txtPMayor_ProcCompra").prop("value",Dato[0]["PrecioMayor"]);
					$("#txtPCompra_ProcCompra").prop("value",Dato[0]["PrecioCompra"]);
					$("#txtStock_ProcCompra").prop("value",Dato[0]["Stock"]);
					$("#txtTC_ProcCompra").prop("value",Dato[0]["TipoCambio"]);
					inst.Calcular_Importe_Compra();
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Calcular_Importe_Compra=function(){
		var Cantid=$("#txtCantidad_ProcCompra").val();
		var PCompra=$("#txtPCompra_ProcCompra").val();
		var PU=0;
		if(Cantid!="" && PCompra!=""){
			PU=PCompra;
			var Totl=parseFloat(PU)*parseFloat(Cantid);
			$("#txtImporte_ProcCompra").prop("value",parseFloat(Totl).toFixed(2));
		}else{
			$("#txtImporte_ProcCompra").prop("value","");
		}
	}
	this.Build_Modal_Productos_Compra=function(){var inst=new ClassRsvaCompra();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Productos_Modal_CS);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		var IdAlm=$("#IdAlmRComp").html();
		if(IdAlm!="-1"){inst.getList_Productos_AlmComp_Compra([IdAlm]);}
	}
	this.getList_Productos_AlmComp_Compra=function(params){var inst=new ClassRsvaCompra();
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Productos_AlmComp_CS",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e;var IdAlm=$("#IdAlmRComp").html();
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
							//'<td id="uniProdAlmD_'+ids+'">'+Dato[i]["Unidad"]+'</td> '+
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
						inst.getList_Producto_Id_modal_Compra([IdAlm,idP]);
					});
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.getList_Producto_Id_modal_Compra=function(params){var inst=new ClassRsvaCompra();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Producto_Id_CS",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();Producto=e;
				if(Producto.length>0){
					$("#txtCodigo_ProcCompra").prop("value",Producto[0]["Codigo"]);
					$("#txtProducto_ProcCompra").prop("value",Producto[0]["Producto"]);
					$("#txtMarca_ProcCompra").prop("value",Producto[0]["Marca"]);
					$("#txtModelo_ProcCompra").prop("value",Producto[0]["Modelo"]);
					//$("#txtUnidad_ProcCompra").prop("value",Producto[0]["Unidad"]);
					if (Producto[0]["IdUnidad"]==null){
						$('#cboUnidad_ProcCompra').val("59").trigger('chosen:updated');
					}else{
						$('#cboUnidad_ProcCompra').val(Producto[0]["IdUnidad"]).trigger('chosen:updated');
					}	
					$("#txtCantidad_ProcCompra").prop("value","1");
					$("#txtPPublico_ProcCompra").prop("value",Producto[0]["PrecioPublico"]);
					$("#txtPMenor_ProcCompra").prop("value",Producto[0]["PrecioMenor"]);
					$("#txtPMayor_ProcCompra").prop("value",Producto[0]["PrecioMayor"]);
					$("#txtStock_ProcCompra").prop("value",Producto[0]["Stock"]);
					$("#txtPCompra_ProcCompra").prop("value",Producto[0]["PrecioCompra"]);
					$("#lblIdProductoProcCompra").html(Producto[0]["IdProducto"]);
					//$("#txtTC_ProcCompra").prop("value",Producto[0]["TipoCambio"]);
					inst.Calcular_Importe_Compra();
					$('#myModal').modal('hide');$('#modal_Manten').html("");
					$(".modal-open").removeClass('modal-open');
					$("#txtCantidad_ProcCompra").focus();
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_Proveedor_Id=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Proveedor_Id",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();Proveedor=e;var inst=new ClassRsvaCompra();
				if(Proveedor.length>0){
					$("#txtRuc_ProcCompra").prop("value",Proveedor[0]["Ruc"]);
					$("#txtRSocial_ProcCompra").prop("value",Proveedor[0]["RazonSocial"]);
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.TotalMonto_Table_DetailCompraFi=function(){
		var TotaMon=0.00;
		var IdMoneda=parseInt($("select#cboMoneda_ProcCompra option:selected").val());
		
		$("#IdTable_DetalleC_ProcCompra tbody tr").each(function (index){
			var importe=$(this).find("td").eq(6).html();
			TotaMon=parseFloat(TotaMon)+parseFloat(importe);
		});
		
		var IdIGV=$("#IdChkIGVPCompra").is(':checked') ? 1 : 0;
		if(parseInt(IdIGV)===1){
			var SubTO=parseFloat(TotaMon)/parseFloat(1.18);
			var IGV=parseFloat(SubTO)*parseFloat(0.18);
			$("#txtSubTotal_ProcCompra").prop("value",parseFloat(SubTO).toFixed(2));
			$("#txtIGV_ProcCompra").prop("value",parseFloat(IGV).toFixed(2));
			$("#txtTotal_ProcCompra").prop("value",parseFloat(TotaMon).toFixed(2));
		}else{
			//var IGV=parseFloat(TotaMon)*parseFloat(0.18);
			let IGV=0.00;
			$("#txtSubTotal_ProcCompra").prop("value",parseFloat(TotaMon).toFixed(2));
			$("#txtIGV_ProcCompra").prop("value",parseFloat(IGV).toFixed(2));
			$("#txtTotal_ProcCompra").prop("value",parseFloat(TotaMon).toFixed(2));
		}
	}
	this.Build_Detail_Compra=function(Datos){var inst=new ClassRsvaCompra();
		$('#IdTable_DetalleC_ProcCompra tbody').append('<tr>'+
			'<td id="delManteDetail_0">'+
				'<i class="fas fa-times-circle f-18"></i>'+
			'</td>'+
			'<td>'+Datos[4]+'</td>'+
			'<td>'+Datos[1]+'</td>'+
			'<td>'+Datos[2]+'</td>'+
			'<td>'+Datos[3]+'</td>'+
			'<td>'+Datos[5]+'</td>'+
			'<td>'+Datos[6]+'</td>'+
			'<td>'+Datos[7]+'</td>'+
			'<td>'+Datos[8]+'</td>'+
			'<td>'+Datos[9]+'</td>'+
			'<td style="display:none">'+Datos[0]+'</td>'+
			'<td style="display:none">'+Datos[10]+'</td>'+
			'<td style="display:none">'+Datos[11]+'</td>'+
		'</tr>');
		inst.TotalMonto_Table_DetailCompraFi();
		$('#IdTable_DetalleC_ProcCompra tbody').unbind("click");
		$('#IdTable_DetalleC_ProcCompra tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='delManteDetail'){
				var add=$(this).parent("tr:first");
				add.remove();
				inst.TotalMonto_Table_DetailCompraFi();
			}
		});
	}
	this.Clear_Detail_Producto_Add=function(){
		$("#lblIdProductoProcCompra").html("-1");
		$("#txtCodigo_ProcCompra").prop("value","");
		$("#txtProducto_ProcCompra").prop("value","");
		$("#txtMarca_ProcCompra").prop("value","");
		$("#txtModelo_ProcCompra").prop("value","");
		$("#txtUnidad_ProcCompra").prop("value","");
		$("#txtCantidad_ProcCompra").prop("value","1");
		$("#txtPCompra_ProcCompra").prop("value","0");
		$("#txtImporte_ProcCompra").prop("value","0");
		$("#txtPPublico_ProcCompra").prop("value","0");
		$("#txtPMenor_ProcCompra").prop("value","0");
		$("#txtPMayor_ProcCompra").prop("value","0");
		$("#txtStock_ProcCompra").prop("value","0");
		$("#txtTC_ProcCompra").prop("value","1");
	}
	this.Clear_Detail_Producto_MenosCod=function(){
		$("#lblIdProductoProcCompra").html("-1");
		$("#txtProducto_ProcCompra").prop("value","");
		$("#txtMarca_ProcCompra").prop("value","");
		$("#txtModelo_ProcCompra").prop("value","");
		$("#txtUnidad_ProcCompra").prop("value","");
		$("#txtCantidad_ProcCompra").prop("value","1");
		$("#txtPCompra_ProcCompra").prop("value","0");
		$("#txtImporte_ProcCompra").prop("value","0");
		$("#txtPPublico_ProcCompra").prop("value","0");
		$("#txtPMenor_ProcCompra").prop("value","0");
		$("#txtPMayor_ProcCompra").prop("value","0");
		$("#txtStock_ProcCompra").prop("value","0");
		$("#txtTC_ProcCompra").prop("value","1");
	}
	this.Clear_Grnal_Compra=function(){
		$('#cboComprobante_ProcCompra').val("-1").trigger('chosen:updated');
		$('#cboProveedor_ProcCompra').val("-1").trigger('chosen:updated');
		$("#txtSerie_ProcCompra").prop("value","");
		$("#txtNumero_ProcCompra").prop("value","");
		var FeH=current_date();
		$("#txtFechaEmision_ProcCompra").prop("value",FeH);
		$("#txtFechaPago_ProcCompra").prop("value",FeH);
		$("#txtRuc_ProcCompra").prop("value","");
		$("#txtRSocial_ProcCompra").prop("value","");
		$("#txtTotal_ProcCompra").prop("value","0");
		$("#txtSubTotal_ProcCompra").prop("value","0");
		$("#txtIGV_ProcCompra").prop("value","0");
		$("#IdTable_DetalleC_ProcCompra tbody").html("");
		
	}
	this.Save_Datos_Compra=function(params){var inst=new ClassRsvaCompra();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"Save_Datos_Compra",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					 alertify.success("PROCESO CORRECTO.");
					 inst.Clear_Grnal_Compra();
					 inst.Clear_Detail_Producto_Add();
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
	//NEW PROVEEDOR
	this.Build_Modal_NewProveedor=function(){var inst=new ClassRsvaCompra();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Proveedor);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
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
			var pId=-1;
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
					$("#txtDireccionFiscal_ManteProveedor").focus();
					//inst.getList_NroRuc_Client([nroR]);
				}
			}
		});
		$("#txtRuc_ManteProveedor").focusout(function(){
			var nroR=$("#txtRuc_ManteProveedor").val();
			if(nroR!="" && nroR.length===11){
				inst.getList_NroRuc_Client([nroR]);
			}
		});
	}
	this.getList_NroRuc_Client=function(params){
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
					var inst=new ClassRsvaCompra();inst.getList_Mante_Proveedor_Update();
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_Mante_Proveedor_Update=function(){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Mante_Proveedor_Update"},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Prove=e;
				if(Prove.length>0){
					$("#cboProveedor_ProcCompra").empty();$("#cboProveedor_ProcCompra").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Prove.length;i++){$("#cboProveedor_ProcCompra").append('<option value="'+Prove[i]["IdProveedor"]+'">'+Prove[i]["Ruc"]+' '+Prove[i]["Comercial"]+'</option>');}
					$("#cboProveedor_ProcCompra").chosen({width: "100%"});
					$('#cboProveedor_ProcCompra').val("-1").trigger('chosen:updated');
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	
	//NEW PRODUCTO
	this.Build_Modal_NewProducto_Compra=function(){var inst=new ClassRsvaCompra();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Mante_Productos);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		var pId=-1;
		inst.getList_ManteProductos_Edit(pId);
		$("#txtSave_ManteProductos").on('click',function(e){
			var Codigo=$("#txtCodigo_ManteProductos").val();
			var Prodc=$("#txtProducto_ManteProductos").val();
			var IdMarca=$("select#cboMarca_ManteProductos option:selected").val();
			var IdModelo=$("select#cboCategoria_ManteProductos option:selected").val();
			//var IdUnidad=$("select#cboUnidad_ManteProductos option:selected").val();
			//var Anio=$("#txtAnio_ManteProductos").val();
			//var CodFabr=$("#txtCodigoFabrica_ManteProductos").val();
			//var StockMin=$("#txtStockMinimo_ManteProductos").val();
			var IdEst=$("#chkHabilitado_MantProducto").is(':checked') ? 1 : 0;
			
			if(Codigo!="" && Prodc!="" && IdMarca!="-1" && IdModelo!="-1"){
				inst.Save_Mante_Productos([pId,Codigo,Prodc,IdMarca,IdModelo,IdEst]);
			}else{
				alertify.error("Alerta, Completar Codigo, Producto, Marca, Modelo y Unidad.");
			}
		});
	}
	this.getList_ManteProductos_Edit=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_ManteProductos_Edit",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Modelo=e["Categoria"],Marca=e["Marca"],Dato=e["Produ"];var inst=new ClassRsvaCompra();console.log(e);
				if(Modelo.length>0){
					$("#cboCategoria_ManteProductos").empty();
					$("#cboCategoria_ManteProductos").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Modelo.length;i++){
						$("#cboCategoria_ManteProductos").append('<option value="'+Modelo[i]["IdCategoria"]+'">'+Modelo[i]["Categoria"]+'</option>');
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
					$('#cboModelo_ManteProductos').val(Dato[0]["IdModelo"]).trigger('chosen:updated');
					$('#cboMarca_ManteProductos').val(Dato[0]["IdMarca"]).trigger('chosen:updated');
					$('#cboUnidad_ManteProductos').val(Dato[0]["IdUnidad"]).trigger('chosen:updated');
					$("#txtCodigo_ManteProductos").prop("value",Dato[0]["Codigo"]);
					$("#txtProducto_ManteProductos").prop("value",Dato[0]["Producto"]);
					$("#txtAnio_ManteProductos").prop("value",Dato[0]["Anio"]);
					$("#txtCodigoFabrica_ManteProductos").prop("value",Dato[0]["CodigoFabricante"]);
					$("#txtStockMinimo_ManteProductos").prop("value",Dato[0]["StockMinimo"]);
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
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
	this.NroDiasFPCompra=function(){var inst=new ClassRsvaCompra();
		var FeH=current_date();
		var FechaPago=$("#txtFechaPago_ProcCompra").val();
		NroD=CantDias_Entre2Fechas(FechaPago,FeH);
		$("#IdNroDiasFPCompra").prop("value",NroD);
	}

	
	//TIPO CAMBIO
	this.getList_TipoCambio=function(){var inst=new ClassRsvaCompra();
		var valor=$("#IdTipoCambio").html();console.log(valor);
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_TipoCambio);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		$("#txtMonto_TC").prop("value",parseFloat(valor).toFixed(2));
		$("#btnSave_TipoCambio").on("click",function(e){
			newValor=$("#txtMonto_TC").val();
			if(newValor!=""){
				$.blockUI();$.ajax({
					type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"Save_TipoCambio",array:[newValor]},async:true,dataType:"json",success:function(e){
						$.unblockUI();
						if(e){
							$('#myModal').modal('hide');$('#modal_Manten').html("");
							$(".modal-open").removeClass('modal-open');
							alertify.success("PROCESO CORRECTO.");
							$("#IdTipoCambio").html(parseFloat(newValor).toFixed(2));
						}else{
							alertify.error("Error, Proceso Incorrecto.");
						}
					},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
				});
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Ingrese Tipo de Cambio.");
			}
		});
		
		
	}

}