$(window).on('load',function(){var inst=new ClassCronoPago();
	$("#IdAlmacenPri").css("display","none");
	inst.getList_cbo_CronoPago();
	
	$("#btnNewCliente_ProcPago").on('click',function(e){
		var Id=$("select#cboCliente_ProcPago option:selected").val();
		if(Id!="-1"){
			inst.Build_Modal_CronogramaPago(Id);
		}else{
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione un cliente.");
		}
	});	

	$("#cboCliente_ProcPago").on('change',function(e){inst.Verificar_Datos_CronoPay();});
});
function ClassCronoPago(){
	this.Verificar_Datos_CronoPay=function(){var inst=new ClassCronoPago();
		$("#IdTable_ClientePago tbody").html("");
		var Id=$("select#cboCliente_ProcPago option:selected").val();
		if(Id!="-1"){
			inst.getList_Datos_CronoPago([Id]);
		}
	}
	this.getList_cbo_CronoPago=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objPago",action:"getList_cbo_CronoPago"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassCronoPago();
				var Dato=e;
				if(Dato.length>0){
					$("#cboCliente_ProcPago").empty();$("#cboCliente_ProcPago").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Dato.length;i++){$("#cboCliente_ProcPago").append('<option value="'+Dato[i]["Id"]+'">'+Dato[i]["Nombre"]+'</option>');}
					$("#cboCliente_ProcPago").chosen({width: "100%"});
					$('#cboCliente_ProcPago').val("-1").trigger('chosen:updated');
				}else{
					$("#cboCliente_ProcPago").empty();$("#cboCliente_ProcPago").append('<option value="-1">Seleccione</option>');
					$("#cboCliente_ProcPago").chosen({width: "100%"});
					$('#cboCliente_ProcPago').val("-1").trigger('chosen:updated');
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_Datos_CronoPago=function(params){var inst=new ClassCronoPago();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objPago",action:"getList_Datos_CronoPago",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var Dato=e;
				$("#IdTable_ClientePago tbody").html("");
				if(Dato.length>0){
					for(var i=0;i<Dato.length;i++){
						var Id=Dato[i]["Id"];
						Me=(Dato[i]["IdDetalle"]).split('-');
						mess=Nombre_Mes(parseInt(Me[1])-1)+' '+Me[0];
						ico='';idss='';
						if(parseInt(Dato[i]["Pagado"])===0){
							ico='<i class="fab fa-paypal f-18"></i>';
							idss='btnPay_'+Id;
						}
						icoPrint='';idssPrint='';
						if(parseInt(Dato[i]["Pagado"])===1){
							icoPrint='<i class="fas fa-print f-18"></i>';
							idssPrint='btnPrint_'+Id;
						}
						$('#IdTable_ClientePago tbody').append('<tr>'+
							'<td>'+(i+1)+'</td>'+
							'<td id="btnMess_'+Id+'">'+mess+'</td>'+
							'<td>'+Dato[i]["Fecha"]+'</td>'+
							'<td id="btnMont_'+Id+'">'+Dato[i]["Monto"]+'</td>'+
							'<td>'+Dato[i]["Plan"]+'</td>'+
							'<td>'+Dato[i]["Pag"]+'</td>'+
							'<td id="'+idss+'">'+
								ico+
							'</td>'+
							'<td id="'+idssPrint+'">'+
								icoPrint+
							'</td>'+
						'</tr>');
					}
					$('#IdTable_ClientePago tbody').unbind("click");
					$('#IdTable_ClientePago tbody').on( 'click','td',function (e) {
						var id=$(this)[0].id.split('_');//.toggleClass('selected');
						if(id[0]==='btnPay' && parseInt(id[2])===0){
							inst.Build_Modal_Pagar(id[1],id[2]);
						}
						else if(id[0]==='btnMont' && parseInt(id[2])===0){
							inst.Build_Modal_Monto(id[1],id[2]);
						}
						else if(id[0]==='btnPrint' && parseInt(id[2])===1){
							inst.RePrint_Ticket_Pago([id[1]]);
						}
					});
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Modal_CronogramaPago=function(Id){var inst=new ClassCronoPago();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_CronogramaPago);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		cli=$("select#cboCliente_ProcPago option:selected").text();
		$("#txtCliente_CronoPay").prop("value",cli);
		Hoy=current_date();console.log(Hoy);
		$("#txtFechaVenc_CronoPay").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
		$("#txtFechaVenc_CronoPay").datepicker( "option", "dateFormat", "dd" );
		//$("#txtFechaVenc_CronoPay").datepicker( "option","minDate",Hoy);
		$("#txtFechaAnio_CronoPay").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
		$("#txtFechaAnio_CronoPay").datepicker( "option", "dateFormat", "mm/yy" );
		//$("#txtFechaAnio_CronoPay").datepicker( "option","minDate",Hoy);
		$("#txtFecha_CronoPay").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
		$("#txtFecha_CronoPay").datepicker( "option", "dateFormat", "dd/mm/yy" );
		
		if(Id!="-1"){inst.getList_combo_CronoPay([Id]);}
		$("#txtTipoPlan_CronoPay").on('change',function(e){
			IdTip=$("select#txtTipoPlan_CronoPay option:selected").val();
			if(IdTip!=""){inst.getList_Tarifa_IdPlan([IdTip]);}			
		});
		
		$("#btnSave_CronoPay").on('click',function(e){
			IdTip=$("select#txtTipoPlan_CronoPay option:selected").val();
			Monto=$("#txtMonto_CronoPay").val();
			Vecn=$("#txtFechaVenc_CronoPay").val();
			Anio=$("#txtFechaAnio_CronoPay").val();
			Fecha=$("#txtFecha_CronoPay").val();
			Obs=$("#txtObs_CronoPay").val();
			IdEst=$("#chkHabilitado_CronoPay").is(':checked') ? 1 : 0;
			if(IdTip!="-1" && Monto!="" && Vecn!="" && Anio!="" && Fecha!=""){
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();
				vex.dialog.confirm({ message:'Desea Guardar?',callback: function(ee){
					if(ee){
						Anio=Anio.split('/')[1]+'-'+Anio.split('/')[0];
						MesAct=Fecha.split('/')[2]+'-'+Fecha.split('/')[1]+'-'+Vecn;
						inst.Save_Datos_CronoPay([Id,IdTip,Monto,Vecn,Anio,Obs,IdEst,MesAct]);
					}
				}});
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");
			}
		});
	}
	this.getList_Tarifa_IdPlan=function(params){var inst=new ClassCronoPago();
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objPago",action:"getList_Tarifa_IdPlan",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e;
				if(Dato.length>0){
					$("#txtMonto_CronoPay").prop("value",Dato[0]["Monto"]);
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.getList_combo_CronoPay=function(params){var inst=new ClassCronoPago();
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objPago",action:"getList_combo_CronoPay",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Tipo=e["Tipo"],Dato=e["Cliente"];
				if(Tipo.length>0){
					$("#txtTipoPlan_CronoPay").empty();$("#txtTipoPlan_CronoPay").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Tipo.length;i++){$("#txtTipoPlan_CronoPay").append('<option value="'+Tipo[i]["Id"]+'">'+Tipo[i]["Nombre"]+'</option>');}
					$("#txtTipoPlan_CronoPay").chosen({width: "100%"});
					$('#txtTipoPlan_CronoPay').val("-1").trigger('chosen:updated');
				}else{
					$("#txtTipoPlan_CronoPay").empty();$("#txtTipoPlan_CronoPay").append('<option value="-1">Seleccione</option>');
					$("#txtTipoPlan_CronoPay").chosen({width: "100%"});
					$('#txtTipoPlan_CronoPay').val("-1").trigger('chosen:updated');
				}
				if(Dato.length>0){console.log(Dato);
					$("#txtMonto_CronoPay").prop("value",Dato[0]["Monto"]);
					$("#txtFechaVenc_CronoPay").prop("value",Dato[0]["FechaVec"]);
					$('#txtTipoPlan_CronoPay').val(Dato[0]["IdTipoPlan"]).trigger('chosen:updated');
					$("#txtObs_CronoPay").prop("value",Dato[0]["Descripcion"]);
					anio=Dato[0]["MesVec"].split('-');
					$("#txtFechaAnio_CronoPay").prop("value",anio[1]+'/'+anio[0]);
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.Save_Datos_CronoPay=function(params){var inst=new ClassCronoPago();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objPago",action:"Save_Datos_CronoPay",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					$('#myModal').modal('hide');$('#modal_Manten').html("");
					  $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					inst.Verificar_Datos_CronoPay();
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Modal_Monto=function(IdDetalle,pEst){var inst=new ClassCronoPago();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_MontoPago_Edit);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		var Id=$("select#cboCliente_ProcPago option:selected").val();
		Clie=$("select#cboCliente_ProcPago option:selected").text();
		mont=$("#btnMont_"+IdDetalle+'_'+pEst).html();
		Mess=$("#btnMess_"+IdDetalle+'_'+pEst).html();
		$("#txtCliente_EditCronoPay").prop("value",Clie);
		$("#txtMonto_EditCronoPay").prop("value",mont);
		$("#txtMes_EditCronoPay").prop("value",Mess);

		$("#btnSave_EditCronoPay").on('click',function(e){
			Monto=$("#txtMonto_EditCronoPay").val();
			Obs=$("#txtObs_EditCronoPay").val();
			
			if(Id!="-1" && Monto!=""){
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();
				vex.dialog.confirm({ message:'Desea Guardar?',callback: function(ee){
					if(ee){
						inst.Save_Datos_EditMonto_CronoPay([Id,IdDetalle,Monto,Obs]);
					}
				}});
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");
			}
		});
	}
	this.Save_Datos_EditMonto_CronoPay=function(params){var inst=new ClassCronoPago();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objPago",action:"Save_Datos_EditMonto_CronoPay",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					$('#myModal').modal('hide');$('#modal_Manten').html("");
					  $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					inst.Verificar_Datos_CronoPay();
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Modal_Pagar=function(IdDetalle,pEst){var inst=new ClassCronoPago();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_MontoPago_Pagar);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		var Id=$("select#cboCliente_ProcPago option:selected").val();
		Clie=$("select#cboCliente_ProcPago option:selected").text();
		mont=$("#btnMont_"+IdDetalle+'_'+pEst).html();
		Mess=$("#btnMess_"+IdDetalle+'_'+pEst).html();
		$("#txtCliente_PayCronoPay").prop("value",Clie);
		$("#txtMonto_PayCronoPay").prop("value",mont);
		$("#txtMes_PayCronoPay").prop("value",Mess);
		$("#txtForma_PayCronoPay").chosen({width: "100%"});
		
		$("#btnSave_PayCronoPay").on('click',function(e){
			Monto=$("#txtMonto_PayCronoPay").val();
			Obs=$("#txtObs_PayCronoPay").val();
			IdForma=$("select#txtForma_PayCronoPay option:selected").val();
			Forma=$("select#txtForma_PayCronoPay option:selected").text();
			if(Id!="-1" && Monto!="" && IdForma!="-1"){
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();
				vex.dialog.confirm({ message:'Desea Guardar?',callback: function(ee){
					if(ee){
						inst.Save_Pagar_CronoPay([Id,IdDetalle,Monto,IdForma,Obs],[Monto,Obs,Forma,Mess,Clie]);
					}
				}});
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");
			}
		});
	}
	this.Save_Pagar_CronoPay=function(params,Dat){var inst=new ClassCronoPago();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objPago",action:"Save_Pagar_CronoPay",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e["Val"]){
					$('#myModal').modal('hide');$('#modal_Manten').html("");
					  $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					inst.Verificar_Datos_CronoPay();
					Fecha=current_date();
					inst.Create_Print_TICKETS_Pago(Dat,e["Ticket"],e["Cliente"],Fecha);
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.RePrint_Ticket_Pago=function(params){var inst=new ClassCronoPago();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objPago",action:"RePrint_Ticket_Pago",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e.length>0){console.log(e);
					var client=[];
					client.push({"NroDocumento":e[0]["NroDocumento"],"Nombre":e[0]["NombreRS"]});
					mess=(e[0]["IdDetalle"]).split('-');
					messs=Nombre_Mes(parseInt(mess[1])-1)+" "+mess[0];
					var datt=[e[0]["Monto"],e[0]["Obs"],'',messs];
					inst.Create_Print_TICKETS_Pago(datt,e[0]["NroTicket"],client,e[0]["FechaPago"]);
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Create_Print_TICKETS_Pago=function(Datos,NroTicket,Cliente,Fecha){var inst=new ClassCronoPago();
		//[Monto,Obs,Forma,Mess,Clie]
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Print_Pago);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		//Fecha=current_date();
		//User=$("#IdUserr").html();
		//console.log(Datos);
		var doc = new jsPDF();
		
		doc.setFontSize(16);doc.setFont("times");
		var alt=10;
		doc.text(15, alt, "TICKET Nro "+Completar_Cero(8,NroTicket));
		
		alt=alt+10;doc.setFontSize(13);doc.text(10, alt, "TELEREDES DEL PERU S.A.C.");
		alt=alt+5;doc.setFontSize(10);doc.text(10, alt, "JIRON TACNA 208 3ER PISO SICUANI");
		
		alt=alt+10;
		
		doc.setFontSize(12);doc.text(10, alt, "Cliente : "+Cliente[0]["Nombre"]);
		alt=alt+5;doc.setFontSize(12);doc.text(10, alt, "DNI ");doc.text(40, alt,": "+Cliente[0]["NroDocumento"]);
		alt=alt+5;doc.setFontSize(12);doc.text(10, alt, "Mes Facturado ");doc.text(40, alt,": "+Datos[3]);
		alt=alt+5;doc.setFontSize(12);doc.text(10, alt, "Monto S/ ");doc.text(40, alt,": "+Datos[0]);
		alt=alt+5;doc.setFontSize(12);doc.text(10, alt, "Fecha Pago ");doc.text(40, alt,": "+Fecha);
		
		//alt=alt+8;doc.setFontSize(12);doc.text(10, alt, "User : "+User);
		alt=alt+8;doc.setFontSize(10);doc.text(10, alt, "Obs : "+Datos[1]);
		alt=alt+10;doc.setFontSize(10);doc.text(10, alt, "Documento interno sin valor tributario");

		var string=doc.output('datauristring');
		$('#IdPrintBVFPay').attr('src', string);
	}
}




