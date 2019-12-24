$(window).on('load',function(){var inst=new ClassReportCompraS();
	$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmRepCompraS").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRepCompraS").html();

	$("#IdFechaIn_ReportCompraS").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_LVRAS();}});
	$("#IdFechaIn_ReportCompraS").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_ReportCompraS").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_LVRAS();}});
	$("#IdFechaFn_ReportCompraS").datepicker( "option", "dateFormat", "dd/mm/yy" );

	$("#cboPrint_RCompraS").on('click',function(e){$("#IdContentRCompraS").printArea();});
	$("#cboExportar_RCompraS").on('click',function(e){window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRCompraS').html()));});
});
function ClassReportCompraS(){
	this.verificar_datos_LVRAS=function(){var inst=new ClassReportCompraS();
		$("#IdTableReportec_ReportCompraS tbody").html("");
		var feIn=$("#IdFechaIn_ReportCompraS").val(),feFn=$("#IdFechaFn_ReportCompraS").val();
		var IdAlm=$("#IdAlmRepCompraS").html();
		if(feIn!="" && feFn!="" && IdAlm!="-1"){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RCompraS([feIn,feFn,IdAlm]);
		}
	}
	this.getList_Datos_RCompraS=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_RCompraS",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassReportCompraS();
				$("#IdTableReportec_ReportCompraS tbody").html("");
				inst.Build_Datos_RCompraS(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RCompraS=function(Datos){var inst=new ClassReportCompraS();
		var IdAlm=$("#IdAlmRepCompraS").html();
		$("#IdTableReportec_ReportCompraS tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdCompraS"]+'_'+Datos[i]["Estado"];
			var iconDel='';colorAnu='';
			if(parseInt(Datos[i]["Estado"])===1){iconDel='<i class="fas fa-times-circle f-18"></i>';}
			else{colorAnu='#EC5849';}
			$('#IdTableReportec_ReportCompraS tbody').append('<tr>'+
				'<td id="deletREPCOMP_'+ids+'">'+
					iconDel+
				'</td>'+
				'<td id="verREPCOMP_'+ids+'" class="instafilta-target">'+
					'<i class="fas fa-file-invoice f-18"></i>'+
				'</td>'+
				'<td>'+Datos[i]["IdCompraS"]+'</td>'+
				'<td>'+Datos[i]["Fec"]+'</td>'+
				'<td>'+Datos[i]["Responsable"]+'</td>'+
				'<td>'+Datos[i]["Total"]+'</td>'+
				'<td style="color:'+colorAnu+'">'+Datos[i]["Est"]+'</td>'+
				'<td>'+Datos[i]["Userr"]+'</td>'+
				'<td>'+Datos[i]["Obs"]+'</td>'+
				'<td>'+Datos[i]["FechaReg"]+'</td>'+
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
		var Alm=$("#AlmRepCompraS").html();
		$('#IdTableReportec_ReportCompraS tbody').unbind("click");
		$('#IdTableReportec_ReportCompraS tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='verREPCOMP'){
				inst.getList_Datos_CompraS_Detalle([id[1],IdAlm]);
			}
			else if(id[0]==='deletREPCOMP'){
				if(parseInt(id[2])===1){
					vex.dialog.prompt({ className: 'vex-theme-os', message: 'Motivo Para Anular Compra?:', callback: function(ee){
						if(ee!=false && ee!=''){
							inst.Anular_CompraS([id[1],IdAlm,ee,Alm]);
						}
						} 
					});
				}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Proceso no autorizado.");}
			}
		});	
	}
	this.getList_Datos_CompraS_Detalle=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_CompraS_Detalle",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassReportCompraS();
				var Detalle=e;
				if(Detalle.length>0){
					$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_ReportCompraS_Detalle_Ver);
					$('#myModal').modal({keyboard: false,backdrop:false});
					$('.modal-dialog').draggable({handle: ".modal-header"});
					$("#exampleModalLabel").html("DETALLE COMPRA SIMPLE NRO : "+params[0]);
					if(Detalle.length>0){
						for(var i=0;i<Detalle.length;i++){
							$('#IdTableDato_ReportCompraSVer tbody').append('<tr>'+
								'<td>'+Detalle[i]["Cantidad"]+'</td>'+
								'<td>'+Detalle[i]["Codigo"]+'</td>'+
								'<td>'+Detalle[i]["Producto"]+'</td>'+
								'<td>'+Detalle[i]["Unidad"]+'</td>'+
								'<td>'+Detalle[i]["PrecioCompra"]+'</td>'+
								'<td>'+Detalle[i]["Importe"]+'</td>'+
								'<td>'+Detalle[i]["PrecioPublico"]+'</td>'+
								'<td>'+Detalle[i]["PrecioMenor"]+'</td>'+
								'<td>'+Detalle[i]["PrecioMayor"]+'</td>'+
							'</tr>');
						}
					}
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Anular_CompraS=function(params){var inst=new ClassReportCompraS();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Anular_CompraS",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					inst.verificar_datos_LVRAS();
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
}