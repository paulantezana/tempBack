$(window).on('load',function(){var inst=new ClassMovAlm();$("#IdAlmacenPri").css("display","none");
	
	$("#cboAlmacen_ProcMovAlm").empty();$("#cboAlmacen_ProcMovAlm").append('<option value="-1">Seleccione</option>');
	$("#cboAlmacen_ProcMovAlm").chosen({width: "100%"});
	$("#cboAlmacenD_ProcMovAlm").empty();$("#cboAlmacenD_ProcMovAlm").append('<option value="-1">Seleccione</option>');
	$("#cboAlmacenD_ProcMovAlm").chosen({width: "100%"});
	inst.getList_combo_MovAlm();
	
	$("#btnSearchProd_MovAlm").on('click',function(e){inst.Build_Modal_Productos_MovAlm();});
	$("#btnClear_MovAlm").on('click',function(e){inst.Clear_AddMovAlm();});
	$("#cboAlmacen_ProcMovAlm").on('change',function(){
		inst.Clear_AddMovAlm();
	});
	$("#btnAdd_MovAlm").on('click',function(e){
		var IdOri=$("select#cboAlmacen_ProcMovAlm option:selected").val();
		var IdDes=$("select#cboAlmacenD_ProcMovAlm option:selected").val();
		if(IdOri!="-1"){
			if(IdDes!="-1"){
				if(IdOri!=IdDes){
					var IdProd=$("#lblIdProductoMovAlm").html();
					var Cant=$("#txtCantidad_MovAlm").val();
					var Cod=$("#txtCodigo_MovAlm").val();
					var producto=$("#txtProducto_MovAlm").val();
					var PU=$("#txtPMayor_MovAlm").val();
					var Importe=$("#txtImporte_MovAlm").val();
					var Unidad=$("#txtUnidad_MovAlm").val();
					if(IdProd!="-1" && Cant!="" && Cod!="" && producto!="" && PU!="" && Importe!=""){
						inst.Build_Detail_Add_MovAlm([Cant,Cod,producto,PU,Importe,IdProd,Unidad]);
						inst.Clear_Detail_AddMovAlm();
					}else{
						(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Datos.");
					}
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Deben ser almacenes Destintos.");
				}
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione Almacen Destino.");
			}
		}else{
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione Almacen Origen.");
		}
	});
	$("#txtCantidad_MovAlm").focusout(function(){inst.Calcular_Importe_MovAlm();});
	$("#txtCantidad_MovAlm").keyup(function (e){if(e.which == 13){$("#txtPMayor_MovAlm").focus();}});
	$("#txtPMayor_MovAlm").focusout(function(){inst.Calcular_Importe_MovAlm();});
	$("#txtPMayor_MovAlm").keyup(function (e){if(e.which == 13){$("#txtImporte_MovAlm").focus();}});
	$("#btnComprar_MovAlm").on('click',function(e){
		var IdOri=$("select#cboAlmacen_ProcMovAlm option:selected").val();
		var IdDes=$("select#cboAlmacenD_ProcMovAlm option:selected").val();
		if(IdOri!="-1"){
			if(IdDes!="-1"){
				if(IdOri!=IdDes){
					var Desc=$("#txtDescripcion_ProcMovAlm").val();
					var Totaal=$("#txtTotal_MovAlm").val();
					var SubTotal=0;
					var IGV=0;
					var AlmOri=$("select#cboAlmacen_ProcMovAlm option:selected").text();
					var AlmDes=$("select#cboAlmacenD_ProcMovAlm option:selected").text();
					var Detail=[];
					$("#IdTable_DetalleC_MovAlm tbody tr").each(function (index){
						var aCantidad=$(this).find("td").eq(1).html();
						var aCodigo=$(this).find("td").eq(2).html();
						var aDescripcion=$(this).find("td").eq(3).html();
						var aUnidad=$(this).find("td").eq(4).html();
						var aPrecio=$(this).find("td").eq(5).html();
						var aImporte=$(this).find("td").eq(6).html();
						var aIdprod=$(this).find("td").eq(7).html();
						Detail.push({"aCantidad":aCantidad,"aCodigo":aCodigo,"aDescripcion":aDescripcion,"aPrecio":aPrecio,"aUnidad":aUnidad,"aImporte":aImporte,"aIdprod":aIdprod});
					});
					if(Detail.length>0 && Totaal!=""){
						(function(){
							vex.defaultOptions.className = 'vex-theme-os';
						})();
						vex.dialog.confirm({ message:'Desea Guardar?', 
							callback: function(ee){
								if(ee){
									var pa=[];
									pa.push({"aTotaal":Totaal,"aDesc":Desc,"aSubTotal":SubTotal,"aIGV":IGV,
									"aIdOri":IdOri,"aAlmOri":AlmOri,"aIdDes":IdDes,"aAlmDes":AlmDes,
									"aDetail":Detail});
									inst.Save_Datos_MovAlm(pa);
								}
						}});
					}else{
						(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Agregar Detalles.");
					}
				}else{
					(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Deben ser almacenes Destintos.");
				}
			}else{
				(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione Almacen Destino.");
			}
		}else{
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione Almacen Origen.");
		}
	});
		
});
function ClassMovAlm(){
	this.getList_combo_MovAlm=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_combo_MovAlm"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var Almacen=e;var inst=new ClassMovAlm();
				if(Almacen.length>0){
					$("#cboAlmacen_ProcMovAlm").empty();$("#cboAlmacen_ProcMovAlm").append('<option value="-1">Seleccione</option>');
					$("#cboAlmacenD_ProcMovAlm").empty();$("#cboAlmacenD_ProcMovAlm").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<Almacen.length;i++){
						$("#cboAlmacen_ProcMovAlm").append('<option value="'+Almacen[i]["IdAlmacen"]+'">'+Almacen[i]["Almacen"]+'</option>');
						$("#cboAlmacenD_ProcMovAlm").append('<option value="'+Almacen[i]["IdAlmacen"]+'">'+Almacen[i]["Almacen"]+'</option>');
					}
					$("#cboAlmacen_ProcMovAlm").chosen({width: "100%"});
					$('#cboAlmacen_ProcMovAlm').val("-1").trigger('chosen:updated');
					$("#cboAlmacenD_ProcMovAlm").chosen({width: "100%"});
					$('#cboAlmacenD_ProcMovAlm').val("-1").trigger('chosen:updated');
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Modal_Productos_MovAlm=function(){var inst=new ClassMovAlm();
		var IdAlm=$("select#cboAlmacen_ProcMovAlm option:selected").val();
		if(IdAlm!="-1"){console.log(IdAlm);
			$("#modal_Manten").html("");$("#modal_Manten").html(Form_Mante_Productos_Modal_MovAlm);
			$('#myModal').modal({keyboard: false,backdrop:false});
			$('.modal-dialog').draggable({handle: ".modal-header"});
			inst.getList_Productos_IdAlm([IdAlm]);
		}else{
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione Almacen Origen.");
		}
	}
	this.getList_Productos_IdAlm=function(params){var inst=new ClassMovAlm();
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Productos_IdAlm",array:params},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e;
				if(Dato.length>0){
					$("#IdTableproduct_MovALm tbody").html("");		
					for(var i=0;i<Dato.length;i++){
						var ids=Dato[i]["IdProducto"]+'_'+Dato[i]["IdUnidad"];
						$('#IdTableproduct_MovALm tbody').append('<tr id="idtr_'+ids+'">'+
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
						var IdAlm=$("select#cboAlmacen_ProcMovAlm option:selected").val();
						inst.getList_Producto_Id_modal_NP([IdAlm,idP],0);
					});
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.getList_Producto_Id_modal_NP=function(params,pTipo){var inst=new ClassMovAlm();
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Producto_Id",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();Producto=e;console.log(Producto);
				if(Producto.length>0){
					$("#txtCodigo_MovAlm").prop("value",Producto[0]["Codigo"]);
					$("#txtProducto_MovAlm").prop("value",Producto[0]["Producto"]);
					$("#txtUnidad_MovAlm").prop("value",Producto[0]["Unidad"]);
					$("#txtPMayor_MovAlm").prop("value",Producto[0]["PrecioBase"]);
					$("#lblIdProductoMovAlm").html(Producto[0]["IdProducto"]);
					inst.Calcular_Importe_MovAlm();
					if(parseInt(pTipo)===1){
						
					}else{
						$("#txtCantidad_MovAlm").prop("value","1");
						$('#myModal').modal('hide');$('#modal_Manten').html("");
						$(".modal-open").removeClass('modal-open');
					}
					$("#txtCantidad_MovAlm").focus();
				}else{
					$("#lblIdProductoMovAlm").html("-1");
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Calcular_Importe_MovAlm=function(){
		var Cantid=$("#txtCantidad_MovAlm").val();
		var PU=$("#txtPMayor_MovAlm").val();
		if(Cantid!="" && PU!=""){
			var Totl=parseFloat(PU)*parseFloat(Cantid);
			$("#txtImporte_MovAlm").prop("value",parseFloat(Totl).toFixed(2));
		}else{
			$("#txtImporte_MovAlm").prop("value","");
		}
	}
	this.Build_Detail_Add_MovAlm=function(Datos){var inst=new ClassMovAlm();//[Cant,Cod,producto,PU,Importe,IdProd,Unidad]
		$('#IdTable_DetalleC_MovAlm tbody').append('<tr>'+
			'<td id="delDetailAddMovAlm_0">'+
				'<i class="fas fa-times-circle f-20"></i>'+
			'</td>'+
			'<td>'+Datos[0]+'</td>'+
			'<td>'+Datos[1]+'</td>'+
			'<td>'+Datos[2]+'</td>'+
			'<td>'+Datos[6]+'</td>'+
			'<td>'+Datos[3]+'</td>'+
			'<td>'+Datos[4]+'</td>'+
			'<td style="display:none">'+Datos[5]+'</td>'+
		'</tr>');
		inst.TotalMonto_Table_DetailMovAlm();
		$('#IdTable_DetalleC_MovAlm tbody').unbind("click");
		$('#IdTable_DetalleC_MovAlm tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='delDetailAddMovAlm'){
				var add=$(this).parent("tr:first");
				add.remove();
				inst.TotalMonto_Table_DetailMovAlm();
			}
		});
	}
	this.TotalMonto_Table_DetailMovAlm=function(){
		var TotaMon=0.00;
		$("#IdTable_DetalleC_MovAlm tbody tr").each(function (index){
			var importe=$(this).find("td").eq(6).html();
			TotaMon=parseFloat(TotaMon)+parseFloat(importe);
		});
		$("#txtTotal_MovAlm").prop("value",parseFloat(TotaMon).toFixed(2));
	}
	this.Clear_Detail_AddMovAlm=function(){
		$("#lblIdProductoMovAlm").html("-1");
		$("#txtImporte_MovAlm").prop("value","0.00");
		$("#txtPMayor_MovAlm").prop("value","0");
		$("#txtCantidad_MovAlm").prop("value","1");
		$("#txtCodigo_MovAlm").prop("value","");
		$("#txtProducto_MovAlm").prop("value","");
	}
	this.Clear_AddMovAlm=function(){var inst=new ClassMovAlm();
		$('#IdTable_DetalleC_MovAlm tbody').html("");
		inst.Clear_Detail_AddMovAlm();
	}
	this.Save_Datos_MovAlm=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"Save_Datos_MovAlm",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassMovAlm();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					inst.Clear_AddMovAlm();
					$("#txtDescripcion_ProcMovAlm").prop("value","");
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}				
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
}




