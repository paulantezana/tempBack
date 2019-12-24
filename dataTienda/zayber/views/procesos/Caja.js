$(window).on('load',function(){var inst=new ClassCaja();
	$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmCaja").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmCaja").html();
	
	$("#IdFecha_Report").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){
		if(IdAlm!="-1"){inst.getList_Datos_Caja([IdAlm]);}
	}});
	$("#IdFecha_Report").datepicker( "option", "dateFormat", "dd/mm/yy" );
	var FeH=current_date();
	$("#IdFecha_Report").prop("value",FeH);
	$("#btnUpdate_Caja").on('click',function(e){if(IdAlm!="-1"){inst.getList_Datos_Caja([IdAlm]);}});
	$("#btnPrint_Caja").on('click',function(e){$("#IdContent_Caja").printArea();});
	$("#btnExportar_Caja").on('click',function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContent_Caja').html()));
		e.preventDefault();
	});	
	$("#btnIngreso_Caja").on('click',function(e){inst.Build_Ingreso_Caja();});
	$("#btnEgreso_Caja").on('click',function(e){inst.Build_Egreso_Caja();});
	$("#btnConvertir_CajaCorriente").on('click',function(e){inst.Build_Convertir_CajaCorriente();});
	if(IdAlm!="-1"){inst.getList_Datos_Caja([IdAlm]);}
});
function ClassCaja(){
	this.getList_Datos_Caja=function(params){
		let fecha=$('#IdFecha_Report').val();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Datos_Caja",array:params,fecha:fecha},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassCaja();console.log(e);
				inst.Build_Datos_Caja(e["Caja"]);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_Caja=function(Datos){var inst=new ClassCaja();
		$("#IdTable_Caja tbody").html("");
		var SalSol=0,salDola=0;	
		if(Datos.length>0){
			SalSol=Datos[Datos.length-1]["SaldoSoles"];
			salDola=Datos[Datos.length-1]["SaldoDolares"];
			for(var i=0;i<Datos.length;i++){
				var ids=Datos[i]["IdCaja"];
				$('#IdTable_Caja tbody').append('<tr>'+
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
		}
		$("#txtSoles_SaldoCaja").prop("value",parseFloat(SalSol).toFixed(2));
		$("#txtDolar_SaldoCaja").prop("value",parseFloat(salDola).toFixed(2));
		$('#filtrarM').keyup(function(){
			var rex = new RegExp($(this).val(), 'i');
			$('.buscarm tr').hide();
			$('.buscarm tr').filter(function (){
				return rex.test($(this).text());
			}).show();
		});
					
		var altM=parseFloat($(window).height())-parseFloat(200);
		$("#IdContent_Caja").css({"overflow-y":"scroll","height":altM+"px"});
	}
	this.Build_Ingreso_Caja=function(){var inst=new ClassCaja();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Caja_Ingreso);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		var IdAlm=$("#IdAlmCaja").html();
		$("#txtSave_IngresoCaja").on('click',function(e){
			var Soles=$("#txtSoles_CajaIngreso").val();
			var Dolar=$("#txtDolar_CajaIngreso").val();
			var Descr=$("#txtDescripcion_IngresoCaja").val();
			var Obs=$("#txtObs_IngresoCaja").val();
			var pTipo="1";
			var pIdTipoServ="-1";
			if(Soles!="" && Dolar!="" && Descr!="" && IdAlm!="-1"){
				(function(){
					vex.defaultOptions.className = 'vex-theme-os';
				})();
				vex.dialog.confirm({ message:'Desea Guardar Ingreso?', 
					callback: function(ee){
					if(ee){
						var pa=[pTipo,pIdTipoServ,Soles,Dolar,Descr,Obs,IdAlm];
						inst.Save_Ingreso_Caja(pa);
					}
				}});
			}else{
				(function(){
					vex.defaultOptions.className = 'vex-theme-os';
				})();
				vex.dialog.alert("Faltan Datos");
			}
		});
	}
	this.Save_Ingreso_Caja=function(params){
		let fecha=$('#IdFecha_Report').val();
		let aux=fecha_Barra_Guion(fecha);
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"Save_Ingreso_Caja",array:params,fecha:aux},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassCaja();console.log(e);
				if(e){
					$('#myModal').modal('hide');$('#modal_Manten').html("");
					$(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					var IdAlm=$("#IdAlmCaja").html();
					if(IdAlm!="-1"){inst.getList_Datos_Caja([IdAlm]);}
				}else{alertify.error("Error, Proceso Incorrecto.");}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Egreso_Caja=function(){var inst=new ClassCaja();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Caja_Egreso);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		var IdAlm=$("#IdAlmCaja").html();
		inst.getList_combo_CajaEgreso();
		$("#txtSave_EgresoCaja").on('click',function(e){
			var Soles=$("#txtSoles_CajaEgreso").val();
			var Dolar=$("#txtDolar_CajaEgreso").val();
			var Descr=$("#txtDescripcion_EgresoCaja").val();
			var Obs=$("#txtObs_EgresoCaja").val();
			var pTipo="2";
			var pIdTipoServ=$("select#cboTipo_CajaEgreso option:selected").val();
			if(Soles!="" && Dolar!="" && Descr!="" && IdAlm!="-1" && pIdTipoServ!="-1"){
				(function(){
					vex.defaultOptions.className = 'vex-theme-os';
				})();
				vex.dialog.confirm({ message:'Desea Guardar Egreso?', 
					callback: function(ee){
					if(ee){
						var pa=[pTipo,pIdTipoServ,Soles,Dolar,Descr,Obs,IdAlm];
						inst.Save_Ingreso_Caja(pa);
					}
				}});
			}else{
				(function(){
					vex.defaultOptions.className = 'vex-theme-os';
				})();
				vex.dialog.alert("Faltan Datos");
			}
		});
	}
	this.getList_combo_CajaEgreso=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_combo_CajaEgreso"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassCaja();
				var Servicio=e;
				if(Servicio.length>0){
					$("#cboTipo_CajaEgreso").empty();$("#cboTipo_CajaEgreso").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Servicio.length;i++){$("#cboTipo_CajaEgreso").append('<option value="'+Servicio[i]["IdTipo"]+'">'+Servicio[i]["Tipo"]+'</option>');}
					$("#cboTipo_CajaEgreso").chosen({width: "100%"});
				}else{
					$("#cboTipo_CajaEgreso").empty();$("#cboTipo_CajaEgreso").append('<option value="-1">Seleccione</option>');
					$("#cboTipo_CajaEgreso").chosen({width: "100%"});
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
}



