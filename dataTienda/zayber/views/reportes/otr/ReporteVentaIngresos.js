$(window).on('load',function(){var inst=new ClassRVentaIE();
	$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmRepVentaIE").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRepVentaIE").html();
	
	$("#IdFechaIn_ReportVentaIE").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_ReportVentaIE();}});
	$("#IdFechaIn_ReportVentaIE").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_ReportVentaIE").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_ReportVentaIE();}});
	$("#IdFechaFn_ReportVentaIE").datepicker( "option", "dateFormat", "dd/mm/yy" );

	$("#cboPrint_RVentaIE").on('click',function(e){
		$("#IdContentRVentaIE").printArea();
	});
	$("#cboExportar_RVentaIE").on('click',function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRVentaIE').html()));
	});
});
function ClassRVentaIE(){
	this.verificar_datos_ReportVentaIE=function(){var inst=new ClassRVentaIE();
		$("#IdTableReportec_ReportVentaIE tbody").html("");
		var feIn=$("#IdFechaIn_ReportVentaIE").val(),feFn=$("#IdFechaFn_ReportVentaIE").val();
		var IdAlm=$("#IdAlmRepVentaIE").html();
		
		if(feIn!="" && feFn!="" && IdAlm!="-1"){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RVentaIE([feIn,feFn,IdAlm]);
		}
	}
	this.getList_Datos_RVentaIE=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_RVentaIE",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRVentaIE();
				$("#IdTableReportec_ReportVentaIE tbody").html("");
				if(e.length>0){
					inst.Build_Datos_RVentaIE(e);
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RVentaIE=function(Datos){var inst=new ClassRVentaIE();
		$("#IdTableReportec_ReportVentaIE tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdVenta"]+'_'+Datos[i]["Estado"]+'_'+Datos[i]["Impresion"];
			var SubTo=0,Exom=0,Igvv=0;
			if(parseInt(Datos[i]["Exonerado"])===0){//Exonerado
				Exom=Datos[i]["Total"];
				Igvv=0;
				SubTo=0;
			}else{
				SubTo=Datos[i]["SubTotal"];Igvv=Datos[i]["IGV"];
			}
			$('#IdTableReportec_ReportVentaIE tbody').append('<tr>'+
				'<td>'+(i+1)+'</td>'+
				'<td>'+Datos[i]["Fec"]+'</td>'+
				'<td>'+Datos[i]["FecCancel"]+'</td>'+
				'<td>'+Datos[i]["Est"]+'</td>'+
				'<td>'+Datos[i]["Comprobante"]+'</td>'+
				'<td>'+Datos[i]["Serie"]+'</td>'+
				'<td>'+Datos[i]["Numero"]+'</td>'+
				'<td>'+Datos[i]["TipoDoc"]+'</td>'+
				'<td>'+Datos[i]["Ruc"]+'</td>'+
				'<td>'+Datos[i]["RazonSocial"]+'</td>'+
				'<td>'+parseFloat(SubTo).toFixed(2)+'</td>'+
				'<td>'+
					parseFloat(Exom).toFixed(2)+
				'</td>'+
				'<td>'+parseFloat(Igvv).toFixed(2)+'</td>'+
				'<td>'+Datos[i]["Total"]+'</td>'+
				'<td>'+
					//Fecha Pago
				'</td>'+
				'<td>'+Datos[i]["TipoBien"]+'</td>'+
				'<td id="fecDetrFVIE_'+ids+'" style="color:red">'+
					Datos[i]["FechaDe"]+
				'</td>'+
				'<td>'+
					Datos[i]["Mont"]+
				'</td>'+
				'<td>'+
					Datos[i]["TipoPag"]+
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
		
		var altM=parseFloat($(window).height())-parseFloat(235);
		$(".table-responsive").css({"overflow-y":"scroll","height":altM+"px"});
		var IdAlm=$("#IdAlmRepVentaIE").html();
		
		$('#IdTableReportec_ReportVentaIE tbody').unbind("click");
		$('#IdTableReportec_ReportVentaIE tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='fecDetrFVIE'){
				if(parseInt(id[2])===1/* && parseInt(id[5])===1 && parseInt(id[6])===0*/){
					inst.Build_modal_FechaDetraccion_Fact(id[1],IdAlm);
				}
			}
		});			
	}
	this.Build_modal_FechaDetraccion_Fact=function(pIdVenta,pIdAlm){var inst=new ClassRVentaIE();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_FechaDetr_Fact);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		inst.getList_Datos_RVenta_FecDett([pIdVenta,pIdAlm]);
		$("#txtFecha_FecDetVIE").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
		$("#txtFecha_FecDetVIE").datepicker( "option", "dateFormat", "dd/mm/yy" );
		
		$("#btnSave_fecDetFA").on('click',function(){
			var Fec=$("#txtFecha_FecDetVIE").val();
			var Monto=$("#txtMonto_FecDetVIE").val();
			var TipoPag=$("#txtTipoPago_FecDetVIE").val();
			if(Fec!="" && Monto!="" && TipoPag!=""){
				Fec=fecha_Barra_Guion(Fec);
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();
				vex.dialog.confirm({ message:'Desea Guardar?',callback: function(ee){
					if(ee){
						inst.Save_FechaDetraccion_Venta([pIdVenta,pIdAlm,Fec,Monto,TipoPag]);
					}
				}});
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar datos.");
			}
		});
	}
	this.Save_FechaDetraccion_Venta=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Save_FechaDetraccion_Venta",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){var inst=new ClassRVentaIE();
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					 $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					inst.verificar_datos_ReportVentaIE();
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_Datos_RVenta_FecDett=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_RVenta_FecDett",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRVentaIE();
				var Dato=e["Dato"],Bien=e["Bien"];
				if(Dato.length>0){
					$("#txtFecha_FecDetVIE").prop("value",Dato[0]["FechaDe"]);
					$("#txtMonto_FecDetVIE").prop("value",Dato[0]["Monto"]);
					$("#txtTipoPago_FecDetVIE").prop("value",Dato[0]["TipoPago"]);
				}
				if(Bien.length>0){
					
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	
	
	
	this.Save_Factura_GuiaRemis=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Save_Factura_GuiaRemis",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){var inst=new ClassRVentaIE();
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					alertify.success("PROCESO CORRECTO.");
					inst.verificar_datos_ReportVenta();
					var inst2=new ClassImpresion();
					var IdAlm=$("#IdAlmRepVenta").html();
					inst2.getList_Datos_ReportVentta_Print([e["IdVenta"],IdAlm]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
}
