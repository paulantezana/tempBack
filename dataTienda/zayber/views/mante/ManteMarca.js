$(window).on('load',function(){var inst=new ClassMarca();$("#IdAlmacenPri").css("display","none");
	inst.getList_Mante_Marca();
	$("#btnNewMarca").on('click',function(e){
		inst.Create_Mante_Marca("-1");
	});
});
function ClassMarca(){
	this.getList_Mante_Marca=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Marca"},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				var inst=new ClassMarca();inst.Build_Mante_Marca(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Mante_Marca=function(Datos){var inst=new ClassMarca();
		$("#IdTableManteMarca tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdMarca"];
			$('#IdTableManteMarca tbody').append('<tr>'+
					'<td id="editManteMarca_'+ids+'" class="center">'+
						'<i class="fas fa-edit f-18"></i>'+
					'</td>'+
					'<td>'+Datos[i]["Marca"]+'</td>'+
					'<td>'+Datos[i]["Simbolo"]+'</td> '+
					'<td class="center">'+Datos[i]["Est"]+'</td> '+
				'</tr>');
		}
		$('#filtrar').keyup(function(){
            var rex = new RegExp($(this).val(), 'i');
            $('.buscar tr').hide();
            $('.buscar tr').filter(function (){
                return rex.test($(this).text());
            }).show();
        });
		
		var altM=parseFloat($(window).height())-parseFloat(250);;
		$(".table-responsive").css({"overflow-y":"scroll","height":altM+"px"});
		
		$('#IdTableManteMarca tbody').unbind("click");
		$('#IdTableManteMarca tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteMarca'){
				inst.Create_Mante_Marca(id[1]);
			}
		});
	}
	this.Create_Mante_Marca=function(pId){
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Mante_Marca);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		var inst=new ClassMarca();
		if(pId!="-1"){inst.getList_Mante_Marca_Edit(pId);}
		
		$("#txtSave_Marca").on('click',function(e){
			var Marca=$("#txtMarca_Marca").val();
			var Simbol=$("#txtSimbolo_Marca").val();
			var IdEst=$("#chkHabilitado_Marca").is(':checked') ? 1 : 0;
			if(Marca!=""){
				inst.Save_Mante_Marca([pId,Marca,Simbol,IdEst]);
			}else{
				alertify.error("Alerta, Completar Datos.");
			}
		});
	}
	this.getList_Mante_Marca_Edit=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Marca_Edit",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e;
				if(Dato.length>0){
					$("#txtMarca_Marca").prop("value",Dato[0]["Marca"]);
					$("#txtSimbolo_Marca").prop("value",Dato[0]["Simbolo"]);
					if(parseInt(Dato[0]["Estado"])===1){$("#chkHabilitado_Marca").prop('checked', true);}else{$("#chkHabilitado_Marca").prop('checked', false);}
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.Save_Mante_Marca=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Mante_Marca",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					  $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassMarca();inst.getList_Mante_Marca(e);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Delete_Mante_Marca=function(pId,IdReg){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Delete_Mante_Marca",array:[pId,IdReg]},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassMarca();inst.Build_Mante_Marca(e["Dato"]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){}
		});
	}
}