
<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			LISTA PRECIO POR ALMACEN
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row fondoProceso">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Almacen</span></br>
							<select id="cboAlmacen_RPrecioAlm"></select>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Buscar</span></br>
							<input type="text" class="form_input" id="filtrar" placeholder="Buscar...">
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnImprimir" id="btnPrint_RPrecioAlm"><i class="fas fa-print f-18"></i> IMPRIMIR</button>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnExportarExc" id="btnExportar_RPrecioAlm"><i class="fas fa-file-excel f-18"></i> EXPORTAR EXCEL</button>
						</div>
					</div>
					<div class="row p-t-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContent_RPrecioAlm">
								<table class="claTableReport" id="IdTable_RPrecioAlma">
									<thead><tr class="">
										<th>Producto</th><th>Unidad</th>
										<th>Precio Compra</th><th>Precio Base</th><th>Precio Distribuido</th><th>	Precio Publico</th>
										<th>Mo</th><th>Stock</th><th>TC</th><th>Hab</th>
									</tr></thead><tbody class="buscar"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="./views/reportes/PrecioAlmacen.js"></script>