$(window).on('load',function(){var inst=new ClassPagoProveedor();
	$("#IdAlmacenPri").css("display","none");

	$("#IdFechaIn_PAGPROV").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_Datos_PAGPROV();}});
	$("#IdFechaIn_PAGPROV").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_PAGPROV").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_Datos_PAGPROV();}});
	$("#IdFechaFn_PAGPROV").datepicker( "option", "dateFormat", "dd/mm/yy" );
	
	//$("#btnPrint_VPV").on('click',function(e){$("#IdContentRVPV").printArea();});
	//$("#btnExportar_VPV").on('click',function(e){window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRVPV').html()));});
	
});
function ClassPagoProveedor(){
	this.verificar_Datos_PAGPROV=function(){var inst=new ClassPagoProveedor();
		$("#IdTableReportec_PAGPROV tbody").html("");
		var feIn=$("#IdFechaIn_PAGPROV").val(),feFn=$("#IdFechaFn_PAGPROV").val();
		if(feIn!="" && feFn!=""){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_PAGV([feIn,feFn]);
		}
	}
	this.getList_Datos_PAGV=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Datos_PAGV",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassPagoProveedor();
				inst.Build_Datos_ReportPAGV(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_ReportPAGV=function(Datos){var inst=new ClassPagoProveedor();
		$("#IdTableReportec_PAGPROV tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdCompraCredito"]+'_'+Datos[i]["NroCuota"]+'_'+Datos[i]["IdAlmacen"]+'_'+Datos[i]["IdEst"];
			var iconm='';
			if(parseInt(Datos[i]["IdEst"])===-1){
				iconm='<i class="far fa-credit-card f-18"></i>';
			}
			$('#IdTableReportec_PAGPROV tbody').append('<tr>'+
				'<td id="payPAGCOMP_'+ids+'">'+
					iconm+
				'</td>'+
				'<td>'+Datos[i]["IdCompraCredito"]+'/'+Datos[i]["NroCuota"]+'</td>'+
				'<td>'+Datos[i]["Proveedor"]+'</td>'+
				'<td>'+Datos[i]["Monto"]+'</td>'+
				'<td>'+Datos[i]["Interes"]+'</td>'+
				'<td>'+Datos[i]["Total"]+'</td>'+
				'<td>'+Datos[i]["FechaLim"]+'</td>'+
				'<td>'+Datos[i]["MontoPag"]+'</td>'+
				'<td>'+Datos[i]["MoraPag"]+'</td>'+
				'<td>'+Datos[i]["TotalPag"]+'</td>'+
				'<td>'+Datos[i]["FechaPag"]+'</td>'+
				'<td>'+Datos[i]["UserPag"]+'</td>'+
				'<td id="verPAGCOMP_'+ids+'">'+
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
		$('#IdTableReportec_PAGPROV tbody').unbind("click");
		$('#IdTableReportec_PAGPROV tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='payPAGCOMP'){
				if(parseInt(id[4])===-1){
					inst.Build_Modal_CreditoPagoProv(id[1],id[2],id[3]);
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Nro Cuota ya esta pagado.");
				}
			}else if(id[0]==='verPAGCOMP'){
				inst.getList_Ids_PayCreditoProv([id[1],id[2],id[3]]);
			}
		});
	}
	this.Build_Modal_CreditoPagoProv=function(pIdCompraCrd,pNroCuota,pIdAlm){var inst=new ClassPagoProveedor();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_VentaCredito_PagoProve);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});

		inst.getList_Datos_PayCreditoProv([pIdCompraCrd,pNroCuota,pIdAlm]);
		$("#txtFechaPago_addVPV").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
		$("#txtFechaPago_addVPV").datepicker( "option", "dateFormat", "dd/mm/yy" );
		
		$("#txtMonto_VCrdPAY").focusout(function(){inst.Calcular_Importe_VentaCredito_Pay();});
		$("#txtMonto_VCrdPAY").keyup(function (e){if(e.which == 13){$("#txtMora_VCrdPAY").focus();}});
		$("#txtMora_VCrdPAY").focusout(function(){inst.Calcular_Importe_VentaCredito_Pay();});
		$("#txtMora_VCrdPAY").keyup(function (e){if(e.which == 13){$("#btnSave_PAYCRDPROV").focus();}});
		
		$("#btnSave_PAYCRDPROV").on('click',function(e){
			var Monto=$("#txtMonto_VCrdPAY").val();
			var Mora=$("#txtMora_VCrdPAY").val();
			var TotalPagar=$("#txtTotalPagar_VCrdPAY").val();
			
			if(Monto!="" &&  Mora!="" &&  TotalPagar!=""){
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();
				vex.dialog.confirm({ message:'Desea Pagar?',callback: function(ee){
					if(ee){
						inst.Save_Pago_CompraCrdProve([pIdCompraCrd,pNroCuota,pIdAlm,Monto,Mora,TotalPagar]);
					}
				}});
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar los Datos.");
			}
		});
	}
	this.getList_Datos_PayCreditoProv=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Datos_PayCreditoProv",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassPagoProveedor();var Dato=e;
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
	this.Save_Pago_CompraCrdProve=function(params){var inst=new ClassPagoProveedor();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"Save_Pago_CompraCrdProve",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					 $(".modal-open").removeClass('modal-open');
					 inst.verificar_Datos_PAGPROV();
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_Ids_PayCreditoProv=function(params){var inst=new ClassPagoProveedor();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Ids_PayCreditoProv",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var Dato=e;
				if(Dato.length>0){
					$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_CompraCreditoProv_Details);
					$('#myModal').modal({keyboard: false,backdrop:false});
					$('.modal-dialog').draggable({handle: ".modal-header"});
					for(var i=0;i<Dato.length;i++){
						var Est='Pendiente';
						if(parseInt(Dato[i]["Pag"])>0){
							Est='Pagado';
						}
						$('#IdTableCredito_COMPCRDPROV tbody').append('<tr>'+
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
	
	
}
