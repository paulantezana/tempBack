$(window).on('load',function(){var inst=new ClassRCaja();
	$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmRCaja").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRCaja").html();
	
	$("#IdFechaIn_ReportCaja").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_ReportCaja();}});
	$("#IdFechaIn_ReportCaja").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_ReportCaja").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_ReportCaja();}});
	$("#IdFechaFn_ReportCaja").datepicker( "option", "dateFormat", "dd/mm/yy" );

	$("#cboPrint_RCaja").on('click',function(e){$("#IdContent_RCaja").printArea();});
	$("#cboExportar_RCaja").on('click',function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContent_RCaja').html()));
	});
	
});
function ClassRCaja(){
	this.verificar_datos_ReportCaja=function(){var inst=new ClassRCaja();
		$("#IdTableReportec_ReportCaja tbody").html("");
		var feIn=$("#IdFechaIn_ReportCaja").val(),feFn=$("#IdFechaFn_ReportCaja").val();
		var IdAlm=$("#IdAlmRCaja").html();
		
		if(feIn!="" && feFn!="" && IdAlm!="-1"){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RCaja([feIn,feFn,IdAlm]);
		}
	}
	this.getList_Datos_RCaja=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_RCaja",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRCaja();
				$("#IdTableReportec_ReportCaja tbody").html("");
				if(e.length>0){
					inst.Build_Datos_RVenta(e);
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RVenta=function(Datos){var inst=new ClassRCaja();
		$("#IdTableReportec_ReportCaja tbody").html("");	
		for(var i=0;i<Datos.length;i++){
				var ids=Datos[i]["IdCaja"];
				$('#IdTableReportec_ReportCaja tbody').append('<tr>'+
					'<td id="codProdAlmDM_'+ids+'">'+(i+1)+'</td>'+
					'<td id="proProdAlmDM_'+ids+'">'+Datos[i]["Tip"]+'</td>'+
					'<td id="proProdAlmDM_'+ids+'">'+Datos[i]["TipoServ"]+'</td>'+
					'<td id="proProdAlmDM_'+ids+'">'+Datos[i]["Soles"]+'</td>'+
					'<td id="proProdAlmDM_'+ids+'">'+Datos[i]["Dolar"]+'</td>'+
					'<td id="proProdAlmDM_'+ids+'">'+Datos[i]["FechaReg"]+'</td>'+
					'<td id="proProdAlmDM_'+ids+'">'+Datos[i]["Userr"]+'</td>'+
					'<td id="proProdAlmDM_'+ids+'">'+Datos[i]["SaldoSoles"]+'</td>'+
					'<td id="proProdAlmDM_'+ids+'">'+Datos[i]["SaldoDolares"]+'</td>'+
					'<td id="proProdAlmDM_'+ids+'">'+Datos[i]["Descripcion"]+'</td>'+
					'<td id="proProdAlmDM_'+ids+'">'+Datos[i]["Obs"]+'</td>'+
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
		
	}
}