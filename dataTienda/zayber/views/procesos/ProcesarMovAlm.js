$(window).on('load',function(){var inst=new ClassReportMovAlm();
	$("#IdAlmacenPri").css("display","none");

	$("#IdFechaIn_ReportCompra").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_LVRA();}});
	$("#IdFechaIn_ReportCompra").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_ReportCompra").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_LVRA();}});
	$("#IdFechaFn_ReportCompra").datepicker( "option", "dateFormat", "dd/mm/yy" );

	$("#cboPrint_RCompra").on('click',function(e){$("#IdContentRCompra").printArea();});
	$("#cboExportar_RCompra").on('click',function(e){window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRCompra').html()));});
});
function ClassReportMovAlm(){
	this.verificar_datos_LVRA=function(){var inst=new ClassReportMovAlm();
		$("#IdTableReportec_ReportCompra tbody").html("");
		var feIn=$("#IdFechaIn_ReportCompra").val(),feFn=$("#IdFechaFn_ReportCompra").val();
		if(feIn!="" && feFn!=""){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RMovAlm([feIn,feFn]);
		}
	}
	this.getList_Datos_RMovAlm=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Datos_RMovAlm",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassReportMovAlm();
				$("#IdTableReportec_ReportCompra tbody").html("");
				if(e.length>0){inst.Build_Datos_RMovAlm(e);}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RMovAlm=function(Datos){var inst=new ClassReportMovAlm();
		var IdAlm=$("#IdAlmRepCompra").html();
		$("#IdTableReportec_ReportCompra tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdRegistro"]+'_'+Datos[i]["Estado"];
			var Est='';
			if(parseInt(Datos[i]["Estado"])===1){Est='Pendiente';}else if(parseInt(Datos[i]["Estado"])===2){Est='Procesado';}else if(parseInt(Datos[i]["Estado"])===0){Est='Anulado';}
			
			$('#IdTableReportec_ReportCompra tbody').append('<tr>'+
				'<td id="aprobarREPCOMP_'+ids+'">'+
					'Aprobar'+
				'</td>'+
				'<td id="deltREPCOMP_'+ids+'" class="instafilta-target">'+
					'<i class="fas fa-trash-alt red f-18"></i>'+
				'</td>'+
				'<td id="verREPCOMP_'+ids+'" class="instafilta-target">'+
					'<i class="fas fa-file-invoice f-18 "></i>'+
				'</td>'+
				'<td>'+Datos[i]["IdRegistro"]+'</td>'+
				'<td>'+Datos[i]["Fecha"]+'</td>'+
				'<td>'+Datos[i]["Total"]+'</td>'+
				'<td>'+Datos[i]["Origen"]+'</td>'+
				'<td>'+Datos[i]["Destino"]+'</td>'+
				'<td>'+Datos[i]["Responsable"]+'</td>'+
				'<td>'+Datos[i]["Userr"]+'</td>'+
				'<td>'+Datos[i]["FechaReg"]+'</td>'+
				'<td>'+Est+'</td>'+
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
		//$("#IdContentRCompra").css({"overflow-y":"scroll","height":altM+"px"});
		var Alm=$("#AlmRepCompra").html();
		$('#IdTableReportec_ReportCompra tbody').unbind("click");
		$('#IdTableReportec_ReportCompra tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='verREPCOMP'){
				inst.getList_Datos_AprobMovAlm_Detalle([id[1]]);
			}
			else if(id[0]==='aprobarREPCOMP'){
				if(parseInt(id[2])===1){
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();
					vex.dialog.confirm({ message:'Desea Aprobar Movimiento?',callback: function(ee){
						if(ee){
							inst.Procesar_MovALm([id[1]]);
						}
					}});
				}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Proceso no autorizado.");}
			}
			else if(id[0]==='deltREPCOMP'){
				if(parseInt(id[2])===1){
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();
					vex.dialog.confirm({ message:'Desea Anular Movimiento?',callback: function(ee){
						if(ee){
							inst.Anular_MovALm([id[1]]);
						}
					}});
				}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Proceso no autorizado.");}
			}
		});	
	}
	this.getList_Datos_AprobMovAlm_Detalle=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Datos_AprobMovAlm_Detalle",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassReportMovAlm();
				var Detalle=e;
				if(Detalle.length>0){
					$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_ProcMovAlm_Detalle_Ver);
					$('#myModal').modal({keyboard: false,backdrop:false});
					$('.modal-dialog').draggable({handle: ".modal-header"});
					$("#exampleModalLabel").html("DETALLE MOVIMIENTO NRO : "+params[0]);
					if(Detalle.length>0){
						for(var i=0;i<Detalle.length;i++){
							$('#IdTableDato_ReportMovAlmVer tbody').append('<tr>'+
								'<td>'+Detalle[i]["Cantidad"]+'</td>'+
								'<td>'+Detalle[i]["Codigo"]+'</td>'+
								'<td>'+Detalle[i]["Producto"]+'</td>'+
								'<td>'+Detalle[i]["Unidad"]+'</td>'+
								'<td>'+Detalle[i]["PUnitario"]+'</td>'+
								'<td>'+Detalle[i]["Importe"]+'</td>'+
							'</tr>');
						}
					}
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Procesar_MovALm=function(params){var inst=new ClassReportMovAlm();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"Procesar_MovALm",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					inst.verificar_datos_LVRA();
					alertify.success("PROCESO CORRECTO.");
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Anular_MovALm=function(params){var inst=new ClassReportMovAlm();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"Anular_MovALm",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					inst.verificar_datos_LVRA();
					alertify.success("PROCESO CORRECTO.");
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
}