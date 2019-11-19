<div class="row">
    <div class="col-md-6">
        <h4>Roles y Permisos del Sistema</h4>
    </div>
    <div class="col-md-3">

       
    </div>
    <div class="col-md-4">
        <table class="table table-hover table-sm table-bordered" id="TableRoles">
        <thead>
            <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>         
            <?php foreach ($parameter[0] as $key => $User): ?>
                <tr id='Rol<?php echo $User["id_rol"] ?>'>
                <td><?php echo $User["name"] ?></td>
                <td><?php echo $User["description"] ?></td>
                <td>
                    <button type="button" class="btn btn-primary" onclick='EditRol(<?php echo $User["id_rol"] ?>)'><i class="fas fa-pen"></i></button>
                    <button type="button" class="btn btn-primary" onclick='DeleteRol(<?php echo $User["id_rol"] ?>)'><i class="fas fa-user-minus"></i></button>
                </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        </table>
    </div>
    <div class="col-md-8">
        <table class="table table-hover table-sm table-bordered" id="TablePermission">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Modulo</th>
                <th scope="col">Funcion</th>
                <th scope="col">Description</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody id="detailPermission">
            <?php foreach ($parameter[1] as $key => $Permission): ?>
                <tr id='Permission<?php echo $Permission["id_permission"] ?>'>
                <td><?php echo $Permission["name"] ?></td>
                <td><?php echo $Permission["module"] ?></td>
                <td><?php echo $Permission["function"] ?></td>
                <td><?php echo $Permission["description"] ?></td>
                <td>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id='State<?php echo $Permission["id_permission"] ?>'>
                        <label class="custom-control-label" for='State<?php echo $Permission["id_permission"] ?>'></label>
                    </div>
                </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        </table>
        <button type="button" class="btn btn-primary" id="buttonSave" onclick="SavePermissionRol()" style="display:none;">Guardar</button>
        <button type="button" class="btn btn-danger" id="buttonCancel" onclick="CancelEdit()" style="display:none;">Cancelar</button>
    </div>
</div>
<script type="text/javascript" src="/OSE-skynet/ose/Asset/js/Manager/Permission.js"></script>