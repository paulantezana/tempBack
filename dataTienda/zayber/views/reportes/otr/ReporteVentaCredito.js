$(window).on('load',function(){var inst=new ClassReportRVENTCRD();
	$("#IdAlmacenPri").css("display","none");

	$("#IdFechaIn_RVENTCRD").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_RVENTCRD();}});
	$("#IdFechaIn_RVENTCRD").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_RVENTCRD").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_RVENTCRD();}});
	$("#IdFechaFn_RVENTCRD").datepicker( "option", "dateFormat", "dd/mm/yy" );

	$("#cboPrint_RVENTCRD").on('click',function(e){$("#IdContentRVENTCRD").printArea();});
	$("#cboExportar_RVENTCRD").on('click',function(e){window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRVENTCRD').html()));});
});
function ClassReportRVENTCRD(){
	this.verificar_datos_RVENTCRD=function(){var inst=new ClassReportRVENTCRD();
		$("#IdTableReportec_RVENTCRD tbody").html("");
		var feIn=$("#IdFechaIn_RVENTCRD").val(),feFn=$("#IdFechaFn_RVENTCRD").val();
		
		if(feIn!="" && feFn!=""){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RVENTCRD([feIn,feFn]);
		}
	}
	this.getList_Datos_RVENTCRD=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_RVENTCRD",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassReportRVENTCRD();
				$("#IdTableReportec_RVENTCRD tbody").html("");
				inst.Build_Datos_RVENTCRD(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RVENTCRD=function(Datos){var inst=new ClassReportRVENTCRD();
		var IdAlm=$("#IdAlmRepCompra").html();
		$("#IdTableReportec_RVENTCRD tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdVentaCredito"]+'_'+Datos[i]["NroCuota"]+'_'+Datos[i]["IdEmpresa"]+'_'+Datos[i]["Pagado"];
			var Pagado=parseInt(Datos[i]["Pagado"]);
			var Est='Pendiente';var btnDelete='';var btnPagar='';
			if(Pagado>0){
				Est='Pagado';btnDelete='<i class="fas fa-times-circle f-18"></i>';
			}else{
				btnPagar='<i class="fab fa-paypal f-18"></i>';
			}
			$('#IdTableReportec_RVENTCRD tbody').append('<tr>'+
				'<td>'+(i+1)+'</td>'+
				'<td id="btnpagarRVENTCRD_'+ids+'">'+
					btnPagar+
				'</td>'+
				'<td>'+Datos[i]["Empresa"]+'</td>'+
				'<td>'+Datos[i]["IdVentaCredito"]+'</td>'+
				'<td>'+Datos[i]["NroCuota"]+'</td>'+
				'<td>'+Datos[i]["Monto"]+'</td>'+
				'<td>'+Datos[i]["Interes"]+'</td>'+
				'<td>'+Datos[i]["Total"]+'</td>'+
				'<td>'+Datos[i]["FechaPa"]+'</td>'+
				'<td>'+Datos[i]["Venedd"]+'</td>'+
				'<td>'+Datos[i]["Ruc"]+'</td>'+
				'<td>'+Datos[i]["RS"]+'</td>'+
				'<td>'+Est+'</td>'+
				'<td id="btndeltRVENTCRD_'+ids+'">'+
					btnDelete+
				'</td>'+
				'<td>'+Datos[i]["UserPag"]+'</td>'+
			'</tr>');
		}
		$('#filtrar').keyup(function(){
            var rex = new RegExp($(this).val(), 'i');
            $('.buscar tr').hide();
            $('.buscar tr').filter(function (){
                return rex.test($(this).text());
            }).show();
        });
		$('#IdTableReportec_RVENTCRD tbody').unbind("click");
		$('#IdTableReportec_RVENTCRD tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');
			if(id[0]==='btnpagarRVENTCRD'){
				if(parseInt(id[4])===-1){
					inst.Build_Modal_CreditoPago_Admin(id[1],id[2],id[3]);
				}
			}
			else if(id[0]==='btndeltRVENTCRD'){
				if(parseInt(id[4])>0){
					vex.dialog.prompt({ className: 'vex-theme-os', message: 'Motivo para Anular?:', callback: function(ee){
								if(ee!=false && ee!=''){
									inst.Delete_Pago_VentaCredito([id[1],id[2],id[3],ee]);
								}
							} 
					});
				}
			}
		});
		
	}
	this.Build_Modal_CreditoPago_Admin=function(pIdCVenta,pNroCuota,pIdEmpresa){var inst=new ClassReportRVENTCRD();
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
	this.getList_Datos_PayCredito=function(params){var inst=new ClassReportRVENTCRD();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_PayCredito",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var Dato=e;
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
	this.Save_Pago_VentaCredito=function(params){var inst=new ClassReportRVENTCRD();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Save_Pago_VentaCredito",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					 $(".modal-open").removeClass('modal-open');
					 inst.verificar_datos_RVENTCRD();
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Delete_Pago_VentaCredito=function(params){var inst=new ClassReportRVENTCRD();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Delete_Pago_VentaCredito",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					 $(".modal-open").removeClass('modal-open');
					 inst.verificar_datos_RVENTCRD();
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
}