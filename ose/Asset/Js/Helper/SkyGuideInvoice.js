let mass = {
    checkNext:{
        func:function(target){
            console.log(target,'checkPrev');
            return true
        },
        messageError:'Fulfill all the conditions!'
    },
    checkPrev:{
        func:function(target){
            console.log(target,'checkPrev');
            return true
        },
        messageError:'Fulfill all the conditions!'
    },
    before:function(target){console.log(target,'before');},
    during:function(target){console.log(target,'during');},
    after:function(target){console.log(target,'after');},
};
let data = {
    tourId: '1',
    spacing: 10,
    intro: {
        enable: true,
        cover: '',
        title: 'Factura gravada con IGV.',
        content: 'Tutorial guiado de factura electrónica de una venta gravada con IGV. Haga clic en iniciar.',
    },
    steps: [
        {
            title: 'Cliente',
            content: 'Ingrese el numero ruc de su cliente.  El sistema automáticamente buscar los datos desde la SUNAT.',
            target: '#fieldsetCustomer',
            event: ['click','#button-addon2'],
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
            checkNext:{
                func:function(target){
                    if ($('#invoiceCustomerSocialReason').val().length  === 0 ||
                        $('#invoiceCustomerIdentityDocumentNumber').val().length  === 0 ||
                        $('#invoiceCustomerIdentityDocumentCode').val().length  === 0){
                        return false;
                    }else {
                        return true
                    }
                },
                messageError:'Debe llenar todos los campos obligatorios del cliente. (DNI, Tipo de documento, razón social)'
            },
        },
        {
            cover: '',
            title: 'Productos',
            content: 'Agrege un nuevo item a la lista',
            target: '#addItemInvoice',
            event: 'click',							//An event which is generated on the selected element, in the transition from step to step
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            title: 'Emitir comprobante',
            content: 'Aga clic para emitir el comprobante',
            target: '#jsInvoiceFormCommit',
            event: 'click',
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            title: 'Confirmar',
            content: 'Aga clic para emitir el comprobante',
            target: '.swal2-popup.swal2-modal.swal2-show',
            event: ['click','.swal2-confirm.btn'],
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
        },
    ],
};

$(document).ready(function() {
    $('#invoiceWithTaxed').on('click',()=>{
        $('#skyGuidePSE').modal('hide');
        iGuider(data);
    })
});
