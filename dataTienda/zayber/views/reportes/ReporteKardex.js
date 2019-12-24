$(window).on('load',function(){var inst=new ClassRKardex();
	$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmRKardex").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRKardex").html();
	if(IdAlm!="-1"){inst.getList_combo_Kardex([IdAlm]);}
	$("#IdFechaIn_ReportKardex").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_Kardex();}});
	$("#IdFechaIn_ReportKardex").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_ReportKardex").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_Kardex();}});
	$("#IdFechaFn_ReportKardex").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#cboProducto_RKardex").on('change',function(e){inst.verificar_datos_Kardex();});
	
	$("#cboPrint_RKardex").on('click',function(e){$("#IdContentRKardex").printArea();});
	$("#cboExportar_RKardex").on('click',function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRKardex').html()));
	});
});
function ClassRKardex(){
	this.getList_combo_Kardex=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_combo_Kardex",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRKardex();
				var Dato=e;
				if(Dato.length>0){
					$("#cboProducto_RKardex").empty();$("#cboProducto_RKardex").append('<option value="-1">Todos</option>');
					for(var i=0;i<Dato.length;i++){$("#cboProducto_RKardex").append('<option value="'+Dato[i]["IdProducto"]+'">'+Dato[i]["Producto"]+'</option>');}
					$("#cboProducto_RKardex").chosen({width: "100%"});
					$('#cboProducto_RKardex').val("-1").trigger('chosen:updated');
				}else{
					$("#cboProducto_RKardex").empty();$("#cboProducto_RKardex").append('<option value="-1">Todos</option>');
					$("#cboProducto_RKardex").chosen({width: "100%"});
					$('#cboProducto_RKardex').val("-1").trigger('chosen:updated');
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.verificar_datos_Kardex=function(){var inst=new ClassRKardex();
		$("#IdTableReportec_ReportKardex tbody").html("");
		var IdAlm=$("#IdAlmRKardex").html();
		var feIn=$("#IdFechaIn_ReportKardex").val(),feFn=$("#IdFechaFn_ReportKardex").val();
		var IdProd=$("select#cboProducto_RKardex option:selected").val();
		if(feIn!="" && feFn!=""){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_Kardex([feIn,feFn,IdAlm,IdProd]);
		}
	}
	this.getList_Datos_Kardex=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_Kardex",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRKardex();
				$("#IdTableReportec_ReportKardex tbody").html("");
				if(e.length>0){
					inst.Build_Datos_RCompra(e);
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RCompra=function(Datos){
		$("#IdTableReportec_ReportKardex tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			IE=parseInt(Datos[i]["IngresoEgreso"]);clrStock='';
			Ingreso='';Egreso='';
			if(IE===1){Ingreso=Datos[i]["Cantidad"];clr='';}else{Egreso="- "+Datos[i]["Cantidad"];clr='';}
			if(parseFloat(Datos[i]["FechaReg"])<0){clrStock="color: #F44336;";}
			$('#IdTableReportec_ReportKardex tbody').append('<tr>'+
				'<td>'+(i+1)+'</td>'+
				'<td>'+Datos[i]["FechaReg"]+'</td>'+
				'<td>'+Datos[i]["Origen"]+'</td>'+
				'<td>'+Datos[i]["Destino"]+'</td>'+
				'<td>'+Datos[i]["Producto"]+'</td>'+
				'<td>'+Ingreso+'</td>'+
				'<td>'+Egreso+'</td>'+
				'<td style="'+clrStock+'">'+Datos[i]["Stock"]+'</td>'+
				'<td>'+Datos[i]["Documento"]+'</td>'+
				'<td>'+Datos[i]["Userr"]+'</td>'+
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