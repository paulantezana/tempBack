$(window).on('load',function(){var inst=new ClassExportPAML();$("#IdAlmacenPri").css("display","none");
	$("#cboAlmacen_RepExportPAlm").chosen({width: "100%"});
	
	$("#cboPrint_RepExportPAlm").on('click',function(e){$("#IdContentRepExportPAlm").printArea();});
	$("#cboExportar_RepExportPAlm").on('click',function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRepExportPAlm').html()));
	});
	$("#cboAlmacen_RepExportPAlm").on('change',function(e){inst.verificar_datos_ExportProd();});
	inst.verificar_datos_ExportProd();
});
function ClassExportPAML(){
	this.verificar_datos_ExportProd=function(){var inst=new ClassExportPAML();
		$("#IdTable_RepExportPAlm tbody").html("");
		var IdAlm=$("select#cboAlmacen_RepExportPAlm option:selected").val();
		if(IdAlm!="-1"){
			inst.getList_Datos_ExportarProduct([IdAlm]);
		}
	}
	this.getList_Datos_ExportarProduct=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Datos_ExportarProduct",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassExportPAML();
				$("#IdTable_RepExportPAlm tbody").html("");
				if(e.length>0){
					inst.Build_Datos_ExportarProduct(e);
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_ExportarProduct=function(Datos){var inst=new ClassExportPAML();
		$("#IdTable_RepExportPAlm tbody").html("");	lon=Datos.length;console.log(lon);
		for(var i=0;i<lon;i++){
			$('#IdTable_RepExportPAlm tbody').append('<tr>'+
				'<td>'+Datos[i]["Codigo"]+'</td>'+
				'<td>'+Datos[i]["CodigoFabricante"]+'</td>'+
				'<td>'+Datos[i]["Producto"]+'</td>'+
				'<td>'+Datos[i]["Marca"]+'</td>'+
				'<td>'+Datos[i]["Modelo"]+'</td>'+
				'<td>'+Datos[i]["Anio"]+'</td>'+
				'<td>'+Datos[i]["PrecioCompra"]+'</td>'+
				'<td>'+Datos[i]["PrecioMayor"]+'</td>'+
				'<td>'+Datos[i]["PrecioMenor"]+'</td>'+
				'<td>'+Datos[i]["PrecioPublico"]+'</td>'+
				'<td>'+Datos[i]["Stock"]+'</td>'+
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
