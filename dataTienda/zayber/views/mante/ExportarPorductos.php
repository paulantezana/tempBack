<?php
	$controller = new MvcController();$pDatos=$controller->combo_ExportarProducto();
	$Alm=$pDatos["Alm"];
?>
<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			EXPORTAR PRODUCTO POR ALMACEN
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row fondoProceso">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Almacen</span></br>
							<select id="cboAlmacen_RepExportPAlm"><?php echo $Alm; ?></select>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Buscar</span></br>
							<input type="text" class="form_input" id="filtrar" placeholder="Buscar...">
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnImprimir" id="cboPrint_RepExportPAlm"><i class="fas fa-print f-18"></i> IMPRIMIR</button>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnExportarExc" id="cboExportar_RepExportPAlm"><i class="fas fa-file-excel f-18"></i> EXPORTAR EXCEL</button>
						</div>
					</div>
					<div class="row p-t-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContentRepExportPAlm">
								<table class="claTableReport" id="IdTable_RepExportPAlm">
									<thead><tr class="">
										<th>codigo</th><th>fabrica</th><th>descripcion</th><th>marca</th><th>modelo</th><th>Anio</th>
										<th>compra</th><th>mayor</th><th>menor</th><th>publico</th><th>Stock</th>
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

<script src="./views/mante/ExportarPorductos.js"></script>