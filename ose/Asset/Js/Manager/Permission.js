var StateUpdate=false;
var IdUpdate=0;
$(document).ready(function(){
    
});
function EditRol(IdRol){
    CancelEdit();
    $.ajax({
        type: "GET",
        dataType : 'json',
		url: "/OSE-skynet/ose/Permission/GetPermissionsRol",
        data: {
			IdRol : IdRol,
        },
        success: function(RolPermission){
            //try {
                IdUpdate=IdRol;
                //var RolPermission = JSON.parse(result);
                RolPermission.forEach(element => {
                    document.getElementById("State"+element['id_permission']).checked = true;
                });
                $("#Rol"+IdUpdate).addClass( "table-primary" );
                $("#buttonSave").show();
                $("#buttonCancel").show();
			//}
			// catch(err) {
            //     IdUpdate=0;
			//     alert(result + '|' + err.message);
			// }
        },
        error: function (error) {
            IdUpdate=0;
            location.href=error.responseText;
         },
        complete: function(){
        	
        }
    });
}
function CancelEdit(){
    $("#Rol"+IdUpdate).removeClass( "table-primary" );
    $('input:checkbox').each(function(){
        $(this)[0].checked=false;
    });
    $("#buttonSave").hide();
    $("#buttonCancel").hide();
}
function SavePermissionRol(){
    let PartialPermissions=[];
    
    $("#detailPermission tr").each(function (index){
        let aIdPermission=$(this)[0].id.split('Permission');
        let aStatePermission=$('#State'+aIdPermission[1]).prop('checked');
        if (aStatePermission==true) {
            PartialPermissions.push(aIdPermission[1]);            
        }
    });
    $.ajax({
    	type: "POST",
		url: "/OSE-skynet/ose/Permission/UpdatePermissions",
        data: {
			PartialPermissions : PartialPermissions,
			idRol : IdUpdate,
        },
        success: function(result){
            let answer=JSON.parse(result);
            if (answer['result']) {
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
        error: function (error) {
            console.log(error);
         },
        complete: function(){
        	
        }
    });
}