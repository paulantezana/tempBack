$(window).on('load',function(){var inst=new ClassReportRCOMPCRD();
	$("#IdAlmacenPri").css("display","none");

	$("#IdFechaIn_RCOMPCRD").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_RCOMPCRD();}});
	$("#IdFechaIn_RCOMPCRD").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_RCOMPCRD").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_RCOMPCRD();}});
	$("#IdFechaFn_RCOMPCRD").datepicker( "option", "dateFormat", "dd/mm/yy" );

	$("#cboPrint_RCOMPCRD").on('click',function(e){$("#IdContentRCOMPCRD").printArea();});
	$("#cboExportar_RCOMPCRD").on('click',function(e){window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRCOMPCRD').html()));});
});
function ClassReportRCOMPCRD(){
	this.verificar_datos_RCOMPCRD=function(){var inst=new ClassReportRCOMPCRD();
		$("#IdTableReportec_RCOMPCRD tbody").html("");
		var feIn=$("#IdFechaIn_RCOMPCRD").val(),feFn=$("#IdFechaFn_RCOMPCRD").val();
		
		if(feIn!="" && feFn!=""){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RCOMPCRD([feIn,feFn]);
		}
	}
	this.getList_Datos_RCOMPCRD=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_RCOMPCRD",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassReportRCOMPCRD();
				$("#IdTableReportec_RCOMPCRD tbody").html("");
				inst.Build_Datos_RCOMPCRD(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RCOMPCRD=function(Datos){var inst=new ClassReportRCOMPCRD();
		
		$("#IdTableReportec_RCOMPCRD tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var Est='Pendiente';
			if(parseInt(Datos[i]["Pagado"])>0){Est='Pagado';}
			$('#IdTableReportec_RCOMPCRD tbody').append('<tr>'+
				'<td>'+(i+1)+'</td>'+
				'<td>'+Datos[i]["Almacen"]+'</td>'+
				'<td>'+Datos[i]["IdCompraCredito"]+'</td>'+
				'<td>'+Datos[i]["NroCuota"]+'</td>'+
				'<td>'+Datos[i]["Monto"]+'</td>'+
				'<td>'+Datos[i]["Interes"]+'</td>'+
				'<td>'+Datos[i]["Total"]+'</td>'+
				'<td>'+Datos[i]["FechaPa"]+'</td>'+
				'<td>'+Datos[i]["Proveedor"]+'</td>'+
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
		
	}
	
}