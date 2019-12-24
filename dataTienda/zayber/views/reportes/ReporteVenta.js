$(window).on('load',function(){var inst=new ClassLRVenta();$("#IdAlmacenPri").css("display","none");
	var Alm=$("#AlmRepVenta").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlmRepVenta").html();
	$("#cboEmpresa_RepVent").chosen({width: "100%"});
	
	$("#IdFechaIn_ReportVenta").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_ReportVenta();}});
	$("#IdFechaIn_ReportVenta").datepicker( "option", "dateFormat", "dd/mm/yy" );
	$("#IdFechaFn_ReportVenta").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1,changeYear: true,disableTextInput:true,onClose: function(selectedDate){inst.verificar_datos_ReportVenta();}});
	$("#IdFechaFn_ReportVenta").datepicker( "option", "dateFormat", "dd/mm/yy" );

	$("#cboPrint_RVenta").on('click',function(e){$("#IdContentRVenta").printArea();});
	$("#cboEmpresa_RepVent").on('change',function(e){inst.verificar_datos_ReportVenta();});
	$("#cboExportar_RVenta").on('click',function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRVenta').html()));
	});
	$("#btnGroupGR_RVenta").on('click',function(e){
		var Fact=[];var fc='';
		$(".claselReportFactVent").each(function(e){
			var chkk=$(this)[0].checked;
			if(chkk){
				var valr=$(this)[0].value;
				var ids=valr.split('_');
				Fact.push({"aIdVenta":ids[0],"aIdComprob":ids[1],"aIdEstado":ids[2],"aImpresion":ids[3],"aIdEmpresa":ids[4]});
				var SerNro=$("#sernroREPVENT_"+valr).html();
				fc=fc+' '+SerNro;
			}
		});
		if(Fact.length>1){
			inst.getList_Gnerar_Guia_Factura_Group([IdAlm,Fact],fc);
		}else{
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccionar mas de 1 factura.");
		}
	});
});
function ClassLRVenta(){
	this.verificar_datos_ReportVenta=function(){var inst=new ClassLRVenta();
		$("#IdTableReportec_ReportVenta tbody").html("");
		var feIn=$("#IdFechaIn_ReportVenta").val(),feFn=$("#IdFechaFn_ReportVenta").val();
		var IdAlm=$("#IdAlmRepVenta").html();
		var IdEmp=$("select#cboEmpresa_RepVent option:selected").val();
		if(feIn!="" && feFn!="" && IdAlm!="-1" && IdEmp!="-1"){
			feIn=fecha_Barra_Guion(feIn);feFn=fecha_Barra_Guion(feFn);
			inst.getList_Datos_RVenta([feIn,feFn,IdAlm,IdEmp]);
		}
	}
	this.getList_Datos_RVenta=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_RVenta",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassLRVenta();
				$("#IdTableReportec_ReportVenta tbody").html("");
				if(e.length>0){
					inst.Build_Datos_RVenta(e);
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Datos_RVenta=function(Datos){var inst=new ClassLRVenta();
		$("#IdTableReportec_ReportVenta tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var pIdComprobante=Datos[i]["IdComprobante"];
			var pImpresion=Datos[i]["Impresion"];
			var pIdEstado=Datos[i]["Estado"];
			var ids=Datos[i]["IdVenta"]+'_'+pIdComprobante+'_'+pIdEstado+'_'+pImpresion+'_'+Datos[i]["IdEmpresa"];
			var icoGFactura='';var icoGGuiaR='';var icoSelc='';var AnularFGR='';
			
			if(parseInt(pImpresion)===1 && parseInt(pIdEstado)===1){
				if(parseInt(pIdComprobante)===1){//Generar Guia Remision
					icoGGuiaR='<i class="fas fa-file-upload f-18"></i>';
					/*icoSelc='<input type="checkbox" id="idselRV_'+ids+'" value="'+ids+'" class="chk2020 claselReportFactVent">';*/
				}else if(parseInt(pIdComprobante)===20){//Generar Factura
					icoGFactura='<i class="fas fa-file-upload f-18"></i>';
				}
			}
			if(parseInt(pIdEstado)===1){
				AnularFGR='<i class="fas fa-times-circle f-18"></i>';
			}
			$('#IdTableReportec_ReportVenta tbody').append('<tr>'+
				'<td id="printREPVENT_'+ids+'" class="center">'+
					'<i class="fas fa-print f-18"></i>'+
				'</td>'+
				'<td>'+(i+1)+'</td>'+
				/*'<td id="guiaREPVENT_'+ids+'" class="center">'+
					icoGGuiaR+
				'</td>'+*/
				/*'<td id="factREPVENT_'+ids+'" class="center">'+
					icoGFactura+
				'</td>'+*/
				'<td>'+Datos[i]["Empresa"]+'</td>'+
				'<td>'+Datos[i]["Fec"]+'</td>'+
				'<td>'+Datos[i]["Comprobante"]+'</td>'+
				'<td id="sernroREPVENT_'+ids+'">'+Datos[i]["Serie"]+'/'+Datos[i]["Numero"]+'</td>'+
				'<td id="nrodocRFVU_'+ids+'">'+Datos[i]["Ruc"]+'</td>'+
				'<td>'+Datos[i]["RazonSocial"]+'</td>'+
				'<td>'+Datos[i]["Total"]+'</td>'+
				'<td>'+Datos[i]["SubTotal"]+'</td>'+
				'<td>'+Datos[i]["IGV"]+'</td>'+
				'<td>'+Datos[i]["Userr"]+'</td>'+
				'<td>'+Datos[i]["Obs"]+'/'+Datos[i]["PagoObs"]+'</td>'+
				'<td>'+Datos[i]["TipoC"]+'</td>'+
				'<td>'+Datos[i]["Est"]+'</td>'+
				'<td id="deltREPVENT_'+ids+'" class="center">'+
					AnularFGR+
				'</td>'+
				/*'<td id="selcREPVENT_'+ids+'" class="center">'+
					icoSelc+
				'</td>'+*/
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
		var IdAlm=$("#IdAlmRepVenta").html();
		var Alm=$("#AlmRepVenta").html();
		$('#IdTableReportec_ReportVenta tbody').unbind("click");
		$('#IdTableReportec_ReportVenta tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='printREPVENT'){
				IdTipoComp=parseInt(id[2]);
				if(IdTipoComp===10){
					var inst2=new ClassImpresion();
					inst2.getList_Print_Ticket([id[1],id[5]]);
				}else if(IdTipoComp===1 || IdTipoComp===2){
					var inst2=new ClassImpresion();
					inst2.getList_Print_FacturaBoleta([id[1]]);
				}else if(IdTipoComp===20){
					var inst2=new ClassImpresion();
					//inst2.getList_Print_GuiaRemision([id[1]]);
				}
			}
			else if(id[0]==='guiaREPVENT'){
				if(parseInt(id[2])===1 && parseInt(id[3])===1 && parseInt(id[4])===1){
					//inst.getList_Gnerar_Guia_Factura([IdAlm,id[1],id[2],id[3],id[4],id[5]]);
				}
			}
			else if(id[0]==='factREPVENT'){
				if(parseInt(id[2])===20 && parseInt(id[5])===1  && parseInt(id[6])===1){
					//inst.getList_Gnerar_Factura_GuiaRemision([id[1],id[2],IdAlm]);
				}
			}
			else if(id[0]==='deltREPVENT'){
				if(parseInt(id[3])===1){
					vex.dialog.prompt({ className: 'vex-theme-os', message: 'Motivo para anular:', callback: function(ee){
						if(ee!=false && ee!='' && (parseInt(id[2])==1)||(parseInt(id[2])==2)){
							inst.Anular_Datos_Factura([id[1],IdAlm,ee,id[2],id[3],id[4],id[5]]);
						}
						} 
					});
				}
			}
		});			
	
		$(".claselReportFactVent").on('click',function(e){
			var chk=$(this)[0].checked;
			if(chk){
				var idval=$(this)[0].value;
				var val=idval.split('_');
				var nroDocc=$("#nrodocRFVU_"+idval).html();
				var vald=inst.Verificar_Chk_ReportVent(val[0],nroDocc);
				if(!vald){
					$("#idselRV_"+idval).prop("checked",false);
				}
			}
		});
	}
	this.Verificar_Chk_ReportVent=function(pIdVent,pNDoc){
		var valido=true;
		$(".claselReportFactVent").each(function(e){
			var chk=$(this)[0].checked;
			if(chk){
				var dival=$(this)[0].value;
				var idvn=dival.split('_')[0];
				var nroDoc=$("#nrodocRFVU_"+dival).html();
				if(nroDoc!=pNDoc && idvn!=pIdVent){
					valido=false;
				}
			}
		});
		return valido;
	}
	this.getList_Gnerar_Guia_Factura=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Gnerar_Guia_Factura",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassLRVenta();
				var Venta=e["Venta"],Detalle=e["Detalle"],SN=e["SN"],TipoDoc=e["TipoDoc"];
					
				if(Venta.length>0 && Detalle.length>0){
					$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_GuiaR_Factura);
					$('#myModal').modal({keyboard: false,backdrop:false});
					$('.modal-dialog').draggable({handle: ".modal-header"});
					$("#txtSerie_GRFA").prop("value",SN[0]);
					$("#txtNumero_GRFA").prop("value",SN[1]);
					if(TipoDoc.length>0){
						$("#cboTipoDoc_ProcVenta").empty();
						for(var i=0;i<TipoDoc.length;i++){$("#cboTipoDoc_ProcVenta").append('<option value="'+TipoDoc[i]["IdTipoDocumento"]+'">'+TipoDoc[i]["TipoDocumento"]+'</option>');}
						$("#cboTipoDoc_ProcVenta").chosen({width: "100%"});
						$('#cboTipoDoc_ProcVenta').val("3").trigger('chosen:updated');
					}
					
					if(parseInt(Venta[0]["RazonSocial"])===0){$("#IdChkIGVPVe").prop("checked",true);}else{$("#IdChkIGVPVe").prop("checked",false);}
					$('#cboTipoBien_ProcVenta').val(Venta[0]["IdTipoBien"]).trigger('chosen:updated');
					$('#cboTipoDoc_ProcVenta').val(Venta[0]["IdTipoDoc"]).trigger('chosen:updated');
					
					$("#txtRuc_GRFA").prop("value",Venta[0]["Ruc"]);
					$("#txtRS_GRFA").prop("value",Venta[0]["RazonSocial"]);
					$("#txtDireccion_GRFA").prop("value",Venta[0]["Direccion"]);
					$("#txtFactura_GRFA").prop("value",Venta[0]["Serie"]+' - '+Venta[0]["Numero"]);
					if(Detalle.length>0){
						var tottl=0;
						for(var i=0;i<Detalle.length;i++){
							var ids=Detalle[i]["IdVenta"]+'_'+Detalle[i]["IdDetalle"];
							tottl=parseFloat(tottl)+parseFloat(Detalle[i]["Importe"]);
							$('#IdTableDato_GRFA tbody').append('<tr>'+
								'<td>'+Detalle[i]["Cantidad"]+'</td>'+
								'<td>'+Detalle[i]["Unidad"]+'</td>'+
								'<td>'+Detalle[i]["Codigo"]+'</td>'+
								'<td>'+Detalle[i]["Producto"]+'</td>'+
								'<td>'+Detalle[i]["PUnitario"]+'</td>'+
								'<td>'+Detalle[i]["Importe"]+'</td>'+
								'<td style="display:none">'+Detalle[i]["IdProducto"]+'</td>'+
							'</tr>');
						}
						$("#txtTotall_GRFA").prop("value",parseFloat(tottl).toFixed(2));
					}
					var IdAlm=$("#IdAlmRepVenta").html();
					var Alm=$("#AlmRepVenta").html();
					$("#btnSave_GRFA").on('click',function(e){
						var IdComprob=20;
						var aSerie=$("#txtSerie_GRFA").val();
						var aNumero=$("#txtNumero_GRFA").val();
						var aTotal=$("#txtTotall_GRFA").val();
						var aIdEmpresa=params[5];
						var aRuc=$("#txtRuc_GRFA").val(),aRS=$("#txtRS_GRFA").val(),aDirec=$("#txtDireccion_GRFA").val();
						var NroFac=$("#txtFactura_GRFA").val();
						var Detail=[];
						var Seriees=$("#txtFactura_GRFA").val();
						var IdIGV=0;
						var IdTipoDoc=$("select#cboTipoDoc_ProcVenta option:selected").val();
						
						$("#IdTableDato_GRFA tbody tr").each(function (index){
							var aCantidad=$(this).find("td").eq(0).html();
							var aUnidad=$(this).find("td").eq(1).html();
							var aCodigo=$(this).find("td").eq(2).html();
							var aDescripcion=$(this).find("td").eq(3).html();
							var aPrecio=$(this).find("td").eq(4).html();
							var aImporte=$(this).find("td").eq(5).html();
							var aIdprod=$(this).find("td").eq(6).html();
							
							Detail.push({"aCantidad":aCantidad,"aCodigo":aCodigo,"aDescripcion":aDescripcion,"aPrecio":aPrecio,
										"aImporte":aImporte,"aIdprod":aIdprod,"aUnidad":aUnidad});
						});
						if(aSerie!="" && aNumero!="" && IdAlm!="-1" && Detail.length>0){
							(function(){
								vex.defaultOptions.className = 'vex-theme-os';
							})();
							vex.dialog.confirm({ message:'Desea Guardar?', 
								callback: function(ee){
									if(ee){
										var pa=[];
										pa.push({"aIdComprob":IdComprob,"aSerie":aSerie,"aNumero":aNumero,
										"aTotaal":aTotal,"aSubTotal":aTotal,"aIGV":"0","aObs":"Generando de factura G.R."+Seriees,"aPago":"","aTipoV":"0",
										"aIdAlm":IdAlm,"aAlm":Alm,"aRuc":aRuc,"aRS":aRS,"aDireccion":aDirec,"aSon":'',"aNroFac":NroFac,"aIdVent":params[0],
										"aIdIGV":IdIGV,"aIdTipoDoc":IdTipoDoc,"aIdEmpresa":aIdEmpresa,
										"aDetail":Detail});
										inst.Save_GuiaRemis_Factura(pa);
									}
							}});
						}else{
							(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");
						}						
					});
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Save_GuiaRemis_Factura=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Save_GuiaRemis_Factura",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();console.log(e);
				if(e){var inst=new ClassLRVenta();
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					alertify.success("PROCESO CORRECTO.");inst.verificar_datos_ReportVenta();
					var inst2=new ClassImpresion();
					var IdAlm=$("#IdAlmRepVenta").html();
					var IdEmpresa=params[0]["aIdEmpresa"];
					inst2.getList_Datos_ReportVentta_Print([e["IdVenta"],IdAlm,IdEmpresa]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Anular_Datos_Factura=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Anular_Datos_Factura",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();console.log(e);
				if(e["Val"]){var inst=new ClassLRVenta();console.log(e["Result"]);
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					alertify.success("PROCESO CORRECTO.");inst.verificar_datos_ReportVenta();
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_Gnerar_Factura_GuiaRemision=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Gnerar_Factura_GuiaRemision",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassLRVenta();
				var Venta=e["Venta"],Detalle=e["Detalle"],SN=e["SN"],TPago=e["TPago"],TipoDoc=e["TipoDoc"],TipoBien=e["TipoBien"];
				if(Venta.length>0 && Detalle.length>0){
					$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Factura_GuiaR);
					$('#myModal').modal({keyboard: false,backdrop:false});
					$('.modal-dialog').draggable({handle: ".modal-header"});
					$("#txtSerie_GRFA").prop("value",SN[0]);
					$("#txtNumero_GRFA").prop("value",SN[1]);
					$("#cboTipoBien_ProcVenta").chosen({width: "100%"});$("#cboTipoDoc_ProcVenta").chosen({width: "100%"});
						
					$("#txtRuc_GRFA").prop("value",Venta[0]["Ruc"]);
					$("#txtRS_GRFA").prop("value",Venta[0]["RazonSocial"]);
					$("#txtDireccion_GRFA").prop("value",Venta[0]["Direccion"]);
					$("#txtFactura_GRFA").prop("value",Venta[0]["Serie"]+' - '+Venta[0]["Numero"]);
					if(TipoDoc.length>0){
						$("#cboTipoDoc_ProcVenta").empty();
						for(var i=0;i<TipoDoc.length;i++){$("#cboTipoDoc_ProcVenta").append('<option value="'+TipoDoc[i]["IdTipoDocumento"]+'">'+TipoDoc[i]["TipoDocumento"]+'</option>');}
						$("#cboTipoDoc_ProcVenta").chosen({width: "100%"});
						$('#cboTipoDoc_ProcVenta').val("3").trigger('chosen:updated');
					}
					if(TipoBien.length>0){
						$("#cboTipoBien_ProcVenta").empty();
						for(var i=0;i<TipoBien.length;i++){$("#cboTipoBien_ProcVenta").append('<option value="'+TipoBien[i]["IdTipoBien"]+'">'+TipoBien[i]["TipoBien"]+'</option>');}
						$("#cboTipoBien_ProcVenta").chosen({width: "100%"});
						$('#cboTipoBien_ProcVenta').val(TipoBien[0]["IdTipoBien"]).trigger('chosen:updated');
					}
					if(TPago.length>0){
						$("#cboCPago_ProcVenta").empty();
						for(var i=0;i<TPago.length;i++){$("#cboCPago_ProcVenta").append('<option value="'+TPago[i]["IdCredito"]+'">'+TPago[i]["Credito"]+'</option>');}
						$("#cboCPago_ProcVenta").chosen({width: "100%"});
						$('#cboCPago_ProcVenta').val("0").trigger('chosen:updated');
					}else{
						$("#cboCPago_ProcVenta").empty();
						$("#cboCPago_ProcVenta").append('<option value="0">Contado</option>');
						$("#cboCPago_ProcVenta").chosen({width: "100%"});
						$('#cboCPago_ProcVenta').val("0").trigger('chosen:updated');
					}
					
					if(parseInt(Venta[0]["RazonSocial"])===0){$("#IdChkIGVPVe").prop("checked",true);}else{$("#IdChkIGVPVe").prop("checked",false);}
					$('#cboTipoBien_ProcVenta').val(Venta[0]["IdTipoBien"]).trigger('chosen:updated');
					$('#cboTipoDoc_ProcVenta').val(Venta[0]["IdTipoDoc"]).trigger('chosen:updated');
					var tottl=0;
					if(Detalle.length>0){
						for(var i=0;i<Detalle.length;i++){
							var ids=Detalle[i]["IdVenta"]+'_'+Detalle[i]["IdDetalle"];
							tottl=parseFloat(tottl)+parseFloat(Detalle[i]["Importe"]);
							$('#IdTableDato_GRFA tbody').append('<tr>'+
								'<td>'+Detalle[i]["Cantidad"]+'</td>'+
								'<td>'+Detalle[i]["Unidad"]+'</td>'+
								'<td>'+Detalle[i]["Codigo"]+'</td>'+
								'<td>'+Detalle[i]["Producto"]+'</td>'+
								'<td>'+Detalle[i]["PUnitario"]+'</td>'+
								'<td>'+Detalle[i]["Dscto"]+'</td>'+
								'<td>'+Detalle[i]["Importe"]+'</td>'+
								'<td style="display:none">'+Detalle[i]["IdProducto"]+'</td>'+
							'</tr>');
						}
						$("#txtTotall_GRFA").prop("value",parseFloat(tottl).toFixed(2));
						inst.Sumar_fact_Convertido(tottl);
					}
					var IdAlm=$("#IdAlmRepVenta").html();
					var Alm=$("#AlmRepVenta").html();
					$("#btnSave_GRFA").on('click',function(e){
						var IdComprob=1;
						var aSerie=$("#txtSerie_GRFA").val();
						var aNumero=$("#txtNumero_GRFA").val();
						var aTotal=$("#txtTotall_GRFA").val();
						var aSubTotal=$("#txtSubTotal_ProcVenta").val();
						var aIGV=$("#txtIGV_ProcVenta").val();
						var IdPago=$("select#cboCPago_ProcVenta option:selected").val();
						
						var aRuc=$("#txtRuc_GRFA").val(),aRS=$("#txtRS_GRFA").val(),aDirec=$("#txtDireccion_GRFA").val();
						var NroFac=$("#txtFactura_GRFA").val();
						var Detail=[];
						var IdIGV=$("#IdChkIGVPVe").is(':checked') ? 1 : 0;
						var IdTipoDoc=$("select#cboTipoDoc_ProcVenta option:selected").val();
						var IdBien=$("select#cboTipoBien_ProcVenta option:selected").val();
			
						$("#IdTableDato_GRFA tbody tr").each(function (index){
							var aCantidad=$(this).find("td").eq(0).html();
							var aCodigo=$(this).find("td").eq(2).html();
							var aDescripcion=$(this).find("td").eq(3).html();
							var aPrecio=$(this).find("td").eq(4).html();
							var aDscto=$(this).find("td").eq(5).html();
							var aImporte=$(this).find("td").eq(6).html();
							var aIdprod=$(this).find("td").eq(7).html();
							
							Detail.push({"aCantidad":aCantidad,"aCodigo":aCodigo,"aDescripcion":aDescripcion,"aPrecio":aPrecio,"aDscto":aDscto,
										"aImporte":aImporte,"aIdprod":aIdprod});
						});
						if(aSerie!="" && aNumero!="" && IdAlm!="-1" && Detail.length>0 && aSubTotal!="" && aIGV!="" && aRuc!="" && aRS!="" && aDirec!=""){
							(function(){
								vex.defaultOptions.className = 'vex-theme-os';
							})();
							vex.dialog.confirm({ message:'Desea Guardar?', 
								callback: function(ee){
									if(ee){
										var pa=[];
										var FH=current_date();
										var FecCancel=sumar_Dia_Fecha(IdPago,FH);
										FecCancel=FecCancel.split('/')[2]+'-'+FecCancel.split('/')[1]+'-'+FecCancel.split('/')[0];
										var Obss='Generando Factura de Guia Remision';
										pa.push({"aIdComprob":IdComprob,"aSerie":aSerie,"aNumero":aNumero,"aIdCliente":"-1","aFechaCancel":FecCancel,
										"aTotaal":aTotal,"aSubTotal":aSubTotal,"aIGV":aIGV,"aObs":Obss,"aPago":"","aTipoV":IdPago,"aIdIGV":IdIGV,"aIdTipoDoc":IdTipoDoc,"aIdBien":IdBien,
										"aIdAlm":IdAlm,"aAlm":Alm,"aRuc":aRuc,"aRS":aRS,"aDireccion":aDirec,"aSon":'',"aNroFac":NroFac,"aIdVent":params[0],
										"aDetail":Detail});
										inst.Save_Factura_GuiaRemis(pa);
									}
							}});
						}else{
							(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");
						}						
					});
					$("#IdChkIGVPVe").on('click',function(){inst.Sumar_fact_Convertido(tottl);});
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
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
	this.Save_Factura_GuiaRemis=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Save_Factura_GuiaRemis",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){var inst=new ClassLRVenta();
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					alertify.success("PROCESO CORRECTO.");
					inst.verificar_datos_ReportVenta();
					var inst2=new ClassImpresion();
					var IdAlm=$("#IdAlmRepVenta").html();
					inst2.getList_Datos_ReportVentta_Print([e["IdVenta"],IdAlm]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}

	this.getList_Gnerar_Guia_Factura_Group=function(params,nfac){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Gnerar_Guia_Factura_Group",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassLRVenta();
				var Venta=e["Venta"],Detalle=e["Detalle"],SN=e["SN"],TipoDoc=e["TipoDoc"];
				//console.log(Detalle);
				if(Venta.length>0 && Detalle.length>0){
					$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_GuiaR_Factura_Group);
					$('#myModal').modal({keyboard: false,backdrop:false});
					$('.modal-dialog').draggable({handle: ".modal-header"});
					$("#txtSerie_GRFA").prop("value",SN[0]);
					$("#txtNumero_GRFA").prop("value",SN[1]);
					if(TipoDoc.length>0){
						$("#cboTipoDoc_ProcVenta").empty();
						for(var i=0;i<TipoDoc.length;i++){$("#cboTipoDoc_ProcVenta").append('<option value="'+TipoDoc[i]["IdTipoDocumento"]+'">'+TipoDoc[i]["TipoDocumento"]+'</option>');}
						$("#cboTipoDoc_ProcVenta").chosen({width: "100%"});
						$('#cboTipoDoc_ProcVenta').val("3").trigger('chosen:updated');
					}
					
					if(parseInt(Venta[0]["RazonSocial"])===0){$("#IdChkIGVPVe").prop("checked",true);}else{$("#IdChkIGVPVe").prop("checked",false);}
					$('#cboTipoBien_ProcVenta').val(Venta[0]["IdTipoBien"]).trigger('chosen:updated');
					$('#cboTipoDoc_ProcVenta').val(Venta[0]["IdTipoDoc"]).trigger('chosen:updated');
					
					$("#txtRuc_GRFA").prop("value",Venta[0]["Ruc"]);
					$("#txtRS_GRFA").prop("value",Venta[0]["RazonSocial"]);
					$("#txtDireccion_GRFA").prop("value",Venta[0]["Direccion"]);
					var aIdEmpresa=params[1][0]["aIdEmpresa"];
					var Facturr=params[1];
					$("#txtFactura_GRFA").prop("value",nfac);
					if(Detalle.length>0){
						var tottl=0;
						for(var i=0;i<Detalle.length;i++){
							var ids=Detalle[i]["IdVenta"]+'_'+Detalle[i]["IdDetalle"];
							tottl=parseFloat(tottl)+parseFloat(Detalle[i]["Importe"]);
							$('#IdTableDato_GRFA tbody').append('<tr>'+
								'<td>'+Detalle[i]["Cantidad"]+'</td>'+
								'<td>'+Detalle[i]["Unidad"]+'</td>'+
								'<td>'+Detalle[i]["Codigo"]+'</td>'+
								'<td>'+Detalle[i]["Producto"]+'</td>'+
								'<td>'+Detalle[i]["PUnitario"]+'</td>'+
								'<td>'+Detalle[i]["Importe"]+'</td>'+
								'<td style="display:none">'+Detalle[i]["IdProducto"]+'</td>'+
							'</tr>');
						}
						$("#txtTotall_GRFA").prop("value",parseFloat(tottl).toFixed(2));
					}
					var IdAlm=$("#IdAlmRepVenta").html();
					var Alm=$("#AlmRepVenta").html();
					$("#btnSave_GRFAGroup").on('click',function(e){
						var IdComprob=20;
						var aSerie=$("#txtSerie_GRFA").val();
						var aNumero=$("#txtNumero_GRFA").val();
						var aTotal=$("#txtTotall_GRFA").val();
						
						var aRuc=$("#txtRuc_GRFA").val(),aRS=$("#txtRS_GRFA").val(),aDirec=$("#txtDireccion_GRFA").val();
						var NroFac=$("#txtFactura_GRFA").val();
						var Detail=[];
						var Seriees=$("#txtFactura_GRFA").val();
						var IdIGV=0;
						var IdTipoDoc=$("select#cboTipoDoc_ProcVenta option:selected").val();
						
						$("#IdTableDato_GRFA tbody tr").each(function (index){
							var aCantidad=$(this).find("td").eq(0).html();
							var aUnidad=$(this).find("td").eq(1).html();
							var aCodigo=$(this).find("td").eq(2).html();
							var aDescripcion=$(this).find("td").eq(3).html();
							var aPrecio=$(this).find("td").eq(4).html();
							var aImporte=$(this).find("td").eq(5).html();
							var aIdprod=$(this).find("td").eq(6).html();
							
							Detail.push({"aCantidad":aCantidad,"aCodigo":aCodigo,"aDescripcion":aDescripcion,"aPrecio":aPrecio,"aUnidad":aUnidad,
										"aImporte":aImporte,"aIdprod":aIdprod});
						});
						if(aSerie!="" && aNumero!="" && IdAlm!="-1" && Detail.length>0){
							(function(){
								vex.defaultOptions.className = 'vex-theme-os';
							})();
							vex.dialog.confirm({ message:'Desea Guardar?', 
								callback: function(ee){
									if(ee){
										var pa=[];
										pa.push({"aIdComprob":IdComprob,"aSerie":aSerie,"aNumero":aNumero,"aIdCliente":"-1",
										"aTotaal":aTotal,"aSubTotal":aTotal,"aIGV":"0","aObs":"Generando de factura G.R."+Seriees,"aPago":"","aTipoV":"1",
										"aIdAlm":IdAlm,"aAlm":Alm,"aRuc":aRuc,"aRS":aRS,"aDireccion":aDirec,"aSon":'',"aNroFac":NroFac,
										"aIdIGV":IdIGV,"aIdTipoDoc":IdTipoDoc,"aIdEmpresa":aIdEmpresa,
										"aDetail":Detail,"aFact":Facturr});
										inst.Save_GuiaRemis_Factura_Group(pa);
									}
							}});
						}else{
							(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");
						}						
					});
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Save_GuiaRemis_Factura_Group=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"Save_GuiaRemis_Factura_Group",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){var inst=new ClassLRVenta();
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					alertify.success("PROCESO CORRECTO.");inst.verificar_datos_ReportVenta();
					var inst2=new ClassImpresion();
					var IdAlm=$("#IdAlmRepVenta").html();
					inst2.getList_Datos_ReportVentta_Print([e["IdVenta"],IdAlm]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
}
