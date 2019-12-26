$(window).on('load',function(){var inst=new ClassRsvaVenta();
	$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmRVenta").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRVenta").html();
	
	var FeH=current_date();
	$("#txtFechaPago_ProcVenta").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
	$("#txtFechaPago_ProcVenta").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#txtFechaPago_ProcVenta").prop("value",FeH);
	
	$("#cboEmpresa_ProcVenta").chosen({width: "100%"});
	
	$("#cboTipoDoc_ProcVenta").chosen({width: "100%"});
	$("#comboMetodoPago").chosen({width: "100%"});
	
	inst.ver_empresa_venta();$("#cboEmpresa_ProcVenta").on('change',function(e){inst.ver_empresa_venta();});

	$("#cboComprobante_ProcVenta").on('change',function(e){inst.Verificar_DocumentoVenta();});
	$("#cboTipoDoc_ProcVenta").on('change',function(e){$("#lblIdCliente").html("-1");$("#txtRuc_ProcVenta").prop("value","");$("#txtRS_ProcVenta").prop("value","");$("#txtDireccion_ProcVenta").prop("value","");});
	
	$("#txtRuc_ProcVenta").focusout(function(){inst.Verificar_NroRuc();});
	$("#txtRuc_ProcVenta").keyup(function (e){if(e.which == 13){$("#txtDireccion_ProcVenta").focus();}});
	
	$("#btnCliente_ProcVenta").on('click',function(e){inst.Build_Modal_Cliente_Venta();});
	$("#btnSearchProd_ProcVenta").on('click',function(e){inst.Build_Modal_Productos_Venta();});
	$("#btnNPVenta_ProcVenta").on('click',function(e){inst.Build_Modal_Venta_NP();});
	$("#txtCodigo_ProcVenta").keyup(function (e){
	if(e.which == 13){
		var CP=$("#txtCodigo_ProcVenta").val();
		if (CP!='') {
			if(IdAlm!="-1" && CP!="" && CP.length>3){
				inst.getList_Producto_Codigo([IdAlm,CP]);
			}
		}else{
			$("#btnComprar_ProcVenta").focus();
		}
		
	}});
	$("#txtPPublico_ProcVenta").focusout(function(){inst.Calcular_Importe_Venta();});
	$("#txtPPublico_ProcVenta").keyup(function (e){if(e.which == 13){$("#btnAdd_ProcVenta").focus();inst.Calcular_Importe_Venta();}});
	$("#txtPMenor_ProcVenta").focusout(function(){inst.Calcular_Importe_Venta();});
	$("#txtPMenor_ProcVenta").keyup(function (e){if(e.which == 13){$("#btnAdd_ProcVenta").focus();inst.Calcular_Importe_Venta();}});
	$("#txtPMayor_ProcVenta").focusout(function(){inst.Calcular_Importe_Venta();});
	$("#txtPMayor_ProcVenta").keyup(function (e){if(e.which == 13){$("#btnAdd_ProcVenta").focus();inst.Calcular_Importe_Venta();}});
	$("#txtCantidad_ProcVenta").focusout(function(){inst.Calcular_Importe_Venta();});
	$("#txtCantidad_ProcVenta").keyup(function (e){if(e.which == 13){$("#txtPPublico_ProcVenta").focus();inst.Calcular_Importe_Venta();}});
	$('input:radio[name=rbtTipoPrecioV]').on('click',function(e){inst.Calcular_Importe_Venta();});
	//$("#rbtTipoPagoCredito").on('click',function(e){$("#IdFechaPagoVenta").css("display","block");});
	//$("#rbtTipoPagoContado").on('click',function(e){$("#IdFechaPagoVenta").css("display","none");$("#txtFechaPago_ProcVenta").prop("value",FeH);});
	$("#IdChkIGVPVe").on('click',function(){inst.TotalMonto_Table_DetailVentaFi();});
	$("#btnAdd_ProcVenta").on('click',function(e){
		inst.AgregarProductoCarrito();
	});
	inst.Verificar_DocumentoVenta();
	$("#btnClear_ProcVenta").on('click',function(e){
		(function(){vex.defaultOptions.className = 'vex-theme-os';})();
		vex.dialog.confirm({ message:'Desea Limpiar?',callback: function(ee){
			if(ee){inst.Clear_Detail_VentaAdd();inst.Clear_Grnal_Venta();}
		}});
	});
	$("#txtMontoRecibido").on('keyup',function(e){
		let recibido=e.target.value;
		let total=$('#txtTotal_ProcVenta').val();
		let vuelto=recibido-parseFloat(total);
		$('#txtVuelto').val(parseFloat(vuelto).toFixed(2));

	});
	$("#btnComprar_ProcVenta").on('click',function(e){
		aIdCliente=$("#lblIdCliente").html();
		var IdEmpresa=$("select#cboEmpresa_ProcVenta option:selected").val();
		var IdComprob=parseInt($("select#cboComprobante_ProcVenta option:selected").val());
		var IdTipoDoc=parseInt($("select#cboTipoDoc_ProcVenta option:selected").val());
		var Formato=$("select#cboFormato_ProcVenta option:selected").val();
		var Ruc=$("#txtRuc_ProcVenta").val();
		var RS=$("#txtRS_ProcVenta").val();
		var Direc=$("#txtDireccion_ProcVenta").val();
		var Email=$("#txtEmail_ProcVenta").val();
		var NroGui=$("#txtNroGuia_ProcVenta").val();
		
		var Totaal=$("#txtTotal_ProcVenta").val();
		var SubTotal=$("#txtSubTotal_ProcVenta").val();
		var IGV=$("#txtIGV_ProcVenta").val();
		var aSon=$("#txtSon_ProcVenta").val();
		//var IdTipoPago=parseInt($('input:radio[name=rbtTipoPagoV]:checked').val());
		var IdTipoPago=parseInt($("#comboMetodoPago").val());
		var Alm=$("#AlmRVenta").html();
		var FechaPago=$("#txtFechaPago_ProcVenta").val();
		var IdIGV=$("#IdChkIGVPVe").is(':checked') ? 1 : 0;
		var Comprob=$("select#cboComprobante_ProcVenta option:selected").text();
		var Detail=[];
		$("#IdTable_DetalleC_ProcVenta tbody tr").each(function (index){
			var aCantidad=$(this).find("td").eq(1).html();
			var aCodigo=$(this).find("td").eq(2).html();
			var aDescripcion=$(this).find("td").eq(3).html();
			var aUnidad=$(this).find("td").eq(4).html();
			var aPU=$(this).find("td").eq(5).html();
			var aImporte=$(this).find("td").eq(6).html();
			//var aTipoPrecio=$(this).find("td").eq(7).html();
			var aIdProducto=$(this).find("td").eq(8).html();
			var aIdNP=$(this).find("td").eq(9).html();
			var aIdTipoPrecio=$(this).find("td").eq(10).html();
			
				
			Detail.push({"aCantidad":aCantidad,"aCodigo":aCodigo,"aDescripcion":aDescripcion,"aUnidad":aUnidad,"aPU":aPU,
							"aImporte":aImporte,"aIdProducto":aIdProducto,"aIdTipoPrecio":aIdTipoPrecio,"aIdNP":aIdNP,"aIdEspecial":'-1',"aIdTipoIgv":'1'});
		});
		if(IdAlm!="-1"){	
			if((IdTipoPago===2 && aIdCliente!="-1") || (IdTipoPago!='2')){
				if(Detail.length>0){
					if(IdEmpresa!="-1" && IdComprob!="-1" && Totaal!="" && SubTotal!="" && IGV!=""){
							if(FechaPago!=""){
								if((IdTipoDoc===6 && Ruc!="" && RS!="" && Ruc.length===11) || (IdTipoDoc===1 && Ruc!="" && RS!="" && Ruc.length===8) || 
									(IdTipoDoc===7 && Ruc!="") || (IdTipoDoc===0 && IdComprob==2)|| (IdComprob==10)){
										if(Ruc==''){Ruc=0;}
										if(RS==''){RS='Varios';}
									(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.confirm({ message:'Desea Guardar?', 
									callback: function(ee){if(ee){
										var pa=[];
										FechaPago=FechaPago.split('/')[2]+'-'+FechaPago.split('/')[1]+'-'+FechaPago.split('/')[0];
										pa.push({"aIdEmpresa":IdEmpresa,"aIdComprob":IdComprob,
											"aIdTipoDoc":IdTipoDoc,"aRuc":Ruc,"aRS":RS,"aDireccion":Direc,"aEmail":Email,"aNroGuia":NroGui,
											"aTotaal":Totaal,"aSubTotal":SubTotal,"aExonerado":'0.00',"aIGV":IGV,"aSon":aSon,"aIdIGV":IdIGV,"aIdTipoPago":IdTipoPago,"aComprob":Comprob,
											"aAlm":Alm,"aIdAlm":IdAlm,"aFechaPago":FechaPago,"aIdCliente":aIdCliente,"aFormato":Formato,"aDetail":Detail});
											inst.Save_Datos_Venta(pa,IdEmpresa,IdComprob);
									}}});
									
								}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Nro Doc y R.S.");}
							}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione Fecha de Pago.");}
					}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione Comprobante y datos.");}
				}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Agregar Detalle para venta.");}
			}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Venta Tipo Credito, debe seleccionar un cliente Fijo, click en boton CLIENTE");}
		}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("No existe Almacen para realizar venta.");}
		
		
				
	});
	//setTimeout(function() { $('input[name="codigo"]').focus();console.log('entra'); }, 3000);
	//$('input[name="codigo"]').get(0).focus();
    $(document).keyup(function (e) {
		console.log(e.shiftKey);
		let tecla=e.which;
		switch (tecla) {
			case 70:
				if (e.shiftKey) {
					$('#cboComprobante_ProcVenta').val('1').trigger('chosen:updated');
					inst.Verificar_DocumentoVenta();
				}
				break;
			case 66:
				if (e.shiftKey) {
				$('#cboComprobante_ProcVenta').val('2').trigger('chosen:updated');
				inst.Verificar_DocumentoVenta();
				}
				break;
			case 84:
				if (e.shiftKey) {
				$('#cboComprobante_ProcVenta').val('10').trigger('chosen:updated');
				inst.Verificar_DocumentoVenta();
				}
				break;
		}
	});
	$('#txtDescripNP_ProcCompra').keyup(function(e){
		let tecla=e.which;
		if(tecla == 13){
			let Idss = $('#txtDescripNP_ProcCompra').val();
			let IdAlm=$("#IdAlmRVenta").html();
			let IdEmpresa=$("select#cboEmpresa_ProcVenta option:selected").val();
			inst.getList_RecuperarDetail_VentaNP([IdAlm,Idss,IdEmpresa]);
		}
	});
});
function ClassRsvaVenta(){
	this.ver_empresa_venta=function(){
		var IdEmp=$("select#cboEmpresa_ProcVenta option:selected").val();
		if(IdEmp!="-1"){
			var Emp=$("select#cboEmpresa_ProcVenta option:selected").text();
			$("#lblNameEmpresaV").html(Emp);
		}
		if (IdEmp==2) {
			$('#cboComprobante_ProcVenta').val('10').trigger('chosen:updated');
			$('#cboComprobante_ProcVenta').prop('disabled', 'disabled');
		}else{
			$('#cboComprobante_ProcVenta').val('2').trigger('chosen:updated');
			$('#cboFormato_ProcVenta').val('TICKET').trigger('chosen:updated');
			$("#cboComprobante_ProcVenta").chosen({width: "100%"});
		}
	   $("#txtCodigo_ProcVenta").focus();
	}
	this.AgregarProductoCarrito=function(){
		var inst=new ClassRsvaVenta();
		var IdAlm=$("#IdAlmRVenta").html();
		if(IdAlm!="-1"){
			var valido=true;
			var IdProd=$("#lblIdProducto").html();
			var Cod=$("#txtCodigo_ProcVenta").val();
			var producto=$("#txtProducto_ProcVenta").val();
			var Marca=$("#txtMarca_ProcVenta").val();
			var Modelo=$("#txtModelo_ProcVenta").val();
			var Unidad=$("#txtUnidad_ProcVenta").val();
			var Cant=$("#txtCantidad_ProcVenta").val();
			var Importe=$("#txtImporte_ProcVenta").val();
			var PU=0;
			var TipPrecio='';
			var TipoPrecio=$('input:radio[name=rbtTipoPrecioV]:checked').val();
			if(parseInt(TipoPrecio)===1){var PPublic=$("#txtPPublico_ProcVenta").val();
				if(PPublic!=""){PU=PPublic;TipPrecio='PP';}else{valido=false;}}
			else if(parseInt(TipoPrecio)===2){var PMenor=$("#txtPMenor_ProcVenta").val();
				if(PMenor!=""){PU=PMenor;TipPrecio='PB';}else{valido=false;}}
			else if(parseInt(TipoPrecio)===3){var PMayor=$("#txtPMayor_ProcVenta").val();
				if(PMayor!=""){PU=PMayor;TipPrecio='PD';}else{valido=false;}}
			var IdNP=-1;
			if(valido && IdProd!="-1" && Cant!="" && producto!="" && Cod!="" && PU!="" && PU.length>0 && Importe!=""){
				var EP=inst.Verificar_Existe_Product_Detail(IdProd);
				if(EP){
					inst.Build_Detail_VentaAdd([IdProd,Cod,producto+' '+Marca+' '+Modelo,Unidad,Cant,PU,Importe,TipoPrecio,TipPrecio,IdNP]);
					inst.Clear_Detail_VentaAdd();
				}
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");
			}
		}else{
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Error en proceso.");
		}
	}
	this.Verificar_DocumentoVenta=function(){var inst=new ClassRsvaVenta();
		$("#lblIdCliente").html("-1");
		$("#txtRuc_ProcVenta").prop("value","");$("#txtRS_ProcVenta").prop("value","");$("#txtDireccion_ProcVenta").prop("value","");
		var IdComprob=$("select#cboComprobante_ProcVenta option:selected").val();
		var IdAlm=$("#IdAlmRVenta").html();
		if(IdAlm!="-1" && IdComprob!="-1"){
			inst.getList_Documentos_Venta([IdComprob]);
		}		
	}
	this.getList_Documentos_Venta=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Documentos_Venta",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRsvaVenta();
				var Doc=e["Doc"];
				if(Doc.length>0){
					$("#cboTipoDoc_ProcVenta").empty();
					for(var i=0;i<Doc.length;i++){$("#cboTipoDoc_ProcVenta").append('<option value="'+Doc[i]["Id"]+'">'+Doc[i]["Nombre"]+'</option>');}
					$("#cboTipoDoc_ProcVenta").chosen({width: "100%"});
					$('#cboTipoDoc_ProcVenta').val(Doc[0]["Id"]).trigger('chosen:updated');
					console.log(params);
					//setTimeout(function() { document.getElementById('txtCodigo_ProcVenta').focus(); }, 3000);
					
					if (params[0]==10) {
						$("#IdChkIGVPVe ").prop('checked', false); 
					}else{
						$("#IdChkIGVPVe").prop('checked', true); 
					}
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Detail_VentaAdd=function(Datos){var inst=new ClassRsvaVenta();
		$('#IdTable_DetalleC_ProcVenta tbody').append('<tr>'+
			'<td id="deltManteDetail_0">'+
				'<i class="fas fa-times-circle f-18"></i>'+
			'</td>'+
			'<td>'+Datos[4]+'</td>'+
			'<td>'+Datos[1]+'</td>'+
			'<td>'+Datos[2]+'</td>'+
			'<td>'+Datos[3]+'</td>'+
			'<td>'+Datos[5]+'</td>'+
			'<td>'+Datos[6]+'</td>'+
			'<td>'+Datos[8]+'</td>'+
			'<td style="display:none">'+Datos[0]+'</td>'+
			'<td style="display:none">'+Datos[9]+'</td>'+
			'<td style="display:none">'+Datos[7]+'</td>'+
			'<td id="editManteDetail_0">'+
				'<i class="fas fa-edit f-18"></i>'+
			'</td>'+
		'</tr>');
		inst.TotalMonto_Table_DetailVentaFi();
		var IdAlm=$("#IdAlmRVenta").html();
		$('#IdTable_DetalleC_ProcVenta tbody').unbind("click");
		$('#IdTable_DetalleC_ProcVenta tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='deltManteDetail'){
				var add=$(this).parent("tr:first");
				add.remove();
				inst.TotalMonto_Table_DetailVentaFi();
			}else if(id[0]==='editManteDetail'){
				var trr=$(this).parent("tr:first")[0].cells;
				var IdPro=trr[8].innerHTML;console.log(IdPro);
				$("#txtCantidad_ProcVenta").prop("value",trr[1].innerHTML);
				var IdTipo=trr[10].innerHTML;console.log(IdTipo);
				if(parseInt(IdTipo)===1){$("#chkBtn1").prop("checked",true);}
				else if(parseInt(IdTipo)===2){$("#chkBtn2").prop("checked",true);}
				else if(parseInt(IdTipo)===3){$("#chkBtn3").prop("checked",true);}
				var add=$(this).parent("tr:first");
				add.remove();
				inst.getList_Producto_Id_modal_NP([IdAlm,IdPro],1);
				inst.TotalMonto_Table_DetailVentaFi();
			}
		});
	}
	this.TotalMonto_Table_DetailVentaFi=function(){
		var TotaMon=0.00;
		$("#IdTable_DetalleC_ProcVenta tbody tr").each(function (index){
			var importe=$(this).find("td").eq(6).html();
			TotaMon=parseFloat(TotaMon)+parseFloat(importe);
		});
		var IdIGV=$("#IdChkIGVPVe").is(':checked') ? 1 : 0;
		if(parseInt(IdIGV)===1){
			var SubTO=parseFloat(TotaMon)/parseFloat(1.18);
			var IGV=parseFloat(SubTO)*parseFloat(0.18);
			$("#txtSubTotal_ProcVenta").prop("value",parseFloat(SubTO).toFixed(2));
			$("#txtIGV_ProcVenta").prop("value",parseFloat(IGV).toFixed(2));
			
		}else{
			$("#txtSubTotal_ProcVenta").prop("value",parseFloat(TotaMon).toFixed(2));
			$("#txtIGV_ProcVenta").prop("value",parseFloat("0").toFixed(2));
		}
		$("#txtTotal_ProcVenta").prop("value",parseFloat(TotaMon).toFixed(2));
		var son=CLetras(parseFloat(TotaMon).toFixed(2),true,1);
		$("#txtSon_ProcVenta").prop("value",son);
	}
	this.getList_Producto_Codigo=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Producto_Codigo",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRsvaVenta();
				var Dato=e;
				if(Dato.length>0){
					$("#lblIdProducto").html(Dato[0]["IdProducto"]);
					$("#txtProducto_ProcVenta").prop("value",Dato[0]["Producto"]);
					$("#txtMarca_ProcVenta").prop("value",Dato[0]["Marca"]);
					$("#txtModelo_ProcVenta").prop("value",Dato[0]["Modelo"]);
					$("#txtUnidad_ProcVenta").prop("value",Dato[0]["Unidad"]);
					$("#txtPPublico_ProcVenta").prop("value",Dato[0]["PrecioPublico"]);
					$("#txtPMenor_ProcVenta").prop("value",Dato[0]["PrecioBase"]);
					$("#txtPMayor_ProcVenta").prop("value",Dato[0]["PrecioDistribuido"]);
					$("#txtStock_ProcVenta").prop("value",Dato[0]["Stock"]);
					$("#txtCodigo_ProcVenta").focus();
					inst.Calcular_Importe_Venta();
					inst.AgregarProductoCarrito();
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Calcular_Importe_Venta=function(){
		var TipoPrecio=$('input:radio[name=rbtTipoPrecioV]:checked').val();
		var Cantid=$("#txtCantidad_ProcVenta").val();
		var PU=0;
		if(Cantid!=""){
			if(parseInt(TipoPrecio)===1){var PPublic=$("#txtPPublico_ProcVenta").val();if(PPublic!=""){PU=PPublic;}}
			else if(parseInt(TipoPrecio)===2){var PMenor=$("#txtPMenor_ProcVenta").val();if(PMenor!=""){PU=PMenor;}}
			else if(parseInt(TipoPrecio)===3){var PMayor=$("#txtPMayor_ProcVenta").val();if(PMayor!=""){PU=PMayor;}}
			var Totl=parseFloat(PU)*parseFloat(Cantid);
			$("#txtImporte_ProcVenta").prop("value",parseFloat(Totl).toFixed(2));
		}else{
			$("#txtImporte_ProcVenta").prop("value","");
		}
	}
	this.Clear_Detail_VentaAdd=function(){
		$("#lblIdProducto").html("-1");
		$("#txtCantidad_ProcVenta").prop("value","1");
		$("#txtCodigo_ProcVenta").prop("value","");
		$("#txtProducto_ProcVenta").prop("value","");
		$("#txtMarca_ProcVenta").prop("value","");
		$("#txtModelo_ProcVenta").prop("value","");
		$("#txtUnidad_ProcVenta").prop("value","");
		$("#txtPPublico_ProcVenta").prop("value","");
		$("#txtPMenor_ProcVenta").prop("value","");
		$("#txtPMayor_ProcVenta").prop("value","");
		$("#txtImporte_ProcVenta").prop("value","");
		$("#txtStock_ProcVenta").prop("value","");
	}
	this.Clear_Grnal_Venta=function(){
		$("#lblIdCliente").html("-1");
		$("#txtTotal_ProcVenta").prop("value","0");
		$("#txtSubTotal_ProcVenta").prop("value","0");
		$("#txtIGV_ProcVenta").prop("value","0");
		$("#txtSon_ProcVenta").prop("value","");
		$("#IdTable_DetalleC_ProcVenta tbody").html("");
		
		$("#txtRuc_ProcVenta").prop("value","");
		$("#txtRS_ProcVenta").prop("value","");
		$("#txtDireccion_ProcVenta").prop("value","");
		$("#txtEmail_ProcVenta").prop("value","");
		$("#txtNroGuia_ProcVenta").prop("value","");
		$("#txtDescripNP_ProcCompra").prop("value","");
		
		var FeH=current_date();
		$("#txtFechaPago_ProcVenta").prop("value",FeH);
	}
	this.Verificar_Existe_Product_Detail=function(pIdProd){var inst=new ClassRsvaVenta();
		var vald=true;
		$("#IdTable_DetalleC_ProcVenta tbody tr").each(function (index){
			var aIdprod=$(this).find("td").eq(8).html();
			if(pIdProd===aIdprod){
				vald=false;
				let acant=$(this).find("td").eq(1).html();
				let apunit=$(this).find("td").eq(5).html();
				acant=parseFloat(acant);
				acant++;
				apunit=parseFloat(apunit);
				let aimport=acant*apunit;
				$(this).find("td").eq(1).html(acant);
				$(this).find("td").eq(6).html(aimport);
				inst.Clear_Detail_VentaAdd();
				inst.TotalMonto_Table_DetailVentaFi();
			}
		});
		return vald;
	}
	this.Save_Datos_Venta=function(params,pIdEmpresa,IdComprob){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"Save_Datos_Venta",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRsvaVenta();
				if(e["Val"]){ console.log(e["Sunat"]);
					alertify.success("PROCESO CORRECTO. Venta Nro "+e["IdVenta"]);
					inst.Clear_Detail_VentaAdd();inst.Clear_Grnal_Venta();
					var IdAlm=$("#IdAlmRVenta").html();
					if(parseInt(IdComprob)===1 || parseInt(IdComprob)===2){
						var fileName=e["Sunat"][0]["enlace"];
						if(fileName!=""){
							//var inst1=new ClassImpresion();
							//inst1.Create_Print_FacturaBoleta(e["IdVenta"],fileName);
							window.open(fileName);
							//$("#txtCodigo_ProcVenta").focus();
						}else{
							alertify.error("Factura electronica no se proceso. "+e["Sunat"][0]["error"]);
						}
					}else{
						var inst1=new ClassImpresion();
						inst1.getList_Print_Ticket([e["IdVenta"],pIdEmpresa]);
						//$("#txtCodigo_ProcVenta").focus();
					}
				}else{
					alertify.error("Error, Proceso Incorrecto. "+e["Sunat"][0]["error"]);
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
	/* BUSCAR PRODUCTO POR CODIGO*/
	this.Build_Modal_Productos_Venta=function(){var inst=new ClassRsvaVenta();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Productos_Modal_NP);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		var IdAlm=$("#IdAlmRVenta").html();console.log(IdAlm);
		if(IdAlm!="-1"){inst.getList_Productos_AlmComp([IdAlm]);}
	}
	this.getList_Productos_AlmComp=function(params){var inst=new ClassRsvaVenta();
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Productos_AlmComp",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e;var IdAlm=$("#IdAlmRVenta").html();console.log(e);
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
							'<td id="uniProdAlmD_'+ids+'">'+Dato[i]["Unidad"]+'</td> '+
							'<td id="uniProdAlmD_'+ids+'">'+Dato[i]["Stock"]+'</td> '+
							'<td id="uniProdAlmD_'+ids+'">'+Dato[i]["PrecioPublico"]+'</td> '+
							'<td id="prveProdAlmD_'+ids+'" style="display:none">'+ids+'</td> '+
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
						inst.getList_Producto_Id_modal_NP([IdAlm,idP],0);
					});
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});	
	}
	this.getList_Producto_Id_modal_NP=function(params,pTipo){var inst=new ClassRsvaVenta();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Producto_Id",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();Producto=e;
				if(Producto.length>0){
					$("#txtCodigo_ProcVenta").prop("value",Producto[0]["Codigo"]);
					$("#txtProducto_ProcVenta").prop("value",Producto[0]["Producto"]);
					$("#txtMarca_ProcVenta").prop("value",Producto[0]["Marca"]);
					$("#txtModelo_ProcVenta").prop("value",Producto[0]["Modelo"]);
					$("#txtUnidad_ProcVenta").prop("value",Producto[0]["Unidad"]);
					$("#txtPPublico_ProcVenta").prop("value",Producto[0]["PrecioPublico"]);
					$("#txtPMenor_ProcVenta").prop("value",Producto[0]["PrecioBase"]);
					$("#txtPMayor_ProcVenta").prop("value",Producto[0]["PrecioDistribuido"]);
					$("#txtStock_ProcVenta").prop("value",Producto[0]["Stock"]);
					$("#lblIdProducto").html(Producto[0]["IdProducto"]);
					inst.Calcular_Importe_Venta();
					if(parseInt(pTipo)===1){
						
					}else{
						$("#txtCantidad_ProcVenta").prop("value","1");
						$('#myModal').modal('hide');$('#modal_Manten').html("");
						$(".modal-open").removeClass('modal-open');
					}
					
					$("#txtCantidad_ProcVenta").focus();
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
	//Search cliente
	this.Build_Modal_Cliente_Venta=function(){var inst=new ClassRsvaVenta();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Cliente_Modal_Venta);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		//var IdAlm=$("#IdAlmRVenta").html();IdTableCliente_PVenta
		inst.getList_Clientes_ProcVenta();
	}
	this.getList_Clientes_ProcVenta=function(){var inst=new ClassRsvaVenta();
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Clientes_ProcVenta"},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e;var IdAlm=$("#IdAlmRVenta").html();
				if(Dato.length>0){
					$("#IdTableCliente_PVenta tbody").html("");		
					for(var i=0;i<Dato.length;i++){
						var ids=Dato[i]["IdCliente"];
						$('#IdTableCliente_PVenta tbody').append('<tr>'+
							'<td id="selcPVCLI_'+ids+'">'+
								'<input type="radio" name="IdSelPVentaClient" value="'+ids+'" class="chk2020">'+
							'</td>'+
							'<td id="rucPVCLI_'+ids+'">'+Dato[i]["Ruc"]+'</td>'+
							'<td id="razonsPVCLI_'+ids+'">'+Dato[i]["RazonSocial"]+'</td> '+
							'<td id="direccPVCLI_'+ids+'">'+Dato[i]["Direccion"]+'</td> '+
						'</tr>');
					}
					$('#filtrar').keyup(function(){
						var rex = new RegExp($(this).val(), 'i');
						$('.buscar tr').hide();
						$('.buscar tr').filter(function (){
							return rex.test($(this).text());
						}).show();
					});
					
					$('input:radio[name=IdSelPVentaClient]').on('click',function(e){
						var idP=$(this)[0].value;
						$("#txtRuc_ProcVenta").prop("value",$("#rucPVCLI_"+idP).html());
						$("#txtRS_ProcVenta").prop("value",$("#razonsPVCLI_"+idP).html());
						$("#txtDireccion_ProcVenta").prop("value",$("#direccPVCLI_"+idP).html());
						$('#myModal').modal('hide');$('#modal_Manten').html("");
						$(".modal-open").removeClass('modal-open');
						$("#lblIdCliente").html(idP);
					});
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	
	// Nubefact
	this.Verificar_NroRuc=function(){var inst=new ClassRsvaVenta();
		$("#lblIdCliente").html("-1");
		var IdTipoDoc=$("select#cboTipoDoc_ProcVenta option:selected").val();
		var NroRuc=$("#txtRuc_ProcVenta").val();
		$("#txtRS_ProcVenta").prop("value","");
		$("#txtDireccion_ProcVenta").prop("value","");
		if(parseInt(IdTipoDoc)===6){//Ruc
			if(NroRuc.length===11){
				inst.getRecuperarRS(NroRuc);
			}
		}else if(parseInt(IdTipoDoc)===1){
			if(NroRuc.length===8){
				if(NroRuc!='12345678'){
					$.ajax({type:"POST",url:"./services/consulta.php",data: {"ndni":NroRuc},
						async:true,dataType:"json",success:function(e){var inst=new ClassRsvaVenta();
							if(e["success"]){
								var Dato=e["result"];console.log(Dato);
								$("#txtRS_ProcVenta").prop("value",Dato["Nombres"]+' '+Dato["ApellidoPaterno"]+' '+Dato["ApellidoMaterno"]);
							}
						},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
					});
				}else{
					$("#txtRS_ProcVenta").prop("value","General");
				}	
			}
		}
	}
	this.getRecuperarRS=function(doc){
		$.ajax({
            url:'http://www.turismotisoc.com/consultas/api.php',
            method:'get',
            dataType: 'JSON',
            async:false,
            data: {
              id : doc,
            },
            success: function(res) {console.log(res);
              $('#txtRS_ProcVenta').val(res['nombre']);
              $('#txtDireccion_ProcVenta').val(res['direccion']);
            },
        });
	}
	this.getList_RecuperarRS_Nubefact=function(params){
		//$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_RecuperarRS_Nubefact",array:params},
			async:true,dataType:"json",success:function(e){var inst=new ClassRsvaVenta();//$.unblockUI();
				var Valido=e[0]["success"];console.log(e);
				if(Valido){
					$("#txtRS_ProcVenta").prop("value",e[0]["Dato"]["nombre_o_razon_social"]);
					$("#txtDireccion_ProcVenta").prop("value",e[0]["Dato"]["direccion"]);
				}else{
					$("#txtRS_ProcVenta").prop("value","");
					$("#txtDireccion_ProcVenta").prop("value","");
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(errorMessage);console.log(textStatus);}
		});
	}
	
	//Nota Pedido
	this.Build_Modal_Venta_NP=function(){var inst=new ClassRsvaVenta();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Venta_NPP);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		var IdAlm=$("#IdAlmRVenta").html();
		var IdEmpresa=$("select#cboEmpresa_ProcVenta option:selected").val();
		if(IdAlm!="-1" && IdEmpresa!="-1"){inst.getList_Datos_VentaNP([IdAlm,IdEmpresa]);}
		
		$("#btnAddNP_VentaNP").on('click',function(e){
			var Idss=$('input:radio[name=idnpVNP]:checked').val();
			if(Idss!=undefined){
				inst.getList_RecuperarDetail_VentaNP([IdAlm,Idss,IdEmpresa]);
			}else{
				alertify.error("Seleccione Nota Pedido.");
			}
		});
	}
	this.getList_Datos_VentaNP=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Datos_VentaNP",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var Datos=e;var inst=new ClassRsvaVenta();
				if(Datos.length>0){
					$("#IdTableNP_VentaNP tbody").html("");	
					for(var i=0;i<Datos.length;i++){
						var ids=Datos[i]["IdVenta"];
						$('#IdTableNP_VentaNP tbody').append('<tr>'+
								'<td>'+
									'<input type="radio" name="idnpVNP" class="chk2020 selcaSelIdVentaNP" value="'+ids+'">'+
								'</td>'+
								'<td>'+Datos[i]["Fec"]+'</td> '+
								'<td>NP</td> '+
								'<td>'+Datos[i]["Serie"]+'/'+Datos[i]["Numero"]+'</td> '+
								'<td>'+Datos[i]["Ruc"]+'</td> '+
								'<td>'+Datos[i]["RS"]+'</td> '+
								'<td>'+Datos[i]["Total"]+'</td> '+
								'<td>'+Datos[i]["Userr"]+'</td> '+
							'</tr>');
					}
				}else{
					$('#myModal').modal('hide');$('#modal_Manten').html("");
					 $(".modal-open").removeClass('modal-open');
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("No hay Datos.");
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_RecuperarDetail_VentaNP=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_RecuperarDetail_VentaNP",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRsvaVenta();
				var Cabe=e["Cabe"];
				var Detail=e["Detail"];
				if(Cabe.length>0){
					$("#txtRuc_ProcVenta").prop("value",Cabe[0]["Ruc"]);
					$("#txtRS_ProcVenta").prop("value",Cabe[0]["RS"]);
					$("#txtDireccion_ProcVenta").prop("value",Cabe[0]["Direccion"]);
					$("#txtDescripNP_ProcCompra").prop("value",Cabe[0]['IdVenta']);
				}
				if(Detail.length>0){
					$("#IdTable_DetalleC_ProcVenta tbody").html("");
					for(var i=0;i<Detail.length;i++){
						inst.Build_Detail_VentaAdd([Detail[i]["IdProducto"],Detail[i]["Codigo"],Detail[i]["Descripcion"],Detail[i]["Unidad"],
								Detail[i]["Cantidad"],Detail[i]["Precio"],Detail[i]["Importe"],Detail[i]["IdTipoPrecio"],Detail[i]["TipPrecio"],
								Detail[i]["IdVenta"]]);
					}					
				}
				$('#myModal').modal('hide');$('#modal_Manten').html("");
				$(".modal-open").removeClass('modal-open');
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
}