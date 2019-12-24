var ListaProductos=[];
var ListaProductosEspeciales=[];
var IdAlmacen;
var teclaGuardada;
var IdProductEspecial=[];
$(window).on('load',function(){
	$("#IdAlmacenPri").css("display","none");
    var Alm=$("#AlmRVenta").html();
    $("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	IdAlmacen=$("#IdAlmRVenta").html();
	
	var FeH=current_date();
	RecuperarProductos(IdAlmacen);
	$("#codigo_buscar").keyup(function (e){
		//console.log(e.target.value);
		if(e.which == 13){
			let codigoAux=e.target.value;
			
			if (codigoAux.length==0) {
				$('#botonGuardar').focus();
				
				return;
			}
			if (codigoAux.length>4) {
				BuscarPorCodigo(e.target.value);
			}
			
		}
	});
	$("#nombre_marca").keyup(function (e){
		//console.log(e.target.value);
		if(e.which == 13){
			let codigoAux=e.target.value;
			if (codigoAux.length==0) {
				$('#botonGuardar').focus();
				return;
			}
		}
	});
	$("input[name='tipoPago']").change(function(e){
		
		if (e.target.id=='pagoTarjeta') {
			$('#efectivoCambio').hide();
		}else{
			$('#efectivoCambio').show();
		}
	});
	$("#nroDocumento").keyup(function(e){
		if(e.which == 13){
			VerificarNroRuc();
		}
	});
	$(document).keyup(function (e) {
		let tecla=e.which;
		//console.log(tecla);
		if (tecla==113) {//tecla f2
			$('#nombre_marca').focus();
			return;
		}
		// if (teclaGuardada && tecla==16) {
		// 	GuardarVenta();
		// 	return;
		// }
		if (tecla==13) {
			let focused = $(':focus');
			console.log(focused);
			if (focused.length==0) {
				$('#botonGuardar').focus();
			}
		}
		
	});
	$(document).keydown(function(e){
		if(e.which == 112){
			$('#codigo_buscar').focus();
			e.preventDefault();
			return;
		}
	});
	$('#modalNuevo').on('shown.bs.modal', function () {
		$('#newCantidad').focus();
		RecuperarProductosEspeciales();
	});
	// $('#modalNuevo').on('hidden.bs.modal', function () {
		
	// });
	$("#newCantidad").keyup(function(e){
		if(e.which == 13){
			$('#newDescripcion').focus();
		}
	});
	$("#newDescripcion").keyup(function(e){
		if(e.which == 13){
			$('#newPrecioUnitario').focus();
		}
	});
	$("#newPrecioUnitario").keyup(function(e){
		if(e.which == 13){
			AgregarProductoNuevo();
		}
	});
});
function RecuperarProductos(IdAlm){
    $.blockUI();
	$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"RecuperarListaProductos",array:IdAlm},
		async:true,dataType:"json",success:function(productos){$.unblockUI();
            
			ListaProductos=productos;
				//busqueda de productos
			// let source  = [ ];
			// for(var i = 0; i < ListaProductos.length; ++i) {
			// 	source.push({ label: ListaProductos[i].descripcion, id:ListaProductos[i].IdProducto });
			// }
			$( "#nombre_marca" ).autocomplete({
				source: ListaProductos,
				select: function( event, ui ) {
					//console.log(ui);
					//console.log(event);
					AgregarFila(ui.item);
					$(this).val("");
    				event.preventDefault();
				}
			});
		},error:function(jqXHR,textStatus,errorMessage){
			console.log(jqXHR.responseText+errorMessage);
		}
	});
}
function BuscarPorCodigo(codigo){
	const resultado = ListaProductos.find( Producto => Producto.Codigo === codigo );
	if (resultado==null) {
		alertify.error("No existe ");
		return; 
	}
	AgregarFila(resultado);
}
function AgregarFila(producto){console.log(producto);
	nuevo=false;
	//verificamos si existe
		$("#tablaCarritoProductos tbody tr").each(function (index){
			var aIdprod=$(this).find("td").eq(8).html();//la columna del id producto
			if(producto["IdProducto"]===aIdprod){
				nuevo=true;
				let cantidad=$(this).find("td").eq(0).find('input').val();
				let precioUnit=$(this).find("td").eq(5).find('input').val();
				cantidad++;
				let importe=parseFloat(cantidad*(parseFloat(precioUnit))).toFixed(2);
				$(this).find("td").eq(0).find('input').val(cantidad);
				
				$(this).find("td").eq(6).html(importe);
				calcularMontoTotal();
			}
		});
	$("#codigo_buscar").prop("value","");
	
	if (nuevo) {return;}
	//en caso de que no exista agregamos
	let Stocks='';
	Stocks=RecuperarStockAlmacenes(producto["IdProducto"]);
	let claseOcultar=$("#checkFacturacion").is(':checked') ? '' : 'class="filaOcultar" style="display: none;"';
	$('#tablaCarritoProductos tbody').append('<tr>'+
		'<td><input type="number" class="form-control input-sm" value="1" onchange="modificarFila(this)"></td>'+
		'<td>'+producto["Codigo"]+'</td>'+
		'<td>'+producto["label"]+'</td> '+
		'<td>'+producto["Unidad"]+'</td> '+
		'<td>Costo:'+producto["PrecioCompra"]+' Mayor:'+producto["PrecioDistribuido"]+'</td> '+
		'<td><input class="form-control input-sm"  value="'+producto["PrecioPublico"]+'" onchange="modificarFila(this)"></td> '+
		'<td>'+producto["PrecioPublico"]+'</td> '+
		'<td '+claseOcultar+'>'+
			'<select class="custom-select custom-select-lg mb-3 comboTipoVenta" id="tipoGravado">'+
				'<option value="1">GRAVADO</option>'+
				'<option value="8">EXONERADO</option>'+
			'</select>'+
		'</td> '+
		'<td style="display:none;">'+producto["IdProducto"]+'</td> '+
		'<td><button type="button" class="btn btn-default boton-peque" onclick="eliminar_fila(this)"><i class="far fa-trash-alt"></i></button></td> '+
		'<td>'+Stocks+'</td> '+
	'</tr>');
	calcularMontoTotal();
}
function RecuperarStockAlmacenes(idProducto){
	let texto='';
	$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"ObtenerStockAlmacenes",array:idProducto},
		async:false,dataType:"json",success:function(e){
			
			e.forEach(element => {
				texto+=element['Simbolo']+':'+element['Stock']+'\n';
			});
			//console.log(texto);
			
		},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
	});
	return texto;
}
function modificarFila(fila){
	let aux=$(fila).parents('tr');
	let columna =aux.find('td');
	let cantidad=$(columna[0]).find('input').val();
	let precioUnit=$(columna[5]).find('input').val();
	let importe=parseFloat(cantidad*(parseFloat(precioUnit))).toFixed(2);
	$(columna[6]).html(importe);
	calcularMontoTotal();
}
function eliminar_fila(e){
	let aux=$(e).parents('tr');
	aux.remove();
	calcularMontoTotal();
}
function calcularMontoTotal(){
	let TotalMonto=0.00;
	$("#tablaCarritoProductos tbody tr").each(function (index){
		var importe=$(this).find("td").eq(6).html();
		TotalMonto=parseFloat(TotalMonto)+parseFloat(importe);
	});
	TotalMonto=parseFloat(TotalMonto).toFixed(2);
	$("#precioTotal").html(TotalMonto);
}
function VerificarDocumentos(){
	$("#nroDocumento").prop("value","");
	$("#razonSocial").prop("value","");
	$("#direccion").prop("value","");
	let IdComprob=$("select#comboComprobantes option:selected").val();
	let IdAlm=$("#IdAlmRVenta").html();
	if(IdAlm!="-1" && IdComprob!="-1"){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"getList_Documentos_Venta",array:[IdComprob]},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				var Doc=e["Doc"];
				if(Doc.length>0){
					$("#tipoDocumentos").empty();
					for(var i=0;i<Doc.length;i++){$("#tipoDocumentos").append('<option value="'+Doc[i]["Id"]+'">'+Doc[i]["Nombre"]+'</option>');}
					$("#tipoDocumentos").chosen({width: "100%"});
					$('#tipoDocumentos').val(Doc[0]["Id"]).trigger('chosen:updated');

				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
}
function ActivarCamposFacturacion(){
	let checkFacturacion=$("#checkFacturacion").is(':checked') ? true : false;
	if (checkFacturacion) {
		$('#camposFacturacion').show();
		$("#comboComprobantes").chosen({width: "100%"});
		$("#tipoDocumentos").chosen({width: "100%"});
		$("#tipoVenta").chosen({width: "100%"});
		$(".filaOcultar").show();
	}else{
		$('#camposFacturacion').hide();
		$(".filaOcultar").hide();
	}
}
function GuardarVenta(){
	let IdEmpresa=$("#comboEmpresa").val();
	let IdComprobante='10';//10=ticket
	let IdTipoDocumento='0';//0=varios
	let FormatoImpresion='TICKET';
	let IsFactura=$("#checkFacturacion").is(':checked') ? true : false;
	let Total=$("#precioTotal").html();
	let SubTotal=parseFloat(Total).toFixed(2)
	let IGV=parseFloat("0").toFixed(2);
	let aSon=CLetras(parseFloat(Total).toFixed(2),true,1);
	let Comprob="TICKET";
	let Ruc=$("#nroDocumento").val();
	let RazonSocial=$("#razonSocial").val();
	let Direccion=$("#direccion").val();	
	let IdTipoPago=$('input:radio[name=tipoPago]:checked').val();
	let Alm=$("#AlmRVenta").html();
	let FechaPago=current_date();
	let IdIGV=$("#checkFacturacion").is(':checked') ? 1 : 0;
	let Detail=[];
	let gravado=0;
	let exonerado=0;
	$("#tablaCarritoProductos tbody tr").each(function (index){
		let aCantidad=$(this).find("td").eq(0).find('input').val();
		let aCodigo=$(this).find("td").eq(1).html();
		let aDescripcion=$(this).find("td").eq(2).html();
		let aUnidad=$(this).find("td").eq(3).html();
		let aPU=$(this).find("td").eq(5).find('input').val();
		let aImporte=$(this).find("td").eq(6).html();
		let aIdTipoIgv=$(this).find("td").eq(7).find('select').val();
		let aIdProducto=$(this).find("td").eq(8).html();
		let aIdProductoEspecial=$(this).find("td").eq(9).html();
		if (aIdTipoIgv==1) {
			gravado+=parseFloat(aImporte);
		}else{
			exonerado+=parseFloat(aImporte);
		}
		Detail.push({"aCantidad":aCantidad,"aCodigo":aCodigo,"aDescripcion":aDescripcion,"aUnidad":aUnidad,"aPU":aPU,
						"aImporte":aImporte,"aIdProducto":aIdProducto,"aIdTipoPrecio":'1',"aIdNP":'-1',"aIdEspecial":aIdProductoEspecial,"aIdTipoIgv":aIdTipoIgv});
	});
	exonerado=parseFloat(exonerado).toFixed(2);
	if (IsFactura) {
		IdComprobante=parseInt($("select#comboComprobantes option:selected").val());
		IdTipoDocumento=parseInt($("select#tipoDocumentos option:selected").val());
		Comprob=$("select#comboComprobantes option:selected").text();

		//SubTotal=parseFloat(Total)/parseFloat(1.18);
		SubTotal=parseFloat(gravado)/parseFloat(1.18);
		IGV=parseFloat(SubTotal)*parseFloat(0.18);
		SubTotal=parseFloat(SubTotal).toFixed(2);
		IGV=parseFloat(IGV).toFixed(2);
	}
	if (IdAlmacen=="-1") {
		return;
	}
	if (Detail.length==0) {
		(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Agregar Detalle para venta.");
		return;
	}
	if (IdComprobante=="-1" || Total=="") {
		(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione Comprobante y datos.");
		return;
	}
	if ((IdTipoDocumento==6 && (Ruc=="" || RazonSocial=="" || Ruc.length!=11))|| (IdTipoDocumento==1 && (Ruc=="" || RazonSocial=="" || Ruc.length!=8))) {
		(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Completar Nro Doc y R.S.");
		return;
	}
	if(Ruc==''){Ruc=0;}
	if(RazonSocial==''){RazonSocial='Varios';}
	let mensajeAdicional='';
	if (exonerado>0) {
		mensajeAdicional='Esta venta incluye un monto exonerado <br>';
	}
	(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.confirm({ message:mensajeAdicional+' Desea Guardar?', 
		callback: function(ee){if(ee){
			var pa=[];
			FechaPago=FechaPago.split('/')[2]+'-'+FechaPago.split('/')[1]+'-'+FechaPago.split('/')[0];
			pa.push({"aIdEmpresa":IdEmpresa,"aIdComprob":IdComprobante,
			"aIdTipoDoc":IdTipoDocumento,"aRuc":Ruc,"aRS":RazonSocial,"aDireccion":Direccion,"aEmail":'',"aNroGuia":'',
			"aTotaal":Total,"aSubTotal":SubTotal,"aExonerado":exonerado,"aIGV":IGV,"aSon":aSon,"aIdIGV":IdIGV,"aIdTipoPago":IdTipoPago,"aComprob":Comprob,
			"aAlm":Alm,"aIdAlm":IdAlmacen,"aFechaPago":FechaPago,"aIdCliente":'-1',"aFormato":FormatoImpresion,"aDetail":Detail});
			EnviarDatos(pa,IdEmpresa,IdComprobante);
			console.log(pa);
		}}});				

}
function EnviarDatos(params,pIdEmpresa,IdComprob){
	$.blockUI();console.log(params);
	$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"Save_Datos_Venta",array:params},
		async:true,dataType:"json",success:function(e){$.unblockUI();console.log(e);
			if(e["Val"]){
				alertify.success("PROCESO CORRECTO. Venta Nro "+e["IdVenta"]);
				LimpiarDatos();
				if(parseInt(IdComprob)===1 || parseInt(IdComprob)===2){
					var fileName=e["Sunat"][0]["enlace"];
					if(fileName!=""){
						//var inst1=new ClassImpresion();
						//inst1.Create_Print_FacturaBoleta(e["IdVenta"],fileName);
						window.open(fileName);
						//$("#txtCodigo_ProcVenta").focus();
					}else{
						alertify.error("Factura electronica no se proceso. "+e["Sunat"][0]["error"]);
					}
				}else{
					var inst1=new ClassImpresion();
					inst1.getList_Print_Ticket([e["IdVenta"],pIdEmpresa]);
					//$("#txtCodigo_ProcVenta").focus();
				}
			}else{
				alertify.error("Error, Proceso Incorrecto. "+e["Sunat"][0]["error"]);
			}				
		},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
	});
}
function LimpiarDatos(){
	$("#codigo_buscar").prop("value","");
	$("#nombre_marca").prop("value","");
	$("#montoRecibido").prop("value","");
	$("#precioTotal").html("0.00");
	$("#vuelto").html("0.00");
	$("#tablaCarritoProductos tbody").html("");
	$("#checkFacturacion").prop("checked", false);
	$('#camposFacturacion').hide();
	$('#comboComprobantes').val('2').trigger('chosen:updated');
	$("#nroDocumento").prop("value","");
	$("#razonSocial").prop("value","");
	$("#direccion").prop("value","");

}
function VerificarNroRuc(){
	var IdTipoDoc=$("select#tipoDocumentos option:selected").val();
	var NroRuc=$("#nroDocumento").val();
	$("#razonSocial").prop("value","");
	$("#direccion").prop("value","");
	if(parseInt(IdTipoDoc)===6){//Ruc
		if(NroRuc.length===11){
			RecuperarRazonSocial(NroRuc);
		}
	}else if(parseInt(IdTipoDoc)===1){
		if(NroRuc.length===8){
			if(NroRuc!='12345678'){
				$.ajax({type:"POST",url:"./services/consulta.php",data: {"ndni":NroRuc},
					async:true,dataType:"json",success:function(e){
						if(e["success"]){
							var Dato=e["result"];console.log(Dato);
							$("#razonSocial").prop("value",Dato["Nombres"]+' '+Dato["ApellidoPaterno"]+' '+Dato["ApellidoMaterno"]);
						}
					},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
				});
			}else{
				$("#razonSocial").prop("value","General");
			}	
		}
	}
}
function RecuperarRazonSocial(NroRuc){
	$.ajax({
		url:'https://buscaruc.com/consultas/api.php',
		method:'get',
		dataType: 'JSON',
		async:false,
		data: {
		  ruc : NroRuc,
		},
		success: function(res) {console.log(res);
		  $('#razonSocial').val(res['socialReason']);
		  $('#direccion').val(res['fiscalAddress']);
		},
	});
}
function AgregarProductoNuevo(){
	let nuevoCodigo='nw001';
	let Descripcion=$('#newDescripcion').val();
	let cantidad=$('#newCantidad').val();
	let precioUnitario=$('#newPrecioUnitario').val();
	let importe=parseFloat(parseFloat(cantidad)*(parseFloat(precioUnitario))).toFixed(2);
	let idEspecialAux=0;
	if (IdProductEspecial['label']==Descripcion) {
		idEspecialAux=IdProductEspecial['id_producto_especial'];
	}
	let claseOcultar=$("#checkFacturacion").is(':checked') ? '' : 'class="filaOcultar" style="display: none;"';
	$('#tablaCarritoProductos tbody').append('<tr>'+
		'<td><input type="number" class="form-control input-sm" value="'+cantidad+'" onchange="modificarFila(this)"></td>'+
		'<td>'+nuevoCodigo+'</td>'+
		'<td>'+Descripcion+'</td> '+
		'<td>UNIDAD</td> '+
		'<td>Costo:'+producto["PrecioCompra"]+' Mayor:'+producto["PrecioDistribuido"]+'</td> '+
		'<td><input class="form-control input-sm"  value="'+precioUnitario+'" onchange="modificarFila(this)"></td> '+
		'<td>'+importe+'</td> '+
		'<td '+claseOcultar+'>'+
			'<select class="custom-select custom-select-lg mb-3 comboTipoVenta" id="tipoGravado">'+
				'<option value="1">GRAVADO</option>'+
				'<option value="8">EXONERADO</option>'+
			'</select>'+
		'</td> '+
		'<td style="display:none;">-1</td> '+
		'<td style="display:none;">'+idEspecialAux+'</td> '+
		'<td><button type="button" class="btn btn-default boton-peque" onclick="eliminar_fila(this)"><i class="far fa-trash-alt"></i></button></td> '+
	'</tr>');
	calcularMontoTotal();
	$("#modalNuevo").modal('hide');
	$("#newCantidad").val('');
	$("#newDescripcion").val('');
	$("#newPrecioUnitario").val('');
	$('#codigo_buscar').focus();
}
function ActualizarVuelto(){
	let total=$('#precioTotal').html();
	let recibido=$('#montoRecibido').val();
	let vuelto=0;
	vuelto=(parseFloat(recibido)-parseFloat(total)).toFixed(2);
	$('#vuelto').html(vuelto);
}
function RecuperarProductosEspeciales(){
	$.blockUI();
	$.ajax({type:"POST",url:url_ajax_request,data:{object:"objProceso",action:"RecuperarProductosEspeciales",array:IdAlmacen},
		async:true,dataType:"json",success:function(productos){$.unblockUI();
            //console.log(productos);
			ListaProductosEspeciales=productos;
				//busqueda de productos
			// let source  = [ ];
			// for(var i = 0; i < ListaProductos.length; ++i) {
			// 	source.push({ label: ListaProductos[i].descripcion, id:ListaProductos[i].IdProducto });
			// }
			$( "#newDescripcion" ).autocomplete({
				source: ListaProductosEspeciales,
				select: function( event, ui ) {
					console.log(ui.item);
					//console.log(event);
					IdProductEspecial=ui.item;
					// $(this).val("");
    				// event.preventDefault();
				}
			});
		},error:function(jqXHR,textStatus,errorMessage){
			console.log(jqXHR.responseText+errorMessage);
		}
	});
}