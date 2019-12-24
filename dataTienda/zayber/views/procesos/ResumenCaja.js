$(window).on('load',function(){  
    var inst=new ClassLRVenta();$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmRepVenta").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRepVenta").html();
	$("#cboEmpresa_RepVent").chosen({width: "100%"});
	
	$("#IdFechaIn_ReportVenta").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){VerificarDatosListar();}});
	$("#IdFechaIn_ReportVenta").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#cboPrint_RVenta").on('click',function(e){$("#IdContentRVenta").printArea();});
    $("#cboEmpresa_RepVent").on('change',function(e){VerificarDatosListar();});
    $("#cboUsuario").on('change',function(e){VerificarDatosListar();});
	$("#cboExportar_RVenta").on('click',function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRVenta').html()));
    });
    ListarUsuarios();
});
function ListarUsuarios(){
    $.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Usuarios"},
		async:true,dataType:"json",success:function(e){$.unblockUI();
			$("#cboUsuario").html("");
			e.forEach(element => {
                $('#cboUsuario').append(
                    '<option value='+element['IdUsuario']+'>'+element['Nombres']+' '+element['ApPaterno']+'</option>'
                );
            });
            $("#cboUsuario").chosen({width: "100%"});
		},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
	});
}
function VerificarDatosListar(){
    let feIn=$("#IdFechaIn_ReportVenta").val();
	let IdAlm=$("#IdAlmRepVenta").html();
	let IdUser=$("select#cboUsuario option:selected").val();
    let IdEmp=$("select#cboEmpresa_RepVent option:selected").val();
    
	if(feIn!="" && IdAlm!="-1" && IdEmp!="-1" && IdUser!="-1"){
        feIn=fecha_Barra_Guion(feIn);
		ConsultarLista(feIn,IdAlm,IdEmp,IdUser);
	}
}
function ConsultarLista(fecha,idAlmacen,IdEmpresa,idUser){
    $.blockUI();
	$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_DatosCaja",fecha:fecha,idAlmacen:idAlmacen,IdEmpresa:IdEmpresa,idUser:idUser},
		async:true,dataType:"json",success:function(e){$.unblockUI();console.log(e);
			let ventas=e['ventas'];
			let ingresos=e['ingresos'];
			let egresos=e['egresos'];
			$("#IdTableReportec_ReportVenta tbody").html("");
			ventas.forEach(element => {
               $("#IdTableReportec_ReportVenta tbody").append('<tr>'+
				'<td>'+element["nroVentas"]+'</td>'+
				'<td>0</td>'+
				'<td>'+element["total"]+'</td>'+
				'</tr>'); 
            });
            $("#IdTableIngresosGastos tbody").html("");
            ingresos.forEach(element => {
               $("#IdTableIngresosGastos tbody").append('<tr>'+
				'<td>Ingresos</td>'+
				'<td>'+element["soles"]+'</td>'+
				'</tr>'); 
            });
            egresos.forEach(element => {
               $("#IdTableIngresosGastos tbody").append('<tr>'+
				'<td>Egresos</td>'+
				'<td>'+element["soles"]+'</td>'+
				'</tr>'); 
            });
		},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
	});
}
function ClassLRVenta(){
	this.verificarDatosListar=function(){var inst=new ClassLRVenta();
		$("#IdTableReportec_ReportVenta tbody").html("");
		var feIn=$("#IdFechaIn_ReportVenta").val(),feFn=$("#IdFechaFn_ReportVenta").val();
		var IdAlm=$("#IdAlmRepVenta").html();
		//var IdEmp=$("select#cboEmpresa_RepVent option:selected").val();
		var IdUsuario=$("select#cboUsuario option:selected").val();
		if(feIn!="" && feFn!="" && IdAlm!="-1" && IdUsuario!="-1"){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RVenta([feIn,feFn,IdAlm,IdUsuario]);
		}
	}
	this.Sumar_fact_Convertido=function(TotaMon){
		var IdIGV=$("#IdChkIGVPVe").is(':checked') ? 1 : 0;
		if(parseInt(IdIGV)===1){
			var SubTO=parseFloat(TotaMon)/parseFloat(1.18);
			var IGV=parseFloat(SubTO)*parseFloat(0.18);
			$("#txtSubTotal_ProcVenta").prop("value",parseFloat(SubTO).toFixed(2));
			$("#txtIGV_ProcVenta").prop("value",parseFloat(IGV).toFixed(2));
			
		}else{
			$("#txtSubTotal_ProcVenta").prop("value",parseFloat(TotaMon).toFixed(2));
			$("#txtIGV_ProcVenta").prop("value",parseFloat("0").toFixed(2));
		}
		$("#txtTotal_ProcVenta").prop("value",parseFloat(TotaMon).toFixed(2));
		var son=CLetras(parseFloat(TotaMon).toFixed(2),true,1);
		$("#txtSon_ProcVenta").prop("value",son);
	}
}
