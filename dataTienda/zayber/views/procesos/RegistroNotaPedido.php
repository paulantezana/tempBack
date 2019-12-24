<?php
	$controller = new MvcController();$pDatos=$controller->combo_Almacen_Id();
	$IdAlmacen=-1;$Almacen="";
	if(count($pDatos)>0){
		$IdAlmacen=$pDatos[0]["IdAlmacen"];$Almacen=$pDatos[0]["Almacen"];
	}
?>
		<label id="IdAlmRNP" style="display:none"><?php  echo $IdAlmacen ?></label>
		<label id="AlmRNP" style="display:none"><?php  echo $Almacen ?></label>

<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Registro Nota de Pedido
		</div>
		<div class="col-md-12 col-xl-12 p-t-5" >
			<div class="row p-t-10">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row fondoProceso">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label id="lblIdProductoPVNP" style="display:none">-1</label>
							<div class="col-md-1 col-sm-8 col-xs-8 p-2">
								<span class="claTexto">Codigo</span></br><input type="text" class="form_input" id="txtCodigo_PVNP">
							</div>
							<div class="col-md-1 col-sm-4 col-xs-4 p-2 center">
								<button class="btnProceso m-t-10" id="btnSearchProd_PVNP"><i class="fas fa-search-plus" ></i> Buscar</button>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12 p-2">
								<span class="claTexto">Producto</span></br>
								<input type="text" class="form_input claReadonly" id="txtProducto_PVNP" readonly>
							</div>
							<!--<div class="col-md-2 col-sm-4 col-xs-6 p-2">
								<button class="btnProceso m-t-10" id="btnNewProduc_ProcCompra"><i class="fas fa-search-plus" ></i> Nuevo</button>
							</div>-->
							<div class="col-md-2 col-sm-4 col-xs-6 p-2">
								<span class="claTexto">Marca</span></br>
								<input type="text" class="form_input claReadonly" id="txtMarca_PVNP" readonly>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6 p-2">
								<span class="claTexto">Modelo</span></br>
								<input type="text" class="form_input claReadonly" id="txtModelo_PVNP" readonly>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6 p-2">
								<span class="claTexto">Unidad</span></br>
								<input type="text" class="form_input claReadonly" id="txtUnidad_PVNP" readonly>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-md-1 col-sm-3 col-xs-6 p-2 m-t-10">
								<span class="claTexto">Cantidad</span></br>
								<input type="text" class="form_input center" id="txtCantidad_PVNP" value="1" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<!--<div class="col-md-2 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Precio Compra</span></br>
								<input type="text" class="form_input" id="txtPCompra_ProcCompra" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div> -->
							<div class="col-md-2 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">P. Publico</span> <input type="radio" name="rbtTipoprecioPVNP" value="1" class="chk2020" checked></br>
								<input type="text" class="form_input" id="txtPPublico_PVNP" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">P. Base</span> <input type="radio" name="rbtTipoprecioPVNP" value="2" class="chk2020"></br>
								<input type="text" class="form_input" id="txtPMenor_PVNP" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">P. Dist</span> <input type="radio" name="rbtTipoprecioPVNP" value="3" class="chk2020"></br>
								<input type="text" class="form_input" id="txtPMayor_PVNP" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2 m-t-10">
								<span class="claTexto">Importe</span></br>
								<input type="text" class="form_input claReadonly center" id="txtImporte_PVNP" value="0" onkeypress="return Valido_Numero_Decimal(event, this)" readonly>
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2 m-t-10">
								<span class="claTexto">Stock</span></br>
								<input type="text" class="form_input claReadonly center" id="txtStock_PVNP" onkeypress="return Valido_Numero_Decimal(event, this)" readonly>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2 right">
								<button class="btnProceso m-t-10" id="btnAdd_PVNP"><i class="fas fa-plus-square" ></i> Agregar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row p-t-10">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive" id="IdContent_DetailC_ProcVenta">
							<table class="claTableProceso" id="IdTable_Detalle_PVNP">
								<thead><tr>
									<th>X</th><th>Cant.</th><th>Codigo</th><th>Descripcion</th><th>Unidad</th><th>P.Unitario</th><th>Importe</th>
									<th>Tipo Precio</th>
									<th style="display:none">IdPrd</th><th style="display:none">IdTipoPrecio</th>
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
								<div class="col-md-12 col-sm-12 col-xs-12">
									<span class="claTexto">Son</span></br>
									<input type="text" class="form_input claReadonly" id="txtSon_PVNP" readonly>
								</div>
							</div>
							<div class="row center">
								<div class="col-md-12 col-sm-12 col-xs-12" style="display:none" id="IdFechaPagoCompra">
									Fecha Pago</br><input type="text" class="form_input claReadonly center" id="txtFechaPago_ProcCompra" readonly style="width: 100px;">
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<div class="row center">
								Exonerar</br><input type="checkbox" id="IdChkIGVPVeNP" class="chk2020 claIGVPVenta">
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 right">Sub Total</div>							
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input type="text" class="form_input claReadonly center" id="txtSubTotal_PVNP" readonly>
								</div>
							</div>
							<div class="row p-t-5">
								<div class="col-md-6 col-sm-6 col-xs-6 right">I.G.V.</div>							
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input type="text" class="form_input claReadonly center" id="txtIGV_PVNP" readonly>
								</div>
							</div>
							<div class="row p-t-5">
								<div class="col-md-6 col-sm-6 col-xs-6 right">Total</div>							
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input type="text" class="form_input claReadonly center" id="txtTotal_PVNP" readonly>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-12">
									Obs/Responsable</br><input type="text" class="form_input" id="txtNroGuia_ProcVenta">
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									Telefono</br><input type="text" class="form_input" id="txtTelefono_PVNP">
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									Fecha Entrega</br><input type="text" class="form_input claReadonly" id="txtFechaEntrega_PVNP" readonly>
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
									<button class="btnGuardar" id="btnClear_PVNP"><i class="fas fa-trash" ></i> Limpiar</button>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 center">
									<button class="btnGuardar btn-verde" id="btnComprar_PVNP"><i class="fas fa-save" ></i> Guardar</button>
								</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<script src="./views/procesos/RegistroNotaPedido.js"></script>
<script src="./views/procesos/RegistroPrint.js"></script>
