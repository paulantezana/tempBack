var Update=false;
var IdSelected=0;
$(document).ready(function(){
    ListUsers();
    VerifyFunctions($('#functionMenuUser').val(),'');
});
function ListUsers(){
    $.ajax({
    	type: "GET",
		url: "/OSE-skynet/ose/User/ListUsers",
        success: function(res){
            $('#UsersDetail').html(res);
        },
	});
}
function EditUsers(IdUser){
    document.getElementById("formUser").reset();
    $.ajax({
        type: "GET",
        dataType : 'json',
		url: "/OSE-skynet/ose/User/GetUser",
        data: {
			idUserUpdate : IdUser,
        },
        success: function(result){console.log(result);
        	// try {
			    //var res = JSON.parse(result);
                Update=true;
                IdSelected=IdUser;
                $('#modalUsers').modal('show');
                $('#formUser').attr('onsubmit','UpdateUser()');
                $('#ButtonSaveUser').html('Actualizar');
                $('#titleModal').html('Actualizar Usuario');
                $('#names').val(result['names']);
                $('#email').val(result['email']);
                $('#phone').val(result['phone']);
                $('#ruc').val(result['ruc']);
                $('#address').val(result['address']);
                $('#ruc').val(result['ruc']);
                $('#typeUser').val(result['id_rol']);
                $('#enabled').prop("checked", (result['state']==1)?true:false);
			// }
			// catch(err) {
			//     alert(result + '|' + err.message);
			// }
        },
        complete: function(){
        	
        },
        error: function (error) {
           location.href=error.responseText;
        }
	});

}
function DeleteUsers(IdUser){
    Swal.fire({
        title: 'Estas seguro de eliminar?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
      }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: "/OSE-skynet/ose/User/DeleteUser",
                data: {
                    idUserDelete : IdUser,
                },
                success: function(result){
                    Swal.fire(
                        'Eliminado!',
                        'El usuario fue eliminado.',
                        'success'
                      )
                },
                error: function (error) {
                   location.href=error.responseText;
                }
            });



        }
    });
}
function CreateUsers(){
    Update=false;
    $('#modalUsers').modal('show');
    $('#formUser').attr('onsubmit','SaveUser()');
    $('#ButtonSaveUser').html('Guardar');
    $('#titleModal').html('Crear Usuario');

}
function SaveUser(){
    let User=new Object();
    User.names=$('#names').val();
    User.email=$('#email').val();
    User.phone=$('#phone').val();
    User.ruc=$('#ruc').val();
    User.address=$('#address').val();
    User.typeUser=$('#typeUser').val();
    User.password=$('#password').val();
    User.state=$('#enabled').is(":checked")?true:false;
    if (VerifyData(User)) {
        RegisterUser(User);
    }
}
function VerifyData(User){
    let answer=true;
    let mesagge='';
    if (User.names.trim()=='' || User.names.length<2) {
        answer=false;
        mesagge+='-<strong>Falta agregar nombres</strong><br/>';
    }
    if (User.email.length<4) {
        answer=false;
        mesagge+='-<strong>Falta agregar Correo Electronico</strong><br/>';
    }
    if (isNaN(User.phone)) {
        answer=false;
        mesagge+='-<strong>Falta agregar Telefono</strong><br/>';
    }
    if (isNaN(User.ruc)) {
        answer=false;
        mesagge+='-<strong>Falta agregar Ruc</strong><br/>';
    }
    if (User.typeUser.trim()=='') {
        answer=false;
        mesagge+='-<strong>Falta asignar un Tipo de Usuario</strong><br/>';
    }
    if (User.password.trim()=='' || User.password.length<4) {
        answer=false;
        mesagge+='-<strong>La contraseña debe tener minimo de 4 caracteres</strong><br/>';
    }
    if (!answer) {
        Swal.fire({
            title: '<h4>Se encontraron los siguientes errores</h4>',
            type: 'error',
            html:
                mesagge,
            timer: 3000
        })
    }
    return answer;
}
function RegisterUser(User){
	$.ajax({
        type: "POST",
        dataType : 'json',
		url: "/OSE-skynet/ose/User/RegisterUser",
        data: {
			User : User,
        },
        success: function(result){console.log(result);
            let answer=JSON.parse(result);
            if (answer['result']) {
                document.getElementById("formUser").reset();
                $('#modalUsers').modal('hide');
                ListUsers();
                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: 'Guardado Correctamente',
                    showConfirmButton: false,
                    timer: 1500
                  })
            }else{
                Swal.fire({
                    title: '<h4>Se encontraron los siguientes errores</h4>',
                    type: 'error',
                    html:
                        answer['mesagge'],
                    timer: 3000
                })
            }
        },
        complete: function(){
        	
        },
        error: function (error) {
           location.href=error.responseText;
        }
	});
}
function UpdateUser(){
    let User=new Object();
    User.id=IdSelected;
    User.names=$('#names').val();
    User.email=$('#email').val();
    User.phone=$('#phone').val();
    User.ruc=$('#ruc').val();
    User.address=$('#address').val();
    User.typeUser=$('#typeUser').val();
    User.password=$('#password').val();
    User.state=$('#enabled').is(":checked")?'1':'0';
    if (VerifyData(User)) {
        SendUpdateUser(User);
    }
}
function SendUpdateUser(User){
	$.ajax({
        type: "POST",
        dataType : 'json',
		url: "/OSE-skynet/ose/User/UpdateUser",
        data: {
			User : User,
        },
        success: function(answer){
            //let answer=JSON.parse(result);
            if (answer['result']) {
                document.getElementById("formUser").reset();
                $('#modalUsers').modal('hide');
                ListUsers();
                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: 'Guardado Correctamente',
                    showConfirmButton: false,
                    timer: 1500
                  })
            }else{
                Swal.fire({
                    title: '<h4>Se encontraron los siguientes errores</h4>',
                    type: 'error',
                    html:
                        answer['mesagge'],
                    timer: 3000
                })
            }
        },
        complete: function(){
        	
        },
        error: function (error) {
            console.log(error);
           //location.href=error.responseText;
        }
	});
}
