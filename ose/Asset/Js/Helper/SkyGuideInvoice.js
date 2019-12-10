let sgInvoiceTaxed = {
    tourId: '1',
    spacing: 10,
    guideTitle: 'Factura gravada con IGV',
    intro: {
        enable: true,
        cover: '',
        title: 'Factura gravada con IGV.',
        content: 'Tutorial guiado de factura electrónica de una venta gravada con IGV. Haga clic en iniciar.',
    },
    steps: [
        {
            cover: 'http://demo.masscode.ru/iguider/doc_files/images/590x300.jpg',
            title: 'Cliente',
            content: 'Ingrese el numero ruc de su cliente.  El sistema automáticamente buscar los datos desde la SUNAT.',
            target: '#fieldsetCustomer',
            event: [
                {
                    target: '#invoiceCustomerSearchDocument',
                    event: 'click',
                },
                {
                    target: '#invoiceCustomerIdentityDocumentNumber-flexdatalist',
                    event: 'change',
                },
            ],
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
            checkNext:{
                func: (target) => {
                    if ($('#invoiceCustomerSocialReason').val().length  === 0 ||
                        $('#invoiceCustomerIdentityDocumentNumber').val().length  === 0 ||
                        $('#invoiceCustomerIdentityDocumentCode').val().length  === 0){
                        return false;
                    }else {
                        return true
                    }
                },
                errorMessage:'Debe llenar todos los campos obligatorios del cliente. (DNI, Tipo de documento, razón social)'
            },
        },
        {
            cover: 'http://demo.masscode.ru/iguider/doc_files/images/590x300.jpg',
            title: 'Productos',
            content: 'Agrege un nuevo item a la lista',
            target: '#addItemInvoice',
            event: 'click',							//An event which is generated on the selected element, in the transition from step to step
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            cover: 'http://demo.masscode.ru/iguider/doc_files/images/590x300.jpg',
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            cover: 'http://demo.masscode.ru/iguider/doc_files/images/590x300.jpg',
            title: 'Emitir comprobante',
            content: 'Aga clic para emitir el comprobante',
            target: '#jsInvoiceFormCommit',
            event: 'click',
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            cover: 'http://demo.masscode.ru/iguider/doc_files/images/590x300.jpg',
            title: 'Confirmar',
            content: 'Aga clic para emitir el comprobante',
            target: '.swal2-popup.swal2-modal.swal2-show',
            event: ['click','.swal2-confirm.btn'],
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
        },
    ],
};

let sgInvoiceUnaffected = {
    tourId: '1',
    spacing: 10,
    guideTitle: 'Factura con venta inafecta',
    intro: {
        enable: true,
        cover: '',
        title: 'Factura con venta inafecta.',
        content: 'Tutorial guiado de factura electrónica de una venta inafecta. Haga clic en iniciar.',
    },
    steps: [
        {
            title: 'Cliente',
            content: 'Ingrese el numero ruc de su cliente.  El sistema automáticamente buscar los datos desde la SUNAT.',
            target: '#fieldsetCustomer',
            event: ['click','#button-addon2'],
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
            checkNext:{
                func: (target) => {
                    if ($('#invoiceCustomerSocialReason').val().length  === 0 ||
                        $('#invoiceCustomerIdentityDocumentNumber').val().length  === 0 ||
                        $('#invoiceCustomerIdentityDocumentCode').val().length  === 0){
                        return false;
                    }else {
                        return true
                    }
                },
                errorMessage:'Debe llenar todos los campos obligatorios del cliente. (DNI, Tipo de documento, razón social)'
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

let sgInvoiceFree = {
    tourId: '1',
    spacing: 10,
    guideTitle: 'Factura con venta gratuita',
    intro: {
        enable: true,
        cover: '',
        title: 'Factura con venta gratuita',
        content: 'Tutorial guiado de factura electrónica de una venta gratuita. Haga clic en iniciar.',
    },
    steps: [
        {
            title: 'Cliente',
            content: 'Ingrese el numero ruc de su cliente.  El sistema automáticamente buscar los datos desde la SUNAT.',
            target: '#fieldsetCustomer',
            event: ['click','#button-addon2'],
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
            checkNext:{
                func: (target) => {
                    if ($('#invoiceCustomerSocialReason').val().length  === 0 ||
                        $('#invoiceCustomerIdentityDocumentNumber').val().length  === 0 ||
                        $('#invoiceCustomerIdentityDocumentCode').val().length  === 0){
                        return false;
                    }else {
                        return true
                    }
                },
                errorMessage:'Debe llenar todos los campos obligatorios del cliente. (DNI, Tipo de documento, razón social)'
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
    $('#sgInvoiceTaxed').on('click',()=>{
        $('#skyGuidePSE').modal('hide');
        window.SkyGuide(sgInvoiceTaxed);
    });
    $('#sgInvoiceUnaffected').on('click',()=>{
        $('#skyGuidePSE').modal('hide');
        window.SkyGuide(sgInvoiceUnaffected);
    });
    $('#sgInvoiceFree').on('click',()=>{
        $('#skyGuidePSE').modal('hide');
        window.SkyGuide(sgInvoiceFree);
    });
});
