<?php
	$controller = new MvcController();$pDatos=$controller->combo_Almacen_Venta();
	$IdAlmacen=-1;$Almacen="";
	$Comprobante=$pDatos["Comprobante"];
	$TipoDoc=$pDatos["TipoDoc"];
	$Empresa=$pDatos["Empresa"];
	$Alm=$pDatos["Alm"];
	if(count($Alm)>0){
		$IdAlmacen=$Alm[0]["IdAlmacen"];$Almacen=$Alm[0]["Almacen"];
	}
?>
		<label id="IdAlmRVenta" style="display:none"><?php  echo $IdAlmacen ?></label>
		<label id="AlmRVenta" style="display:none"><?php  echo $Almacen ?></label>
<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Registro Venta
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row">
				<div class="col-md-2 col-sm-2 col-xs-12">
					<div class="row center fondoProceso m-r-5">
						<div class="col-md-12 col-sm-12 col-xs-12 p-b-10">
							<span class="claTexto">Empresa</span></br>
							<select id="cboEmpresa_ProcVenta">
								<?php echo $Empresa; ?>
							</select>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-t-30 p-b-30">
							<span class="claEmpresa center" id="lblNameEmpresaV"></span>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-t-15 p-b-15">
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="row center fondoProceso m-r-5 m-l-5">
						<label id="lblIdCliente" style="display:none">-1</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<span class="claTexto">Tipo Doc</span></br>
							<select id="cboTipoDoc_ProcVenta"><?php echo $TipoDoc; ?></select>
						</div>
						<div class="col-md-5 col-sm-5 col-xs-8">
							<span class="claTexto">Nro Doc</span></br>
							<input type="text" class="form_input" id="txtRuc_ProcVenta" onkeypress="return NroEntero11D(event, this)">
						</div>
						<div class="col-md-3 col-sm-3 col-xs-4">
							<!--</br><button class="btnProceso" id="btnSearch_ProcVenta"><i class="fas fa-search-plus"></i> Buscar</button> -->
						</div>
						<div class="col-md-9 col-sm-9 col-xs-8 left">
							<span class="claTexto">R.S./Nombres</span></br>
							<textarea type="text" class="form_input " id="txtRS_ProcVenta" ></textarea>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-4">
							</br><button class="btnProceso" id="btnCliente_ProcVenta"><i class="fas fa-file"></i> Cliente</button>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 left">
							<span class="claTexto">Direccion</span>
							</br><textarea type="text" class="form_input" id="txtDireccion_ProcVenta"></textarea>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 left">
							<span class="claTexto">Email</span></br>
							<textarea type="text" class="form_input" id="txtEmail_ProcVenta"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="row center fondoProceso m-l-5">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<span class="claTexto">Comprobante</span></br>
							<select id="cboComprobante_ProcVenta"><?php echo $Comprobante; ?></select>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<span class="claTexto">Formato Impresion</span></br>
							<select id="cboFormato_ProcVenta">
								<option value="A4">A4</option>
								<option value="A5">A5</option>
								<option value="TICKET">TICKET</option>
							</select>
						</div>
						<!--<div class="col-md-5 col-sm-5 col-xs-5">
							<span class="claTexto">Serie</span></br>
							<input type="text" class="form_input claReadonly" id="txtSerie_ProcVenta" onkeypress="return NroEntero11D(event, this)" readonly>
						</div>
						<div class="col-md-5 col-sm-5 col-xs-5">
							<span class="claTexto">Numero</span></br>
							<input type="text" class="form_input" id="txtNumero_ProcVenta" onkeypress="return NroEntero11D(event, this)" readonly>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2">
							<span class="claTexto">Hab</span></br>
							<input type="checkbox" id="IdNumeroHabFB" class="chk2020">
						</div>-->
						<div class="col-md-12 col-sm-12 col-xs-12 p-t-5 p-b-5">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 p-2">
									<span class="claTexto">Nota Pedido</span></br>
									<input type="text" class="form_input claReadonly" id="txtDescripNP_ProcCompra" readonly>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 center p-2 m-t-10">
									<button class="btnProceso" id="btnNPVenta_ProcVenta"><i class="fas fa-search-plus"></i> Buscar</button>
								</div>
							</div>
						</div>
						<!--<div class="col-md-12 col-sm-12 col-xs-12">
							<span class="claTexto">Fecha Venta</span></br>
							<input type="text" class="form_input claReadonly center" id="txtFechaEmis_ProcVenta" readonly style="width: 100px;">
						</div>-->
						<div class="col-md-12 col-sm-12 col-xs-12 left">
							<span class="claTexto">Nro Guia</span></br>
							<input type="text" class="form_input" id="txtNroGuia_ProcVenta">
						</div>
						
					</div>
				</div>
			</div>
			<div class="row p-t-10">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row fondoProceso ">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label id="lblIdProducto" style="display:none">-1</label>
							<div class="col-md-1 col-sm-8 col-xs-8 p-2">
								<span class="claTexto">Codigo</span></br><input type="text" class="form_input" name="codigo" id="txtCodigo_ProcVenta">
							</div>
							<div class="col-md-1 col-sm-4 col-xs-4 p-2 center">
								<button class="btnProceso m-t-10" id="btnSearchProd_ProcVenta"><i class="fas fa-search-plus" ></i> Buscar</button>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12 p-2">
								<span class="claTexto">Producto</span></br>
								<input type="text" class="form_input claReadonly" id="txtProducto_ProcVenta" readonly>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6 p-2">
								<span class="claTexto">Familia</span></br>
								<input type="text" class="form_input claReadonly" id="txtModelo_ProcVenta" readonly>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6 p-2">
								<span class="claTexto">Marca</span></br>
								<input type="text" class="form_input claReadonly" id="txtMarca_ProcVenta" readonly>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6 p-2">
								<span class="claTexto">Unidad</span></br>
								<input type="text" class="form_input claReadonly" id="txtUnidad_ProcVenta" readonly>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-md-1 col-sm-3 col-xs-6 p-2 m-t-10">
								<span class="claTexto">Cantidad</span></br>
								<input type="text" class="form_input center" id="txtCantidad_ProcVenta" value="1" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<!--<div class="col-md-2 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Precio Compra</span></br>
								<input type="text" class="form_input" id="txtPCompra_ProcCompra" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div> -->
							<div class="col-md-2 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Precio Publico</span> <input type="radio" name="rbtTipoPrecioV" id="chkBtn1" value="1" class="chk2020" checked></br>
								<input type="text" class="form_input" id="txtPPublico_ProcVenta" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Precio Base</span> <input type="radio" name="rbtTipoPrecioV" id="chkBtn2" value="2" class="chk2020"></br>
								<input type="text" class="form_input" id="txtPMenor_ProcVenta" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Precio Dist</span> <input type="radio" name="rbtTipoPrecioV" id="chkBtn3" value="3" class="chk2020"></br>
								<input type="text" class="form_input" id="txtPMayor_ProcVenta" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2 m-t-10">
								<span class="claTexto">Importe</span></br>
								<input type="text" class="form_input claReadonly center" id="txtImporte_ProcVenta" value="0" onkeypress="return Valido_Numero_Decimal(event, this)" readonly>
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2 m-t-10">
								<span class="claTexto">Stock</span></br>
								<input type="text" class="form_input claReadonly center" id="txtStock_ProcVenta" onkeypress="return Valido_Numero_Decimal(event, this)" readonly>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2 right">
								<button class="btnProceso m-t-10" id="btnAdd_ProcVenta"><i class="fas fa-plus-square" ></i> Agregar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row p-t-10">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row fondoProceso">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContent_DetailC_ProcVenta">
									<table class="claTableProceso" id="IdTable_DetalleC_ProcVenta">
										<thead><tr>
											<th>X</th><th>Cant.</th><th>Codigo</th><th>Descripcion</th><th>Unidad</th><th>P.Unitario</th><th>Importe</th>
											<th>Tipo Precio</th>
											<th style="display:none">IdPrd</th><th style="display:none">IdNP</th><th style="display:none">IdTipoPrecio</th>
											<th>Editar</th>
										</tr></thead>
										<tbody></tbody>
									</table>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-t-5">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										Son</br><input type="text" class="form_input claReadonly" id="txtSon_ProcVenta" readonly>
									</div>
								</div>
								<div class="row">
									<!-- <div class="col-md-6 col-sm-6 col-xs-6">
										<input type="radio" name="rbtTipoPagoV" id="rbtTipoPagoContado" value="1" class="chk2020" checked> CONTADO
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<input type="radio" name="rbtTipoPagoV" id="rbtTipoPagoCredito" value="2" class="chk2020"> CREDITO
									</div> -->
									<div class="col-md-6 col-sm-6 col-xs-6">
										<select id="comboMetodoPago">
											<option value="1">CONTADO</option>
											<option value="2">CREDITO</option>
											<option value="3">IZIPAY</option>
											<option value="4">POS</option>
										</select>
									</div>
								</div>
								<div class="row center">
									<div class="col-md-12 col-sm-12 col-xs-12" style="display:none" id="IdFechaPagoVenta">
										Fecha Pago</br><input type="text" class="form_input claReadonly center" id="txtFechaPago_ProcVenta" readonly style="width: 100px;">
									</div>
								</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<div class="row center">
									Exonerar IGV</br><input type="checkbox" id="IdChkIGVPVe" checked="" class="chk2020 claIGVPVenta">
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6 right">Sub Total</div>							
									<div class="col-md-6 col-sm-6 col-xs-6">
										<input type="text" class="form_input claReadonly center" id="txtSubTotal_ProcVenta" readonly>
									</div>
								</div>
								<div class="row p-t-5">
									<div class="col-md-6 col-sm-6 col-xs-6 right">I.G.V.</div>							
									<div class="col-md-6 col-sm-6 col-xs-6">
										<input type="text" class="form_input claReadonly center" id="txtIGV_ProcVenta" readonly>
									</div>
								</div>
								<div class="row p-t-5">
									<div class="col-md-6 col-sm-6 col-xs-6 right">Total</div>							
									<div class="col-md-6 col-sm-6 col-xs-6">
										<input type="text" class="form_input claReadonly center" id="txtTotal_ProcVenta" readonly>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-t-5">
							<div class="col-md-6 col-sm-6 col-xs-12">
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="row">
									<div class="col-md-2 col-sm-2 col-xs-2 right">RECIBIDO</div>							
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="number" class="form_input center" id="txtMontoRecibido" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-2 right">VUELTO</div>							
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="number" class="form_input center" id="txtVuelto" readonly>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row p-t-10">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row center">
						<div class="col-md-6 col-sm-6 col-xs-6 center">
							<button class="btnGuardar" id="btnClear_ProcVenta"><i class="fas fa-trash" ></i> Limpiar</button>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 center">
							<button class="btnGuardar btn-verde" id="btnComprar_ProcVenta"><i class="fas fa-save" ></i> Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="./views/procesos/RegistroVenta.js"></script>
<script src="./views/procesos/RegistroPrint.js"></script>