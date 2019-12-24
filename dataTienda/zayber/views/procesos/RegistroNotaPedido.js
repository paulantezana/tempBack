$(window).on('load',function(){
	var inst=new ClassRNotaPedido();

	$("#IdAlmacenPri").css("display","none");
	let empresaAlmacenes = [];
	$("#IdAlmacenPri option").each(function(){
		empresaAlmacenes.push({IdAlm: this.value, Alm: this.text, colorFondo: this.dataset.colorfondo, colorTexto: this.dataset.colortexto});
	});
	$("#headerEmpresaDatos").css('display','none');
	$("#headerEmpresaAlmacenes").css('display','none');
	$("#headerEmpresaUsuarioDatos").css('display','none');

	let empresaAlmacenesHTML = '';
	empresaAlmacenes.forEach(item=>{
		empresaAlmacenesHTML += `<div data-idalmacen="${item.IdAlm}" class='headerEmpresaAlmacenes-item' style="background: ${item.colorFondo}; color: ${item.colorTexto}">${item.Alm}</div>`;
	});
	let headerEmpresaUsuarioTypo = $("#headerEmpresaUsuarioTypo");
	headerEmpresaUsuarioTypo.html(empresaAlmacenesHTML).removeAttr('class').addClass('col-xl-10 col-md-10 col-sm-10 col-xs-12 headerEmpresaAlmacenes');
	headerEmpresaUsuarioTypo.on('click',function(e){
		$('.headerEmpresaAlmacenes-item').each(function () {
			$(this).removeClass('esta-activo');
		});
		$(e.target).addClass('esta-activo');
		$("#IdAlmRNP").html(e.target.dataset.idalmacen);
	});

	
	var Alm=$("#AlmRNP").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRNP").html();

	//inst.getList_combo_VentaNP([IdAlm]);
		
	
	$("#cboEmpresa_ProcVentaNP").chosen({width: "100%"});
	$("#cboComprobante_ProcVentaNP").chosen({width: "100%"});
	$("#cboTipoDoc_ProcVentaNP").chosen({width: "100%"});
	$("#txtFechaEmis_ProcVentaNP").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
	$("#txtFechaEmis_ProcVentaNP").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#txtFechaEntrega_PVNP").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){}});
	$("#txtFechaEntrega_PVNP").datepicker( "option", "dateFormat", "dd/mm/yy" );
	var FeH=current_date();
	$("#txtFechaEmis_ProcVentaNP").prop("value",FeH);
	$("#txtFechaEntrega_PVNP").prop("value",FeH);
	$("#txtFechaEntrega_PVNP").datepicker( "option", "minDate",FeH);
	
	$("#IdNumeroHabFBNP").on('click',function(e){var idss=$(this)[0].checked;if(idss){$("#txtNumero_ProcVentaNP").prop("readonly",false);}else{$("#txtNumero_ProcVentaNP").prop("readonly",true);}});
	$("#btnSearchRUC_ProcVentaNP").on('click',function(e){var Nro=$("#txtRuc_ProcVentaNP").val();
		if(Nro!="" && Nro.length===11){inst.getList_RecuperarRS_NroRuc_NP([Nro]);}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Ingrese Nro RUC.");}
	});
	$("#cboComprobante_ProcVentaNP").on('change',function(e){inst.Verificar_Serie_Nro_AlmCompro()});
	$("#cboEmpresa_ProcVentaNP").on('change',function(e){inst.Verificar_Serie_Nro_AlmCompro()});
	
	$("#txtCodigo_PVNP").keyup(function (e){if(e.which == 13){$("#txtCantidad_PVNP").focus();var CP=$("#txtCodigo_PVNP").val();if(IdAlm!="-1" && CP!="" && CP.length>3){inst.getList_Producto_Codigo_PVNP([IdAlm,CP]);}}});
	$("#txtCantidad_PVNP").focusout(function(){inst.Calcular_Importe_VentaNP();});
	$("#txtCantidad_PVNP").keyup(function (e){if(e.which == 13){$("#btnAdd_PVNP").focus();inst.Calcular_Importe_VentaNP();}});
	$('input:radio[name=rbtTipoprecioPVNP]').on('click',function(e){inst.Calcular_Importe_VentaNP();});
	$("#IdChkIGVPVeNP").on('click',function(){inst.TotalMonto_Table_DetailVentaFi_NP();});
	$("#btnAdd_PVNP").on('click',function(e){
		if(IdAlm!="-1"){
			var valido=true;
			var IdProd=$("#lblIdProductoPVNP").html();
			var Cod=$("#txtCodigo_PVNP").val();
			var producto=$("#txtProducto_PVNP").val();
			var Marca=$("#txtMarca_PVNP").val();
			var Modelo=$("#txtModelo_PVNP").val();
			var Unidad=$("#txtUnidad_PVNP").val();
			var Cant=$("#txtCantidad_PVNP").val();
			var Importe=$("#txtImporte_PVNP").val();
			var PU=0;
			var TipPrecio='';
			var TipoPrecio=$('input:radio[name=rbtTipoprecioPVNP]:checked').val();
			if(parseInt(TipoPrecio)===1){var PPublic=$("#txtPPublico_PVNP").val();
				if(PPublic!=""){PU=PPublic;TipPrecio='PP';}else{valido=false;}}
			else if(parseInt(TipoPrecio)===2){var PMenor=$("#txtPMenor_PVNP").val();
				if(PMenor!=""){PU=PMenor;TipPrecio='PB';}else{valido=false;}}
			else if(parseInt(TipoPrecio)===3){var PMayor=$("#txtPMayor_PVNP").val();
				if(PMayor!=""){PU=PMayor;TipPrecio='PD';}else{valido=false;}}
			if(valido && IdProd!="-1" && Cant!="" && producto!="" && Cod!="" && PU!="" && PU.length>0 && Importe!=""){
				var EP=inst.Verificar_Existe_Product_Detail_NP(IdProd);
				if(EP){
					inst.Build_Detail_VentaAdd_NP([IdProd,Cod,producto+' '+Marca+' '+Modelo,Unidad,Cant,PU,Importe,TipoPrecio,TipPrecio]);
					inst.Clear_Detail_VentaAdd_NP();
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Producto ya existe en detalle.");
				}
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");
			}
		}else{
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Error en proceso.");
		}
	});
	$("#btnClear_PVNP").on('click',function(e){
		(function(){vex.defaultOptions.className = 'vex-theme-os';})();
		vex.dialog.confirm({ message:'Desea Limpiar?',callback: function(ee){
			if(ee){
				inst.Clear_Detail_VentaAdd_NP();inst.Clear_Grnal_Venta_NP();
			}
		}});
	});
	$("#btnComprar_PVNP").on('click',function(e){
		var IdEmpresa=1;
		var IdComprob=15;

		var Serie=$("#txtSerie_ProcVentaNP").val();
		var Numero=$("#txtNumero_ProcVentaNP").val();
		var FechaEm=$("#txtFechaEmis_ProcVentaNP").val();
		var IdTipoDoc=$("select#cboTipoDoc_ProcVentaNP option:selected").val();
		var Ruc=$("#txtRuc_ProcVentaNP").val();
		var RS=$("#txtRS_ProcVentaNP").val();
		var Direc=$("#txtDireccion_ProcVenta").val();
		var Email=$("#txtEmail_ProcVenta").val();

		var NroGui=$("#txtNroGuia_ProcVenta").val();
		
		var Totaal=$("#txtTotal_PVNP").val();
		var SubTotal=$("#txtSubTotal_PVNP").val();
		var IGV=$("#txtIGV_PVNP").val();
		var aSon=$("#txtSon_PVNP").val();
		var FechaEnt=$("#txtFechaEntrega_PVNP").val();
		var Telefono=$("#txtTelefono_PVNP").val();
		var Alm=$("#AlmRNP").html();
		var IdIGV=$("#IdChkIGVPVeNP").is(':checked') ? 1 : 0;
		
		var Detail=[];
		$("#IdTable_Detalle_PVNP tbody tr").each(function (index){
			var aCantidad=$(this).find("td").eq(1).html();
			var aCodigo=$(this).find("td").eq(2).html();
			var aDescripcion=$(this).find("td").eq(3).html();
			var aUnidad=$(this).find("td").eq(4).html();
			var aPU=$(this).find("td").eq(5).html();
			var aImporte=$(this).find("td").eq(6).html();
			var aIdProducto=$(this).find("td").eq(8).html();
			var aIdTipoPrecio=$(this).find("td").eq(9).html();
			
			Detail.push({"aCantidad":aCantidad,"aCodigo":aCodigo,"aDescripcion":aDescripcion,"aUnidad":aUnidad,"aPU":aPU,
							"aImporte":aImporte,"aIdProducto":aIdProducto,"aIdTipoPrecio":aIdTipoPrecio});
		});
		if(Detail.length>0 && Totaal!="" && Totaal!="0.00" && SubTotal!="" && IGV!="" && IdComprob!="-1" && IdEmpresa!="-1" && FechaEnt!=""){
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();
			vex.dialog.confirm({ 
				message:'Desea Guardar?',
				callback: function(ee){if(ee){
					var pa=[];
					FechaEnt=FechaEnt.split('/')[2]+'-'+FechaEnt.split('/')[1]+'-'+FechaEnt.split('/')[0];
					pa.push({"aIdEmpresa":IdEmpresa,"aIdComprob":IdComprob,"aNroGuia":NroGui,
						"aTotaal":Totaal,"aSubTotal":SubTotal,"aIGV":IGV,"aSon":aSon,"aIdIGV":IdIGV,"aFechaEnt":FechaEnt,
						"aTelefono":Telefono,"aAlm":Alm,"aIdAlm":IdAlm,"aDetail":Detail});
						inst.Save_Datos_Venta_NP(pa);
				}}
			});
		}else{(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");}	
	});
	$("#btnSearchProd_PVNP").on('click',function(e){inst.Build_Modal_Productos_NP();});
	
	$("#txtRuc_ProcVentaNP").keyup(function (e){if(e.which == 13){$("#btnSearchRUC_ProcVentaNP").focus();}});
	$("#btnSearchRUC_ProcVentaNP").keyup(function (e){if(e.which == 13){var Nro=$("#txtRuc_ProcVentaNP").val();if(Nro!="" && Nro.length===11){inst.getList_RecuperarRS_NroRuc_NP([Nro]);}}});
	//$("#btnAdd_PVNP").keyup(function (e){if(e.which == 13){}}}});
});
function ClassRNotaPedido(){
	this.getList_combo_VentaNP=function(params){
		// $.blockUI();
		// $.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_combo_VentaNP",array:params},
		// 	async:true,dataType:"json",success:function(e){$.unblockUI();var Compro=e["Compro"],TipoDoc=e["TipoDoc"],Empresa=e["Empresa"];var inst=new ClassRNotaPedido();
		// 		if(Compro.length>0){
		// 			$("#cboComprobante_ProcVentaNP").empty();
		// 			for(var i=0;i<Compro.length;i++){$("#cboComprobante_ProcVentaNP").append('<option value="'+Compro[i]["Id"]+'">'+Compro[i]["Nombre"]+'</option>');}
		// 			$("#cboComprobante_ProcVentaNP").chosen({width: "100%"});
		// 			$('#cboComprobante_ProcVentaNP').val(Compro[0]["Id"]).trigger('chosen:updated');
		// 		}
		// 		if(TipoDoc.length>0){
		// 			$("#cboTipoDoc_ProcVentaNP").empty();
		// 			for(var i=0;i<TipoDoc.length;i++){$("#cboTipoDoc_ProcVentaNP").append('<option value="'+TipoDoc[i]["Id"]+'">'+TipoDoc[i]["Nombre"]+'</option>');}
		// 			$("#cboTipoDoc_ProcVentaNP").chosen({width: "100%"});
		// 			$('#cboTipoDoc_ProcVentaNP').val(TipoDoc[0]["Id"]).trigger('chosen:updated');
		// 		}
		// 		if(Empresa.length>0){
		// 			$("#cboEmpresa_ProcVentaNP").empty();
		// 			for(var i=0;i<Empresa.length;i++){$("#cboEmpresa_ProcVentaNP").append('<option value="'+Empresa[i]["Id"]+'">'+Empresa[i]["Nombre"]+'</option>');}
		// 			$("#cboEmpresa_ProcVentaNP").chosen({width: "100%"});
		// 			$('#cboEmpresa_ProcVentaNP').val(Empresa[0]["Id"]).trigger('chosen:updated');
		// 		}
		// 		inst.Verificar_Serie_Nro_AlmCompro();
		// 	},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		// });
	}
	this.Verificar_Serie_Nro_AlmCompro=function(){var inst=new ClassRNotaPedido();
		var IdEmp=$("select#cboEmpresa_ProcVentaNP option:selected").val();
		var IdComprob=$("select#cboComprobante_ProcVentaNP option:selected").val();
		var IdAlm=$("#IdAlmRNP").html();
		if(IdAlm!="-1" && IdEmp!="-1" && IdComprob!="-1"){inst.getList_Serie_Numero_VentaNP([IdEmp,IdComprob]);}
		if(IdEmp!="-1"){
			var Emp=$("select#cboEmpresa_ProcVentaNP option:selected").text();
			$("#lblNameEmpresaSelc").html(Emp);
		}else{$("#lblNameEmpresaSelc").html("");}
	}
	this.getList_Serie_Numero_VentaNP=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Serie_Numero_VentaNP",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRNotaPedido();
				var Serie=e["Serie"];
				var NroC=e["Numero"][0]["Numero"];
				$("#txtNumero_ProcVentaNP").prop("value",NroC);
				$("#txtSerie_ProcVentaNP").prop("value",Serie);
				$("#IdNumeroHabFBNP").prop("checked",false);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Calcular_Importe_VentaNP=function(){
		var TipoPrecio=$('input:radio[name=rbtTipoprecioPVNP]:checked').val();
		var Cantid=$("#txtCantidad_PVNP").val();
		var PU=0;
		if(Cantid!=""){
			if(parseInt(TipoPrecio)===1){var PPublic=$("#txtPPublico_PVNP").val();if(PPublic!=""){PU=PPublic;}}
			else if(parseInt(TipoPrecio)===2){var PMenor=$("#txtPMenor_PVNP").val();if(PMenor!=""){PU=PMenor;}}
			else if(parseInt(TipoPrecio)===3){var PMayor=$("#txtPMayor_PVNP").val();if(PMayor!=""){PU=PMayor;}}
			var Totl=parseFloat(PU)*parseFloat(Cantid);
			$("#txtImporte_PVNP").prop("value",parseFloat(Totl).toFixed(2));
		}else{
			$("#txtImporte_PVNP").prop("value","");
		}
	}
	this.getList_Producto_Codigo_PVNP=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Producto_Codigo",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRNotaPedido();
				var Dato=e;
				if(Dato.length>0){
					$("#lblIdProductoPVNP").html(Dato[0]["IdProducto"]);
					$("#txtProducto_PVNP").prop("value",Dato[0]["Producto"]);
					$("#txtMarca_PVNP").prop("value",Dato[0]["Marca"]);
					$("#txtModelo_PVNP").prop("value",Dato[0]["Modelo"]);
					$("#txtUnidad_PVNP").prop("value",Dato[0]["Unidad"]);
					$("#txtPPublico_PVNP").prop("value",Dato[0]["PrecioPublico"]);
					$("#txtPMenor_PVNP").prop("value",Dato[0]["PrecioBase"]);
					$("#txtPMayor_PVNP").prop("value",Dato[0]["PrecioDistribuido"]);
					$("#txtStock_PVNP").prop("value",Dato[0]["Stock"]);
					inst.Calcular_Importe_VentaNP();
				}else{
					$("#lblIdProductoPVNP").html("-1");
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Verificar_Existe_Product_Detail_NP=function(pIdProd){
		var vald=true;
		$("#IdTable_Detalle_PVNP tbody tr").each(function (index){
			var aIdprod=$(this).find("td").eq(8).html();
			if(pIdProd===aIdprod){
				vald=false;
			}
		});
		return vald;
	}
	this.Build_Detail_VentaAdd_NP=function(Datos){var inst=new ClassRNotaPedido();
		$('#IdTable_Detalle_PVNP tbody').append('<tr>'+
			'<td id="editManteDetail_0">'+
				'<i class="fas fa-times-circle f-18"></i>'+
			'</td>'+
			'<td>'+Datos[4]+'</td>'+
			'<td>'+Datos[1]+'</td>'+
			'<td>'+Datos[2]+'</td>'+
			'<td>'+Datos[3]+'</td>'+
			'<td>'+Datos[5]+'</td>'+
			'<td>'+Datos[6]+'</td>'+
			'<td>'+Datos[8]+'</td>'+
			'<td style="display:none">'+Datos[0]+'</td>'+
			'<td style="display:none">'+Datos[7]+'</td>'+
		'</tr>');
		inst.TotalMonto_Table_DetailVentaFi_NP();
		$('#IdTable_Detalle_PVNP tbody').unbind("click");
		$('#IdTable_Detalle_PVNP tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteDetail'){
				var add=$(this).parent("tr:first");
				add.remove();
				inst.TotalMonto_Table_DetailVentaFi_NP();
			}
		});
	}
	this.TotalMonto_Table_DetailVentaFi_NP=function(){
		var TotaMon=0.00;
		$("#IdTable_Detalle_PVNP tbody tr").each(function (index){
			var importe=$(this).find("td").eq(6).html();
			TotaMon=parseFloat(TotaMon)+parseFloat(importe);
		});
		var IdIGV=$("#IdChkIGVPVeNP").is(':checked') ? 1 : 0;
		if(parseInt(IdIGV)===1){
			var SubTO=parseFloat(TotaMon)/parseFloat(1.18);
			var IGV=parseFloat(SubTO)*parseFloat(0.18);
			$("#txtSubTotal_PVNP").prop("value",parseFloat(SubTO).toFixed(2));
			$("#txtIGV_PVNP").prop("value",parseFloat(IGV).toFixed(2));
			
		}else{
			$("#txtSubTotal_PVNP").prop("value",parseFloat(TotaMon).toFixed(2));
			$("#txtIGV_PVNP").prop("value",parseFloat("0").toFixed(2));
		}
		$("#txtTotal_PVNP").prop("value",parseFloat(TotaMon).toFixed(2));
		var son=CLetras(parseFloat(TotaMon).toFixed(2),true,1);
		$("#txtSon_PVNP").prop("value",son);
	}
	this.Clear_Detail_VentaAdd_NP=function(){
		$("#lblIdProductoPVNP").html("-1");
		$("#txtCantidad_PVNP").prop("value","1");
		$("#txtCodigo_PVNP").prop("value","");
		$("#txtProducto_PVNP").prop("value","");
		$("#txtMarca_PVNP").prop("value","");
		$("#txtModelo_PVNP").prop("value","");
		$("#txtUnidad_PVNP").prop("value","");
		$("#txtPPublico_PVNP").prop("value","");
		$("#txtPMenor_PVNP").prop("value","");
		$("#txtPMayor_PVNP").prop("value","");
		$("#txtImporte_PVNP").prop("value","");
	}
	this.Clear_Grnal_Venta_NP=function(){
		$("#txtTotal_PVNP").prop("value","0");
		$("#txtSubTotal_PVNP").prop("value","0");
		$("#txtIGV_PVNP").prop("value","0");
		$("#txtSon_PVNP").prop("value","");
		$("#txtTelefono_PVNP").prop("value","");
		$("#IdTable_Detalle_PVNP tbody").html("");
		
		$("#txtRuc_ProcVentaNP").prop("value","");
		$("#txtRS_ProcVentaNP").prop("value","");
		$("#txtDireccion_ProcVenta").prop("value","");
		$("#txtEmail_ProcVenta").prop("value","");
		$("#txtNroGuia_ProcVenta").prop("value","");		
	}
	this.Save_Datos_Venta_NP=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"Save_Datos_Venta_NP",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassRNotaPedido();
				if(e["Val"]){
					alertify.success("PROCESO CORRECTO.");
					inst.Clear_Detail_VentaAdd_NP();inst.Clear_Grnal_Venta_NP();
					inst.Verificar_Serie_Nro_AlmCompro();
					var inst2=new ClassImpresion();
					//inst2.getList_Datos_ReportVentta_Print([e["IdVenta"],IdAlm]);
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Modal_Productos_NP=function(){var inst=new ClassRNotaPedido();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Productos_Modal_NP);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		var IdAlm=$("#IdAlmRNP").html();
		if(IdAlm!="-1"){inst.getList_Productos_AlmComp([IdAlm]);}
	}
	this.getList_Productos_AlmComp=function(params){var inst=new ClassRNotaPedido();
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Productos_AlmComp",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e;var IdAlm=$("#IdAlmRNP").html();
				if(Dato.length>0){
					$("#IdTableproduct_AddCompra tbody").html("");		
					for(var i=0;i<Dato.length;i++){
						var ids=Dato[i]["IdProducto"];
						$('#IdTableproduct_AddCompra tbody').append('<tr id="idtr_'+ids+'">'+
							'<td id="codProdAlmD_'+ids+'">'+
								'<input type="radio" name="IdSelPVentaNP" value="'+ids+'" class="chk2020">'+
							'</td>'+
							'<td id="codProdAlmD_'+ids+'">'+Dato[i]["Codigo"]+'</td>'+
							'<td id="uniProdAlmD_'+ids+'">'+Dato[i]["Producto"]+'</td> '+
							'<td id="uniProdAlmD_'+ids+'">'+Dato[i]["Unidad"]+'</td> '+
							'<td id="uniProdAlmD_'+ids+'">'+Dato[i]["Stock"]+'</td> '+
							'<td id="prveProdAlmD_'+ids+'" style="display:none">'+ids+'</td> '+
						'</tr>');
					}
					$('#filtrar').keyup(function(){
						var rex = new RegExp($(this).val(), 'i');
						$('.buscar tr').hide();
						$('.buscar tr').filter(function (){
							return rex.test($(this).text());
						}).show();
					});
					
					$('input:radio[name=IdSelPVentaNP]').on('click',function(e){
						var idP=$(this)[0].value;
						inst.getList_Producto_Id_modal_NP([IdAlm,idP]);
					});
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.getList_Producto_Id_modal_NP=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Producto_Id",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();Producto=e;var inst=new ClassRNotaPedido();
				if(Producto.length>0){
					$("#txtCodigo_PVNP").prop("value",Producto[0]["Codigo"]);
					$("#txtProducto_PVNP").prop("value",Producto[0]["Producto"]);
					$("#txtMarca_PVNP").prop("value",Producto[0]["Marca"]);
					$("#txtModelo_PVNP").prop("value",Producto[0]["Modelo"]);
					$("#txtUnidad_PVNP").prop("value",Producto[0]["Unidad"]);
					$("#txtCantidad_PVNP").prop("value","1");
					$("#txtPPublico_PVNP").prop("value",Producto[0]["PrecioPublico"]);
					$("#txtPMenor_PVNP").prop("value",Producto[0]["PrecioBase"]);
					$("#txtPMayor_PVNP").prop("value",Producto[0]["PrecioDistribuido"]);
					$("#txtStock_PVNP").prop("value",Producto[0]["Stock"]);
					$("#lblIdProductoPVNP").html(Producto[0]["IdProducto"]);
					inst.Calcular_Importe_VentaNP();
					$('#myModal').modal('hide');$('#modal_Manten').html("");
					$(".modal-open").removeClass('modal-open');
					$("#txtCantidad_PVNP").focus();
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_RecuperarRS_NroRuc_NP=function(params){
		/*$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_RecuperarRS_Nro",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				var Dato=JSON.parse(e);
				if(Dato.length>0){
					$("#txtRS_ProcVentaNP").prop("value",Dato[0]["RazonSocial"]);
					$("#txtDireccion_ProcVenta").prop("value",Dato[0]["Direccion"]);
				}else{
					$("#txtRS_ProcVentaNP").prop("value","");
					$("#txtDireccion_ProcVenta").prop("value","");
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});*/
	}
	
}



