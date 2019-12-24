$(window).on('load',function(){var inst=new ClassReportCompra();
	$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmRepCompra").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRepCompra").html();

	$("#IdFechaIn_ReportCompra").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_LVRA();}});
	$("#IdFechaIn_ReportCompra").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_ReportCompra").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_LVRA();}});
	$("#IdFechaFn_ReportCompra").datepicker( "option", "dateFormat", "dd/mm/yy" );

	$("#cboPrint_RCompra").on('click',function(e){$("#IdContentRCompra").printArea();});
	$("#cboExportar_RCompra").on('click',function(e){window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRCompra').html()));});
});
function ClassReportCompra(){
	this.verificar_datos_LVRA=function(){var inst=new ClassReportCompra();
		$("#IdTableReportec_ReportCompra tbody").html("");
		var feIn=$("#IdFechaIn_ReportCompra").val(),feFn=$("#IdFechaFn_ReportCompra").val();
		var IdAlm=$("#IdAlmRepCompra").html();
		if(feIn!="" && feFn!="" && IdAlm!="-1"){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RCompra([feIn,feFn,IdAlm]);
		}
	}
	this.getList_Datos_RCompra=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_RCompra",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassReportCompra();
				$("#IdTableReportec_ReportCompra tbody").html("");
				if(e.length>0){inst.Build_Datos_RCompra(e);}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RCompra=function(Datos){var inst=new ClassReportCompra();
		var IdAlm=$("#IdAlmRepCompra").html();
		$("#IdTableReportec_ReportCompra tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdCompra"]+'_'+Datos[i]["Estado"];
			var iconDel='';colorAnu='';
			if(parseInt(Datos[i]["Estado"])===1){iconDel='<i class="fas fa-times-circle f-18"></i>';}
			else{colorAnu='#EC5849';}
			$('#IdTableReportec_ReportCompra tbody').append('<tr>'+
				'<td id="deletREPCOMP_'+ids+'">'+
					iconDel+
				'</td>'+
				'<td id="verREPCOMP_'+ids+'" class="instafilta-target">'+
					'<i class="fas fa-file-invoice f-18"></i>'+
				'</td>'+
				'<td>'+Datos[i]["IdCompra"]+'</td>'+
				'<td>'+Datos[i]["Fec"]+'</td>'+
				'<td>'+Datos[i]["Comprobante"]+'</td>'+
				'<td>'+Datos[i]["Serie"]+'/'+Datos[i]["Numero"]+'</td>'+
				'<td>'+Datos[i]["Proveedor"]+'</td>'+
				'<td>'+Datos[i]["Moneda"]+'</td>'+
				'<td>'+Datos[i]["Total"]+'</td>'+
				'<td>'+Datos[i]["SubTotal"]+'</td>'+
				'<td>'+Datos[i]["IGV"]+'</td>'+
				'<td>'+Datos[i]["TipoPago"]+'</td>'+
				'<td style="color:'+colorAnu+'">'+Datos[i]["Est"]+'</td>'+
				'<td>'+Datos[i]["Userr"]+'</td>'+
				'<td>'+Datos[i]["Obs"]+'</td>'+
				'<td>'+Datos[i]["FechaPago"]+'</td>'+
				//'<td>'+Datos[i]["FechaReg"]+'</td>'+
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
				inst.getList_Datos_Compra_Detalle([id[1],IdAlm]);
			}
			else if(id[0]==='deletREPCOMP'){
				if(parseInt(id[2])===1){
					vex.dialog.prompt({ className: 'vex-theme-os', message: 'Motivo Para Anular Compra?:', callback: function(ee){
						if(ee!=false && ee!=''){
							inst.Anular_Compra([id[1],IdAlm,ee,Alm]);
						}
						} 
					});
				}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Proceso no autorizado.");}
			}
		});	
	}
	this.getList_Datos_Compra_Detalle=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_Compra_Detalle",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassReportCompra();
				var Detalle=e;
				if(Detalle.length>0){
					$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_ReportCompra_Detalle_Ver);
					$('#myModal').modal({keyboard: false,backdrop:false});
					$('.modal-dialog').draggable({handle: ".modal-header"});
					$("#exampleModalLabel").html("DETALLE COMPRA NRO : "+params[0]);
					if(Detalle.length>0){
						for(var i=0;i<Detalle.length;i++){
							$('#IdTableDato_ReportCompraVer tbody').append('<tr>'+
								'<td>'+Detalle[i]["Cantidad"]+'</td>'+
								'<td>'+Detalle[i]["Codigo"]+'</td>'+
								'<td>'+Detalle[i]["Producto"]+'</td>'+
								'<td>'+Detalle[i]["Unidad"]+'</td>'+
								'<td>'+Detalle[i]["PUnitario"]+'</td>'+
								'<td>'+Detalle[i]["Importe"]+'</td>'+
								/*'<td>'+Detalle[i]["PrecioPublico"]+'</td>'+
								'<td>'+Detalle[i]["PrecioMenor"]+'</td>'+
								'<td>'+Detalle[i]["PrecioMayor"]+'</td>'+*/
							'</tr>');
						}
					}
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Anular_Compra=function(params){var inst=new ClassReportCompra();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Anular_Compra",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					inst.verificar_datos_LVRA();
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
}