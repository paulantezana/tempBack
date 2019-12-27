<?php
	$controller = new MvcController();$pDatos=$controller->combo_Almacen_Venta();
	$IdAlmacen=-1;$Almacen="";
	$Comprobante=$pDatos["Comprobante"];
	$TipoDoc=$pDatos["TipoDoc"];
	$Empresa=$pDatos["Empresa"];
	$Alm=$pDatos["Alm"];
	if(count($Alm)>0){
		$IdAlmacen=$Alm[0]["IdAlmacen"];$Almacen=$Alm[0]["Almacen"];
	}
?>
		<label id="IdAlmRVenta" style="display:none"><?php  echo $IdAlmacen ?></label>
        <label id="AlmRVenta" style="display:none"><?php  echo $Almacen ?></label>
<div class="col-md-8 ">
    <div class="row barraTotal">
        <div class="form-group col-md-6">
            <label for="codigo_buscar">Buscar Nota de pedido</label>
            <input type="text" class="form-control" id="buscar_nota_pedido" placeholder="Codigo" autofocus/>
        </div>
        <!-- <div class="col-md-1">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevo"><i class="fas fa-plus"></i></button>
        </div> -->
        <div class="form-group col-md-4">
            <label for="codigo_buscar">Buscar por Codigo (F1)</label>
            <input type="text" class="form-control" id="codigo_buscar" placeholder="Codigo"/>
        </div>
        <!-- <div class="col-md-4">
            <div class="form-group ui-widget">
                <label for="nombre_marca">Buscar por Nombre/Marca (F2)</label>
                <input type="text" class="form-control" id="nombre_marca" placeholder="Nombre / Marca">
                
            </div>
        </div> -->
    </div>
    <div class="row barraTotal m-t-10 table-responsive">
        <table class="table table-hover table-bordered claTableProceso" id="tablaCarritoProductos">
            <thead>
                <tr>
                    <th width="60">Cant</th>
                    <th>Codigo</th>
                    <th>Descripcion</th>
                    <th>Unidad</th>
                    <th width="100">Precios</th>
                    <th width="100">Precio U.</th>
                    <th width="90">Total</th>
                    <th width="90" class="filaOcultar" style="display: none;">Tipo</th>
                    <th style="display:none;">IdProducto</th>
                    <th width="50">X</th>
                    <th width="50">Stock</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-4 ">
    <div class="row" style="display:none;">
        <div class="col-md-12 col-sm-12 col-xs-12 p-b-10">
			<span class="claTexto">Empresa</span></br>
			<select id="comboEmpresa">
				<?php echo $Empresa; ?>
			</select>
		</div>
    </div>
    <div class="row barraTotalMonto">
        <div class="col-md-12"><h4>TOTAL   S/ <strong id="precioTotal">0.00</strong></h4></div>
    </div>
    <div class="row barraTotal">
        <div class="col-md-4 offset-md-2">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="pagoContado" name="tipoPago" class="custom-control-input" value="1" checked>
                <label class="custom-control-label" for="pagoContado">CONTADO</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="pagoTarjeta" name="tipoPago" class="custom-control-input" Value="3">
                <label class="custom-control-label" for="pagoTarjeta">TARJETA</label>
            </div>
        </div>
        <div class="col-md-12" id="efectivoCambio">
            <div class="form-group row">
                <label for="montoRecibido" class="col-sm-4 col-form-label">RECIBIDO</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control-plaintext" id="montoRecibido" onkeyup="ActualizarVuelto()">
                </div>
                <div class="col-md-4"><h5>VUELTO</h5></div>
                <div class="col-md-8"><h5>S/. <strong id="vuelto">0.00</strong></h5></div>
            </div>
        </div>
        
    <!-- </div>
    <div class="row barraTotal"> -->
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-check">
                <input class="form-check-input is-invalid" type="checkbox" value="" id="checkFacturacion" onchange="ActivarCamposFacturacion()">
                <label class="form-check-label" for="checkFacturacion">
                    FACTURACION
                </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row barraTotal" id="camposFacturacion" style="display:none;">
        <div class="col-md-6">
            <select class="custom-select custom-select-lg mb-3" id="comboComprobantes" onchange="VerificarDocumentos()">
                <option value="2">BOLETA DE VENTA</option>
                <option value="1">FACTURA</option>
            </select>
        </div>
        <div class="col-md-6">
            <select class="custom-select custom-select-lg mb-3" id="tipoDocumentos">
                <option value="0">VARIOS</option>
                <option value="1">DNI</option>
            </select>
        </div>
        <div class="col-md-12">
            <label for="nroDocumento">Nro Documento</label>
            <input type="text" class="form-control" id="nroDocumento">
        </div>
        <div class="col-md-12">
            <label for="razonSocial">Nombre / Razon Social</label>
            <input type="text" class="form-control" id="razonSocial">
        </div>
        <div class="col-md-12">
            <label for="direccion">Direccion</label>
            <input type="text" class="form-control" id="direccion">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <button type="button" class="btn btn-default" onclick="LimpiarDatos()">LIMPIAR</button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-primary" onclick="GuardarVenta()" id="botonGuardar">GUARDAR</button>
        </div>
    </div>
</div>

<div class="modal fade modalJos" tabindex="-1" role="dialog" id="modalNuevo" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content  modal-lg">
        <div class="row container">
            <div class="modal-header">
                <h5 class="modal-title">Producto sin Stock</h5>
            </div>
            <div class="modal-body">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="newCantidad">Cantidad</label>
                        <input type="number" class="form-control" id="newCantidad" placeholder="Cantidad" autofocus>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="newDescripcion">Descripcion</label>
                        <input type="text" class="form-control" id="newDescripcion" placeholder="Descripcion">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="newPrecioUnitario">Precio Unit.</label>
                        <input type="text" class="form-control" id="newPrecioUnitario" placeholder="Precio Unitario">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" onclick="AgregarProductoNuevo()" >Agregar</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<script src="./views/procesos/RegistroVentaRapida.js"></script>
<script src="./views/procesos/RegistroPrint.js"></script>