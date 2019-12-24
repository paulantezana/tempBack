$(window).on('load',function(){var inst=new ClassLRPago();$("#IdAlmacenPri").css("display","none");
	inst.getList_cbo_ReportCronoPago();
	
	$("#IdFechaIn_ReportPago").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.Verificar_ReportCronoPago();}});
	$("#IdFechaIn_ReportPago").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_ReportPago").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.Verificar_ReportCronoPago();}});
	$("#IdFechaFn_ReportPago").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#cboCliente_RepVent").on('change',function(e){inst.Verificar_ReportCronoPago();});
	
	$("#cboPrint_RPago").on('click',function(e){$("#IdContentRPago").printArea();});
	$("#cboExportar_RPago").on('click',function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRPago').html()));
	});
});
function ClassLRPago(){
	this.getList_cbo_ReportCronoPago=function(){var inst=new ClassLRPago();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objPago",action:"getList_cbo_ReportCronoPago"},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				var Dato=e;
				if(Dato.length>0){
					$("#cboCliente_RepVent").empty();$("#cboCliente_RepVent").append('<option value="-1">Todos</option>');
					for(var i=0;i<Dato.length;i++){$("#cboCliente_RepVent").append('<option value="'+Dato[i]["Id"]+'">'+Dato[i]["Nombre"]+'</option>');}
					$("#cboCliente_RepVent").chosen({width: "100%"});
					$('#cboCliente_RepVent').val("-1").trigger('chosen:updated');
				}else{
					$("#cboCliente_RepVent").empty();$("#cboCliente_RepVent").append('<option value="-1">Todos</option>');
					$("#cboCliente_RepVent").chosen({width: "100%"});
					$('#cboCliente_RepVent').val("-1").trigger('chosen:updated');
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Verificar_ReportCronoPago=function(){var inst=new ClassLRPago();
		$("#IdTableReportec_ReportPago tbody").html("");
		var feIn=$("#IdFechaIn_ReportPago").val(),feFn=$("#IdFechaFn_ReportPago").val();
		var IdCliente=$("select#cboCliente_RepVent option:selected").val();
		if(feIn!="" && feFn!=""){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RPago([feIn,feFn,IdCliente]);
		}
	}
	this.getList_Datos_RPago=function(params){var inst=new ClassLRPago();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objPago",action:"getList_Datos_RPago",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				$("#IdTableReportec_ReportPago tbody").html("");
				if(e.length>0){
					inst.Build_Datos_RPago(e);
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RPago=function(Datos){var inst=new ClassLRPago();
		$("#IdTableReportec_ReportPago tbody").html("");
		total=0;
		for(var i=0;i<Datos.length;i++){
			Me=(Datos[i]["IdDetalle"]).split('-');
			mess=Nombre_Mes(parseInt(Me[1])-1)+' '+Me[0];
			total=parseFloat(total)+parseFloat(Datos[i]["Monto"]);
			$('#IdTableReportec_ReportPago tbody').append('<tr>'+
				'<td>'+(i+1)+'</td>'+
				'<td>'+mess+'</td>'+
				'<td>'+Datos[i]["Cliente"]+'</td>'+
				'<td>'+Datos[i]["Fecha"]+'</td>'+
				'<td>'+Datos[i]["Monto"]+'</td>'+
				'<td>'+Datos[i]["Pago"]+'</td>'+
				'<td>'+Datos[i]["Obs"]+'</td>'+
				'<td>'+Datos[i]["Userr"]+'</td>'+
			'</tr>');
		}
		$('#IdTableReportec_ReportPago tbody').append('<tr>'+
				'<td colspan="4">Total</td>'+
				'<td>'+parseFloat(total).toFixed(2)+'</td>'+
				'<td colspan="4"></td>'+
			'</tr>');
		
		$('#filtrar').keyup(function(){
            var rex = new RegExp($(this).val(), 'i');
            $('.buscar tr').hide();
            $('.buscar tr').filter(function (){
                return rex.test($(this).text());
            }).show();
        });
		

	}
}
