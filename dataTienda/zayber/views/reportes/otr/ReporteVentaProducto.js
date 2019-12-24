$(window).on('load',function(){var inst=new ClassRepVentaD();
		$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmRepVentaD").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRepVentaD").html();
	
	$("#IdFechaIn_ReportVentaD").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_ReportVentaD();}});
	$("#IdFechaIn_ReportVentaD").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_ReportVentaD").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_ReportVentaD();}});
	$("#IdFechaFn_ReportVentaD").datepicker( "option", "dateFormat", "dd/mm/yy" );

	$("#cboPrint_RVentaD").on('click',function(e){
		$("#IdContentRVentaD").printArea();
	});
	$("#cboExportar_RVentaD").on('click',function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRVentaD').html()));
	});
});
function ClassRepVentaD(){
	this.verificar_datos_ReportVentaD=function(){var inst=new ClassRepVentaD();
		$("#IdTableReportec_ReportVentaD tbody").html("");
		var feIn=$("#IdFechaIn_ReportVentaD").val(),feFn=$("#IdFechaFn_ReportVentaD").val();
		var IdAlm=$("#IdAlmRepVentaD").html();
		console.log(IdAlm);
		if(feIn!="" && feFn!="" && IdAlm!="-1"){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RVentaD([feIn,feFn,IdAlm]);
		}
	}
	this.getList_Datos_RVentaD=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_RVentaD",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRepVentaD();
				$("#IdTableReportec_ReportVentaD tbody").html("");
				if(e.length>0){
					inst.Build_Datos_RVentaD(e);
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RVentaD=function(Datos){
		$("#IdTableReportec_ReportVentaD tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdVenta"]+'_'+Datos[i]["IdComprobante"]+'_'+Datos[i]["Serie"]+'_'+Datos[i]["Numero"];
			$('#IdTableReportec_ReportVentaD tbody').append('<tr>'+
				'<td>'+(i+1)+'</td>'+
				'<td>'+Datos[i]["Fec"]+'</td>'+
				'<td>'+Datos[i]["Comprobante"]+'</td>'+
				'<td>'+Datos[i]["Serie"]+'</td>'+
				'<td>'+Datos[i]["Numero"]+'</td>'+
				'<td>'+Datos[i]["RazonSocial"]+'</td>'+
				
				'<td>'+Datos[i]["Cantidad"]+'</td>'+
				'<td>'+Datos[i]["Producto"]+'</td>'+
				'<td>'+Datos[i]["PUnitario"]+'</td>'+
				'<td>'+Datos[i]["Dscto"]+'</td>'+
				'<td>'+Datos[i]["Importe"]+'</td>'+
			'</tr>');
		}
		$('#filtrar').keyup(function(){
            var rex = new RegExp($(this).val(), 'i');
            $('.buscar tr').hide();
            $('.buscar tr').filter(function (){
                return rex.test($(this).text());
            }).show();
        });
		
		var altM=parseFloat($(window).height())-parseFloat(235);;
		$("#IdContentRVentaD").css({"overflow-y":"scroll","height":altM+"px"});
		var IdAlm=$("#IdAlmRepVentaD").html();
		$('#IdTableReportec_ReportVentaD tbody').unbind("click");
		$('#IdTableReportec_ReportVentaD tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='printREPVENT'){
				//var inst2=new ClassImpresion();
				//inst2.getList_Datos_ReportVentta_Print([id[1],id[2],id[3],id[4],IdAlm]);
			}
			else if(id[0]==='guiaREPVENT'){
				//var inst2=new ClassImpresion();
				//inst2.getList_Datos_Guia_Print([id[1],id[2],id[3],id[4],IdAlm]);
			}
		});
					
	}
}
