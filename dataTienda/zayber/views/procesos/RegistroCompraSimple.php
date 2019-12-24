	<?php
	$controller = new MvcController();$pDatos=$controller->combo_Almacen_Id();
	$IdAlmacen=-1;$Almacen="";
	if(count($pDatos)>0){
		$IdAlmacen=$pDatos[0]["IdAlmacen"];$Almacen=$pDatos[0]["Almacen"];
	}
?>
	<label id="IdAlmCompSimple" style="display:none"><?php  echo $IdAlmacen ?></label>
	<label id="AlmCompSimple" style="display:none"><?php  echo $Almacen ?></label>
	
	
	
	
	
<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Compra Simple
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row center fondoProceso">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<span class="claTexto">Responsable</span></br>
							<input type="text" class="form_input" id="txtObs_ProcCS">
						</div>
					</div>
				</div>
			</div>
			<div class="row p-t-10">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row fondoProceso">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label id="lblIdProductoProcCS" style="display:none">-1</label>
							<div class="col-md-1 col-sm-8 col-xs-8 p-2">
								<span class="claTexto">Codigo</span></br><input type="text" class="form_input" id="txtCodigo_ProcCS">
							</div>
							<div class="col-md-1 col-sm-4 col-xs-4 p-2 center">
								<button class="btnProceso m-t-10" id="btnSearchProd_ProcCS"><i class="fas fa-search-plus" ></i> Buscar</button>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12 p-2">
								<span class="claTexto">Producto</span></br>
								<input type="text" class="form_input claReadonly" id="txtProducto_ProcCS" readonly>
							</div>
							<!--<div class="col-md-2 col-sm-4 col-xs-6 p-2">
								<button class="btnProceso m-t-10" id="btnNewProduc_ProcCompra"><i class="fas fa-search-plus" ></i> Nuevo</button>
							</div> -->
							<div class="col-md-2 col-sm-4 col-xs-6 p-2">
								<span class="claTexto">Familia</span></br>
								<input type="text" class="form_input claReadonly" id="txtModelo_ProcCS" readonly>
							</div>
							<div class="col-md-2 col-sm-4 col-xs-6 p-2">
								<span class="claTexto">Marca</span></br>
								<input type="text" class="form_input claReadonly" id="txtMarca_ProcCS" readonly>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Unidad</span></br>
								<select id="cboUnidad_ProcCompra"></select>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Cantidad</span></br>
								<input type="text" class="form_input center" id="txtCantidad_ProcCS" value="1" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Precio Compra</span></br>
								<input type="text" class="form_input" id="txtPCompra_ProcCS" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Importe</span></br>
								<input type="text" class="form_input claReadonly center" id="txtImporte_ProcCS" value="0" onkeypress="return Valido_Numero_Decimal(event, this)" readonly>
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Trf Publico</span></br>
								<input type="text" class="form_input center" id="txtPPublico_ProcCS" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Trf Base</span></br>
								<input type="text" class="form_input center" id="txtPMenor_ProcCS" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Trf Dist</span></br>
								<input type="text" class="form_input center" id="txtPMayor_ProcCS" onkeypress="return Valido_Numero_Decimal(event, this)">
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2">
								<span class="claTexto">Stock</span></br>
								<input type="text" class="form_input claReadonly center" id="txtStock_ProcCS" onkeypress="return Valido_Numero_Decimal(event, this)" readonly>
							</div>
							<div class="col-md-1 col-sm-3 col-xs-6 p-2" style="display:none;">
								<span class="claTexto">TipoC</span></br>
								<input type="text" class="form_input center" id="txtTC_ProcCS" onkeypress="return Valido_Numero_Decimal(event, this)" value="1">
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 p-2 right">
								<button class="btnProceso m-t-10" id="btnAdd_ProcCS"><i class="fas fa-plus-square" ></i> Agregar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row p-t-10">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row fondoProceso">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContent_DetailC_ProcCS">
								<table class="claTableProceso" id="IdTable_DetalleC_ProcCS">
									<thead><tr>
										<th>X</th><th>Cant.</th><th>Codigo</th><th>Descripcion</th><th>Unidad</th><th>P.Compra</th>
										<th>Importe</th><th>P.Publico</th><th>P.Base</th><th>P.Dist</th>
										<th style="display:none">IdPrd</th>
										<th>T.C.</th><th style="display:none">IdUni</th>
									</tr></thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="row p-t-10">
								<div class="col-md-9 col-sm-6 col-xs-6"></div>
								<div class="col-md-3 col-sm-6 col-xs-6">
									<div class="col-md-4 col-sm-4 col-xs-6">Total</div>
									<div class="col-md-8 col-sm-8 col-xs-8">
										<input type="text" class="form_input claReadonly center" id="txtTotal_ProcCS" readonly>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="row p-t-10">
								<div class="col-md-6 col-sm-6 col-xs-6 center">
									<button class="btnGuardar" id="btnClear_ProcCS"><i class="fas fa-trash" ></i> Limpiar</button>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 center">
									<button class="btnGuardar btn-verde" id="btnComprar_ProcCS"><i class="fas fa-save" ></i> Guardar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="./views/procesos/RegistroCompraSimple.js"></script>
