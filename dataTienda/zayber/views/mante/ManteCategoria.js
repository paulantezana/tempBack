$(window).on('load',function(){var inst=new ClassCategoria();$("#IdAlmacenPri").css("display","none");
	inst.getList_Mante_Categoria();
	$("#btnNewCategoria").on('click',function(e){
		inst.Create_Mante_Categoria("-1");
	});
});
function ClassCategoria(){
	this.getList_Mante_Categoria=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Categoria"},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				var inst=new ClassCategoria();inst.Build_Mante_Categoria(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Build_Mante_Categoria=function(Datos){var inst=new ClassCategoria();
		$("#IdTableManteCategoria tbody").html("");	
		for(var i=0;i<Datos.length;i++){
			var ids=Datos[i]["IdCategoria"];
			$('#IdTableManteCategoria tbody').append('<tr>'+
					'<td id="editManteCategoria_'+ids+'" class="center">'+
						'<i class="fas fa-edit f-18"></i>'+
					'</td>'+
					'<td>'+Datos[i]["Categoria"]+'</td>'+
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
		
		$('#IdTableManteCategoria tbody').unbind("click");
		$('#IdTableManteCategoria tbody').on( 'click','td',function (e) {
			var id=$(this)[0].id.split('_');//.toggleClass('selected');
			if(id[0]==='editManteCategoria'){
				inst.Create_Mante_Categoria(id[1]);
			}
		});
	}
	this.Create_Mante_Categoria=function(pId){
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Mante_Categoria);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		var inst=new ClassCategoria();
		if(pId!="-1"){inst.getList_Mante_Categoria_Edit(pId);}
		
		$("#txtSave_Categoria").on('click',function(e){
			var Categoria=$("#txtCategoria_Categoria").val();
			var Simbol=$("#txtSimbolo_Categoria").val();
			var IdEst=$("#chkHabilitado_Categoria").is(':checked') ? 1 : 0;
			if(Categoria!=""){
				inst.Save_Mante_Categoria([pId,Categoria,Simbol,IdEst]);
			}else{
				alertify.error("Alerta, Completar Datos.");
			}
		});
	}
	this.getList_Mante_Categoria_Edit=function(pId){
		$.blockUI();
		$.ajax({
			type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Mante_Categoria_Edit",array:[pId]},async:true,dataType:"json",success:function(e){
				$.unblockUI();var Dato=e;
				if(Dato.length>0){
					$("#txtCategoria_Categoria").prop("value",Dato[0]["Categoria"]);
					$("#txtSimbolo_Categoria").prop("value",Dato[0]["Simbolo"]);
					if(parseInt(Dato[0]["Estado"])===1){$("#chkHabilitado_Categoria").prop('checked', true);}else{$("#chkHabilitado_Categoria").prop('checked', false);}
				}
			},error:function(jqXHR,textStatus,errorMessage){/*console.log(jqXHR.responseText);*/}
		});	
	}
	this.Save_Mante_Categoria=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Mante_Categoria",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					 $('#myModal').modal('hide');$('#modal_Manten').html("");
					  $(".modal-open").removeClass('modal-open');
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassCategoria();inst.getList_Mante_Categoria(e);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Delete_Mante_Categoria=function(pId,IdReg){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Delete_Mante_Categoria",array:[pId,IdReg]},
			async:true,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					alertify.success("PROCESO CORRECTO.");
					var inst=new ClassCategoria();inst.Build_Mante_Categoria(e["Dato"]);
				}else{alertify.error("Error, Proceso Incorrecto.");}	
			},error:function(jqXHR,textStatus,errorMessage){}
		});
	}
}