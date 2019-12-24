	<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Movimiento Almacen de Productos
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="row center fondoProceso m-r-5">
						<div class="col-md-12 col-sm-12 col-xs-12 p-b-10">
							<div class="row">
								<div class="col-md-4 col-sm-6 col-xs-6">
									Almacen Origen
								</div>
								<div class="col-md-8 col-sm-6 col-xs-6">
									<select id="cboAlmacen_ProcMovAlm"><option value="-1">Seleccione</option></select>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-b-10">
							<div class="row">
								<div class="col-md-4 col-sm-6 col-xs-6">
									Almacen Destino
								</div>
								<div class="col-md-8 col-sm-6 col-xs-6">
									<select id="cboAlmacenD_ProcMovAlm"><option value="-1">Seleccione</option></select>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-t-10 p-b-10">
							<span class="claTexto">Responsable/Descripcion</span></br>
							<textarea type="text" class="form_input" id="txtDescripcion_ProcMovAlm"></textarea>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-t-15 p-b-15">
						</div>
					</div>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<div class="row center fondoProceso m-r-5 m-l-5">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<label id="lblIdProductoMovAlm" style="display:none">-1</label>
								<div class="col-md-2 col-sm-4 col-xs-12">
									<span class="claTexto">Codigo</span></br><input type="text" class="form_input" id="txtCodigo_MovAlm"> 
								</div>
								<div class="col-md-2 col-sm-4 col-xs-4 p-2 center">
									<!--<button class="btnProceso m-t-10" id="btnSearchIdProd_MovAlm"><i class="fas fa-search-plus" ></i> Buscar</button>-->
								</div>
								<div class="col-md-6 col-sm-5 col-xs-8">
									<span class="claTexto">Producto</span></br>
									<input type="text" class="form_input claReadonly" id="txtProducto_MovAlm" readonly>
								</div>
								<div class="col-md-2 col-sm-4 col-xs-4 p-2 center">
									<button class="btnProceso m-t-10" id="btnSearchProd_MovAlm"><i class="fas fa-search-plus" ></i> Buscar</button>
								</div>
							</div>
							<div class="row p-t-5 p-b-5">
								<div class="col-md-4 col-sm-4 col-xs-12">
									<span class="claTexto">Unidad</span></br>
									<input type="text" class="form_input center" id="txtUnidad_MovAlm" disabled>
								</div>
								<div class="col-md-2 col-sm-3 col-xs-6">
									<span class="claTexto">Cantidad</span></br>
									<input type="text" class="form_input center" id="txtCantidad_MovAlm" value="1" onkeypress="return Valido_Numero_Decimal(event, this)">
								</div>
								<div class="col-md-2 col-sm-3 col-xs-6 p-2">
									<span class="claTexto">Precio Unitario</span></br>
									<input type="text" class="form_input" id="txtPMayor_MovAlm" onkeypress="return Valido_Numero_Decimal(event, this)">
								</div>
								<div class="col-md-2 col-sm-3 col-xs-6">
									<span class="claTexto">Importe</span></br>
									<input type="text" class="form_input claReadonly center" id="txtImporte_MovAlm" value="0" onkeypress="return Valido_Numero_Decimal(event, this)" readonly>
								</div>
								<div class="col-md-2 col-sm-3 col-xs-6 p-2 center">
									<button class="btnProceso m-t-10" id="btnAdd_MovAlm"><i class="fas fa-plus-square" ></i> Agregar</button>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-t-10 p-b-10">
							<div class="table-responsive" id="IdContent_DetailC_MovAlm">
									<table class="claTableProceso" id="IdTable_DetalleC_MovAlm">
										<thead><tr>
											<th>X</th>
											<th>Cant.</th><th>Codigo</th><th>Descripcion</th><th>Unidad</th><th>P.Unitario</th><th>Importe</th>
											<th style="display:none">IdPrd</th>
										</tr></thead>
										<tbody></tbody>
									</table>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 left p-b-10">
							<div class="row center">
								<div class="col-md-6 col-sm-4 col-xs-4 center">
									
								</div>
								<div class="col-md-3 col-sm-4 col-xs-4 right">
									Total
								</div>
								<div class="col-md-3 col-sm-4 col-xs-4 center">
									<input type="text" class="form_input claReadonly center" id="txtTotal_MovAlm" readonly>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 left">
							<div class="row center">
								<div class="col-md-6 col-sm-6 col-xs-6 center">
									<button class="btnGuardar" id="btnClear_MovAlm"><i class="fas fa-trash" ></i> Limpiar</button>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 center">
									<button class="btnGuardar btn-verde" id="btnComprar_MovAlm"><i class="fas fa-save" ></i> Guardar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="./views/procesos/RegistroMovimientoAlm.js"></script>
