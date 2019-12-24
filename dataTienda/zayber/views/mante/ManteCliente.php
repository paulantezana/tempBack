<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row center claTitleRegistro marginManteReg">
		Mantenimiento Cliente
	</div>
</div>
<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row marginManteReg">
		<div class="col-xl-6 col-md-6 col-sm-6 col-xs-8">
			  <input id="filtrar" type="text" class="form-control" placeholder="Buscar...">
		</div>
		<div class="col-xl-6 col-md-6 col-sm-6 col-xs-4 right">
			<button class="btn btn-success btn-round clr-verde" id="btnNewCliente"><i class="fas fa-plus-circle"></i> Nuevo</button>
		</div>
	</div>
</div>
<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row marginManteReg">
		<div class="table-responsive TablaBlancoF">
			<table class="claTableRegistro" id="IdTableManteCliente">
				<thead><tr>
					<th>Editar</th>
					<th>Nro Doc</th>
					<th>Razon Social</th>
					<th>Direccion</th>
					<th>Telefono</th>
					<th>Email</th>
					<th>Obs</th>
					<th>Hab</th>
				</tr></thead>
				<tbody class="buscar"></tbody>
			</table>
		</div>
	</div>
</div>
<script src="./views/mante/ManteCliente.js"></script>
