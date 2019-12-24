var aArreglo=[];
var aMarca=[];var aModelo=[];
var marcas_nuevas=[];var modelos_nuevos=[];
$(window).on('load',function(){var inst=new ClassImportPAML();$("#IdAlmacenPri").css("display","none");
	$("#cboAlmacen_RepImportPAlm").chosen({width: "100%"});
	inst.getList_Datos_ImportarProduct();
	$(document).ready(function(){$('#files').change(handleFile);});
	$("#btnSaveMarca").on('click',function(e){if(marcas_nuevas.length>0){inst.Save_Marca_ImportarProduct(marcas_nuevas);}});
	$("#btnSaveModelo").on('click',function(e){if(modelos_nuevos.length>0){inst.Save_Modelo_ImportarProduct(modelos_nuevos);}});
	
	$("#btnSave_ImportPAlm").on('click',function(e){
		IdAlm=$("select#cboAlmacen_RepImportPAlm option:selected").val();
		if(aArreglo.length>0 && IdAlm!="-1"){
			let nro_div=aArreglo.length/100;
			let inicio=0;
			nro_div=Math.round(nro_div);
			var valido=false;
			for (var i = 0; i <= nro_div; i++) {
				var arreglo_particionado=aArreglo.slice(inicio,100*(i+1));
				$.blockUI();
				$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Producto_ImportarProduct",array:[IdAlm,arreglo_particionado]},
					async:false,dataType:"json",success:function(e){
						if(e){
							valido=true;
						}else{
							valido=false;
						}
					},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
				});
				inicio=inicio+100;
			}
			$.unblockUI();
			if(valido){
				alertify.success("PROCESO CORRECTO.");
			}else{
				alertify.error("Error, Proceso Incorrecto.");
			}
		}
	});
});
function ClassImportPAML(){
	this.limpiar=function(){location.reload(true);}
	this.getList_Datos_ImportarProduct=function(){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"getList_Datos_ImportarProduct"},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassImportPAML();
				aMarca=e["Marca"];aModelo=e["Modelo"];
				console.log(aMarca);
				console.log(aModelo);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Save_Marca_ImportarProduct=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Marca_ImportarProduct",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassImportPAML();
				if(e){
					inst.limpiar();alertify.success("PROCESO CORRECTO.");
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Save_Modelo_ImportarProduct=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Modelo_ImportarProduct",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassImportPAML();
				if(e){
					inst.limpiar();alertify.success("PROCESO CORRECTO.");
				}else{
					alertify.error("Error, Proceso Incorrecto.");
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Save_Producto_ImportarProduct=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objMante",action:"Save_Producto_ImportarProduct",array:params},
			async:false,dataType:"json",success:function(e){$.unblockUI();
				if(e){
					return true;
				}else{
					return false;
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
}
function handleFile(e) {
	$("#IdTable_RepImportPAlm tbody").html("");
	var files = e.target.files;
	var i, f;
	//Loop through files
	for (i = 0, f = files[i]; i != files.length; ++i){
		var reader = new FileReader();
		var name = f.name;
		reader.onload = function(e){
			var data = e.target.result;
			var workbook = XLSX.read(data, { type: 'binary' });   
			var sheet_name_list = workbook.SheetNames;
			sheet_name_list.forEach(function (y) { /* iterate through sheets */
                    //Convert the cell value to Json
                    var roa = XLSX.utils.sheet_to_json(workbook.Sheets[y]);
                    if (roa.length > 0) {
                        result = roa;
                    }
                });
               	//Get the first column first cell value
                //alert(result[0].Column1);
                armarTabla(result);
		};
		reader.readAsArrayBuffer(f);
	}
}
function armarTabla(datos){
	$("#IdTable_RepImportPAlm tbody").html("");
	var marca_aux="";
	var modelo_aux="";
	patron ="S/",nuevoValor="";
	datos.forEach(function(valor,indice,array){
		marca_aux=buscarmarca(valor.marca);
		modelo_aux=buscarmodelo(valor.modelo);
		IdMarca=1;IdModelo=1;
		
			compra=valor.compra;
				compra=parseFloat(compra).toFixed(2);
			menor=valor.menor;
				menor=parseFloat(menor).toFixed(2);
			mayor=valor.mayor;
				mayor=parseFloat(mayor).toFixed(2);
			publico=valor.publico;
				publico=parseFloat(publico).toFixed(2);
			
			$('#IdTable_RepImportPAlm tbody').append('<tr><td>'+indice+'</td><td>'+valor.codigo+'</td><td>'+
			valor.descripcion+'</td><td>'+compra+'</td><td>'+mayor+'</td><td>'+
			menor+'</td><td>'+publico+'</td><td>'+valor.marca+'</td><td>'+valor.modelo+'</td></tr>');
			
			if (marca_aux!=0) {
				valor.marca=marca_aux;IdMarca=marca_aux;
			}else{
				if (typeof valor.marca!= 'undefined') {
					let aux_existe=true;
					marcas_nuevas.forEach(function(element){
						if (element==valor.marca) {
							aux_existe=false;
						}
					});

					if (aux_existe) {
						marcas_nuevas.push(valor.marca);						
					}
				}
				valor.marca=marca_aux;	
			}
			if (modelo_aux!=0) {
				valor.modelo=modelo_aux;IdModelo=modelo_aux;	
			}else{
				if (typeof valor.modelo!= 'undefined') {
					let aux_existe_modelo=true;
					modelos_nuevos.forEach(function(element){
						if (element==valor.modelo) {
							aux_existe_modelo=false;
						}
					});

					if (aux_existe_modelo) {
						modelos_nuevos.push(valor.modelo);						
					}
				}
				valor.modelo=modelo_aux;	
			}
			aArreglo.push({"codigo":valor.codigo,"descripcion":valor.descripcion,"marca":IdMarca,"modelo":IdModelo,
			"compra":compra,"menor":menor,"mayor":mayor,"publico":publico});
	});
	console.log(marcas_nuevas);
	console.log(modelos_nuevos);
	marcas_nuevas.forEach(function(element){
		$('#IdTable_RepMarcaPAlm tbody').append('<tr><td>'+element+'</td></tr>');
	});
	modelos_nuevos.forEach(function(element) {
		$('#IdTable_RepModeloPAlm tbody').append('<tr><td>'+element+'</td></tr>');
	});
}
function buscarmarca(valor){
	if(valor!="" && valor!=null){valor=valor.trim();valor=valor.toUpperCase();}
	var aux=0;
	if(aMarca.length>0){
		for (var i=0;i<aMarca.length;i++){
			if (aMarca[i].Nombre==valor) {
				aux=aMarca[i].Id;				
			}
		}
	}
	return aux;
}
function buscarmodelo(valor){
	if(valor!="" && valor!=null){valor=valor.trim();}
	var aux=0;
	if(aModelo.length>0){
		for (var i=0;i<aModelo.length;i++){
			if (aModelo[i].Nombre==valor) {
				aux=aModelo[i].Id;				
			}
		}
	}
	return aux;
}
