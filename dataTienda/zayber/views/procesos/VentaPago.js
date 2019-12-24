$(window).on('load',function(){var inst=new ClassReportVPV();
	$("#IdAlmacenPri").css("display","none");
	
	inst.getList_cbo_VPV();
	$("#IdFechaIn_VPV").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_Datos_ReportVPV();}});
	$("#IdFechaIn_VPV").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_VPV").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_Datos_ReportVPV();}});
	$("#IdFechaFn_VPV").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#cboEmpresa_VPV").on('change',function(e){inst.verificar_Datos_ReportVPV();});
	
	$("#btnPrint_VPV").on('click',function(e){$("#IdContentRVPV").printArea();});
	$("#btnExportar_VPV").on('click',function(e){window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRVPV').html()));});
	
	$("#btnAgruparCredito_VPV").on('click',function(e){
		var ArrVentas=[];var montTO=0;var RucSel='';var aRS='';var aIdCliente='';
		$(".claSelcVentPagVend").each(function(e){
			var chkV=$(this)[0].checked;
			if(chkV){
				var ids=$(this)[0].value;
				if(RucSel===''){
					RucSel=$("#nroRUCREPVENT_"+ids).html();
					aRS=$("#rrssREPVENT_"+ids).html();
					aIdCliente=$("#idclientREPVENT_"+ids).html();
				}
				var to=$("#totlREPVENT_"+ids).html();
				montTO=parseFloat(montTO)+parseFloat(to);
				var idd=ids.split('_');
				ArrVentas.push({"aIdVenta":idd[0],"aIdEstado":idd[1],"aIdEmpresa":idd[2],"aIdAlm":idd[3]});
			}
		});
		if(ArrVentas.length>0){
			inst.Build_Modal_VentaCredito(ArrVentas,montTO,RucSel,aRS,aIdCliente);
		}else{
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione Minimo 1.");
		}
	});
});
function ClassReportVPV(){
	this.getList_cbo_VPV=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_cbo_VPV"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassReportVPV();var Dato=e;
				if(Dato.length>0){
					$("#cboEmpresa_VPV").empty();//$("#cboEmpresa_VPV").append('<option value="-1">Todos</option>');
					for(var i=0;i<Dato.length;i++){$("#cboEmpresa_VPV").append('<option value="'+Dato[i]["IdEmpresa"]+'">'+Dato[i]["Comercial"]+'</option>');}
					$("#cboEmpresa_VPV").chosen({width: "100%"});
					$('#cboEmpresa_VPV').val(Dato[0]["IdEmpresa"]).trigger('chosen:updated');
				}else{
					$("#cboEmpresa_VPV").empty();$("#cboEmpresa_VPV").append('<option value="-1">Seleccione</option>');
					$("#cboEmpresa_VPV").chosen({width: "100%"});$('#cboEmpresa_VPV').val("-1").trigger('chosen:updated');
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.verificar_Datos_ReportVPV=function(){var inst=new ClassReportVPV();
		$("#IdTableReportec_ReportVPV tbody").html("");
		var feIn=$("#IdFechaIn_VPV").val(),feFn=$("#IdFechaFn_VPV").val();
		var IdEmp=$("select#cboEmpresa_VPV option:selected").val();
		if(feIn!="" && feFn!="" && IdEmp!="-1"){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_VPV([feIn,feFn,IdEmp]);
		}
	}
	this.getList_Datos_VPV=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_VPV",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassReportVPV();
				inst.Build_Datos_ReportVPV(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_ReportVPV=function(Datos){var inst=new ClassReportVPV();
		$("#IdTableReportec_ReportVPV tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var pIdEstd=parseInt(Datos[i]["Estado"]);
			var ids=Datos[i]["IdVenta"]+'_'+pIdEstd+'_'+Datos[i]["IdEmpresa"]+'_'+Datos[i]["IdAlmacen"];
			var chkSecl='';btnPagar='';btnDelete='';//btnEdit='';
			if(pIdEstd===1){
				chkSecl='<input type="checkbox" id="IdChkREPVENTC_'+ids+'" name="chkSelVENTR" value="'+ids+'" class="chk2020 claSelcVentPagVend">';
				btnPagar='<i class="fab fa-paypal f-18"></i>';
			}else if(pIdEstd===2){
				btnDelete='<i class="fas fa-times-circle f-18"></i>';
				//btnEdit='<i class="fas fa-edit f-18"></i>';
			}else if(pIdEstd===3){
				btnDelete='<i class="fas fa-times-circle f-18"></i>';
			}
			$('#IdTableReportec_ReportVPV tbody').append('<tr>'+
				'<td id="selCVV_'+ids+'">'+
					chkSecl+
				'</td>'+
				'<td id="pagarCVV_'+ids+'">'+
					btnPagar+
				'</td>'+
				/*'<td id="editCVV_'+ids+'">'+
					btnEdit+
				'</td>'+*/
				'<td id="idclientREPVENT_'+ids+'" style="display:none">'+Datos[i]["IdCliente"]+'</td>'+
				'<td>'+Datos[i]["Empresa"]+'</td>'+
				'<td>'+Datos[i]["Fec"]+'</td>'+
				'<td>'+Datos[i]["Comprobante"]+' '+Datos[i]["Serie"]+'/'+Datos[i]["Numero"]+'</td>'+
				'<td id="nroRUCREPVENT_'+ids+'">'+Datos[i]["Ruc"]+'</td>'+
				'<td id="rrssREPVENT_'+ids+'">'+Datos[i]["RazonSocial"]+'</td>'+
				//'<td>'+Datos[i]["Direccion"]+'</td>'+
				'<td id="totlREPVENT_'+ids+'">'+Datos[i]["Total"]+'</td>'+
				'<td>'+Datos[i]["Userr"]+'</td>'+
				'<td>'+Datos[i]["Email"]+'</td>'+
				'<td>'+Datos[i]["Est"]+'</td>'+
				'<td>'+Datos[i]["FecPag"]+'</td>'+
				'<td id="anularCVV_'+ids+'">'+
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
		
		//var altM=parseFloat($(window).height())-parseFloat(235);;
		//$(".table-responsive").css({"overflow-y":"scroll","height":altM+"px"});

		$('#IdTableReportec_ReportVPV tbody').unbind("click");
		$('#IdTableReportec_ReportVPV tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');
			if(id[0]==='pagarCVV'){
				if(parseInt(id[2])===1){
					var iddds=id[1]+'_'+id[2]+'_'+id[3]+'_'+id[4];
					var aTotal=$("#totlREPVENT_"+iddds).html();
					var aCliente=$("#rrssREPVENT_"+iddds).html();
					var aRuc=$("#nroRUCREPVENT_"+iddds).html();
					var pIdCliente=$("#idclientREPVENT_"+iddds).html();
					inst.Build_Modal_Pagar_VentaCreditoSimple(id[1],id[2],id[3],id[4],aTotal,aRuc,aCliente,pIdCliente);
				}
			}
			else if(id[0]==='anularCVV'){
				if(parseInt(id[2])===2 || parseInt(id[2])===3){
					var iddds=id[1]+'_'+id[2]+'_'+id[3]+'_'+id[4];
					var pIdCliente=$("#idclientREPVENT_"+iddds).html();
					vex.dialog.prompt({ className: 'vex-theme-os', message: 'Motivo para Anular Venta Credito?:', callback: function(ee){
								if(ee!=false && ee!=''){
									inst.Build_Modal_Delete_VentaCredito([id[1],id[2],id[3],id[4],pIdCliente,ee]);
								}
							} 
					});
				}
			}
		});
		
		$(".claSelcVentPagVend").on('click',function(e){
			var ids=$(this)[0].value;
			var pIdClient=$("#idclientREPVENT_"+ids).html();
			var valid=inst.Verificar_Chk_Exist(pIdClient);
			if(valid){
				
			}else{
				$("#IdChkREPVENTC_"+ids).prop("checked",false);
			}
		});
	}
	this.Verificar_Chk_Exist=function(pIdCli){
		var valido=true;
		$(".claSelcVentPagVend").each(function(e){
			var ids=$(this)[0].checked;
			if(valido && ids){
				var val=$(this)[0].value;
				var aIdC=$("#idclientREPVENT_"+val).html();
				if(aIdC!=pIdCli){
					valido=false;
				}
			}	
		});
		return valido;
	}
	this.Build_Modal_VentaCredito=function(Datos,pMonto,pRuc,pRS,pIdCliente){var inst=new ClassReportVPV();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_VentaCredito_Venta);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		$("#txtTotalVenta_VPV").prop("value",parseFloat(pMonto).toFixed(2));
		$("#txtRuc_VPV").prop("value",pRuc);
		$("#txtRS_VPV").prop("value",pRS);
		
		inst.getList_cbo_VentCrd_VPV();
		$("#txtFechaPago_addVPV").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
		$("#txtFechaPago_addVPV").datepicker( "option", "dateFormat", "dd/mm/yy" );
		
		$("#txtMonto_addVPV").focusout(function(){inst.Calcular_Importe_VentaCredito();});
		$("#txtMonto_addVPV").keyup(function (e){if(e.which == 13){$("#txtInteres_addVPV").focus();}});
		$("#txtInteres_addVPV").focusout(function(){inst.Calcular_Importe_VentaCredito();});
		$("#txtInteres_addVPV").keyup(function (e){if(e.which == 13){$("#btnAddDetail_VPV").focus();}});
		
		$("#btnAddDetail_VPV").on('click',function(e){
			var NroC=$("#txtNroCuota_addVPV").val();
			var Monto=$("#txtMonto_addVPV").val();
			var Interes=$("#txtInteres_addVPV").val();
			var Total=$("#txtTotal_addVPV").val();
			var FechaPag=$("#txtFechaPago_addVPV").val();
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
		$("#btnSaveVentaCredito_VPV").on('click',function(e){
			var NroRuc=$("#txtRuc_VPV").val();
			var RS=$("#txtRS_VPV").val();
			var Total=pMonto;
			var TotalAdd=$("#txtTotalMonto_VPV").val();
			var IdVend=$("select#cboVendedor_VPV option:selected").val();
			var IdEmp=$("select#cboEmpresa_VPV option:selected").val();
			var Detail=[];
			$("#IdTableCredito_VPV tbody tr").each(function (index){
				var aNroC=$(this).find("td").eq(2).html();
				var aMonto=$(this).find("td").eq(3).html();
				var aInteres=$(this).find("td").eq(4).html();
				var aTotal=$(this).find("td").eq(5).html();
				var aFechaPago=$(this).find("td").eq(6).html();
				aFechaPago=aFechaPago.split('/')[2]+'-'+aFechaPago.split('/')[1]+'-'+aFechaPago.split('/')[0];
				Detail.push({"aNroC":aNroC,"aMonto":aMonto,"aInteres":aInteres,"aTotal":aTotal,"aFechaPago":aFechaPago});
			});
			if(NroRuc!="" && RS!="" &&  Total!="" &&  TotalAdd!=""&&  IdEmp!="-1" &&  IdVend!="-1" && parseFloat(TotalAdd).toFixed(2)>=parseFloat(Total).toFixed(2)){
				if(Detail.length>0){
					inst.Save_Datos_VentaCredito([pIdCliente,NroRuc,RS,IdEmp,IdVend,Total,Datos,Detail]);
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Agregar Detalle.");
				}
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar los Datos.");
			}
		});
	}
	this.getList_cbo_VentCrd_VPV=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_cbo_VentCrd_VPV"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassReportVPV();var Dato=e;
				if(Dato.length>0){
					$("#cboVendedor_VPV").empty();
					for(var i=0;i<Dato.length;i++){$("#cboVendedor_VPV").append('<option value="'+Dato[i]["IdUsuario"]+'">'+Dato[i]["Nombres"]+'</option>');}
					$("#cboVendedor_VPV").chosen({width: "100%"});
					$('#cboVendedor_VPV').val(Dato[0]["IdUsuario"]).trigger('chosen:updated');
				}else{
					$("#cboVendedor_VPV").empty();$("#cboVendedor_VPV").append('<option value="-1">Seleccione</option>');
					$("#cboVendedor_VPV").chosen({width: "100%"});$('#cboVendedor_VPV').val("-1").trigger('chosen:updated');
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Detail_VentaAdd=function(Datos){var inst=new ClassReportVPV();
		var iddd=Datos[0];
		$('#IdTableCredito_VPV tbody').append('<tr>'+
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
		inst.TotalMonto_Table_DetailVentaFi();
		$('#IdTableCredito_VPV tbody').unbind("click");
		$('#IdTableCredito_VPV tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='deltManteDetail'){
				var add=$(this).parent("tr:first");
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();
				vex.dialog.confirm({ message:'Desea Eliminar?',callback: function(ee){
					if(ee){
						add.remove();
						inst.TotalMonto_Table_DetailVentaFi();
					}
				}});
			}else if(id[0]==='editManteDetail'){
				var ids=id[1];
				var add=$(this).parent("tr:first");
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();
				vex.dialog.confirm({ message:'Desea Editar?',callback: function(ee){
					if(ee){
						$("#txtNroCuota_addVPV").prop("value",ids);
						$("#txtMonto_addVPV").prop("value",$("#montVPV_"+ids).html());
						$("#txtInteres_addVPV").prop("value",$("#interesVPV_"+ids).html());
						$("#txtTotal_addVPV").prop("value",$("#totlaVPV_"+ids).html());
						$("#txtFechaPago_addVPV").prop("value",$("#fecpagVPV_"+ids).html());
						add.remove();
						inst.TotalMonto_Table_DetailVentaFi();
					}
				}});
				
			}
		});
	}
	this.TotalMonto_Table_DetailVentaFi=function(){
		var TotaMon=0.00;
		$("#IdTableCredito_VPV tbody tr").each(function (index){
			var importe=$(this).find("td").eq(5).html();
			TotaMon=parseFloat(TotaMon)+parseFloat(importe);
		});
		$("#txtTotalMonto_VPV").prop("value",parseFloat(TotaMon).toFixed(2));
	}
	this.Calcular_Importe_VentaCredito=function(){
		var Monto=$("#txtMonto_addVPV").val();
		var Interes=$("#txtInteres_addVPV").val();
		if(Monto!="" && Interes!=""){
			var Totl=parseFloat(Monto)+parseFloat(Interes);
			$("#txtTotal_addVPV").prop("value",parseFloat(Totl).toFixed(2));
		}else{
			$("#txtTotal_addVPV").prop("value","");
		}
	}
	this.Clear_Detail_AddDetails=function(){
		$("#txtNroCuota_addVPV").prop("value","");
		$("#txtMonto_addVPV").prop("value","");
		$("#txtInteres_addVPV").prop("value","");
		$("#txtTotal_addVPV").prop("value","");
		$("#txtFechaPago_addVPV").prop("value","");
	}
	this.Verificar_Existe_NroCuota=function(pNroC){
		var vald=true;
		$("#IdTableCredito_VPV tbody tr").each(function (index){
			var aIdNroC=$(this).find("td").eq(2).html();
			if(aIdNroC===pNroC){
				vald=false;
			}
		});
		return vald;
	}
	this.Save_Datos_VentaCredito=function(params){var inst=new ClassReportVPV();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Save_Datos_VentaCredito",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e["Val"]){
					alertify.success("PROCESO CORRECTO.");
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					 $(".modal-open").removeClass('modal-open');
					 inst.verificar_Datos_ReportVPV();
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
	//PAGAR VENTA CREDITO SIMPLE
	this.Build_Modal_Pagar_VentaCreditoSimple=function(IdVenta,pIdEstado,pIdEmpresa,pIdAlm,pTotal,aRuc,aCliente,pIdCliente){var inst=new ClassReportVPV();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_VentaCredito_PagarSimple);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		$("#txtTotalVenta_CPVNETA").prop("value",parseFloat(pTotal).toFixed(2));
		$("#txtCliente_CPVNETA").prop("value",aCliente);
		
		var fechaHoy=current_date();
		$("#txtFechaPago_CPVNETA").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
		$("#txtFechaPago_CPVNETA").datepicker( "option", "dateFormat", "dd/mm/yy" );
		$("#txtFechaPago_CPVNETA").prop("value",fechaHoy);
		
		$("#txtMora_CPVNETA").focusout(function(){inst.Calcular_TotalPagar_VentaCreditoS();});
		$("#txtMora_CPVNETA").keyup(function (e){if(e.which == 13){$("#btnSaveCompraCredito_CPVNETA").focus();}});
		
		
		$("#btnSaveCompraCredito_CPVNETA").on('click',function(e){
			var Cliente=$("#txtCliente_CPVNETA").val();
			var Total=pTotal;
			var Mora=$("#txtMora_CPVNETA").val();
			var TotalPagar=$("#txtTotalPagar_CPVNETA").val();
			var FechaPag=$("#txtFechaPago_CPVNETA").val();
			
			if(Cliente!="" &&  Total!="" &&  TotalPagar!="" &&  Mora!="" && FechaPag!=""){
				FechaPag=FechaPag.split('/')[2]+'_'+FechaPag.split('/')[1]+'_'+FechaPag.split('/')[0];
				inst.Save_PagarSimple_VentaCreditoS([IdVenta,pIdEmpresa,pIdAlm,Total,Mora,TotalPagar,aRuc,FechaPag,pIdCliente]);
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar los Datos.");
			}
		});
	}
	this.Calcular_TotalPagar_VentaCreditoS=function(){
		var Monto=$("#txtTotalVenta_CPVNETA").val();
		var Mora=$("#txtMora_CPVNETA").val();
		if(Monto!="" && Mora!=""){
			var Totl=parseFloat(Monto)+parseFloat(Mora);
			$("#txtTotalPagar_CPVNETA").prop("value",parseFloat(Totl).toFixed(2));
		}else{
			$("#txtTotalPagar_CPVNETA").prop("value","");
		}
	}
	this.Save_PagarSimple_VentaCreditoS=function(params){var inst=new ClassReportVPV();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Save_PagarSimple_VentaCreditoS",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					 $(".modal-open").removeClass('modal-open');
					 inst.verificar_Datos_ReportVPV();
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
	//ANULAR CREDITO VENTA O PAGADO
	this.Build_Modal_Delete_VentaCredito=function(params){var inst=new ClassReportVPV();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Build_Modal_Delete_VentaCredito",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e["Val"]){
					var Ress=e["Result"][0]["aResult"];
					if(parseInt(Ress)===1){
						alertify.success("PROCESO CORRECTO.");
						inst.verificar_Datos_ReportVPV();
					}else{
						alertify.error("Error, Contiene Pagos del Cliente, Primero Eliminar Detalle Pago del Cliente.");
					}
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
}
