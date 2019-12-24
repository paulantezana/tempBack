$(window).on('load',function(){var inst=new ClassReportNP();
		$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmRepNP").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRepNP").html();
	
	$("#IdFechaIn_ReportNP").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_ReportNP();}});
	$("#IdFechaIn_ReportNP").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_ReportNP").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_ReportNP();}});
	$("#IdFechaFn_ReportNP").datepicker( "option", "dateFormat", "dd/mm/yy" );

	$("#cboPrint_RNP").on('click',function(e){$("#IdContentRNP").printArea();});
	$("#cboExportar_RNP").on('click',function(e){window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRNP').html()));});
});
function ClassReportNP(){
	this.verificar_datos_ReportNP=function(){var inst=new ClassReportNP();
		$("#IdTableReportec_ReportNP tbody").html("");
		var feIn=$("#IdFechaIn_ReportNP").val(),feFn=$("#IdFechaFn_ReportNP").val();
		var IdAlm=$("#IdAlmRepNP").html();
		if(feIn!="" && feFn!="" && IdAlm!="-1"){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RNP([feIn,feFn,IdAlm]);
		}
	}
	this.getList_Datos_RNP=function(params){var inst=new ClassReportNP();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_RNP",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				$("#IdTableReportec_ReportNP tbody").html("");
				if(e.length>0){inst.Build_Datos_RCompra(e);}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RCompra=function(Datos){var inst=new ClassReportNP();
		$("#IdTableReportec_ReportNP tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdVenta"]+'_'+Datos[i]["Estado"]+'_'+Datos[i]["IdEmpresa"];
			var Estt='';var icoDel='';var colAnul='';
			if(parseInt(Datos[i]["Estado"])===1){Estt='Pendiente';icoDel='<i class="fas fa-times-circle f-18"></i>';}
			else if(parseInt(Datos[i]["Estado"])===0){Estt='Anulado';colAnul='#EC5849';}
			else if(parseInt(Datos[i]["Estado"])===2){Estt='Facturado';colAnul='#36AB6B';}
			$('#IdTableReportec_ReportNP tbody').append('<tr>'+
				'<td id="delREPVENTNP_'+ids+'">'+
					icoDel+
				'</td>'+
				'<td id="verREPVENTNP_'+ids+'">'+
					'<i class="fas fa-file-invoice f-18"></i>'+
				'</td>'+
				'<td>'+Datos[i]["IdVenta"]+'</td>'+
				'<td>'+Datos[i]["Empresa"]+'</td>'+
				'<td>'+Datos[i]["Fec"]+'</td>'+
				'<td>'+Datos[i]["Comprobante"]+'</td>'+
				'<td>'+Datos[i]["Serie"]+'/'+Datos[i]["Numero"]+'</td>'+
				'<td>'+Datos[i]["Ruc"]+'</td>'+
				'<td>'+Datos[i]["RS"]+'</td>'+
				//'<td>'+Datos[i]["Direccion"]+'</td>'+
				'<td>'+Datos[i]["Total"]+'</td>'+
				'<td>'+Datos[i]["Userr"]+'</td>'+
				'<td>'+Datos[i]["Obs"]+'</td>'+
				'<td>'+Datos[i]["Telefono"]+'</td>'+
				'<td style="color:'+colAnul+'">'+Estt+'</td>'+
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
		
		var IdAlm=$("#IdAlmRepNP").html();
		$('#IdTableReportec_ReportNP tbody').unbind("click");
		$('#IdTableReportec_ReportNP tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='delREPVENTNP'){
				if(parseInt(id[2])===1){
					vex.dialog.prompt({ className: 'vex-theme-os', message: 'Motivo para anular:', callback: function(ee){
						if(ee!=false && ee!=''){
							inst.Anular_Venta_NP([id[1],IdAlm,ee,id[3]]);
						}
						} 
					});
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Proceso no autorizado.");
				}
			}
			else if(id[0]==='verREPVENTNP'){
				inst.getList_Datos_NotaPedido_Detalle([id[1],IdAlm,id[2],id[3]]);
			}
		});			
	}
	this.Anular_Venta_NP=function(params){var inst=new ClassReportNP();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Anular_Venta_NP",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					inst.verificar_datos_ReportNP();
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_Datos_NotaPedido_Detalle=function(params){var inst=new ClassReportNP();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_NotaPedido_Detalle",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				var Detalle=e;
				if(Detalle.length>0){
					$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_ReportNP_Detalle_Ver);
					$('#myModal').modal({keyboard: false,backdrop:false});
					$('.modal-dialog').draggable({handle: ".modal-header"});
					$("#exampleModalLabel").html("DETALLE NOTA PEDIDO NRO : "+params[0]);
					if(Detalle.length>0){
						for(var i=0;i<Detalle.length;i++){
							$('#IdTableDato_ReportNPVer tbody').append('<tr>'+
								'<td>'+Detalle[i]["Cantidad"]+'</td>'+
								'<td>'+Detalle[i]["Codigo"]+'</td>'+
								'<td>'+Detalle[i]["Descripcion"]+'</td>'+
								'<td>'+Detalle[i]["Unidad"]+'</td>'+
								'<td>'+Detalle[i]["Precio"]+'</td>'+
								'<td>'+Detalle[i]["Importe"]+'</td>'+
							'</tr>');
						}
					}
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
}
