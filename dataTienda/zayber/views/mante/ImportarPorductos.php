<?php
	$controller = new MvcController();$pDatos=$controller->combo_ImportarProducto();
	$Alm=$pDatos["Alm"];
?>
<!--<script src="./assets/js/xlsx.core.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script> 

<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			IMPORTAR PRODUCTOS POR ALMACEN
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row fondoProceso">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Almacen</span></br>
							<select id="cboAlmacen_RepImportPAlm"><?php echo $Alm; ?></select>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Buscar</span></br>
							<input type="text" class="form_input" id="filtrar" placeholder="Buscar...">
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12 center">
							<input type="file" id="files" name="files"/>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12 center">
							<button class="btnExportarExc" id="btnSave_ImportPAlm"><i class="fas fa-save f-18"></i> Guardar Producto</button>
						</div>
					</div>
					<div class="row p-t-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContentRepImportPAlm">
								<table class="claTableReport" id="IdTable_RepImportPAlm">
									<thead><tr class="">
										<th>Nro</th><th>Codigo</th><th>Descripcion</th>
										<th>P. Compra</th><th>P. Mayor</th><th>P. Menor</th><th>P. Publico</th><th>Marca</th><th>Modelo</th>
									</tr></thead><tbody class="buscar"></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row p-t-20"></div>
					<div class="row p-t-20">
						
						<div class="col-md-6 col-sm-6 col-xs-6 col-12">
							<div class="row">
								<div class="table-responsive" id="IdContentMarca">
									<table class="claTableReport" id="IdTable_RepMarcaPAlm">
										<thead><tr class="">
											<th>Marca</th>
										</tr></thead><tbody></tbody>
									</table>
								</div>
							</div>
							<div class="row p-t-20">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<button type="button" class="btn btn-danger" id="btnSaveMarca">Guardar Marca</button>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 col-12">
							<div class="row">
								<div class="table-responsive" id="IdContentModelo">
									<table class="claTableReport" id="IdTable_RepModeloPAlm">
										<thead><tr class="">
											<th>Modelo</th>
										</tr></thead><tbody></tbody>
									</table>
								</div>
							</div>
							<div class="row p-t-20">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<button type="button" class="btn btn-danger" id="btnSaveModelo">Guardar Modelo</button>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="./views/mante/ImportarPorductos.js"></script>
