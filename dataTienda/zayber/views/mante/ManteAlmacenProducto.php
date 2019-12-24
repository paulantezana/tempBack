<?php
	$controller = new MvcController();$pDatos=$controller->combo_Almacen_Id();
	$IdAlmacen=-1;$Almacen="";
	if(count($pDatos)>0){
		$IdAlmacen=$pDatos[0]["IdAlmacen"];$Almacen=$pDatos[0]["Almacen"];
	}
?>
		<label id="IdAlmPrdAlm" style="display:none"><?php  echo $IdAlmacen ?></label>
		<label id="AlmPrdAlm" style="display:none"><?php  echo $Almacen ?></label>
		
<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row center claTitleRegistro marginManteReg">
		Producto Almacen
	</div>
</div>
<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row marginManteReg">
		<div class="col-xl-5 col-md-5 col-sm-5 col-xs-5">
			  <input id="filtrar" type="text" class="form-control" placeholder="Buscar...">
		</div>
		<div class="col-md-2 col-sm-2 col-xs-6 center">
			<button class="btnExportarExc" onclick="exportTableToExcel('IdTableManteProductoAlm')"><i class="fas fa-file-excel f-18"></i> EXPORTAR EXCEL</button>
		</div>
		<div class="col-xl-5 col-md-5 col-sm-5 col-xs-5 right">
			<button class="btn btn-success btn-round clr-verde" id="btnNewProductoAlm"><i class="fas fa-plus-circle"></i> Nuevo</button>
		</div>
	</div>
</div>
<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row marginManteReg">
		<div class="table-responsive TablaBlancoF">
			<table class="claTableRegistro" id="IdTableManteProductoAlm">
				<thead><tr>
					<th>E</th>
					<th>Codigo</th>
					<th>Producto</th>
					<th>Marca</th>
					<th>Categoria</th>
					<th>Unidad</th>
					<th>Precio Compra</th>
					<th>Precio Base</th>
					<th>Precio Distribuido</th>
					<th>Precio Publico</th>
					<th>Mo</th>
					<th>Stock</th>
					<th>Est</th>
				</tr></thead>
				<tbody class="buscar"></tbody>
			</table>
		</div>
	</div>
</div>

<script src="./views/mante/ManteAlmacenProducto.js"></script>
