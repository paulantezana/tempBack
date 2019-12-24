<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row center claTitleRegistro marginManteReg">
		Mantenimiento Productos
	</div>
</div>
<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row marginManteReg">
		<div class="col-xl-6 col-md-6 col-sm-6 col-xs-6">
			  <input id="filtrar" type="text" class="form-control" placeholder="Buscar...">
		</div>
		<div class="col-xl-6 col-md-6 col-sm-6 col-xs-6 right">
			<button class="btn btn-success btn-round clr-verde" id="btnNewProductos"><i class="fas fa-plus-circle"></i> Nuevo</button>
		</div>
	</div>
</div>
<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row marginManteReg">
		<div class="table-responsive TablaBlancoF" id="IdContentManteProductos">
			<table class="claTableRegistro" id="IdTableManteProductos">
				<thead><tr>
					<th>Edit</th>
					<th>Codigo</th>
					<th>Nombre Producto</th>
					<th>Modelo</th>
					<th>Marca</th>
					<th>Hab</th>	
				</tr></thead>
				<tbody class="buscar"></tbody>
			</table>
		</div>
	</div>
</div>

<script src="./views/mante/ManteProductos.js"></script>
