let invoiceCustomerDefaultSG = {
    title: 'Cliente',
    content: 'Ingrese el <span class="text-danger">ruc de su cliente</span> Y haga <span class="text-danger">clic en la lupita</span>.  El sistema automáticamente buscara los datos desde la SUNAT.',
    target: '#fieldsetCustomer',
    event: [
        {
            target: '#invoiceCustomerSearchDocument',
            event: 'click',
        },
    ],
    loc: 'http://localhost/OSE-skynet/ose/Invoice/NewInvoice',
    checkNext: {
        func: (target) => {
            if ($('#invoiceCustomerSocialReason').val().length === 0 ||
                $('#invoiceCustomerIdentityDocumentNumber').val().length === 0 ||
                $('#invoiceCustomerIdentityDocumentCode').val().length === 0) {
                return false;
            } else {
                return true
            }
        },
        errorMessage: 'Debe llenar todos los campos obligatorios del cliente. (DNI, Tipo de documento, razón social)'
    },
    delayAfter: 1000,
};
let invoiceSubmitDefaultSG = [
    {
        title: 'Emitir comprobante',
        content: 'Aga clic para emitir el comprobante',
        target: '#jsInvoiceFormCommit',
        event: 'click',
    },
    {
        title: 'Confirmar',
        content: 'Aga clic para emitir el comprobante',
        target: '.swal2-popup.swal2-modal.swal2-show',
        event: [{
            event: 'click',
            target: '.swal2-confirm.btn',
        }],
    },
    {
        title: 'Gracias por usar nuestro asistente.',
        content: 'Así de fácil es emitir un comprobante',
    },
];

let sgInvoiceTaxed = {
    tourId: 'tazed',
    spacing: 10,
    guideTitle: 'Factura gravada con IGV',
    intro: {
        enable: true,
        cover: '',
        title: 'Factura gravada con IGV.',
        content: 'Tutorial guiado de factura electrónica de una venta gravada con IGV. Haga clic en iniciar.',
    },
    steps: [
        invoiceCustomerDefaultSG,
        {
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
            before: () => {
                let detailSaleTableBody = document.getElementById('detailSaleTableBody');
                if (detailSaleTableBody){
                    const observer = new MutationObserver(() => {
                        [...document.querySelectorAll('.JsInvoiceAffectationItem')].forEach(item=>{
                            if(item.value != '10'){
                                $('.JsInvoiceAffectationItem').val('10').trigger('change');
                            }
                        });
                    });
                    const observerOptions = { attributes: true, childList: true, subtree: true };
                    observer.observe(detailSaleTableBody, observerOptions);
                }
            }
        },
        ...invoiceSubmitDefaultSG,
    ],
};

let sgInvoiceFree = {
    tourId: 'free',
    spacing: 10,
    guideTitle: 'Factura con venta gratuita',
    intro: {
        enable: true,
        cover: '',
        title: 'Factura con venta gratuita',
        content: 'Tutorial guiado de factura electrónica de una venta gratuita. Haga clic en iniciar.',
    },
    steps: [
        invoiceCustomerDefaultSG,
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
            before: () => {
                let detailSaleTableBody = document.getElementById('detailSaleTableBody');
                if (detailSaleTableBody){
                    const observer = new MutationObserver(() => {
                        [...document.querySelectorAll('.JsInvoiceAffectationItem')].forEach(item=>{
                            if(item.value == '10' || item.value == '20' || item.value == '30' || item.value == '40'){
                                $('.JsInvoiceAffectationItem').val('11').trigger('change');
                            }
                        });
                    });
                    const observerOptions = { attributes: true, childList: true, subtree: true };
                    observer.observe(detailSaleTableBody, observerOptions);
                }
            }
        },
        ...invoiceSubmitDefaultSG,
    ],
};

let sgInvoiceExonerated = {
    tourId: 'exonerated',
    spacing: 10,
    guideTitle: 'Factura con venta exonerada',
    intro: {
        enable: true,
        cover: '',
        title: 'Factura con venta exonerada.',
        content: 'Tutorial guiado de factura electrónica de una venta exonerada. Haga clic en iniciar.',
    },
    steps: [
        invoiceCustomerDefaultSG,
        {
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
            before: () => {
                let detailSaleTableBody = document.getElementById('detailSaleTableBody');
                if (detailSaleTableBody){
                    const observer = new MutationObserver(() => {
                        [...document.querySelectorAll('.JsInvoiceAffectationItem')].forEach(item=>{
                            if(item.value != '20'){
                                $('.JsInvoiceAffectationItem').val('20').trigger('change');
                            }
                        });
                    });
                    const observerOptions = { attributes: true, childList: true, subtree: true };
                    observer.observe(detailSaleTableBody, observerOptions);
                }
            }
        },
        ...invoiceSubmitDefaultSG,
    ],
};

