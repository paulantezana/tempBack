$(window).on('load',function(){var inst=new ClassConfPermisoUserF();$("#IdAlmacenPri").css("display","none");
	inst.getList_Config_PermisoUser();
	$("#btnSaveConfPermisoUserVOS").on('click',function(e){inst.Create_Mante_ConfPermisoUser();});
	$("#cboTipoUser_PermisoVOS").on('change',function(e){
		inst.Disabled_chk_ConfPermisoUser();
		var IdTipo=$("select#cboTipoUser_PermisoVOS option:selected").val();
		if(IdTipo!="-1"){inst.getList_Config_PermisoUserDatos(IdTipo);}
	});
});
function ClassConfPermisoUserF(){
	this.getList_Config_PermisoUser=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"getList_Config_PermisoUser"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var TipoUser=e["TipoUser"],Menu=e["Menu"];var inst=new ClassConfPermisoUserF();
				if(TipoUser.length>0){
					$("#cboTipoUser_PermisoVOS").empty();
					$("#cboTipoUser_PermisoVOS").append('<option value="-1">Seleccione</option>');
					for(var i=0;i<TipoUser.length;i++){
						$("#cboTipoUser_PermisoVOS").append('<option value="'+TipoUser[i]["IdTipoUsuario"]+'">'+TipoUser[i]["TipoUsuario"]+'</option>');					
					}
					$("#cboTipoUser_PermisoVOS").chosen({width: "100%"});
				}
				if(Menu.length>0){
					inst.Build_Mante_TipoUserVOS(Menu);
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Mante_TipoUserVOS=function(Datos){
		$("#IdTableConfPermisoUserVOS tbody").html("");
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdForm"];
			$('#IdTableConfPermisoUserVOS tbody').append('<tr>'+
				'<td>'+Datos[i]["Menu"]+'</td>'+
				'<td>'+Datos[i]["Nombre"]+'</td>'+
				'<td id="HabPermisoUserVOS_'+ids+'" class="center">'+
					'<input type="checkbox" class="chk2020 chkHabPermisoUserVOS" id="chkHabPermisoUserT_'+ids+'">'+
				'</td> '+
			'</tr>');
		}
		var altM=parseFloat($(window).height())-parseFloat(270);;
		$(".table-responsive").css({"overflow-y":"scroll","height":altM+"px"});
	}
	this.Disabled_chk_ConfPermisoUser=function(){
		$(".chkHabPermisoUserVOS").each(function(e){
			var ids=($(this)[0].id).split('_')[1];
			$("#chkHabPermisoUserT_"+ids).prop('checked', false);
		});
	}
	this.getList_Config_PermisoUserDatos=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"getList_Config_PermisoUserDatos",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();
				if(e.length>0){
					for(var i=0;i<e.length;i++){
						var aIds=e[i]["IdForm"];
						$("#chkHabPermisoUserT_"+aIds).prop('checked', true);
					}
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.Create_Mante_ConfPermisoUser=function(){
		var inst=new ClassConfPermisoUserF();
		var IdTipo=$("select#cboTipoUser_PermisoVOS option:selected").val();
		if(IdTipo!="-1"){
			var arrayDat=[];
			$(".chkHabPermisoUserVOS").each(function(e){
				var ids=($(this)[0].id).split('_')[1],chkk=$(this)[0].checked;
				if(chkk){arrayDat.push({"aId":ids}); }
			});
			inst.Save_Config_PermisoUser([IdTipo,arrayDat]);
		}else{
			(function(){vex.defaultOptions.className = 'vex-theme-os';})();vex.dialog.alert("Seleccione Tipo Usuario.");
		}
	}
	this.Save_Config_PermisoUser=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objRegistro",action:"Save_Config_PermisoUser",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
}