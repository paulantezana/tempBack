
<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row claTitleMante">
		<div class="col-xl-10 col-md-10 col-sm-10 col-xs-9">
			<h2>Cliente Tarifa</h2>
		</div>
		<div class="col-xl-2 col-md-2 col-sm-2 col-xs-3 p-t-10 right">
			<button class="btn btn-primary btn-round" id="btnNewProductoAlm">New</button>
		</div>
	</div>
</div>
<div class="col-md-12 col-xl-12 card">
	<div class="row p-t-10">
		<div class="col-xl-1 col-md-1 col-sm-2 col-xs-3">Almacen</div>
		<div class="col-xl-2 col-md-2 col-sm-2 col-xs-4">
			<select id="cboAlmacen_ProductoAlm"></select>
		</div>
	</div>
	<div class="row p-t-15">
		<div class="input-group">
		  <span class="input-group-addon">Buscar</span>
		  <input id="filtrar" type="text" class="form-control" placeholder="Buscar...">
		</div>
	</div>
	<div class="row p-t-15">
		<div class="table-responsive" id="IdContentProductoAlm">
			<table class="claTableRegD" id="IdTableManteProductoAlm">
				<thead><tr>
					<th>Editar</th>
					<th>Categoria</th>
					<th>Codigo</th>
					<th>Producto</th>
					<th>Unidad</th>
					<th>Precio Compra</th>
					<th>Precio Venta</th>
					<th>Stock</th>
				</tr></thead>
				<tbody class="buscar"></tbody>
			</table>
		</div>
	</div>
</div>

<script src="./views/mante/ManteAlmacenProducto.js"></script>