let sgInvoiceUnaffected = {
    tourId: 'unaffected',
    spacing: 10,
    guideTitle: 'Factura con venta inafecta',
    intro: {
        enable: true,
        cover: '',
        title: 'Factura con venta inafecta.',
        content: 'Tutorial guiado de factura electrónica de una venta inafecta. Haga clic en iniciar.',
    },
    steps: [
        invoiceCustomerDefaultSG,
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
            before: () => {
                let detailSaleTableBody = document.getElementById('detailSaleTableBody');
                if (detailSaleTableBody){
                    const observer = new MutationObserver(() => {
                        [...document.querySelectorAll('.JsInvoiceAffectationItem')].forEach(item=>{
                            if(item.value != '30'){
                                $('.JsInvoiceAffectationItem').val('30').trigger('change');
                            }
                        });
                    });
                    const observerOptions = { attributes: true, childList: true, subtree: true };
                    observer.observe(detailSaleTableBody, observerOptions);
                }
            }
        },
        ...invoiceSubmitDefaultSG,
    ],
};

let sgInvoiceExport = {
    tourId: 'export',
    spacing: 10,
    guideTitle: 'Factura exportacion',
    intro: {
        enable: true,
        cover: '',
        title: 'Factura exportacion.',
        content: 'Tutorial guiado de factura electrónica exportacion. Haga clic en iniciar.',
    },
    steps: [
        {
            title: 'Configuracion',
            content: 'Haga click en Opciones Avanzadas',
            target: '[data-target="#invoiceAdvancedOptModal"]',
            event: 'click'
        },
        {
            title: 'Configuracion',
            content: 'Cambie el Tipo de operación a <span class="text-danger">Exportación de bienes</span> y haga <span>clic en aceptar</span>',
            target: '#invoiceAdvancedOptModal .modal-content',
            event: [
                {
                    event: 'click',
                    target: '#invoiceAdvancedOptModalConfirm',
                }
            ],
            checkNext: {
                func: (target) => {
                    // console.log(target);
                    // target.stopImmediatePropagation();
                    if ($('#invoiceOperationCode').val() === '0200'){
                        // console.log('bueno');
                        return true;
                    } else {
                        // console.log('malo');
                        // $('#invoiceAdvancedOptModal').modal('show');
                        return false;
                    }
                },
                errorMessage: 'El Tipo de operación debe ser Exportación de bienes'
            },
            delayBefore: 400,
        },
        invoiceCustomerDefaultSG,
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
            before: () => {
                let detailSaleTableBody = document.getElementById('detailSaleTableBody');
                if (detailSaleTableBody){
                    // const observer = new MutationObserver(() => {
                    //     [...document.querySelectorAll('.JsInvoiceAffectationItem')].forEach(item=>{
                    //         if(item.value != '40'){
                    //             $('.JsInvoiceAffectationItem').val('40').trigger('change');
                    //         }
                    //     });
                    // });
                    // const observerOptions = { attributes: true, childList: true, subtree: true };
                    // observer.observe(detailSaleTableBody, observerOptions);
                }
            }
        },
        ...invoiceSubmitDefaultSG,
    ],
};

$(document).ready(function () {
    $(function () {
        $("#sgSearchInvoice").on("keyup", function () {
            let value = $(this).val().toLowerCase();
            $("#sgTableInvoice > tbody > tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $('#sgInvoiceTaxed').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceTaxed);
    });
    $('#sgInvoiceFree').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceFree);
    });
    $('#sgInvoiceExonerated').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceExonerated);
    });
    $('#sgInvoiceUnaffected').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceUnaffected);
    });
    $('#sgInvoiceExport').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceExport);
    });

    // let elementTest = document.querySelector('#invoiceAdvancedOptions .modal-content');
    // elementTest.addEventListener('rezise',()=>{
    //     console.log('hola');
    // });
});


