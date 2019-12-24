<?php
	$controller = new MvcController();$pDatos=$controller->combo_Almacen_Id();
	$IdAlmacen=-1;$Almacen="";
	if(count($pDatos)>0){
		$IdAlmacen=$pDatos[0]["IdAlmacen"];$Almacen=$pDatos[0]["Almacen"];
	}
?>
		<label id="IdAlmRComp" style="display:none"><?php  echo $IdAlmacen ?></label>
		<label id="AlmRComp" style="display:none"><?php  echo $Almacen ?></label>
<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Registro Compra
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="row fondoProceso">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<span class="claTexto">Proveedor</span></br>
									<select id="cboProveedor_ProcCompra"><option value="-1">Seleccione</option></select>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-8 col-sm-8 col-xs-8">
									<span class="claTexto">Ruc</span></br>
									<input type="text" class="form_input claReadonly" id="txtRuc_ProcCompra" readonly>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4 right">
									</br><button class="btnProceso" id="btnNewProveedor_ProcCompra"><i class="fas fa-file"></i> Nuevo</button>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<span class="claTexto">Razon Social</span></br>
									<textarea type="text" class="form_input claReadonly" id="txtRSocial_ProcCompra" readonly></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-12"></div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="row center fondoProceso">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<span class="claTexto">Comprobante</span></br>
							<select id="cboComprobante_ProcCompra"><option value="-1">Seleccione</option></select>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<span class="claTexto">Serie</span></br>
							<input type="text" class="form_input" id="txtSerie_ProcCompra">
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<span class="claTexto">Numero</span></br>
							<input type="text" class="form_input" id="txtNumero_ProcCompra">
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<span class="claTexto">Fecha Compra</span></br>
							<input type="text" class="form_input claReadonly center" id="txtFechaEmision_ProcCompra" readonly style="width: 100px;">
						</div>
					</div>
				</div>
			</div>
			<div class="row p-t-10">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row fondoProceso">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label id="lblIdProductoProcCompra" style="display:none">-1</label>
							<div class="col-md-1 col-sm-8 col-xs-8 p-2">
								<span class="claTexto">Codigo</span></br><input type="text" class="form_input" id="txtCodigo_ProcCompra">
							</div>
							<div class="col-md-1 col-sm-4 col-xs-4 p-2 center">
								<button class="btnProceso m-t-10" id="btnmasProducto_ProcCompra"><i class="fas fa-search-plus" ></i> Buscar</button>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12 p-2">
								<span class="claTexto">Producto</span></br><input type="text" class="form_input claReadonly" id="txtProducto_ProcCompra" readonly>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6 p-2 center">
								<button class="btnProceso m-t-10" id="btnNewProduc_ProcCompra"><i class="fas fa-search-plus" ></i> Nuevo</button>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6 p-2">
								<span class="claTexto">Marca</span></br><input type="text" class="form_input claReadonly" id="txtMarca_ProcCompra" readonly>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6 p-2">
								<span class="claTexto">Modelo</span></br><input type="text" class="form_input claReadonly" id="txtModelo_ProcCompra" readonly>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-md-2 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Unidad</span></br>
								<select id="cboUnidad_ProcCompra"></select>
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Cantidad</span></br><input type="text" class="form_input center" id="txtCantidad_ProcCompra" value="1" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">P. Compra</span></br><input type="text" class="form_input" id="txtPCompra_ProcCompra" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Importe</span></br><input type="text" class="form_input claReadonly center" id="txtImporte_ProcCompra" value="0" onkeypress="return Valido_Numero_Decimal(event, this)" readonly>
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Prec. Publico</span></br><input type="text" class="form_input" id="txtPPublico_ProcCompra" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Prec. Base</span></br><input type="text" class="form_input" id="txtPMenor_ProcCompra" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Prec. Dist.</span></br><input type="text" class="form_input" id="txtPMayor_ProcCompra" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Stock</span></br><input type="text" class="form_input claReadonly" id="txtStock_ProcCompra" onkeypress="return Valido_Numero_Decimal(event, this)" readonly>
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2" style="display:none">
								<span class="claTexto">T.C.</span></br><input type="text" class="form_input" id="txtTC_ProcCompra" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2 right">
								<button class="btnProceso m-t-10" id="btnAdd_ProcCompra"><i class="fas fa-plus-square" ></i> Agregar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row p-t-10">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive" id="IdContent_DetailC_ProcCompra">
							<table class="claTableProceso" id="IdTable_DetalleC_ProcCompra">
								<thead><tr>
									<th>X</th>
									<th>Cant.</th>
									<th>Codigo</th>
									<th>Descripcion</th>
									<th>Unidad</th>
									<th>P.Compra</th>
									<th>Importe</th>
									<th>P. Publico</th>
									<th>P. Base</th>
									<th>P. Dist</th>
									<th style="display:none">IdPrd</th>
									<th style="display:none">T.C.</th>
									<th style="display:none">IdUni</th>
								</tr></thead>
								<tbody></tbody>
							</table>
					</div>
				</div>
			</div>
			<div class="row p-t-10">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row fondoProceso">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-4">
									<input type="radio" name="rbtTipoPago" id="rbtTipoPagoContado" value="1" class="chk2020" checked> CONTADO
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<input type="radio" name="rbtTipoPago" id="rbtTipoPagoCredito" value="2" class="chk2020"> CREDITO
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<input type="radio" name="rbtTipoPago" id="rbtTipoPagoConsig" value="3" class="chk2020"> CONSIGNACION
								</div>
							</div>
							<div class="row center">
								<div class="row center" id="IdFechaPagoCompra" style="display:none" >
									<div class="col-md-6 col-sm-6 col-xs-12">
										Fecha Pago</br><input type="text" class="form_input claReadonly center" id="txtFechaPago_ProcCompra" readonly style="width: 100px;">
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										Nro Dias</br><input type="text" value="0" class="form_input claReadonly center" id="IdNroDiasFPCompra" readonly style="width: 100px;">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<div class="row center">
								Incluir IGV</br><input type="checkbox" id="IdChkIGVPCompra" class="chk2020 claIGVPVenta">
							</div>
							<div class="row center">
								Moneda</br><select id="cboMoneda_ProcCompra"><option value="1">S/</option><option value="2">$</option></select>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 right">Sub Total</div>							
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input type="text" class="form_input claReadonly center" id="txtSubTotal_ProcCompra" readonly>
								</div>
							</div>
							<div class="row p-t-5">
								<div class="col-md-6 col-sm-6 col-xs-6 right">I.G.V.</div>							
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input type="text" class="form_input claReadonly center" id="txtIGV_ProcCompra" readonly>
								</div>
							</div>
							<div class="row p-t-5">
								<div class="col-md-6 col-sm-6 col-xs-6 right">Total</div>							
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input type="text" class="form_input claReadonly center" id="txtTotal_ProcCompra" readonly>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row p-t-10">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row center">
						<button class="btnGuardar btn-verde" id="btnComprar_ProcCompra"><i class="fas fa-save" ></i> Comprar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<script src="./views/procesos/RegistroCompra.js"></script>
