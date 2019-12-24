$(window).on('load',function(){var inst=new ClassReportCPC();
		$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmRepCPC").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRepCPC").html();
	
	$("#IdFechaIn_COMPPAG").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_Datos_ReportCPC();}});
	$("#IdFechaIn_COMPPAG").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_COMPPAG").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_Datos_ReportCPC();}});
	$("#IdFechaFn_COMPPAG").datepicker( "option", "dateFormat", "dd/mm/yy" );

	//$("#btnPrint_VPV").on('click',function(e){$("#IdContentRVPV").printArea();});
	//$("#btnExportar_VPV").on('click',function(e){window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRVPV').html()));});
	
	$("#btnAgruparCPago_COMPPAG").on('click',function(e){
		var ArrVentas=[];var montTO=0;var Proveed='';var IdProv=-1;
		$(".claSelcVentPagVend").each(function(e){
			var chkV=$(this)[0].checked;
			if(chkV){
				var ids=$(this)[0].value;
				if(Proveed===''){
					Proveed=$("#proveedREPVENT_"+ids).html();
					IdProv=$("#idprovvREPVENT_"+ids).html();
				}
				var to=$("#totlREPVENT_"+ids).html();
				montTO=parseFloat(montTO)+parseFloat(to);
				var iddd=ids.split('_')[0];
				ArrVentas.push({"aId":iddd});
			}
		});
		if(ArrVentas.length>0){
			inst.Build_Modal_CompraCredito(ArrVentas,montTO,Proveed,IdProv);
		}else{
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione Minimo 1.");
		}
	});
});
function ClassReportCPC(){
	this.verificar_Datos_ReportCPC=function(){var inst=new ClassReportCPC();
		$("#IdTable_ReportCOMPPAG tbody").html("");
		var feIn=$("#IdFechaIn_COMPPAG").val(),feFn=$("#IdFechaFn_COMPPAG").val();
		var IdAlm=$("#IdAlmRepCPC").html();
		var IdEmp=$("select#cboEmpresa_VPV option:selected").val();
		if(feIn!="" && feFn!="" && IdAlm!="-1"){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_CPC([feIn,feFn,IdAlm]);
		}
	}
	this.getList_Datos_CPC=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_CPC",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassReportCPC();
				inst.Build_Datos_ReportCPC(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_ReportCPC=function(Datos){var inst=new ClassReportCPC();
		$("#IdTable_ReportCOMPPAG tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var pIdEstd=parseInt(Datos[i]["Estado"]);
			var ids=Datos[i]["IdCompra"]+'_'+pIdEstd;
			var chkSecl='';btnPagar='';btnEdit='';btnDelete='';
			if(pIdEstd===1){
				chkSecl='<input type="checkbox" id="IdChkREPVENTC_'+ids+'" name="chkSelVENTR" value="'+ids+'" class="chk2020 claSelcVentPagVend">';
				btnPagar='<i class="fab fa-paypal f-18"></i>';
			}else if(pIdEstd===2){
				btnDelete='<i class="fas fa-times-circle f-18"></i>';
				btnEdit='<i class="fas fa-edit f-18"></i>';
			}else if(pIdEstd===3){
				btnDelete='<i class="fas fa-times-circle f-18"></i>';
			}
			$('#IdTable_ReportCOMPPAG tbody').append('<tr>'+
				'<td id="selCCP_'+ids+'">'+
					chkSecl+
				'</td>'+
				'<td id="pagarCCP_'+ids+'">'+
					btnPagar+
				'</td>'+
				/*'<td id="editCCP_'+ids+'">'+
					btnEdit+
				'</td>'+*/
				'<td id="idprovvREPVENT_'+ids+'" style="display:none">'+Datos[i]["IdProveedor"]+'</td>'+
				'<td>'+Datos[i]["Fec"]+'</td>'+
				'<td>'+Datos[i]["Comprobante"]+' '+Datos[i]["Serie"]+'/'+Datos[i]["Numero"]+'</td>'+
				'<td id="proveedREPVENT_'+ids+'">'+Datos[i]["Proveedor"]+'</td>'+
				'<td id="totlREPVENT_'+ids+'">'+Datos[i]["Total"]+'</td>'+
				'<td>'+Datos[i]["Userr"]+'</td>'+
				'<td>'+Datos[i]["Est"]+'</td>'+
				'<td>'+Datos[i]["FechaPago"]+'</td>'+
				'<td id="anularCCP_'+ids+'">'+
					btnDelete+
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
		
		var IdAlm=$("#IdAlmRepCPC").html();
		
		$('#IdTable_ReportCOMPPAG tbody').unbind("click");
		$('#IdTable_ReportCOMPPAG tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');
			if(id[0]==='pagarCCP'){
				if(parseInt(id[2])===1){
					var iddds=id[1]+'_'+id[2];
					var aTotal=$("#totlREPVENT_"+iddds).html();
					var aProve=$("#proveedREPVENT_"+iddds).html();
					var pIdProv=$("#idprovvREPVENT_"+iddds).html();
					inst.Build_Modal_Pagar_CompraCredito(id[1],id[2],aTotal,aProve,pIdProv);
				}
			}
			else if(id[0]==='anularCCP'){
				if(parseInt(id[2])===2 || parseInt(id[2])===3){
					var iddds=id[1]+'_'+id[2];
					var aProve=$("#proveedREPVENT_"+iddds).html();
					var pIdProv=$("#idprovvREPVENT_"+iddds).html();
					vex.dialog.prompt({ className: 'vex-theme-os', message: 'Motivo para Anular Compra Credito?:', callback: function(ee){
								if(ee!=false && ee!=''){
									inst.Build_Modal_Delete_CompraCredito([id[1],IdAlm,id[2],ee]);
								}
							} 
					});
				}
			}
			else if(id[0]==='editCCP'){
				if(parseInt(id[2])===2){
					var iddds=id[1]+'_'+id[2];
					var aProve=$("#proveedREPVENT_"+iddds).html();
					var pIdProv=$("#idprovvREPVENT_"+iddds).html();
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();
					vex.dialog.confirm({ message:'Desea Editar?',callback: function(ee){
						if(ee){
							inst.Build_Modal_Edit_CompraCredito(id[1],IdAlm,id[2],aProve,pIdProv);
						}
					}});
				}
			}
		});
		$(".claSelcVentPagVend").on('click',function(e){
			var ids=$(this)[0].value;
			var pIdProv=$("#idprovvREPVENT_"+ids).html();
			var valid=inst.Verificar_Chk_Exist(ids,pIdProv);
			if(valid){
				
			}else{
				$("#IdChkREPVENTC_"+ids).prop("checked",false);
			}
		});
	}
	this.Verificar_Chk_Exist=function(pIds,pIdPv){
		var valido=true;
		$(".claSelcVentPagVend").each(function(e){
			var ids=$(this)[0].checked;
			if(valido && ids){
				var val=$(this)[0].value;
				var aIdProv=$("#idprovvREPVENT_"+val).html();
				if(aIdProv!=pIdPv){
					valido=false;
				}
			}	
		});
		return valido;
	}
	this.Build_Modal_CompraCredito=function(Datos,pMonto,pProveed,pIdProveedor){var inst=new ClassReportCPC();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_CompraCredito_Compra);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		$("#txtTotalVenta_CPC").prop("value",parseFloat(pMonto).toFixed(2));
		$("#txtProveedor_CPC").prop("value",pProveed);
		var IdAlm=$("#IdAlmRepCPC").html();
		
		$("#txtFechaPago_addCPC").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
		$("#txtFechaPago_addCPC").datepicker( "option", "dateFormat", "dd/mm/yy" );
		
		$("#txtMonto_addCPC").focusout(function(){inst.Calcular_Importe_CompraCredito();});
		$("#txtMonto_addCPC").keyup(function (e){if(e.which == 13){$("#txtInteres_addCPC").focus();}});
		$("#txtInteres_addCPC").focusout(function(){inst.Calcular_Importe_CompraCredito();});
		$("#txtInteres_addCPC").keyup(function (e){if(e.which == 13){$("#btnAddDetail_CPC").focus();}});
		
		$("#btnAddDetail_CPC").on('click',function(e){
			var NroC=$("#txtNroCuota_addCPC").val();
			var Monto=$("#txtMonto_addCPC").val();
			var Interes=$("#txtInteres_addCPC").val();
			var Total=$("#txtTotal_addCPC").val();
			var FechaPag=$("#txtFechaPago_addCPC").val();
			if(NroC!="" && Monto!="" &&  Interes!="" &&  Total!="" &&  FechaPag!=""){
				var EP=inst.Verificar_Existe_NroCuota(NroC);
				if(EP){
					inst.Build_Detail_VentaAdd([NroC,Monto,Interes,Total,FechaPag]);
					inst.Clear_Detail_AddDetails();
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Nro Cuota ya existe.");
				}
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar los Datos.");
			}
		});
		$("#btnSaveCompraCredito_CPC").on('click',function(e){
			var Proveedor=$("#txtProveedor_CPC").val();
			var Total=pMonto;
			var TotalAdd=$("#txtTotalMonto_CPC").val();
			var Detail=[];
			$("#IdTableCredito_CPC tbody tr").each(function (index){
				var aNroC=$(this).find("td").eq(2).html();
				var aMonto=$(this).find("td").eq(3).html();
				var aInteres=$(this).find("td").eq(4).html();
				var aTotal=$(this).find("td").eq(5).html();
				var aFechaPago=$(this).find("td").eq(6).html();
				aFechaPago=aFechaPago.split('/')[2]+'-'+aFechaPago.split('/')[1]+'-'+aFechaPago.split('/')[0];
				Detail.push({"aNroC":aNroC,"aMonto":aMonto,"aInteres":aInteres,"aTotal":aTotal,"aFechaPago":aFechaPago});
			});
			if(Proveedor!="" &&  Total!="" &&  TotalAdd!="" && parseFloat(Total).toFixed(2)===parseFloat(TotalAdd).toFixed(2)){
				if(Detail.length>0){console.log(Datos);
					inst.Save_Datos_CompraCredito([Proveedor,pIdProveedor,IdAlm,Total,Datos,Detail]);
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Agregar Detalle.");
				}
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar los Datos.");
			}
		});
	}
	this.Build_Detail_VentaAdd=function(Datos){var inst=new ClassReportCPC();
		var iddd=Datos[0];
		$('#IdTableCredito_CPC tbody').append('<tr>'+
			'<td id="deltManteDetail_'+iddd+'">'+
				'<i class="fas fa-times-circle f-18"></i>'+
			'</td>'+
			'<td id="editManteDetail_'+iddd+'">'+
				'<i class="fas fa-edit f-18"></i>'+
			'</td>'+
			'<td id="nroCuoVPV_'+iddd+'">'+Datos[0]+'</td>'+
			'<td id="montVPV_'+iddd+'">'+Datos[1]+'</td>'+
			'<td id="interesVPV_'+iddd+'">'+Datos[2]+'</td>'+
			'<td id="totlaVPV_'+iddd+'">'+Datos[3]+'</td>'+
			'<td id="fecpagVPV_'+iddd+'">'+Datos[4]+'</td>'+
		'</tr>');
		inst.TotalMonto_Table_DetailCompraFi();
		$('#IdTableCredito_CPC tbody').unbind("click");
		$('#IdTableCredito_CPC tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='deltManteDetail'){
				var add=$(this).parent("tr:first");
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();
				vex.dialog.confirm({ message:'Desea Eliminar?',callback: function(ee){
					if(ee){
						add.remove();
						inst.TotalMonto_Table_DetailCompraFi();
					}
				}});
			}else if(id[0]==='editManteDetail'){
				var ids=id[1];
				var add=$(this).parent("tr:first");
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();
				vex.dialog.confirm({ message:'Desea Editar?',callback: function(ee){
					if(ee){
						$("#txtNroCuota_addCPC").prop("value",ids);
						$("#txtMonto_addCPC").prop("value",$("#montVPV_"+ids).html());
						$("#txtInteres_addCPC").prop("value",$("#interesVPV_"+ids).html());
						$("#txtTotal_addCPC").prop("value",$("#totlaVPV_"+ids).html());
						$("#txtFechaPago_addCPC").prop("value",$("#fecpagVPV_"+ids).html());
						add.remove();
						inst.TotalMonto_Table_DetailCompraFi();
					}
				}});
				
			}
		});
	}
	this.TotalMonto_Table_DetailCompraFi=function(){
		var TotaMon=0.00;
		$("#IdTableCredito_CPC tbody tr").each(function (index){
			var importe=$(this).find("td").eq(5).html();
			TotaMon=parseFloat(TotaMon)+parseFloat(importe);
		});
		$("#txtTotalMonto_CPC").prop("value",parseFloat(TotaMon).toFixed(2));
	}
	this.Calcular_Importe_CompraCredito=function(){
		var Monto=$("#txtMonto_addCPC").val();
		var Interes=$("#txtInteres_addCPC").val();
		if(Monto!="" && Interes!=""){
			var Totl=parseFloat(Monto)+parseFloat(Interes);
			$("#txtTotal_addCPC").prop("value",parseFloat(Totl).toFixed(2));
		}else{
			$("#txtTotal_addCPC").prop("value","");
		}
	}
	this.Clear_Detail_AddDetails=function(){
		$("#txtNroCuota_addCPC").prop("value","");
		$("#txtMonto_addCPC").prop("value","");
		$("#txtInteres_addCPC").prop("value","");
		$("#txtTotal_addCPC").prop("value","");
		$("#txtFechaPago_addCPC").prop("value","");
	}
	this.Verificar_Existe_NroCuota=function(pNroC){
		var vald=true;
		$("#IdTableCredito_CPC tbody tr").each(function (index){
			var aIdNroC=$(this).find("td").eq(2).html();
			if(aIdNroC===pNroC){
				vald=false;
			}
		});
		return vald;
	}
	this.Save_Datos_CompraCredito=function(params){var inst=new ClassReportCPC();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Save_Datos_CompraCredito",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e["Val"]){
					alertify.success("PROCESO CORRECTO.");
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					 $(".modal-open").removeClass('modal-open');
					 inst.verificar_Datos_ReportCPC();
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	//PAGAR COMPRA SIMPLE
	this.Build_Modal_Pagar_CompraCredito=function(IdCompra,pIdEstado,pTotal,pProveedor,pIdProv){var inst=new ClassReportCPC();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_CompraCredito_PagarSimple);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		$("#txtTotalVenta_CPCPAY").prop("value",parseFloat(pTotal).toFixed(2));
		$("#txtProveedor_CPCPAY").prop("value",pProveedor);
		var IdAlm=$("#IdAlmRepCPC").html();
		var fechaHoy=current_date();
		$("#txtFechaPago_CPCPAY").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
		$("#txtFechaPago_CPCPAY").datepicker( "option", "dateFormat", "dd/mm/yy" );
		$("#txtFechaPago_CPCPAY").prop("value",fechaHoy);
		
		$("#txtMora_addCPC").focusout(function(){inst.Calcular_TotalPagar_CompraCredito();});
		$("#txtMora_addCPC").keyup(function (e){if(e.which == 13){$("#btnSaveCompraCredito_CPCPAY").focus();}});
		
		
		$("#btnSaveCompraCredito_CPCPAY").on('click',function(e){
			var Proveedor=$("#txtProveedor_CPCPAY").val();
			var Total=pTotal;
			var Mora=$("#txtMora_addCPC").val();
			var TotalPagar=$("#txtTotalPagar_CPCPAY").val();
			var FechaPag=$("#txtFechaPago_CPCPAY").val();
			
			if(Proveedor!="" &&  Total!="" &&  TotalPagar!="" &&  Mora!="" && IdAlm!="-1" && FechaPag!=""){
				FechaPag=FechaPag.split('/')[2]+'_'+FechaPag.split('/')[1]+'_'+FechaPag.split('/')[0];
				inst.Save_PagarSimple_CompraCredito([IdCompra,IdAlm,Total,Mora,TotalPagar,pProveedor,FechaPag,pIdProv]);
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar los Datos.");
			}
		});
	}
	this.Calcular_TotalPagar_CompraCredito=function(){
		var Monto=$("#txtTotalVenta_CPCPAY").val();
		var Mora=$("#txtMora_addCPC").val();
		if(Monto!="" && Mora!=""){
			var Totl=parseFloat(Monto)+parseFloat(Mora);
			$("#txtTotalPagar_CPCPAY").prop("value",parseFloat(Totl).toFixed(2));
		}else{
			$("#txtTotalPagar_CPCPAY").prop("value","");
		}
	}
	this.Save_PagarSimple_CompraCredito=function(params){var inst=new ClassReportCPC();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Save_PagarSimple_CompraCredito",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					 $(".modal-open").removeClass('modal-open');
					 inst.verificar_Datos_ReportCPC();
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	//ANULAR CREDITO COMPRA O PAGADO
	this.Build_Modal_Delete_CompraCredito=function(params){var inst=new ClassReportCPC();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Build_Modal_Delete_CompraCredito",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e["Val"]){
					var Ress=e["Result"][0]["aResult"];
					if(parseInt(Ress)===1){
						alertify.success("PROCESO CORRECTO.");
						inst.verificar_Datos_ReportCPC();
					}else{
						alertify.error("Error, Contiene Pagos al Proveedor, Primero Eliminar Detalle Pago Proveedor.");
					}
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	//EDIT COMPRA Credito
	this.Build_Modal_Edit_CompraCredito=function(IdCompra,pIdEstado,pProveed,pIdProveedor){var inst=new ClassReportCPC();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_CompraCredito_CompraEdit);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		$("#txtTotalVenta_CPC").prop("value",parseFloat(pMonto).toFixed(2));
		$("#txtProveedor_CPC").prop("value",pProveed);
		var IdAlm=$("#IdAlmRepCPC").html();
		inst.getList_Datos_CompraCredito_Edit();
		$("#txtFechaPago_addCPC").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
		$("#txtFechaPago_addCPC").datepicker( "option", "dateFormat", "dd/mm/yy" );
		
		$("#txtMonto_addCPC").focusout(function(){inst.Calcular_Importe_CompraCredito();});
		$("#txtMonto_addCPC").keyup(function (e){if(e.which == 13){$("#txtInteres_addCPC").focus();}});
		$("#txtInteres_addCPC").focusout(function(){inst.Calcular_Importe_CompraCredito();});
		$("#txtInteres_addCPC").keyup(function (e){if(e.which == 13){$("#btnAddDetail_CPC").focus();}});
		
		$("#btnAddDetail_CPC").on('click',function(e){
			var NroC=$("#txtNroCuota_addCPC").val();
			var Monto=$("#txtMonto_addCPC").val();
			var Interes=$("#txtInteres_addCPC").val();
			var Total=$("#txtTotal_addCPC").val();
			var FechaPag=$("#txtFechaPago_addCPC").val();
			if(NroC!="" && Monto!="" &&  Interes!="" &&  Total!="" &&  FechaPag!=""){
				var EP=inst.Verificar_Existe_NroCuota(NroC);
				if(EP){
					inst.Build_Detail_VentaAdd([NroC,Monto,Interes,Total,FechaPag]);
					inst.Clear_Detail_AddDetails();
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Nro Cuota ya existe.");
				}
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar los Datos.");
			}
		});
		$("#btnSaveCompraCredito_CPC").on('click',function(e){
			var Proveedor=$("#txtProveedor_CPC").val();
			var Total=pMonto;
			var TotalAdd=$("#txtTotalMonto_CPC").val();
			var Detail=[];
			$("#IdTableCredito_CPC tbody tr").each(function (index){
				var aNroC=$(this).find("td").eq(2).html();
				var aMonto=$(this).find("td").eq(3).html();
				var aInteres=$(this).find("td").eq(4).html();
				var aTotal=$(this).find("td").eq(5).html();
				var aFechaPago=$(this).find("td").eq(6).html();
				aFechaPago=aFechaPago.split('/')[2]+'-'+aFechaPago.split('/')[1]+'-'+aFechaPago.split('/')[0];
				Detail.push({"aNroC":aNroC,"aMonto":aMonto,"aInteres":aInteres,"aTotal":aTotal,"aFechaPago":aFechaPago});
			});
			if(Proveedor!="" &&  Total!="" &&  TotalAdd!="" && parseFloat(Total).toFixed(2)===parseFloat(TotalAdd).toFixed(2)){
				if(Detail.length>0){console.log(Datos);
					inst.Save_Datos_CompraCredito([Proveedor,pIdProveedor,IdAlm,Total,Datos,Detail]);
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Agregar Detalle.");
				}
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar los Datos.");
			}
		});
	}
	this.getList_Datos_CompraCredito_Edit=function(params){var inst=new ClassReportCPC();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_CompraCredito_Edit",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
								
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
	
}
