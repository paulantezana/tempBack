$(window).on('load',function(){var inst=new ClassLRPrecioAlm();$("#IdAlmacenPri").css("display","none");
	
	inst.getList_combo_RPrecioAlm();

	$("#btnPrint_RPrecioAlm").on('click',function(e){$("#IdContent_RPrecioAlm").printArea();});
	$("#btnExportar_RPrecioAlm").on('click',function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContent_RPrecioAlm').html()));
	});
	
	$("#cboAlmacen_RPrecioAlm").on('change',function(e){inst.verificar_datos_ReportVenta();});
});
function ClassLRPrecioAlm(){
	this.getList_combo_RPrecioAlm=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_combo_RPrecioAlm",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var Dato=e;
				if(Dato.length>0){
					$("#cboAlmacen_RPrecioAlm").empty();$("#cboAlmacen_RPrecioAlm").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Dato.length;i++){$("#cboAlmacen_RPrecioAlm").append('<option value="'+Dato[i]["IdAlmacen"]+'">'+Dato[i]["Almacen"]+'</option>');}
					$("#cboAlmacen_RPrecioAlm").chosen({width: "100%"});
					$('#cboAlmacen_RPrecioAlm').val("-1").trigger('chosen:updated');
				}else{
					$("#cboAlmacen_RPrecioAlm").empty();$("#cboAlmacen_RPrecioAlm").append('<option value="-1">Seleccione</option>');
					$("#cboAlmacen_RPrecioAlm").chosen({width: "100%"});
					$('#cboAlmacen_RPrecioAlm').val("-1").trigger('chosen:updated');
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.verificar_datos_ReportVenta=function(){var inst=new ClassLRPrecioAlm();
		$("#IdTable_RPrecioAlma tbody").html("");
		var IdAlm=$("select#cboAlmacen_RPrecioAlm option:selected").val();
		if(IdAlm!="-1"){
			inst.getList_Datos_RPrecioAlm([IdAlm]);
		}
	}
	this.getList_Datos_RPrecioAlm=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_RPrecioAlm",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassLRPrecioAlm();
				$("#IdTable_RPrecioAlma tbody").html("");
				if(e.length>0){
					inst.Build_Datos_RVenta(e);
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RVenta=function(Datos){var inst=new ClassLRPrecioAlm();
		$("#IdTable_RPrecioAlma tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdProducto"]+'_'+Datos[i]["IdUnidad"];
			$('#IdTable_RPrecioAlma tbody').append('<tr>'+
					'<td>'+Datos[i]["Producto"]+'</td>'+
					'<td>'+Datos[i]["Unidad"]+'</td>'+
					'<td>'+Datos[i]["PrecioCompra"]+'</td>'+
					'<td>'+Datos[i]["PrecioBase"]+'</td>'+
					'<td>'+Datos[i]["PrecioDistribuido"]+'</td>'+
					'<td>'+Datos[i]["PrecioPublico"]+'</td>'+
					'<td>'+Datos[i]["Moneda"]+'</td>'+
					'<td>'+Datos[i]["Stock"]+'</td>'+
					'<td>'+Datos[i]["TipoCambio"]+'</td>'+
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
		
	}
}
