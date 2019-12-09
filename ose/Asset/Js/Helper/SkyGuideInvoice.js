let data = {
    tourId: '1',
    spacing: 5,
    around: 0,
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
            target: '#customerFieldset',
            // trigger: false,
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            cover: '',
            title: 'Productos',
            content: 'Agrege un nuevo item',
            target: '#addItemInvoice',
            // trigger: false,							//An event which is generated on the selected element, in the transition from step to step
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            title: 'Buscar un producto existente',
            content: '',
            target: '#detailSaleTableBody',
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            title: 'Emitir comprobante',
            content: 'Aga clic para emitir el comprobante',
            target: '#jsInvoiceFormCommit',
            loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
        },
    ],
};

$(document).ready(function() {
    $('#invoiceWithTaxed').on('click',()=>{
        $('#skyGuidePSE').modal('hide');
        SkyGuide(data);
    })
});
