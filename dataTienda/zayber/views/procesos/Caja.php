<?php
	$controller = new MvcController();$pDatos=$controller->combo_Almacen_Id();
	$IdAlmacen=-1;$Almacen="";
	if(count($pDatos)>0){
		$IdAlmacen=$pDatos[0]["IdAlmacen"];$Almacen=$pDatos[0]["Almacen"];
	}
?>
		<label id="IdAlmCaja" style="display:none"><?php  echo $IdAlmacen ?></label>
		<label id="AlmCaja" style="display:none"><?php  echo $Almacen ?></label>

<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Movimiento Caja
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row fondoProceso">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-1 col-sm-2 col-xs-6 p-2">
							<span class="claTexto">S/</span></br>
							<input type="text" class="form_input" id="txtSoles_SaldoCaja" readonly>
						</div>
						<!-- <div class="col-md-1 col-sm-2 col-xs-6 p-2">
							<span class="claTexto">$</span></br>
							<input type="text" class="form_input" id="txtDolar_SaldoCaja" readonly>
						</div> -->
						<div class="col-md-1 col-sm-2 col-xs-6 p-2">
							<span class="claTexto">Fecha</span></br>
							<input type="text" class="form_input" id="IdFecha_Report">
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnImprimir" id="btnUpdate_Caja"><i class="fas fa-sync-alt f-18"></i> Actualizar</button>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnImprimir" id="btnIngreso_Caja"><i class="fas fa-hand-holding-usd f-18"></i> Ingreso</button>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnImprimir" id="btnEgreso_Caja"><i class="fas fa-file-invoice-dollar f-18"></i> Egreso</button>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnExportarExc" id="btnExportar_Caja"><i class="fas fa-file-excel f-18"></i> EXPORTAR EXCEL</button>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnImprimir" id="btnPrint_Caja"><i class="fas fa-print f-18"></i> IMPRIMIR</button>
						</div>
					</div>
					<div class="row p-t-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContent_Caja">
								<table class="claTableReport" id="IdTable_Caja">
									<thead><tr class="">
										<th>Nro</th><th>Tipo</th><th>Tipo Servicio</th><th>S/.</th><th>$.</th><th>Fecha Reg.</th>
										<th>Usuario</th><th>Saldo S/.</th><th>Saldo $.</th><th>Descripcion</th><th>Obs</th>
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
	
<script src="./views/procesos/Caja.js"></script>
