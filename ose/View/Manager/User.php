<div class="row">
    <div class="col-md-6">
        <h4>Lista de Usuarios</h4>
    </div>
    <div class="col-md-2">
        <h4>
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-user-plus"></i> Crear Usuarios</button> -->
        <button type="button" class="btn btn-primary" onclick='CreateUsers()' name='verifyagregar' style="display:none;"><i class="fas fa-user-plus"></i> Crear Usuarios</button>
        </h4>
       
    </div>
    <div class="col-md-12">
        <table class="table table-hover table-sm table-bordered" id="TableUsers">
        <thead>
            <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Telefono</th>
            <th scope="col">Tipo de Usuario</th>
            <th scope="col">Estado</th>
            <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody id="UsersDetail">
        </tbody>
        </table>
    </div>
</div>
<!-- Modal usuarios -->
<div class="modal fade" id="modalUsers" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModal">Crear Usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id='formUser' onsubmit="">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="names">Nombres</label>
                    <input type="text" class="form-control" id="names" placeholder="Nombres" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Correo Electronico" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="phone">Telefono</label>
                    <input type="number" class="form-control" id="phone" placeholder="Telefono" >
                </div>
                <div class="form-group col-md-6">
                    <label for="ruc">Ruc</label>
                    <input type="text" class="form-control" id="ruc" placeholder="Ruc">
                </div>
                <div class="form-group col-md-12">
                    <label for="address">Direccion</label>
                    <input type="text" class="form-control" id="address" placeholder="Direccion">
                </div>
                <div class="form-group col-md-6">
                    <!-- <label for="typeUser">Tipo Usuario</label>
                    <input type="text" class="form-control" id="typeUser" placeholder="Tipo de Usuario" required> -->
                    <div class="form-group">
                        <label for="typeUser">Tipo de Usuario</label>
                        <select class="form-control" id="typeUser">
                        <?php foreach ($parameter[0] as $key => $Rol): ?>
                            <option value='<?php echo $Rol["id_rol"] ?>'><?php echo $Rol["name"] ?></option>
                        <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" placeholder="Contraseña" pattern="(?=^.{4,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"  required>
                </div>
                <div class="custom-control custom-switch col-md-3 offset-md-4">
                    <input type="checkbox" class="custom-control-input" id="enabled">
                    <label class="custom-control-label" for="enabled">Habilitar</label>
                </div>
            </div>
            <div class="row">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" id='ButtonSaveUser'>Guardar</button>
            </div>
        </form>
        
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="/OSE-skynet/ose/Asset/js/Manager/User.js"></script>