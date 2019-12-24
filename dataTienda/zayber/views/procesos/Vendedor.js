$(window).on('load',function(){var inst=new ClassVendedor();
	$("#IdAlmacenPri").css("display","none");
		
	inst.getList_cbo_PAGV();
	$("#IdFechaIn_PAGV").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_Datos_ReportPAGV();}});
	$("#IdFechaIn_PAGV").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_PAGV").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_Datos_ReportPAGV();}});
	$("#IdFechaFn_PAGV").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#cboEmpresa_PAGV").on('change',function(e){inst.verificar_Datos_ReportPAGV();});
	
	//$("#btnPrint_VPV").on('click',function(e){$("#IdContentRVPV").printArea();});
	//$("#btnExportar_VPV").on('click',function(e){window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRVPV').html()));});
	
});
function ClassVendedor(){
	this.getList_cbo_PAGV=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_cbo_PAGV"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassVendedor();var Dato=e;
				if(Dato.length>0){
					$("#cboEmpresa_PAGV").empty();$("#cboEmpresa_PAGV").append('<option value="-1">Todos</option>');
					for(var i=0;i<Dato.length;i++){$("#cboEmpresa_PAGV").append('<option value="'+Dato[i]["IdEmpresa"]+'">'+Dato[i]["Comercial"]+'</option>');}
					$("#cboEmpresa_PAGV").chosen({width: "100%"});
					$('#cboEmpresa_PAGV').val("-1").trigger('chosen:updated');
				}else{
					$("#cboEmpresa_PAGV").empty();$("#cboEmpresa_PAGV").append('<option value="-1">Todos</option>');
					$("#cboEmpresa_PAGV").chosen({width: "100%"});$('#cboEmpresa_PAGV').val("-1").trigger('chosen:updated');
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.verificar_Datos_ReportPAGV=function(){var inst=new ClassVendedor();
		$("#IdTableReportec_ReportPAGV tbody").html("");
		var feIn=$("#IdFechaIn_PAGV").val(),feFn=$("#IdFechaFn_PAGV").val();
		var IdEmp=$("select#cboEmpresa_PAGV option:selected").val();
		if(feIn!="" && feFn!=""){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_PAGV([feIn,feFn,IdEmp]);
		}
	}
	this.getList_Datos_PAGV=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_PAGV",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassVendedor();
				inst.Build_Datos_ReportPAGV(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_ReportPAGV=function(Datos){var inst=new ClassVendedor();
		$("#IdTableReportec_ReportPAGV tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdVentaCredito"]+'_'+Datos[i]["NroCuota"]+'_'+Datos[i]["IdEmpresa"]+'_'+Datos[i]["IdEst"];
			var iconm='';
			if(parseInt(Datos[i]["IdEst"])===-1){
				iconm='<i class="far fa-credit-card f-18"></i>';
			}
			$('#IdTableReportec_ReportPAGV tbody').append('<tr>'+
				'<td id="payPAGVENT_'+ids+'">'+
					iconm+
				'</td>'+
				'<td>'+Datos[i]["IdVentaCredito"]+'/'+Datos[i]["NroCuota"]+'</td>'+
				'<td>'+Datos[i]["Empresa"]+'</td>'+
				'<td>'+Datos[i]["Monto"]+'</td>'+
				'<td>'+Datos[i]["Interes"]+'</td>'+
				'<td>'+Datos[i]["Total"]+'</td>'+
				'<td>'+Datos[i]["FechaPa"]+'</td>'+
				'<td>'+Datos[i]["Ruc"]+'</td>'+
				'<td>'+Datos[i]["RS"]+'</td>'+
				'<td>'+Datos[i]["MontoPag"]+'</td>'+
				'<td>'+Datos[i]["MoraPag"]+'</td>'+
				'<td>'+Datos[i]["TotalPag"]+'</td>'+
				'<td>'+Datos[i]["FechaPag"]+'</td>'+
				'<td id="verPAGVENT_'+ids+'">'+
					'<i class="fas fa-file-alt f-18"></i>'+
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
		$('#IdTableReportec_ReportPAGV tbody').unbind("click");
		$('#IdTableReportec_ReportPAGV tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='payPAGVENT'){
				if(parseInt(id[4])===-1){
					inst.Build_Modal_CreditoPago(id[1],id[2],id[3]);
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Nro Cuota ya esta pagado.");
				}
			}else if(id[0]==='verPAGVENT'){
				inst.getList_Ids_PayCredito([id[1],id[2],id[3]]);
			}
		});
	}
	this.Build_Modal_CreditoPago=function(pIdCVenta,pNroCuota,pIdEmpresa){var inst=new ClassVendedor();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_VentaCredito_Pago);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});

		inst.getList_Datos_PayCredito([pIdCVenta,pNroCuota,pIdEmpresa]);
		$("#txtFechaPago_addVPV").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
		$("#txtFechaPago_addVPV").datepicker( "option", "dateFormat", "dd/mm/yy" );
		
		$("#txtMonto_VCrdPAY").focusout(function(){inst.Calcular_Importe_VentaCredito_Pay();});
		$("#txtMonto_VCrdPAY").keyup(function (e){if(e.which == 13){$("#txtMora_VCrdPAY").focus();}});
		$("#txtMora_VCrdPAY").focusout(function(){inst.Calcular_Importe_VentaCredito_Pay();});
		$("#txtMora_VCrdPAY").keyup(function (e){if(e.which == 13){$("#btnSave_VCrdPAY").focus();}});
		
		$("#btnSave_VCrdPAY").on('click',function(e){
			var Monto=$("#txtMonto_VCrdPAY").val();
			var Mora=$("#txtMora_VCrdPAY").val();
			var TotalPagar=$("#txtTotalPagar_VCrdPAY").val();
			
			if(Monto!="" &&  Mora!="" &&  TotalPagar!=""){
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();
				vex.dialog.confirm({ message:'Desea Pagar?',callback: function(ee){
					if(ee){
						inst.Save_Pago_VentaCredito([pIdCVenta,pNroCuota,pIdEmpresa,Monto,Mora,TotalPagar]);
					}
				}});
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar los Datos.");
			}
		});
	}
	this.getList_Datos_PayCredito=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_PayCredito",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassVendedor();var Dato=e;
				if(Dato.length>0){
					$('#txtNroCuota_VCrdPAY').prop("value",Dato[0]["NroCuota"]);
					$('#txtMonto_VCrdPAY').prop("value",Dato[0]["Total"]);
					$('#txtMora_VCrdPAY').prop("value",Dato[0]["Mora"]);
					inst.Calcular_Importe_VentaCredito_Pay();
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Calcular_Importe_VentaCredito_Pay=function(){
		var Monto=$("#txtMonto_VCrdPAY").val();
		var Mora=$("#txtMora_VCrdPAY").val();
		if(Monto!="" && Mora!=""){
			var Totl=parseFloat(Monto)+parseFloat(Mora);
			$("#txtTotalPagar_VCrdPAY").prop("value",parseFloat(Totl).toFixed(2));
		}else{
			$("#txtTotalPagar_VCrdPAY").prop("value","");
		}
	}
	this.Save_Pago_VentaCredito=function(params){var inst=new ClassVendedor();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Save_Pago_VentaCredito",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					 $(".modal-open").removeClass('modal-open');
					 inst.verificar_Datos_ReportPAGV();
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_Ids_PayCredito=function(params){var inst=new ClassVendedor();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Ids_PayCredito",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var Dato=e;
				if(Dato.length>0){
					$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_VentaCredito_Details);
					$('#myModal').modal({keyboard: false,backdrop:false});
					$('.modal-dialog').draggable({handle: ".modal-header"});
					for(var i=0;i<Dato.length;i++){
						var Est='Pendiente';
						if(parseInt(Dato[i]["Pag"])>0){
							Est='Pagado';
						}
						$('#IdTableCredito_VPVDetails tbody').append('<tr>'+
							'<td>'+Dato[i]["NroCuota"]+'</td>'+
							'<td>'+Dato[i]["Monto"]+'</td>'+
							'<td>'+Dato[i]["Interes"]+'</td>'+
							'<td>'+Dato[i]["Total"]+'</td>'+
							'<td>'+Dato[i]["FechaPag"]+'</td>'+
							'<td>'+Est+'</td>'+
							'<td>'+Dato[i]["Userr"]+'</td>'+
						'</tr>');
					}
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("No hay Datos.");
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
	
	
	this.Build_Detail_VentaAdd=function(Datos){var inst=new ClassVendedor();
		var iddd=Datos[0];
		$('#IdTableCredito_VPV tbody').append('<tr>'+
			'<td id="deltManteDetail_'+iddd+'">'+
				'<i class="ion-trash-a f-18"></i>'+
			'</td>'+
			'<td id="editManteDetail_'+iddd+'">'+
				'<i class="ion-compose f-18"></i>'+
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
}
