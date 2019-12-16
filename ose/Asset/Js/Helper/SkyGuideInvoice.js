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

let invoiceProductAddDefaultSG =         {
        title: 'Productos',
        content: 'Agrege un nuevo item a la lista',
        target: '#addItemInvoice',
        event: 'click',							//An event which is generated on the selected element, in the transition from step to step
    };

let invoiceProductSearchDefaultSG = {
    title: 'Buscar un producto existente',
        content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
        target: '#fieldsetProductList',
};

let invoiceAdvancedOptDefaultSG = {
        title: 'Configuracion',
        content: 'Haga click en Opciones Avanzadas',
        target: '[data-target="#invoiceAdvancedOptModal"]',
        event: 'click',
        loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
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
        abort: [{
            event: 'click',
            target: '.swal2-cancel.btn',
        }],
    },
    {
        title: 'Gracias por usar nuestro asistente.',
        content: 'Así de fácil es emitir un comprobante',
    },
];

let sgInvoiceTaxed = {
    tourId: 'tazed',
    guideTitle: 'Factura gravada con IGV',
    intro: {
        enable: true,
        title: 'Factura gravada con IGV.',
        content: 'Tutorial guiado de factura electrónica de una venta gravada con IGV. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
            before: () => {
                let detailSaleTableBody = document.getElementById('detailSaleTableBody');
                if (detailSaleTableBody){
                    const observer = new MutationObserver(mutationList => {
                        console.log(mutationList);
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
    guideTitle: 'Factura con venta gratuita',
    intro: {
        enable: true,
        title: 'Factura con venta gratuita',
        content: 'Tutorial guiado de factura electrónica de una venta gratuita. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
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
    guideTitle: 'Factura con venta exonerada',
    intro: {
        enable: true,
        title: 'Factura con venta exonerada.',
        content: 'Tutorial guiado de factura electrónica de una venta exonerada. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
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
    guideTitle: 'Factura con venta inafecta',
    intro: {
        enable: true,
        title: 'Factura con venta inafecta.',
        content: 'Tutorial guiado de factura electrónica de una venta inafecta. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
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
    guideTitle: 'Factura exportacion',
    intro: {
        enable: true,
        title: 'Factura exportacion.',
        content: 'Tutorial guiado de factura electrónica exportacion. Haga clic en iniciar.',
    },
    steps: [
        {
            title: 'Configuracion',
            content: 'Haga click en Opciones Avanzadas',
            target: '[data-target="#invoiceAdvancedOptModal"]',
            event: 'click',
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            title: 'Tipo de operación',
            content: 'Cambie el Tipo de operación a <span class="text-danger">Exportación de bienes</span> y haga <span>clic en aceptar</span>',
            target: '#invoiceAdvancedOptModal .modal-content',
            event: [
                {
                    event: 'click',
                    target: '#invoiceAdvancedOptModalConfirm',
                }
            ],
            before: ()=>{
                $('#invoiceAdvancedOptModalConfirm').removeAttr('data-dismiss');
            },
            checkNext: {
                func: () => {
                    if ($('#invoiceOperationCode').val() === '0200'){
                        $('#invoiceAdvancedOptModalConfirm').attr('data-dismiss','modal');
                        $('#invoiceAdvancedOptModal').modal('hide');
                        return true;
                    } else {
                        return false;
                    }
                },
                errorMessage: 'El Tipo de operación debe ser Exportación de bienes'
            },
            delayBefore: 400,
        },
        invoiceCustomerDefaultSG,
        invoiceProductAddDefaultSG,
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
                            if(item.value != '40'){
                                $('.JsInvoiceAffectationItem').val('40').trigger('change');
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

let sgInvoiceGlobalDiscount = {
    tourId: 'InvoiceGlobalDiscount',
    guideTitle: 'Factura con decuento global',
    intro: {
        enable: true,
        title: 'Factura con decuento global',
        content: 'Tutorial guiado de factura electrónica con decuento global. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        invoiceProductSearchDefaultSG,
        {
            title: 'Descuento global',
            content: 'Ingrese el descuento global en porcentaje.',
            target: '#invoiceGlobalDiscountPercentage',
            checkNext: {
                func: () => $('#invoiceGlobalDiscountPercentage').val().length === 0,
                errorMessage: 'Debe indicar un porcentaje en el descuento global.'
            },
        },
        ...invoiceSubmitDefaultSG,
    ]
};

let sgInvoiceISC = {
    tourId: 'InvoiceISC',
    guideTitle: 'Factura con venta exonerada',
    intro: {
        enable: true,
        title: 'Factura con venta exonerada.',
        content: 'Tutorial guiado de factura electrónica de una venta exonerada. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        invoiceProductSearchDefaultSG,
        ...invoiceSubmitDefaultSG,
    ]
};

let sgInvoiceByCurrency = {
    tourId: 'InvoiceByCurrency',
    guideTitle: 'Factura en otras monedas',
    intro: {
        enable: true,
        title: 'Factura en otras monedas.',
        content: 'Tutorial guiado de factura electrónica en otras monedas. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceAdvancedOptDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            title: 'Tipo de moneda',
            content: 'Cambie el Tipo de moneda <span class="text-danger">a la moneda que dese usar (Dólares, Soles, Euro, etc.)</span> y haga <span>clic en aceptar</span>',
            target: '#invoiceAdvancedOptModal .modal-content',
            event: [
                {
                    event: 'click',
                    target: '#invoiceAdvancedOptModalConfirm',
                }
            ],
            delayBefore: 400,
        },
        invoiceCustomerDefaultSG,
        invoiceProductAddDefaultSG,
        invoiceProductSearchDefaultSG,
        ...invoiceSubmitDefaultSG,
    ]
};

let sgInvoiceDetraction = {
    tourId: 'InvoicePerception',
    guideTitle: 'Factura sujeta a Detracción',
    intro: {
        enable: true,
        title: 'Factura sujeta a detracción',
        content: 'Tutorial guiado de factura electrónica sujeta a una detracción. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceAdvancedOptDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            title: 'Tipo de operación',
            content: 'Cambie el Tipo de operación a <span class="text-danger">Una de los dos tipos de detracción.</span> y haga <span>clic en aceptar</span>',
            target: '#invoiceAdvancedOptModal .modal-content',
            event: [
                {
                    event: 'click',
                    target: '#invoiceAdvancedOptModalConfirm',
                }
            ],
            before: ()=>{
                $('#invoiceAdvancedOptModalConfirm').removeAttr('data-dismiss');
            },
            checkNext: {
                func: () => {
                    let iOc = $('#invoiceOperationCode');
                    if (iOc.val() === '1001' || iOc.val() === '1004'){
                        $('#invoiceAdvancedOptModalConfirm').attr('data-dismiss','modal');
                        $('#invoiceAdvancedOptModal').modal('hide');
                        return true;
                    } else {
                        return false;
                    }
                },
                errorMessage: 'Alija al menos una operación sujeta a detracción.'
            },
            delayBefore: 400,
        },

        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        invoiceProductSearchDefaultSG,
        {
            title: 'Régimen',
            content: 'Haga clic en Régimen',
            target: '#invoiceBodyTab',
            event: [{
                event: 'click',
                target: '#navRegimeSunatTab',
            }],
            delayBefore: 400,
        },
        {
            title: 'Habilitar detracción',
            content: 'Habilite la detracción para poder configurar.',
            target: '#InvoiceDetractionEnableRow',
            event: [{
                event: 'change',
                target: '#invoiceDetractionEnable',
            }],
            delayBefore: 400,
        },
        {
            title: 'Configura la detracción',
            content: 'Configura la detracción según corresponda.',
            target: '#collapseInvoiceDetraction',
            checkNext: {
                func: () => $('#invoiceSubjectDetractionCode').val().length !== 0,
                errorMessage: 'Elija al menos un tipo de detracción.'
            },
            delayBefore: 400,
        },
        ...invoiceSubmitDefaultSG,
    ]
};

let sgInvoicePerception = {
    tourId: 'InvoicePerception',
    guideTitle: 'Factura sujeta a percepción',
    intro: {
        enable: true,
        title: 'Factura sujeta a percepción',
        content: 'Tutorial guiado de factura electrónica sujeta a una percepción. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceAdvancedOptDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        {
            title: 'Tipo de operación',
            content: 'Cambie el Tipo de operación a <span class="text-danger">Operación Sujeta a Percepción</span> y haga <span>clic en aceptar</span>',
            target: '#invoiceAdvancedOptModal .modal-content',
            event: [
                {
                    event: 'click',
                    target: '#invoiceAdvancedOptModalConfirm',
                }
            ],
            before: ()=>{
                $('#invoiceAdvancedOptModalConfirm').removeAttr('data-dismiss');
            },
            checkNext: {
                func: () => {
                    if ($('#invoiceOperationCode').val() === '2001'){
                        $('#invoiceAdvancedOptModalConfirm').attr('data-dismiss','modal');
                        $('#invoiceAdvancedOptModal').modal('hide');
                        return true;
                    } else {
                        return false;
                    }
                },
                errorMessage: 'El Tipo de operación debe ser Operación Sujeta a Percepción'
            },
            delayBefore: 400,
        },

        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        invoiceProductSearchDefaultSG,
        {
            title: 'Régimen',
            content: 'Haga clic en Régimen',
            target: '#invoiceBodyTab',
            event: [{
                event: 'click',
                target: '#navRegimeSunatTab',
            }],
            delayBefore: 400,
        },
        {
            title: 'Habilitar percepción',
            content: 'Habilite la percepción para poder configurar.',
            target: '#InvoicePerceptionEnableRow',
            event: [{
                event: 'change',
                target: '#invoicePerceptionEnable',
            }],
            delayBefore: 400,
        },
        {
            title: 'Elegir percepción',
            content: 'Elija el tipo de percepción que dese aplicar a la factura.',
            target: '#collapseInvoicePerception',
            checkNext: {
                func: () => $('#invoicePerceptionCode').val().length !== 0,
                errorMessage: 'Elija al menos un tipo de percepción.'
            },
            delayBefore: 400,
        },
        ...invoiceSubmitDefaultSG,
    ]
};

let sgInvoiceReferralGuide = {
    tourId: 'InvoiceReferralGuide',
    guideTitle: 'Factura guia',
    intro: {
        enable: true,
        title: 'Factura guia',
        content: 'Tutorial guiado de Factura guia electrónica. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        invoiceProductSearchDefaultSG,
        {
            title: 'Factura Guía',
            content: 'Haga clic en Guía',
            target: '#invoiceBodyTab',
            event: [{
                event: 'click',
                target: '#navReferralGuideTab',
            }],
            delayBefore: 400,
        },
        {
            title: 'Habilitar Guía',
            content: 'Habilite la Guía para poder configurar.',
            target: '#InvoiceReferralGuideEnableRow',
            event: [{
                event: 'change',
                target: '#invoiceGuideEnable',
            }],
            delayBefore: 400,
        },
        {
            title: 'Guía',
            content: 'llenar los campos de la guía.',
            target: '#collapseInvoiceGuide',
            checkNext: {
                func: () => $('#transferCode').val().length !== 0,
                errorMessage: 'Debe llenar los campos de la guía.'
            },
            delayBefore: 400,
        },
        ...invoiceSubmitDefaultSG,
    ]
};

let sgInvoicePrepayment = {
    tourId: 'InvoicePrepayment',
    guideTitle: 'Factura con venta exonerada',
    intro: {
        enable: true,
        title: 'Factura con venta exonerada.',
        content: 'Tutorial guiado de factura electrónica de una venta exonerada. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
        },
        ...invoiceSubmitDefaultSG,
    ]
};

let sgInvoiceTicketTaxed = {
    tourId: 'InvoiceTicketTaxed',
    guideTitle: 'Boleta de venta.',
    intro: {
        enable: true,
        title: 'Boleta de venta.',
        content: 'Tutorial guiado de boleta de venta electrónica. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewTicket',
        },
        invoiceProductAddDefaultSG,
        invoiceProductSearchDefaultSG,
        ...invoiceSubmitDefaultSG,
    ]
};

let sgInvoiceTicketGlobalDiscount = {
    tourId: 'InvoiceTicketGlobalDiscount',
    guideTitle: 'Factura con venta exonerada',
    intro: {
        enable: true,
        title: 'Factura con venta exonerada.',
        content: 'Tutorial guiado de factura electrónica de una venta exonerada. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
        },
        ...invoiceSubmitDefaultSG,
    ]
};

let sgInvoiceTicketFree = {
    tourId: 'InvoiceTicketFree',
    guideTitle: 'Factura con venta exonerada',
    intro: {
        enable: true,
        title: 'Factura con venta exonerada.',
        content: 'Tutorial guiado de factura electrónica de una venta exonerada. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
        },
        ...invoiceSubmitDefaultSG,
    ]
};

let sgCreditNote = {
    tourId: 'CreditNote',
    guideTitle: 'Factura con venta exonerada',
    intro: {
        enable: true,
        title: 'Factura con venta exonerada.',
        content: 'Tutorial guiado de factura electrónica de una venta exonerada. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
        },
        ...invoiceSubmitDefaultSG,
    ]
};

let sgDebitNote = {
    tourId: 'DebitNote',
    guideTitle: 'Factura con venta exonerada',
    intro: {
        enable: true,
        title: 'Factura con venta exonerada.',
        content: 'Tutorial guiado de factura electrónica de una venta exonerada. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
        },
        ...invoiceSubmitDefaultSG,
    ]
};

let sgInvoiceVoided = {
    tourId: 'InvoiceVoided',
    guideTitle: 'Factura con venta exonerada',
    intro: {
        enable: true,
        title: 'Factura con venta exonerada.',
        content: 'Tutorial guiado de factura electrónica de una venta exonerada. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
        },
        ...invoiceSubmitDefaultSG,
    ]
};

let sgInvoiceTicketVoided = {
    tourId: 'InvoiceTicketVoided',
    guideTitle: 'Factura con venta exonerada',
    intro: {
        enable: true,
        title: 'Factura con venta exonerada.',
        content: 'Tutorial guiado de factura electrónica de una venta exonerada. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
        },
        ...invoiceSubmitDefaultSG,
    ]
};

