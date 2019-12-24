$(window).on('load',function(){
	$("#IdAlmacenPri").css("display","none");
	var Alm=$("#Alm").html();$("#IdLabelTitleAlmacen").html("Almacen: "+Alm);
	var IdAlm=$("#IdAlm").html();
	$("#FechaInicio").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1, dateFormat:'dd/mm/yy', changeYear: true,disableTextInput:true,onClose: function(selectedDate){VerificarProductosESpeciales();}});
	$("#FechaFin").datepicker({defaultDate: +1,changeMonth: true,numberOfMonths: 1, dateFormat:'dd/mm/yy', changeYear: true,disableTextInput:true,onClose: function(selectedDate){VerificarProductosESpeciales();}});
	$("#productoEspecial").on('change',function(e){

    });
	
	$("#cboPrint_RKardex").on('click',function(e){$("#IdContentRKardex").printArea();});
	$("#cboExportar_RKardex").on('click',function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#IdContentRKardex').html()));
	});
});
function VerificarProductosESpeciales(){
    let FechaInicio=$('#FechaInicio').val();
    let FechaFin=$('#FechaFin').val();
    let IdAlmacen=$("#IdAlm").html();
    if (FechaInicio!='' && FechaFin!='') {
        FechaInicio=fecha_Barra_Guion(FechaInicio);
        FechaFin=fecha_Barra_Guion(FechaFin);
        ListarProductosEspeciales(FechaInicio,FechaFin,IdAlmacen);
    }
}
function ListarProductosEspeciales(fechaInicio,fechaFin,idAlmacen){
    $.blockUI();
    $.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"ProductosEspecialesVendidos",fechaInicio:fechaInicio,fechaFin:fechaFin,idAlmacen:idAlmacen},
        async:true,dataType:"json",success:function(e){$.unblockUI();console.log(e);
            $("#tablaVentasProductosEspeciales tbody").html("");
            e.forEach(element => {
                let ids=element["IdVenta"]+'_'+element["IdComprobante"]+'_'+element["Estado"]+'_'+'1'+'_'+element["IdEmpresa"];
                $('#tablaVentasProductosEspeciales tbody').append('<tr >'+
                    '<td id="printREPVENT_'+ids+'"><i class="fas fa-print f-18"></i></td>'+
                    '<td>'+element["fecha"]+'</td>'+
                    '<td>'+element["Nombres"]+'</td>'+
                    '<td>'+element["Comprobante"]+'</td>'+
                    '<td>'+element["Serie"]+'/'+element["Numero"]+'</td>'+
                    '<td>'+element["RazonSocial"]+'</td>'+
                    '<td>'+element["Total"]+'</td>'+
                    '<td>'+element["SubTotal"]+'</td>'+
                    '<td>'+element["IGV"]+'</td>'+
                    '<td>'+element["Estado"]+'</td>'+
                '</tr>');
            });
            $('#tablaVentasProductosEspeciales tbody').on( 'click','td',function (e) {
                var id=$(this)[0].id.split('_');//.toggleClass('selected');
                if(id[0]==='printREPVENT'){
                    IdTipoComp=parseInt(id[2]);
                    if(IdTipoComp===10){
                        var inst2=new ClassImpresion();
                        inst2.getList_Print_Ticket([id[1],id[5]]);
                    }else if(IdTipoComp===1 || IdTipoComp===2){
                        var inst2=new ClassImpresion();
                        inst2.getList_Print_FacturaBoleta([id[1]]);
                    }else if(IdTipoComp===20){
                        var inst2=new ClassImpresion();
                        //inst2.getList_Print_GuiaRemision([id[1]]);
                    }
                }
            });	
        },error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
    });
}