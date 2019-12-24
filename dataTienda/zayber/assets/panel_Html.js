var Form_Modal_Mante_Productos=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Productos</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Codigo</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtCodigo_ManteProductos">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Nombre Producto</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<textarea type="text" class="form_input" id="txtProducto_ManteProductos"></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Modelo</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<select id="cboCategoria_ManteProductos"></select>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Marca</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<select id="cboMarca_ManteProductos"></select>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Habilitado</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="checkbox" class="chkHabilitado" id="chkHabilitado_MantProducto" checked>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="txtSave_ManteProductos" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_Mante_Almacen=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">ALMACEN</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Almacen</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtAlmacen_Almc">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Simbolo</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtSimbolo_Almc">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Descripcion</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtDescrip_Almc">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Ruc</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtRuc_Almc">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Razon Social</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtRazonSocial_Almc">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Direccion</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtDireccion_Almc">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Color de fondo</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="color" class="form_input" id="colorFondo_Almc">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Color de texto</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="color" class="form_input" id="colorTexto_Almc">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Habilitado</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="checkbox" class="chkHabilitado" id="chkHabilitado_Almc" checked>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="txtSave_Almc" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_Mante_Unidad=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Unidad</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Unidad</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtUnidad_Unid">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Simbolo</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtSimbolo_Unid">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Habilitado</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="checkbox" class="chkHabilitado" id="chkHabilitado_Unid" checked>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="txtSave_Unid" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_Mante_Marca=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">MARCA</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Marca</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtMarca_Marca">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Simbolo</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtSimbolo_Marca">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Habilitado</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="checkbox" class="chkHabilitado" id="chkHabilitado_Marca" checked>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="txtSave_Marca" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_Mante_Plan=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">TIPO PLAN</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Tipo Plan</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtTipo_Plan">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Simbolo</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtSimbolo_Plan">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Monto</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtMonto_Plan" onkeypress="return Valido_Numero_Decimal(event,this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Habilitado</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="checkbox" class="chkHabilitado" id="chkHabilitado_Plan" checked>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="txtSave_Plan" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_Mante_Categoria=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Modelo</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Modelo</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtCategoria_Categoria">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Simbolo</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtSimbolo_Categoria">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Habilitado</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="checkbox" class="chkHabilitado" id="chkHabilitado_Categoria" checked>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="txtSave_Categoria" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_Caja_Ingreso=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Ingreso</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">S/.</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form-control" id="txtSoles_CajaIngreso" onkeypress="return Valido_Numero_Decimal(event,this)" value="0">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5" style="display:none;">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">$.</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form-control" id="txtDolar_CajaIngreso" onkeypress="return Valido_Numero_Decimal(event,this)" value="0">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Descripcion</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form-control" id="txtDescripcion_IngresoCaja">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Obs</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form-control" id="txtObs_IngresoCaja">'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button class="btnGuardar btn-verde" id="txtSave_IngresoCaja"><i class="fas fa-save"></i> Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_Caja_Egreso=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Egreso</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Tipo</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<select id="cboTipo_CajaEgreso"></select>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">S/.</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form-control" id="txtSoles_CajaEgreso" onkeypress="return Valido_Numero_Decimal(event,this)" value="0">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5" style="display:none;">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">$.</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form-control" id="txtDolar_CajaEgreso" onkeypress="return Valido_Numero_Decimal(event,this)" value="0">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Descripcion</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form-control" id="txtDescripcion_EgresoCaja">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Obs</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form-control" id="txtObs_EgresoCaja">'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button class="btnGuardar btn-verde" id="txtSave_EgresoCaja"><i class="fas fa-save"></i> Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_UserSystem=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal modal-lg" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Registrar Usuario</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-1 col-sm-6 col-xs-12">TipoDoc</div>'+
							'<div class="col-md-3 col-sm-6 col-xs-12">'+
								'<select id="cboTipoDoc_ManteSystem"></select>'+
							'</div>'+
							'<div class="col-md-1 col-sm-6 col-xs-12">NroDoc</div>'+
							'<div class="col-md-3 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtNroDoc_ManteSystem">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-1 col-sm-6 col-xs-12">Nombres</div>'+
							'<div class="col-md-3 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtNombre_ManteSystem">'+
							'</div>'+
							'<div class="col-md-1 col-sm-6 col-xs-12">Paterno</div>'+
							'<div class="col-md-3 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtApPaterno_ManteSystem">'+
							'</div>'+
							'<div class="col-md-1 col-sm-6 col-xs-12">Materno</div>'+
							'<div class="col-md-3 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtApMaterno_ManteSystem">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-1 col-sm-6 col-xs-12">Fecha Nac</div>'+
							'<div class="col-md-2 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtFechaNac_ManteSystem" readonly>'+
							'</div>'+
							'<div class="col-md-1 col-sm-6 col-xs-12">Sexo</div>'+
							'<div class="col-md-1 col-sm-6 col-xs-12">'+
								'<input type="radio" name="genderSystem" value="1" id="rbtMS" checked> M<br>'+
							'</div>'+
							'<div class="col-md-1 col-sm-6 col-xs-12">'+
								'<input type="radio" name="genderSystem" value="2" id="rbtFS"> F<br>'+
							'</div>'+
							'<div class="col-md-1 col-sm-6 col-xs-12">Direccion</div>'+
							'<div class="col-md-2 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtDireccion_ManteSystem">'+
							'</div>'+
							'<div class="col-md-1 col-sm-6 col-xs-12">Telefono</div>'+
							'<div class="col-md-2 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtTelefono_ManteSystem">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-1 col-sm-6 col-xs-12">Email</div>'+
							'<div class="col-md-3 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtEmail_ManteSystem">'+
							'</div>'+
							'<div class="col-md-1 col-sm-6 col-xs-12">CodUser</div>'+
							'<div class="col-md-2 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtCodUser_ManteSystem">'+
							'</div>'+
							'<div class="col-md-1 col-sm-6 col-xs-12">Password</div>'+
							'<div class="col-md-2 col-sm-6 col-xs-12">'+
								'<input type="password" class="form_input" id="txtPassword_ManteSystem">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-1 col-sm-6 col-xs-12">TipoUser</div>'+
							'<div class="col-md-3 col-sm-6 col-xs-12">'+
								'<select id="cboTipoUser_ManteSystem"></select>'+
							'</div>'+/*
							'<div class="col-md-1 col-sm-6 col-xs-12">Firma</div>'+
							'<div class="col-md-2 col-sm-6 col-xs-12">'+
								'<input type="password" class="form_input" id="txtFirma_ManteSystem">'+
							'</div>'+*/
							'<div class="col-md-2 col-sm-6 col-xs-12">Habilitado</div>'+
							'<div class="col-md-1 col-sm-6 col-xs-12">'+
								'<input type="checkbox" class="chkHabilitado" id="chkHabilitado_ManteSystem" checked>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_ManteSystem" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_UserVenta_System=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal modal-lg" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Habilitar Usuario Venta</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5 ">'+
							'<div class="table-responsive">'+
								'<table class="claTableRegD" id="IdTableConfHabUserSystemAlm">'+
									'<thead><tr>'+
										'<th>Region</th><th>Habilitar</th>'+
								'</tr></thead><tbody></tbody></table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_ManteHabUserSystemAlm" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Mante_Proveedor=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Proveedor</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Nombre Comercial</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtNComercial_ManteProveedor">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Ruc</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtRuc_ManteProveedor" onkeypress="return NroEntero11D(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Razon Social</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<textarea type="text" class="form_input" id="txtRazonSocial_ManteProveedor"></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Direccion Fiscal</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<textarea type="text" class="form_input" id="txtDireccionFiscal_ManteProveedor"></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Telefono</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtTelefono_ManteProveedor">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Email</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtEmail_ManteProveedor">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Representante</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtRepresentante_ManteProveedor">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Obs</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtObs_ManteProveedor">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Habilitado</div>'+
							'<div class="col-md-8 col-sm-6 col-xs-12">'+
								'<input type="checkbox" class="chkHabilitado" id="chkHabilitado_Manteproveedor" checked>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_ManteProveedor" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_Productos_CompraAdd=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Productos</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="input-group">'+
							  '<span class="input-group-addon">Buscar</span>'+
							  '<input id="filtrar" type="text" class="form-control" placeholder="Buscar...">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" id="IdContentProductosComp">'+
								'<table class="claTableRegD" id="IdTableproduct_AddCompra">'+
									'<thead><tr class="">'+
										'<th>Codigo</th><th>Producto</th><th>Unidad</th>'+
										'<th style="display:none">IdProd</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					//'<button type="button" id="btnSave_ManteProveedor" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_Productos_Modal_MovAlm=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Productos</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="input-group">'+
							  '<span class="input-group-addon">Buscar</span>'+
							  '<input id="filtrar" type="text" class="form-control" placeholder="Buscar...">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" id="IdContentProductosMovAlm">'+
								'<table class="claTableRegD" id="IdTableproduct_MovALm">'+
									'<thead><tr class="">'+
										'<th>Sel</th><th>Codigo</th><th>Producto</th><th>Unidad</th><th>Stock</th>'+
										'<th style="display:none">IdProd</th>'+
										'<th style="display:none">IdUnidad</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					//'<button type="button" id="btnSave_ManteProveedor" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_Productos_Modal_NP=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Productos</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="input-group">'+
							  '<span class="input-group-addon">Buscar</span>'+
							  '<input id="filtrar" type="text" class="form-control" placeholder="Buscar...">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" id="IdContentProductosComp">'+
								'<table class="claTableRegD" id="IdTableproduct_AddCompra">'+
									'<thead><tr class="">'+
										'<th>Sel</th><th>Codigo</th><th>Producto</th><th>Unidad</th><th>Stock</th><th>Precio</th>'+
										'<th style="display:none">IdProd</th>'+
										'<th style="display:none">IdUnidad</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					//'<button type="button" id="btnSave_ManteProveedor" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_VisorFBV_Venta=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal " role="document">'+
				'<div class="modal-content modal-lg">'+
				  '<div class="modal-header">'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5" id="IdPrintFB">'+
							//'<embed frameborder="0" width="100%" id="IdPrintFB" height="400px">'+
							'<iframe type="application/pdf" width="100%" height="500px" id="IdPrintFB"></iframe>'+
						'</div>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_Cliente_Modal_Venta=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Clientes</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="input-group">'+
							  '<span class="input-group-addon">Buscar</span>'+
							  '<input id="filtrar" type="text" class="form-control" placeholder="Buscar...">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" id="">'+
								'<table class="claTableRegD" id="IdTableCliente_PVenta">'+
									'<thead><tr class="">'+
										'<th>Sel</th><th>Ruc</th><th>Razon Social</th><th>Direccion</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					//'<button type="button" id="btnSave_ManteProveedor" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_Productos_Modal_CSF=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Productos</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="input-group">'+
							  '<span class="input-group-addon">Buscar</span>'+
							  '<input id="filtrar" type="text" class="form-control" placeholder="Buscar...">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" id="IdContentProductosComp">'+
								'<table class="claTableRegD" id="IdTableproduct_AddCompra">'+
									'<thead><tr class="">'+
										'<th>Sel</th><th>Codigo</th><th>Producto</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					//'<button type="button" id="btnSave_ManteProveedor" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_CronogramaPago=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Cronograma Pago Cliente</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Cliente</br><textarea type="text" class="form_input" id="txtCliente_CronoPay" disabled></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Tipo Plan</br><select id="txtTipoPlan_CronoPay"></select>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Monto Pago</br><input type="text" class="form_input" id="txtMonto_CronoPay" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Mes Inicio</br><input type="text" class="form_input" id="txtFecha_CronoPay" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Dia Vencimiento</br><input type="text" class="form_input" id="txtFechaVenc_CronoPay" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Hasta Mes y A���o Cronograma</br><input type="text" class="form_input" id="txtFechaAnio_CronoPay" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Obs</br><textarea type="text" class="form_input" id="txtObs_CronoPay"></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-6 col-sm-6 col-xs-12">Habilitado</div>'+
							'<div class="col-md-6 col-sm-6 col-xs-12">'+
								'<input type="checkbox" class="chkHabilitado" id="chkHabilitado_CronoPay" checked>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_CronoPay" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_MontoPago_Edit=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Modificar Monto Pago</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Cliente</br><textarea type="text" class="form_input" id="txtCliente_EditCronoPay" disabled></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Mes</br><textarea type="text" class="form_input" id="txtMes_EditCronoPay" disabled></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Monto Pago</br><input type="text" class="form_input" id="txtMonto_EditCronoPay" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Obs</br><textarea type="text" class="form_input" id="txtObs_EditCronoPay"></textarea>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_EditCronoPay" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_MontoPago_Pagar=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Pagar Cuota</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Cliente</br><textarea type="text" class="form_input" id="txtCliente_PayCronoPay" disabled></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Mes</br><textarea type="text" class="form_input" id="txtMes_PayCronoPay" disabled></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Monto Pago</br><input type="text" class="form_input" id="txtMonto_PayCronoPay" onkeypress="return Valido_Numero_Decimal(event, this)" disabled>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Forma Pago</br><select id="txtForma_PayCronoPay">'+
									'<option value="1">Contado</option><option value="2">Deposito</option><option value="3">Tarjeta</option>'+
								'</select>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Obs</br><textarea type="text" class="form_input" id="txtObs_PayCronoPay"></textarea>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_PayCronoPay" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Mante_Productos_Modal_CS=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Productos</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="input-group">'+
							  '<span class="input-group-addon">Buscar</span>'+
							  '<input id="filtrar" type="text" class="form-control" placeholder="Buscar...">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" id="IdContentProductosComp">'+
								'<table class="claTableRegD" id="IdTableproduct_AddCompra">'+
									'<thead><tr class="">'+
										'<th>Sel</th><th>Codigo</th><th>Producto</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					//'<button type="button" id="btnSave_ManteProveedor" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Mante_Producto_Alm=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Producto Almacen</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-12 col-sm-12 col-xs-12">'+
								'Producto</br><select id="txtProducto_ProdAlm"></select>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-6 col-sm-6 col-xs-12">Unidad</div>'+
							'<div class="col-md-6 col-sm-6 col-xs-12">'+
								'<select id="txtUnidad_ProdAlm"></select>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-6 col-sm-6 col-xs-12">Moneda</div>'+
							'<div class="col-md-6 col-sm-6 col-xs-12">'+
								'<select id="txtMoneda_ProdAlm"></select>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-6 col-sm-6 col-xs-12">Precio Compra</div>'+
							'<div class="col-md-6 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtPrecioCompra_ProdAlm" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-6 col-sm-6 col-xs-12">Precio Base</div>'+
							'<div class="col-md-6 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtPrecioBase_ProdAlm" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-6 col-sm-6 col-xs-12">Precio Distribuido</div>'+
							'<div class="col-md-6 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtPrecioDistribuido_ProdAlm" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-6 col-sm-6 col-xs-12">Precio Publico</div>'+
							'<div class="col-md-6 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtPrecioPublico_ProdAlm" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-6 col-sm-6 col-xs-12">Tipo Cambio</div>'+
							'<div class="col-md-6 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtTipoCambio_ProdAlm" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Habilitado</div>'+
							'<div class="col-md-8 col-sm-6 col-xs-12">'+
								'<input type="checkbox" class="chkHabilitado" id="chkHabilitado_ProdAlm" checked>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_ProductoAlm" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_Costo_ConfClienteTrf=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Tarifa Cliente</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Categoria</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtCategoria_ConfClienteTrf" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Producto</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtProducto_ConfClienteTrf" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Costo</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtCosto_ConfClienteTrf" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_ConfClienteTrf" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Mante_Cliente=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">CLIENTES</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Ruc/DNI</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtRuc_ManteCliente" onkeypress="return NroEntero11D(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Razon Social</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<textarea type="text" class="form_input" id="txtRazonSocial_ManteCliente"></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Direccion Fiscal</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<textarea type="text" class="form_input" id="txtDireccionFiscal_ManteCliente"></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Telefono</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtTelefono_ManteCliente">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Email</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtEmail_ManteCliente">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12 campoN">Obs</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtObs_ManteCliente">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Habilitado</div>'+
							'<div class="col-md-8 col-sm-6 col-xs-12">'+
								'<input type="checkbox" class="chkHabilitado" id="chkHabilitado_ManteCliente" checked>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_ManteCliente" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Modal_Print_FBG=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal modal-lg" role="document">'+
				'<div class="modal-content modal-lg">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Impresion</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<iframe id="IdPrintBVF" type="application/pdf" width="100%" height="500px"></iframe>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_Print_Ticket=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal modal-lg" role="document">'+
				'<div class="modal-content modal-lg">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Ticket</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<iframe id="IdPrintBVF" type="application/pdf" width="100%" height="500px"></iframe>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_Print_Pago=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal modal-lg" role="document">'+
				'<div class="modal-content modal-lg">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Ticket Pago</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<iframe id="IdPrintBVFPay" type="application/pdf" width="100%" height="500px"></iframe>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Mante_GuiaR_Factura=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Guia Remision</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-2 col-sm-2 col-xs-6">Serie</div>'+
							'<div class="col-md-2 col-sm-2 col-xs-6">'+
								'<input type="text" class="form_input" id="txtSerie_GRFA" readonly>'+
							'</div>'+
							'<div class="col-md-2 col-sm-2 col-xs-6">Numero</div>'+
							'<div class="col-md-4 col-sm-4 col-xs-6">'+
								'<input type="text" class="form_input" id="txtNumero_GRFA">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-3 col-xs-6">Tipo Doc</div>'+
							'<div class="col-md-9 col-sm-9 col-xs-6">'+
								'<select id="cboTipoDoc_ProcVenta"><option value="0">Otros</option></select>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-3 col-xs-6">Ruc</div>'+
							'<div class="col-md-9 col-sm-9 col-xs-6">'+
								'<input type="text" class="form_input" id="txtRuc_GRFA" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-3 col-xs-6">Rason Social</div>'+
							'<div class="col-md-9 col-sm-9 col-xs-12">'+
								'<input type="text" class="form_input" id="txtRS_GRFA" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Direccion</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtDireccion_GRFA" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Factura Nro</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtFactura_GRFA" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" id="IdContentRVenta">'+
								'<table class="claTableRegD" id="IdTableDato_GRFA">'+
									'<thead><tr class="">'+
										'<th>Cant</th><th>Unidad</th><th>Codigo</th><th>Descripcion</th><th>P.U.</th><th>Importe</th>'+
										'<th style="display:none">IdProd</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-4">'+
								
							'</div>'+
							'<div class="col-md-4 col-sm-4 col-xs-6 right">Total</div>'+
							'<div class="col-md-4 col-sm-4 col-xs-6">'+
								'<input type="text" class="form_input" id="txtTotall_GRFA" readonly>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_GRFA" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_GuiaR_Factura_Group=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Agrupar Guia Remision</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-2 col-sm-2 col-xs-6">Serie</div>'+
							'<div class="col-md-2 col-sm-2 col-xs-6">'+
								'<input type="text" class="form_input" id="txtSerie_GRFA" readonly>'+
							'</div>'+
							'<div class="col-md-2 col-sm-2 col-xs-6">Numero</div>'+
							'<div class="col-md-4 col-sm-4 col-xs-6">'+
								'<input type="text" class="form_input" id="txtNumero_GRFA">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-3 col-xs-6">Tipo Doc</div>'+
							'<div class="col-md-9 col-sm-9 col-xs-6">'+
								'<select id="cboTipoDoc_ProcVenta"><option value="0">Otros</option></select>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-3 col-xs-6">Ruc</div>'+
							'<div class="col-md-9 col-sm-9 col-xs-6">'+
								'<input type="text" class="form_input" id="txtRuc_GRFA" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-3 col-xs-6">Rason Social</div>'+
							'<div class="col-md-9 col-sm-9 col-xs-12">'+
								'<input type="text" class="form_input" id="txtRS_GRFA" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Direccion</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtDireccion_GRFA" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Factura Nro</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtFactura_GRFA" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" id="IdContentRVenta">'+
								'<table class="claTableRegD" id="IdTableDato_GRFA">'+
									'<thead><tr class="">'+
										'<th>Cant</th><th>Unidad</th><th>Codigo</th><th>Descripcion</th><th>P.U.</th><th>Importe</th>'+
										'<th style="display:none">IdProd</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-4">'+
								
							'</div>'+
							'<div class="col-md-4 col-sm-4 col-xs-6 right">Total</div>'+
							'<div class="col-md-4 col-sm-4 col-xs-6">'+
								'<input type="text" class="form_input" id="txtTotall_GRFA" readonly>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_GRFAGroup" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_PagoCliente_Fact=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">PAGO CLIENTE</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-12 right">Cliente</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-12">'+
								'<textarea type="text" class="form_input" id="txtClient_PagoVentaFa" readonly></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" id="IdContentRVentaPago">'+
								'<table class="claTableRegD" id="IdTableDato_GRFAPago">'+
									'<thead><tr class="">'+
										'<th>Comprobante</th><th>Serie</th><th>Numero</th><th>Monto</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6 right">Total</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input center" id="txtTotal_PagoVentaFa" readonly>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_PagoClienteFA" class="btn btn-primary">PAGAR</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_FechaDetr_Fact=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">FECHA DETRACCION</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-12 right">Fecha Detraccion</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-12">'+
								'<input type="text" class="form_input" id="txtFecha_FecDetVIE" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-12 right">Monto</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-12">'+
								'<input type="text" class="form_input" id="txtMonto_FecDetVIE" value="0" onkeypress="return Valido_Numero_Decimal(event,this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6 right">Tipo Pago</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input center" id="txtTipoPago_FecDetVIE">'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_fecDetFA" class="btn btn-primary">GUARDAR</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_TipoCambio=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">TIPO CAMBIO</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-12 right">Tipo Cambio</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-12">'+
								'<input type="text" class="form_input" id="txtMonto_TC" value="0" onkeypress="return Valido_Numero_Decimal(event,this)">'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_TipoCambio" class="btn btn-primary">GUARDAR</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Modal_Venta_NPP=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content modal-lg">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Nota Pedido Pendientes</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5 ">'+
							'<div class="table-responsive">'+
								'<table class="claTableRegD" id="IdTableNP_VentaNP">'+
									'<thead><tr>'+
										'<th>Sel</th><th>Fecha</th><th>C</th><th>S/Nro</th><th>NroDoc</th><th>RS/Nombres</th><th>Total</th><th>User</th>'+
								'</tr></thead><tbody></tbody></table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnAddNP_VentaNP" class="btn btn-primary">Agregar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_VerDispoProducto_RVenta=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content modal-lg">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">DISPONIBILIDAD DE PRODUCTOS</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5 ">'+
							'<div class="table-responsive">'+
								'<table class="claTableRegD" id="IdTableVerDispo_RVenta">'+
									'<thead><tr>'+
										'<th>Almacen</th><th>Producto</th><th>Stock</th><th>Unidad</th><th>PPublico</th><th>PBase</th><th>PDistribuido</th>'+
								'</tr></thead><tbody></tbody></table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Modal_Venta_DeudaCliente=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal modal-lg" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Deudas Cliente</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5 ">'+
							'<div class="table-responsive">'+
								'<table class="claTableRegD" id="IdTableDeuda_VentaDC">'+
									'<thead><tr>'+
										'<th>Fecha</th><th>C</th><th>S</th><th>Nro</th><th>Total</th>'+
								'</tr></thead><tbody></tbody></table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Mante_Factura_GuiaR=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Generar Factura</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-2 col-sm-2 col-xs-6">Serie</div>'+
							'<div class="col-md-2 col-sm-2 col-xs-6">'+
								'<input type="text" class="form_input" id="txtSerie_GRFA" readonly>'+
							'</div>'+
							'<div class="col-md-2 col-sm-2 col-xs-6">Numero</div>'+
							'<div class="col-md-4 col-sm-4 col-xs-6">'+
								'<input type="text" class="form_input" id="txtNumero_GRFA">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-3 col-xs-6">Tipo Doc</div>'+
							'<div class="col-md-9 col-sm-9 col-xs-6">'+
								'<select id="cboTipoDoc_ProcVenta"><option value="0">Otros</option></select>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-3 col-xs-6">Ruc</div>'+
							'<div class="col-md-9 col-sm-9 col-xs-6">'+
								'<input type="text" class="form_input" id="txtRuc_GRFA">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-3 col-xs-6">Rason Social</div>'+
							'<div class="col-md-9 col-sm-9 col-xs-12">'+
								'<input type="text" class="form_input" id="txtRS_GRFA">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Direccion</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtDireccion_GRFA">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-3 col-sm-6 col-xs-12">Guia Numero</div>'+
							'<div class="col-md-9 col-sm-6 col-xs-12">'+
								'<input type="text" class="form_input" id="txtFactura_GRFA" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" id="IdContentRVenta">'+
								'<table class="claTableRegD" id="IdTableDato_GRFA">'+
									'<thead><tr class="">'+
										'<th>Cant</th><th>Unidad</th><th>Codigo</th><th>Descripcion</th><th>P.U.</th><th>Dscto</th><th>Importe</th>'+
										'<th style="display:none">IdProd</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-2 col-sm-2 col-xs-6 center">'+
								'IGV </br> <input type="checkbox" id="IdChkIGVPVe" class="chk2020 claIGVPVentaFac" checked="">'+
							'</div>'+
							'<div class="col-md-3 col-sm-3 col-xs-6 center">'+
								'Sub Total </br> <input type="text" class="form_input" id="txtSubTotal_ProcVenta" readonly="" value="0">'+
							'</div>'+
							'<div class="col-md-3 col-sm-3 col-xs-6 center">'+
								'I.G.V. </br> <input type="text" class="form_input" id="txtIGV_ProcVenta" readonly="" value="0">'+
							'</div>'+
							'<div class="col-md-3 col-sm-3 col-xs-6 center">'+
								'Total </br> <input type="text" class="form_input" id="txtTotall_GRFA" readonly="" value="0">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-6 col-sm-6 col-xs-6">'+
								'Condiciones Pago </br> <select id="cboCPago_ProcVenta"></select>'+
							'</div>'+
							'<div class="col-md-6 col-sm-6 col-xs-6">'+
								'Tipo Bien </br><select id="cboTipoBien_ProcVenta"><option value="0">Otros</option></select>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_GRFA" class="btn btn-primary">Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Mante_ReportCompra_Detalle_Ver=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">DETALLE COMPRA</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" >'+
								'<table class="claTableRegD" id="IdTableDato_ReportCompraVer">'+
									'<thead><tr class="">'+
										'<th>Cant</th><th>Codigo</th><th>Descripcion</th><th>Unidad</th><th>P.U.</th><th>Importe</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_ProcMovAlm_Detalle_Ver=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">DETALLE MOVIMIENTO</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" >'+
								'<table class="claTableRegD" id="IdTableDato_ReportMovAlmVer">'+
									'<thead><tr class="">'+
										'<th>Cant</th><th>Codigo</th><th>Descripcion</th><th>Unidad</th><th>P.U.</th><th>Importe</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Mante_ReportCompraS_Detalle_Ver=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">DETALLE COMPRA SIMPLE</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" >'+
								'<table class="claTableRegD" id="IdTableDato_ReportCompraSVer">'+
									'<thead><tr class="">'+
										'<th>Cant</th><th>Codigo</th><th>Descripcion</th><th>Unidad</th><th>P.U.</th><th>Importe</th><th>P.Publico</th><th>P.Menor</th><th>P.Mayor</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Mante_ReportNP_Detalle_Ver=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">DETALLE NP</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="table-responsive" >'+
								'<table class="claTableRegD" id="IdTableDato_ReportNPVer">'+
									'<thead><tr class="">'+
										'<th>Cant</th><th>Codigo</th><th>Descripcion</th><th>Unidad</th><th>P.U.</th><th>Importe</th>'+
									'</tr></thead><tbody class="buscar"></tbody>'+
								'</table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Modal_VentaCredito_Venta=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content modal-lg">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">VENTA CREDITO</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-1 col-sm-2 col-xs-6">Total</div>'+
							'<div class="col-md-3 col-sm-4 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtTotalVenta_VPV" readonly>'+
							'</div>'+
							'<div class="col-md-1 col-sm-2 col-xs-6">Ruc</div>'+
							'<div class="col-md-3 col-sm-4 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtRuc_VPV" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-2 col-sm-2 col-xs-4">Rason Social</div>'+
							'<div class="col-md-10 col-sm-10 col-xs-8">'+
								'<input type="text" class="form_input claReadonly" id="txtRS_VPV" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Nro Cuota</br><input type="text" class="form_input" id="txtNroCuota_addVPV" onkeypress="return NroEntero3D(event, this)">'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Monto</br><input type="text" class="form_input" id="txtMonto_addVPV" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Interes</br><input type="text" class="form_input" id="txtInteres_addVPV" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Total</br><input type="text" class="form_input claReadonly" id="txtTotal_addVPV" readonly onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Fecha Pago</br><input type="text" class="form_input claReadonly" id="txtFechaPago_addVPV" readonly>'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'<button type="button" id="btnAddDetail_VPV" class="btnProceso m-t-10"><i class="fas fa-plus-square f-18"></i> Agregar</button>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5 ">'+
							'<div class="table-responsive">'+
								'<table class="claTableRegD" id="IdTableCredito_VPV">'+
									'<thead><tr>'+
										'<th>X</th><th>E</th><th>NroC</th><th>Monto</th><th>Interes</th><th>Total</th><th>Fecha Pago</th>'+
								'</tr></thead><tbody></tbody></table>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-2 col-sm-2 col-xs-4">Total Monto</div>'+
							'<div class="col-md-4 col-sm-4 col-xs-8">'+
								'<input type="text" class="form_input claReadonly" id="txtTotalMonto_VPV" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-2 col-sm-2 col-xs-4">Vendedor</div>'+
							'<div class="col-md-4 col-sm-4 col-xs-8">'+
								'<select id="cboVendedor_VPV"></select>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSaveVentaCredito_VPV" class="btnGuardar btn-verde"><i class="fas fa-save f-18"></i> Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Modal_VentaCredito_Pago=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">PAGO CUOTA</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Nro Cuota</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtNroCuota_VCrdPAY" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Monto</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtMonto_VCrdPAY" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Mora</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input" id="txtMora_VCrdPAY" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Total Pagar</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtTotalPagar_VCrdPAY" readonly>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_VCrdPAY" class="btn btn-primary">PAGAR</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_VentaCredito_PagoProve=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">PAGO CUOTA</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Nro Cuota</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtNroCuota_VCrdPAY" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Monto</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtMonto_VCrdPAY" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Mora</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input" id="txtMora_VCrdPAY" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Total Pagar</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtTotalPagar_VCrdPAY" readonly>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSave_PAYCRDPROV" class="btn btn-primary">PAGAR</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Modal_VentaCredito_Details=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content modal-lg">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">VENTA CREDITO DETALLE</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5 ">'+
							'<div class="table-responsive">'+
								'<table class="claTableRegD" id="IdTableCredito_VPVDetails">'+
									'<thead><tr>'+
										'<th>Nro Cuota</th><th>Monto</th><th>Interes</th><th>Total</th><th>Fecha Venc</th><th>Estado</th><th>Usuario</th>'+
								'</tr></thead><tbody></tbody></table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_CompraCreditoProv_Details=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content modal-lg">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">COMPRA CREDITO DETALLE</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5 ">'+
							'<div class="table-responsive">'+
								'<table class="claTableRegD" id="IdTableCredito_COMPCRDPROV">'+
									'<thead><tr>'+
										'<th>Nro Cuota</th><th>Monto</th><th>Interes</th><th>Total</th><th>Fecha Venc</th><th>Estado</th><th>Usuario</th>'+
								'</tr></thead><tbody></tbody></table>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Modal_CompraCredito_Compra=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content modal-lg">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">COMPRA CREDITO</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-1 col-sm-2 col-xs-6">Total</div>'+
							'<div class="col-md-3 col-sm-4 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtTotalVenta_CPC" readonly>'+
							'</div>'+
							'<div class="col-md-1 col-sm-2 col-xs-6">Proveedor</div>'+
							'<div class="col-md-7 col-sm-6 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtProveedor_CPC" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Nro Cuota</br><input type="text" class="form_input" id="txtNroCuota_addCPC" onkeypress="return NroEntero3D(event, this)">'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Monto</br><input type="text" class="form_input" id="txtMonto_addCPC" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Interes</br><input type="text" class="form_input" id="txtInteres_addCPC" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Total</br><input type="text" class="form_input claReadonly" id="txtTotal_addCPC" readonly onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Fecha Pago</br><input type="text" class="form_input claReadonly" id="txtFechaPago_addCPC" readonly>'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'<button type="button" id="btnAddDetail_CPC" class="btnProceso m-t-10"><i class="fas fa-plus-square f-18"></i> Agregar</button>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5 ">'+
							'<div class="table-responsive">'+
								'<table class="claTableRegD" id="IdTableCredito_CPC">'+
									'<thead><tr>'+
										'<th>X</th><th>E</th><th>NroC</th><th>Monto</th><th>Interes</th><th>Total</th><th>Fecha Pago</th>'+
								'</tr></thead><tbody></tbody></table>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-2 col-sm-2 col-xs-4">Total Monto</div>'+
							'<div class="col-md-4 col-sm-4 col-xs-8">'+
								'<input type="text" class="form_input claReadonly" id="txtTotalMonto_CPC" readonly>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSaveCompraCredito_CPC" class="btnGuardar btn-verde"><i class="fas fa-save f-18"></i> Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';
var Form_Modal_CompraCredito_CompraEdit=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content modal-lg">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">COMPRA CREDITO EDITAR</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-1 col-sm-2 col-xs-6">Total</div>'+
							'<div class="col-md-3 col-sm-4 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtTotalVenta_CPC" readonly>'+
							'</div>'+
							'<div class="col-md-1 col-sm-2 col-xs-6">Proveedor</div>'+
							'<div class="col-md-7 col-sm-6 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtProveedor_CPC" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Nro Cuota</br><input type="text" class="form_input" id="txtNroCuota_addCPC" onkeypress="return NroEntero3D(event, this)">'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Monto</br><input type="text" class="form_input" id="txtMonto_addCPC" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Interes</br><input type="text" class="form_input" id="txtInteres_addCPC" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Total</br><input type="text" class="form_input claReadonly" id="txtTotal_addCPC" readonly onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'Fecha Pago</br><input type="text" class="form_input claReadonly" id="txtFechaPago_addCPC" readonly>'+
							'</div>'+
							'<div class="col-md-2 col-sm-4 col-xs-6">'+
								'<button type="button" id="btnAddDetail_CPC" class="btnProceso m-t-10"><i class="fas fa-plus-square f-18"></i> Agregar</button>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5 ">'+
							'<div class="table-responsive">'+
								'<table class="claTableRegD" id="IdTableCredito_CPCEdit">'+
									'<thead><tr>'+
										'<th>X</th><th>E</th><th>NroC</th><th>Monto</th><th>Interes</th><th>Total</th><th>Fecha Pago</th>'+
								'</tr></thead><tbody></tbody></table>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-2 col-sm-2 col-xs-4">Total Monto</div>'+
							'<div class="col-md-4 col-sm-4 col-xs-8">'+
								'<input type="text" class="form_input claReadonly" id="txtTotalMonto_CPC" readonly>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSaveCompraCredito_CPCEdit" class="btnGuardar btn-verde"><i class="fas fa-save f-18"></i> Guardar</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Modal_CompraCredito_PagarSimple=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content ">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">COMPRA CREDITO PAGAR</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Proveedor</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtProveedor_CPCPAY" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Total</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtTotalVenta_CPCPAY" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Mora</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input" id="txtMora_addCPC" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Total Pagar</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtTotalPagar_CPCPAY" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Fecha Pago</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtFechaPago_CPCPAY" readonly>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSaveCompraCredito_CPCPAY" class="btnGuardar btn-verde"><i class="fas fa-save f-18"></i> PAGAR</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_Modal_VentaCredito_PagarSimple=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal" role="document">'+
				'<div class="modal-content ">'+
				  '<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">VENTA CREDITO PAGAR</h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Cliente</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<textarea type="text" class="form_input claReadonly" id="txtCliente_CPVNETA" readonly></textarea>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Total</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtTotalVenta_CPVNETA" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Mora</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input" id="txtMora_CPVNETA" onkeypress="return Valido_Numero_Decimal(event, this)">'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Total Pagar</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtTotalPagar_CPVNETA" readonly>'+
							'</div>'+
						'</div>'+
						'<div class="row p-t-5">'+
							'<div class="col-md-4 col-sm-4 col-xs-6">Fecha Pago</div>'+
							'<div class="col-md-8 col-sm-8 col-xs-6">'+
								'<input type="text" class="form_input claReadonly" id="txtFechaPago_CPVNETA" readonly>'+
							'</div>'+
						'</div>'+
				  '</div>'+
				  '<div class="modal-footer">'+
					'<button type="button" id="btnSaveCompraCredito_CPVNETA" class="btnGuardar btn-verde"><i class="fas fa-save f-18"></i> PAGAR</button>'+
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
var Form_VisorFBV_Venta=
			'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
			  '<div class="modal-dialog topModal " role="document">'+
				'<div class="modal-content modal-lg">'+
				  '<div class="modal-header">'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
				  '</div>'+
				  '<div class="modal-body">'+
						'<div class="row p-t-5" id="IdPrintFB">'+
							//'<embed frameborder="0" width="100%" id="IdPrintFB" height="400px">'+
							//'<iframe type="application/pdf" width="100%" height="500px" id="IdPrintFB"></iframe>'+
						'</div>'+
				  '</div>'+
				'</div>'+
			  '</div>'+
			'</div>';			
			
			
			
			
			