let sgReferralGuide = {
    tourId: 'ReferralGuide',
    guideTitle: 'Factura con venta exonerada',
    intro: {
        enable: true,
        title: 'Factura con venta exonerada.',
        content: 'Tutorial guiado de factura electrónica de una venta exonerada. Haga clic en iniciar.',
    },
    steps: [
        {
            ...invoiceCustomerDefaultSG,
            loc: location.origin + '/OSE-skynet/ose/Invoice/NewInvoice',
        },
        invoiceProductAddDefaultSG,
        {
            title: 'Buscar un producto existente',
            content: 'Elija un producto de la lista. puede cambiar el precio unitario y la cantidad si lo requiere',
            target: '#fieldsetProductList',
        },
        ...invoiceSubmitDefaultSG,
    ]
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

    $('#sgInvoiceGlobalDiscount').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceGlobalDiscount);
    });

    $('#sgInvoiceISC').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceISC);
    });

    $('#sgInvoiceByCurrency').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceByCurrency);
    });

    $('#sgInvoiceDetraction').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceDetraction);
    });

    $('#sgInvoicePerception').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoicePerception);
    });

    $('#sgInvoiceReferralGuide').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceReferralGuide);
    });

    $('#sgInvoicePrepayment').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoicePrepayment);
    });

    $('#sgInvoiceTicketTaxed').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceTicketTaxed);
    });

    $('#sgInvoiceTicketGlobalDiscount').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceTicketGlobalDiscount);
    });

    $('#sgInvoiceTicketFree').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceTicketFree);
    });

    $('#sgCreditNote').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgCreditNote);
    });

    $('#sgDebitNote').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgDebitNote);
    });

    $('#sgInvoiceVoided').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceVoided);
    });

    $('#sgInvoiceTicketVoided').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgInvoiceTicketVoided);
    });

    $('#sgReferralGuide').on('click', () => {
        $('#sgModalPSE').modal('hide');
        window.SkyGuide(sgReferralGuide);
    });
});
