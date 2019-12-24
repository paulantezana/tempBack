$(window).on('load',function(){var inst=new ClassRVentaPago();
	$("#IdAlmacenPri").css("display","none");
	var Alm=$("#IdAlmRepVentaPag").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRepVentaPag").html();
	inst.getList_cbo_RepVentaPago();
	
	$("#IdFechaIn_ReportVentaPago").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_ReportVentaPago();}});
	$("#IdFechaIn_ReportVentaPago").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_ReportVentaPago").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_ReportVentaPago();}});
	$("#IdFechaFn_ReportVentaPago").datepicker( "option", "dateFormat", "dd/mm/yy" );
	
	$("#cboCliente_ProcVentaPago").on('change',function(e){
		inst.verificar_datos_ReportVentaPago();
	});
	$("#cboPrint_RVentaPago").on('click',function(e){
		$("#IdContentRVentaPago").printArea();
	});
	$("#cboExportar_RVentaPago").on('click',function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRVentaPago').html()));
	});
	$("#cboPagar_RVentaPago").on('click',function(e){
		var feIn=$("#IdFechaIn_ReportVentaPago").val(),feFn=$("#IdFechaFn_ReportVentaPago").val();
		var IdAlm=$("#IdAlmRepVentaPag").html();
		var IdCli=$("select#cboCliente_ProcVentaPago option:selected").val();
		if(feIn!="" && feFn!="" && IdAlm!="-1" && IdCli!="-1"){
			var IdVents=[];
			$(".claIGVPVentaPago").each(function(e){
				var chk=$(this)[0].checked;
				if(chk){
					var valu=$(this)[0].value,idss=$(this)[0].id;
					var mont=$("#montRFPC_"+idss).html();
					var comp=$("#compRFPC_"+idss).html();
					var serie=$("#serietRFPC_"+idss).html();
					var nros=$("#nroRFPC_"+idss).html();
					IdVents.push({"aIdVenta":valu,"aMonto":mont,"aComprobante":comp,"aSerie":serie,"aNumero":nros});
				}
			});
			if(IdVents.length>0){
				inst.Build_modal_PagoCliente(IdVents);
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione facturas para pagar.");
			}
		}
	});
});
function ClassRVentaPago(){
	this.getList_cbo_RepVentaPago=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_cbo_RepVentaPago"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRVentaPago();
				var Cliente=e;
				if(Cliente.length>0){
					$("#cboCliente_ProcVentaPago").empty();$("#cboCliente_ProcVentaPago").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Cliente.length;i++){$("#cboCliente_ProcVentaPago").append('<option value="'+Cliente[i]["IdCliente"]+'">'+Cliente[i]["Comercial"]+'</option>');}
					$("#cboCliente_ProcVentaPago").chosen({width: "100%"});
					$('#cboCliente_ProcVentaPago').val("-1").trigger('chosen:updated');
				}else{
					$("#cboCliente_ProcVentaPago").empty();$("#cboCliente_ProcVentaPago").append('<option value="-1">Seleccione</option>');
					$("#cboCliente_ProcVentaPago").chosen({width: "100%"});
					$('#cboCliente_ProcVentaPago').val("-1").trigger('chosen:updated');
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.verificar_datos_ReportVentaPago=function(){var inst=new ClassRVentaPago();
		$("#IdTableReportec_ReportVentaPago tbody").html("");
		var feIn=$("#IdFechaIn_ReportVentaPago").val(),feFn=$("#IdFechaFn_ReportVentaPago").val();
		var IdAlm=$("#IdAlmRepVentaPag").html();
		var IdCli=$("select#cboCliente_ProcVentaPago option:selected").val();
		if(feIn!="" && feFn!="" && IdAlm!="-1" && IdCli!="-1"){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RVentaPago([feIn,feFn,IdAlm,IdCli]);
		}
	}
	this.getList_Datos_RVentaPago=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_RVentaPago",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRVentaPago();
				$("#IdTableReportec_ReportVentaPago tbody").html("");
				if(e.length>0){
					inst.Build_Datos_RVentaPago(e);
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RVentaPago=function(Datos){var inst=new ClassRVentaPago();
		$("#IdTableReportec_ReportVentaPago tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdVenta"]+'_'+Datos[i]["IdComprobante"]+'_'+Datos[i]["Serie"]+'_'+Datos[i]["Numero"]+'_'+Datos[i]["Estado"]+'_'+Datos[i]["Impresion"];
			var chkk='';
			if(parseInt(Datos[i]["Estado"])===1){
				chkk='<input type="checkbox" id="'+ids+'" value="'+Datos[i]["IdVenta"]+'" class="chk2020 claIGVPVentaPago">';
			}
			$('#IdTableReportec_ReportVentaPago tbody').append('<tr>'+
				'<td id="printREPVENTPag_'+ids+'">'+
					'<i class="ion-printer f-16"></i>'+
				'</td>'+
				'<td id="guiaREPVENT_'+ids+'">'+
					chkk+
				'</td>'+
				'<td>'+Datos[i]["Fec"]+'</td>'+
				'<td id="compRFPC_'+ids+'">'+Datos[i]["Comprobante"]+'</td>'+
				'<td id="serietRFPC_'+ids+'">'+Datos[i]["Serie"]+'</td>'+
				'<td id="nroRFPC_'+ids+'">'+Datos[i]["Numero"]+'</td>'+
				'<td>'+Datos[i]["Ruc"]+'</td>'+
				'<td>'+Datos[i]["RazonSocial"]+'</td>'+
				'<td>'+Datos[i]["Direccion"]+'</td>'+
				'<td id="montRFPC_'+ids+'">'+Datos[i]["Total"]+'</td>'+
				'<td>'+Datos[i]["SubTotal"]+'</td>'+
				'<td>'+Datos[i]["IGV"]+'</td>'+
				'<td>'+Datos[i]["Userr"]+'</td>'+
				'<td title="'+Datos[i]["PagoObs"]+'">'+Datos[i]["Obs"]+'</td>'+
				'<td>'+Datos[i]["TipoC"]+'</td>'+
				'<td>'+Datos[i]["Est"]+'</td>'+
			'</tr>');
		}
		$('#filtrar').keyup(function(){
            var rex = new RegExp($(this).val(), 'i');
            $('.buscar tr').hide();
            $('.buscar tr').filter(function (){
                return rex.test($(this).text());
            }).show();
        });
		
		var altM=parseFloat($(window).height())-parseFloat(280);
		$(".table-responsive").css({"overflow-y":"scroll","height":altM+"px"});
		var IdAlm=$("#IdAlmRepVentaPag").html();
		
		$('#IdTableReportec_ReportVentaPago tbody').unbind("click");
		$('#IdTableReportec_ReportVentaPago tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='printREPVENTPag'){
				var inst2=new ClassImpresion();
				inst2.getList_Datos_ReportVentta_Print([id[1],IdAlm]);
			}
		});			
	}
	this.Build_modal_PagoCliente=function(Datos){
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_FechaDetr_Fact);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		var Client=$("select#cboCliente_ProcVentaPago option:selected").text();
		$("#txtClient_PagoVentaFa").prop("value",Client);
		if(Datos.length>0){
			var tottl=0;
			for(var i=0;i<Datos.length;i++){
				var ids=Datos[i]["aIdVenta"];
				tottl=parseFloat(tottl)+parseFloat(Datos[i]["aMonto"]);
				$('#IdTableDato_GRFAPago tbody').append('<tr>'+
					'<td>'+Datos[i]["aComprobante"]+'</td>'+
					'<td>'+Datos[i]["aSerie"]+'</td>'+
					'<td>'+Datos[i]["aNumero"]+'</td>'+
					'<td>'+Datos[i]["aMonto"]+'</td>'+
				'</tr>');
			}
			$("#txtTotal_PagoVentaFa").prop("value",parseFloat(tottl).toFixed(2));
		}
	}
	
	
	
	
	this.Save_Factura_GuiaRemis=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Save_Factura_GuiaRemis",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){var inst=new ClassRVentaPago();
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
