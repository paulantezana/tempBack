class SubmitForm {
    constructor(){
        this.modeForm = 'create';
        this.listenerSubmit();

        this.submitCallback = response => {
            if (response.success) {
                $('#unitMeasureModal').modal('hide');
                Swal.fire(
                    this.modeForm === 'update' ? '¡Actualizado!' : '¡Guardado!',
                    response.message,
                    'success'
                ).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    type: 'error',
                    title: '¡Algo salió mal!',
                    html: response.message,
                });
            }
        }
    }

    setSubmitCallBack(callback){
        this.submitCallback = callback;
    }

    setModeForm(mode = 'create'){
        this.modeForm = mode;
    }

    listenerSubmit(){}
}

// ---------------------------------------------------------------------------------------------------------------------
// CUSTOMER
// ---------------------------------------------------------------------------------------------------------------------

class CustomerForm extends SubmitForm {
    constructor(){
        super();

        $('#customerBtnNew').on('click', e => {
            e.preventDefault();
            $('#customerModal').modal('show');

            CustomerForm.clearForm();
            this.modeForm = 'create';
        });

        // Validacion de la respuesta
        this.submitCallback = response => {
            if (response.success) {
                $('#unitMeasureModal').modal('hide');
                Swal.fire({
                    type: 'success',
                    title: this.modeForm === 'update' ? '¡Actualizado!' : '¡Guardado!',
                    html: response.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    type: 'error',
                    title: '¡Algo salió mal!',
                    html: response.message,
                });

                if ( typeof(response.error) == 'object' ){
                    let keys = Object.keys(response.error);
                    $('#customerForm input').removeClass('is-invalid');
                    $('#customerForm select').removeClass('is-invalid');
                    keys.forEach(k => {
                        $(`#customerForm #${k}`).addClass('is-invalid');
                        $(`#customerForm .${k}-feedback`).html(response.error[k]['messages'][0]);
                    });
                }
            }
        };

        this.delete();
        this.updateModal();
    }

    static clearForm(){
        $('#customerForm input').removeClass('is-invalid');
        $('#customerForm select').removeClass('is-invalid');
        $('#documentNumber').val('');
        $('#identityDocumentCode').val('');
        $('#socialReason').val('');
        $('#commercialReason').val('');
        $('#fiscalAddress').val('');
        $('#mainEmail').val('');
        $('#optionalEmail1').val('');
        $('#telephone').val('');
        $('#customerId').val('');
    }

    listenerSubmit(){
        $('#customerForm').submit(e => {
            e.preventDefault();
            const url = this.modeForm === 'update' ? '/Customer/Update' : '/Customer/Create';

            $.ajax({
                url: service.apiPath + url,
                type: "POST",
                dataType: 'json',
                contentType : 'application/json',
                data: JSON.stringify({
                    documentNumber: $('#documentNumber').val(),
                    identityDocumentCode: $('#identityDocumentCode').val(),
                    socialReason: $('#socialReason').val(),
                    commercialReason: $('#commercialReason').val(),
                    fiscalAddress: $('#fiscalAddress').val(),
                    mainEmail: $('#mainEmail').val(),
                    optionalEmail1: $('#optionalEmail1').val(),
                    telephone: $('#telephone').val(),
                    customerId: this.modeForm === 'update' ? $('#customerId').val() : 0,
                }),
                success: response => {
                    if (this.submitCallback){
                        this.submitCallback(response);
                    } else {
                        console.warn('Callback Not Fount');
                    }
                }
            });
        });
    }

    delete(){
        $('.jsCustomerDelete').on('click', ev => {
            ev.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo!'
            }).then((result) => {
                if (result.value) {
                    let customerId = ev.target.dataset.id;
                    $.ajax({
                        url: service.apiPath + '/Customer/Delete',
                        type: "POST",
                        dataType: 'json',
                        contentType : 'application/json',
                        data: JSON.stringify({
                            customer_id: customerId,
                        }),
                        success: response => {
                            if (response.success) {
                                Swal.fire({
                                    type: 'success',
                                    title: '¡Eliminado!',
                                    html: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: '¡Algo salió mal!',
                                    text: response.message,
                                })
                            }
                        }
                    });
                }
            })
        });
    }

    updateModal(){
        $('.jsCustomerEdit').on('click', e => {
            e.preventDefault();

            $('#customerModal').modal('show');
            this.modeForm = 'update';
            let customerId = e.target.dataset.id;

            $.ajax({
                url: service.apiPath + '/Customer/ById',
                type: "POST",
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    customer_id: customerId,
                }),
                success: response => {
                    // if (response.success) {
                    $('#documentNumber').val(response.data.document_number);
                    $('#identityDocumentCode').val(response.data.identity_document_code);
                    $('#socialReason').val(response.data.social_reason);
                    $('#commercialReason').val(response.data.commercial_reason);
                    $('#fiscalAddress').val(response.data.fiscal_address);
                    $('#mainEmail').val(response.data.main_email);
                    $('#optionalEmail1').val(response.data.optional_email_1);
                    $('#telephone').val(response.data.telephone);
                    $('#customerId').val(response.data.customer_id);
                    // }
                }
            });
        });
    }
}
let customerForm = new CustomerForm();

// Search customer select picker
(function () {
    let searchCustomerOptions = {
        ajax: {
            url: service.apiPath + '/Customer/Search',
            type: 'POST',
            dataType: 'json',
            data: {
                q: "{{{q}}}"
            }
        },
        preprocessData: function (response) {
            let i;
            let data = response.data;
            let l = data.length;
            let array = [];

            if (l) {
                for (i = 0; i < l; i++) {
                    array.push(
                        $.extend(true, data[i], {
                            text: `${data[i].document_number} ${data[i].social_reason}`,
                            value: data[i].customer_id,
                        })
                    );
                }
            }
            return array;
        }
    };
    $('.searchCustomer')
        .selectpicker()
        .filter(".with-ajax")
        .ajaxSelectPicker(searchCustomerOptions);
})();

$('#SearchPublicDocumentExtractor').click(function () {
    $('#SearchPublicDocumentExtractor').prop('disabled',true);
    $.ajax({
        url: service.apiPath + '/Customer/SearchPublicDocumentExtractor',
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            documentNumber: $('#documentNumber').val(),
        }),
        success: response => {
            $('#documentNumber').val(response.data.documentNumber);
            $('#identityDocumentCode').val(response.data.identityDocumentCode);
            $('#socialReason').val(response.data.socialReason);
            $('#commercialReason').val(response.data.commercialReason);
            $('#fiscalAddress').val(response.data.fiscalAddress);
        },
        complete: e => {
            $('#SearchPublicDocumentExtractor').prop('disabled',false);
        }
    });
});

// ---------------------------------------------------------------------------------------------------------------------
// PRODUCT
// ---------------------------------------------------------------------------------------------------------------------
class ProductForm extends SubmitForm{
    constructor(){
        super();

        $('#productBtnNew').on('click', e => {
            e.preventDefault();
            $('#productModal').modal('show');
            ProductForm.ClearForm();
            this.modeForm = 'create';
        });

        this.submitCallback = response => {
            if (response.success) {
                $('#productModal').modal('hide');
                Swal.fire(
                    this.modeForm === 'update' ? '¡Actualizado!' : '¡Guardado!',
                    response.message,
                    'success'
                ).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    type: 'error',
                    title: '¡Algo salió mal!',
                    text: response.message,
                });

                if ( typeof(response.error) == 'object' ){
                    let keys = Object.keys(response.error);
                    $('#productForm input').removeClass('is-invalid');
                    $('#productForm select').removeClass('is-invalid');
                    keys.forEach(k => {
                        $(`#productForm #product${k}`).addClass('is-invalid');
                        $(`#productForm .product${k}-feedback`).html(response.error[k]['messages'][0]);
                    });
                }
            }
        };

        this.delete();
        this.updateModal();
    }

    static ClearForm(){
        $('#productForm input').removeClass('is-invalid');
        $('#productForm select').removeClass('is-invalid');
        $('#productDescription').val('');
        $('#productCurrencyCode').val('');
        $('#productUnitPricePurchase').val('');
        $('#productUnitPriceSale').val('');
        $('#productUnitPricePurchaseIgv').val('');
        $('#productUnitPriceSaleIgv').val('');
        $('#productAffectationIgvTypeCode').val('');
        $('#productProductCode').html('').selectpicker('refresh');
        $('#productUnitMeasureCode').html('').selectpicker('refresh');
        $('#productProductId').val('');
        $('#productSystemIscTypeCode').val('');
        $('#productIsc').val('');
    }

    listenerSubmit(){
        $('#productForm').submit(e => {

            e.preventDefault();
            const url = this.modeForm === 'update' ? '/Product/Update' : '/Product/Create';
            $.ajax({
                url: service.apiPath + url,
                type: "POST",
                dataType: 'json',
                contentType : 'application/json',
                data: JSON.stringify({
                    unitMeasureCode: $('#productUnitMeasureCode').val(),
                    description: $('#productDescription').val(),
                    productCode: $('#productProductCode').val(),
                    unitPricePurchase: $('#productUnitPricePurchase').val(),
                    unitPriceSale: $('#productUnitPriceSale').val(),
                    unitPricePurchaseIgv: $('#productUnitPricePurchaseIgv').val(),
                    unitPriceSaleIgv: $('#productUnitPriceSaleIgv').val(),
                    affectationCode: $('#productAffectationIgvTypeCode').val(),
                    currencyCode: $('#productCurrencyCode').val(),
                    systemIscCode: $('#productSystemIscTypeCode').val(),
                    isc: $('#productIsc').val(),
                    productId: this.modeForm === 'update' ? $('#productProductId').val() : 0,
                }),
                success: this.submitCallback
                    ? this.submitCallback
                    : () => {
                        console.warn('Callback Not Fount')
                    }
            });
        });
    }

    delete(){
        $('.jsProductDelete').on('click', ev => {
            ev.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo!'
            }).then((result) => {
                if (result.value) {
                    let productId = ev.target.dataset.id;

                    $.ajax({
                        url: service.apiPath + '/Product/Delete',
                        type: "POST",
                        dataType: 'json',
                        contentType : 'application/json',
                        data: JSON.stringify({
                            product_id: productId,
                        }),
                        success: response => {
                            if (response.success) {
                                Swal.fire(
                                    '¡Eliminado!',
                                    'Su registro ha sido eliminado.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: '¡Algo salió mal!',
                                    text: response.message,
                                })
                            }
                        }
                    });
                }
            })
        });
    }

    updateModal(){
        $('.jsProductEdit').on('click', e => {
            e.preventDefault();
            this.modeForm = 'update';
            let productId = e.target.dataset.id;

            $.ajax({
                url: service.apiPath + '/Product/ById',
                type: "POST",
                dataType: 'json',
                contentType : 'application/json',
                data: JSON.stringify({
                    product_id: productId,
                }),
                success: response => {
                    if (response.success) {
                        $('#productModal').modal('show');

                        $('#productDescription').val(response.data.description);
                        $('#productUnitPricePurchase').val(response.data.unit_price_purchase);
                        $('#productUnitPriceSale').val(response.data.unit_price_sale);
                        $('#productUnitPricePurchaseIgv').val(response.data.unit_price_purchase_igv);
                        $('#productUnitPriceSaleIgv').val(response.data.unit_price_sale_igv);
                        $('#productAffectationIgvTypeCode').val(response.data.affectation_code);
                        $('#productCurrencyCode').val(response.data.currency_code);
                        $('#productProductId').val(response.data.product_id);
                        $('#productSystemIscTypeCode').val(response.data.system_isc_code);
                        $('#productIsc').val(response.data.isc);

                        let productProductCode = $('#productProductCode');
                        productProductCode.html(`
                            <option value="${response.data.product_code.code}" selected="selected">${response.data.product_code.description}</option>
                        `).selectpicker('refresh');
                        productProductCode.selectpicker('val', response.data.product_code.code);
                        productProductCode.trigger('change');

                        let productUnitMeasureId = $('#productUnitMeasureCode');
                        productUnitMeasureId.html(`
                            <option value="${response.data.unit_measure_code.code}" selected="selected">${response.data.unit_measure_code.description}</option>
                        `).selectpicker('refresh');
                        productUnitMeasureId.selectpicker('val', response.data.unit_measure_code.code);
                        productUnitMeasureId.trigger('change');
                    }
                }
            });
        });
    }
}
let productForm = new ProductForm();

(function () {
    let unitMeasureTypeCodeOptions = {
        ajax: {
            url: service.apiPath + '/UnitMeasureTypeCode/Search',
            type: 'POST',
            dataType: 'json',
            data: {
                q: "{{{q}}}"
            }
        },
        preprocessData: function (response) {
            let i;
            let data = response.data;
            let l = data.length;
            let array = [];

            if (l) {
                for (i = 0; i < l; i++) {
                    array.push(
                        $.extend(true, data[i], {
                            text: `${data[i].description} - ${data[i].code}`,
                            value: data[i].code,
                        })
                    );
                }
            }
            return array;
        }
    };
    $('.searchUnitMeasureTypeCode')
        .selectpicker()
        .filter(".with-ajax")
        .ajaxSelectPicker(unitMeasureTypeCodeOptions);
})();

// Search SUNAT CODE
(function () {
    let searchProductCodeOptions = {
        ajax: {
            url: service.apiPath + '/ProductCode/Search',
            type: 'POST',
            dataType: 'json',
            data: {
                q: "{{{q}}}"
            }
        },
        preprocessData: function (response) {
            let i;
            let data = response.data;
            let l = data.length;
            let array = [];

            if (l) {
                for (i = 0; i < l; i++) {
                    array.push(
                        $.extend(true, data[i], {
                            text: data[i].description,
                            value: data[i].code,
                            data: {
                                subtext: data[i].code
                            }
                        })
                    );
                }
            }
            return array;
        }
    };
    $('.productCode').selectpicker().filter(".with-ajax")
        .ajaxSelectPicker(searchProductCodeOptions);
})();

// ---------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------
// INVOICE
// ---------------------------------------------------------------------------------------------------------------------------

$('#invoiceNewCustomer').on('click',e =>{
    $('#customerModal').modal('show');

    const successCallback = response => {
        if (response.success) {
            $.ajax({
                url: `${service.apiPath}/Customer/ById`,
                dataType: 'json',
                type: 'post',
                contentType: 'application/json',
                data: JSON.stringify({ customer_id: response.data }),
                success: res =>{
                    $('#customerModal').modal('hide');
                    let selectCustomerSearch = $('#selectCustomerSearch');
                    selectCustomerSearch.html(`
                        <option value="${res.data.customer_id}" title="${res.data.social_reason}" selected="selected">${res.data.social_reason}</option>
                    `).selectpicker('refresh');
                    selectCustomerSearch.selectpicker('render');
                    selectCustomerSearch.selectpicker('val', res.data.customer_id);
                    selectCustomerSearch.trigger('change');
                }
            });
        } else {
            Swal.fire({
                type: 'error',
                title: '¡Algo salió mal!',
                html: response.message,
            });

            if ( typeof(response.error) == 'object' ){
                let keys = Object.keys(response.error);
                $('#customerForm input').removeClass('is-invalid');
                $('#customerForm select').removeClass('is-invalid');
                keys.forEach(k => {
                    $(`#customerForm #${k}`).addClass('is-invalid');
                    $(`#customerForm .${k}-feedback`).html(response.error[k]['messages'][0]);
                });
            }
        }
    };

    customerForm.setModeForm('create');
    CustomerForm.clearForm();
    customerForm.setSubmitCallBack(successCallback)
});

/**
 * Dependencies
 *  - ProductForm                       : class
 *  - ValidateInputIsNumber             : function | Helper
 *  - GenerateUniqueId                  : function | Helper
 *  - RoundCurrency                     : function | Helper
 * @constructor
 */
const InvoiceScripts = () => {
    let detailSaleTableBody = $('#detailSaleTableBody'),
        invoiceOperationCode = $('#invoiceOperationCode'),
        businessIncludeIgv = parseInt($('#businessIncludeIgv').val()) === 1,
        invoiceDocumentCode = $('#invoiceDocumentCode');

    let igvPercentage = 0.18;

    // Calc total invoice
    const calcTotalInvoice = () => {
        let totalItemInput = [...$('.JsInvoiceTotalItem')];
        let discountItemInput = [...$('.JsInvoiceDiscountItem')];
        let subTotalItemInput = [...$('.JsInvoiceSubTotalItem')];
        let affectationItemInput = [...$('.JsInvoiceAffectationItem')];
        let igvItemInput = [...$('.JsInvoiceIgvItem')];
        let iscItemInput = [...$('.JsInvoiceIscItem')];

        let prepaymentRegulationItemInput = [...$('.JsPrepaymentRegulationItem')];

        // let iscItem = [...$('.JsInvoiceIscItem')];
        let plasticBagTaxInput = [...$('.JsInvoicePlasticBagTax')];

        let invoiceSaleCreditNoteCode = $('#invoiceSaleCreditNoteCode');
        let invoiceGlobalDiscountPercentage = $('#invoiceGlobalDiscountPercentage').val();

        // CALC prepayment
        let sumPrepaymentTotalItem = 0;
        $.each(subTotalItemInput, function(t) {
            if($(prepaymentRegulationItemInput[t]).is(':checked')){
                sumPrepaymentTotalItem += parseFloat($(subTotalItemInput[t]).val() || 0)
            }
        });
        $('#invoiceTotalPrepayment').val(RoundCurrency(sumPrepaymentTotalItem));

        // CALC Exonerated
        let sumExoneratedTotalItem = 0;
        let sumExoneratedPrepaymentTotalItem = 0;
        $.each(subTotalItemInput, function(t) {
            if($(affectationItemInput[t]).val() === '20'){
                if($(prepaymentRegulationItemInput[t]).is(':checked')){
                    sumExoneratedPrepaymentTotalItem += parseFloat($(subTotalItemInput[t]).val() || 0)
                }else {
                    sumExoneratedTotalItem += parseFloat($(subTotalItemInput[t]).val() || 0)
                }
            }
        });
        let exoneratedDiscount = invoiceGlobalDiscountPercentage > 0 ? ( sumExoneratedTotalItem * invoiceGlobalDiscountPercentage / 100) : 0;
        $('#invoiceTotalExonerated').val(RoundCurrency(sumExoneratedTotalItem - exoneratedDiscount - sumExoneratedPrepaymentTotalItem));

        // CALC Unaffected
        let sumUnaffectedTotalItem = 0;
        let sumUnaffectedPrepaymentTotalItem = 0;
        $.each(subTotalItemInput, function(t) {
            if($(affectationItemInput[t]).val() === '30' || ($(affectationItemInput[t]).val() === '40' && invoiceOperationCode.val() === '0401')){
                if($(prepaymentRegulationItemInput[t]).is(':checked')){
                    sumUnaffectedPrepaymentTotalItem += parseFloat($(subTotalItemInput[t]).val() || 0)
                }else {
                    sumUnaffectedTotalItem += parseFloat($(subTotalItemInput[t]).val() || 0)
                }
            }
        });
        let unaffectedDiscount = invoiceGlobalDiscountPercentage > 0 ? ( sumUnaffectedTotalItem * invoiceGlobalDiscountPercentage / 100) : 0;
        $('#invoiceTotalUnaffected').val(RoundCurrency(sumUnaffectedTotalItem - unaffectedDiscount - sumUnaffectedPrepaymentTotalItem));


        // CALC export
        let sumExportTotalItem = 0;
        let sumExportPrepaymentTotalItem = 0;
        $.each(subTotalItemInput, function(t) {
            if($(affectationItemInput[t]).val() === '40' && invoiceOperationCode.val() !== '0401'){
                if($(prepaymentRegulationItemInput[t]).is(':checked')){
                    sumExportPrepaymentTotalItem += parseFloat($(subTotalItemInput[t]).val() || 0)
                }else {
                    sumExportTotalItem += parseFloat($(subTotalItemInput[t]).val() || 0)
                }
            }
        });
        let exportDiscount = invoiceGlobalDiscountPercentage > 0 ? ( sumExportTotalItem * invoiceGlobalDiscountPercentage / 100) : 0;
        $('#invoiceTotalExport').val(RoundCurrency(sumExportTotalItem - exportDiscount - sumExportPrepaymentTotalItem));

        // CALC Taxed
        let sumTaxedTotalItem = 0;
        let sumTaxedPrepaymentTotalItem = 0;
        $.each(subTotalItemInput, function(t) {
            if($(affectationItemInput[t]).val() === '10'){
                if($(prepaymentRegulationItemInput[t]).is(':checked')){
                    sumTaxedPrepaymentTotalItem += parseFloat($(subTotalItemInput[t]).val() || 0)
                }else {
                    if (!(invoiceSaleCreditNoteCode.val() === '03' && invoiceDocumentCode.val() === '07')){
                        sumTaxedTotalItem += parseFloat($(subTotalItemInput[t]).val() || 0)
                    }
                }
            }
        });
        let taxedDiscount = invoiceGlobalDiscountPercentage > 0 ? ( sumTaxedTotalItem * invoiceGlobalDiscountPercentage / 100) : 0;
        $('#invoiceTotalTaxed').val(RoundCurrency(sumTaxedTotalItem - taxedDiscount - sumTaxedPrepaymentTotalItem));



        // CALC Discounts
        let sumDiscountItem = 0;
        $.each(discountItemInput, function(t) {
            if(!($(prepaymentRegulationItemInput[t]).is(':checked'))){
                sumDiscountItem += parseFloat($(discountItemInput[t]).val() || 0);
            }
        });
        $('#invoiceItemDiscount').val(RoundCurrency(sumDiscountItem));
        let totalDiscount = exoneratedDiscount + unaffectedDiscount + taxedDiscount;

        $('#invoiceTotalDiscount').val(RoundCurrency(sumDiscountItem + totalDiscount));
        // $('#invoiceTotalDiscount').val(RoundCurrency(totalDiscount));
        $('#invoiceGlobalDiscount').val(RoundCurrency(totalDiscount));

        // CALC ISC
        let sumIscItem = 0;
        $.each(iscItemInput, function(t) {
            sumIscItem += parseFloat($(iscItemInput[t]).val() || 0)
        });
        $('#invoiceTotalIsc').val(RoundCurrency(sumIscItem));

        // CALC IGV
        let sumIgvItem = 0;
        let sumIgvPrepaymentItem = 0;
        $.each(igvItemInput, function(t) {
            if($(prepaymentRegulationItemInput[t]).is(':checked')){
                sumIgvPrepaymentItem += parseFloat($(igvItemInput[t]).val() || 0);
            }else {
                if (!(invoiceSaleCreditNoteCode.val() === '03' && invoiceDocumentCode.val() === '07')){
                    sumIgvItem += parseFloat($(igvItemInput[t]).val() || 0);
                }
            }
        });

        if(invoiceGlobalDiscountPercentage > 0){
            $('#invoiceTotalIgv').val(RoundCurrency((sumTaxedTotalItem - taxedDiscount) * igvPercentage));
        }else{
            $('#invoiceTotalIgv').val(RoundCurrency(sumIgvItem - sumIgvPrepaymentItem));
        }


        // CALC Free
        let sumFreeTotalItem = 0;
        let sumFreePrepaymentTotalItem = 0;
        $.each(subTotalItemInput, function(t) {
            switch ($(affectationItemInput[t]).val()) {
                case "11":
                case "12":
                case "13":
                case "14":
                case "15":
                case "16":
                case "31":
                case "32":
                case "33":
                case "34":
                case "35":
                case "36":
                    if($(prepaymentRegulationItemInput[t]).is(':checked')){
                        sumFreePrepaymentTotalItem += parseFloat($(subTotalItemInput[t]).val() || 0);
                    }else {
                        sumFreeTotalItem += parseFloat($(subTotalItemInput[t]).val() || 0);
                    }
                    break;
                default:
                    break;
            }
        });
        $('#invoiceTotalFree').val(RoundCurrency(sumFreeTotalItem - sumFreePrepaymentTotalItem));

        // CALC PLASTIC
        let plasticBagTax = 0;
        $.each(plasticBagTaxInput, function(t) {
            plasticBagTax += parseFloat($(plasticBagTaxInput[t]).val() || 0)
        });
        $('#invoiceTotalPlasticBagTax').val(RoundCurrency(plasticBagTax));

        // CALC TOTALS
        let invoiceTotals = $('.JsInvoiceTotals'),
            sumInvoiceTotals = 0;
        $.each(invoiceTotals, function(t) {
            sumInvoiceTotals += parseFloat($(invoiceTotals[t]).val() || 0);
        });


        let invoiceTotalCharge = $('#invoiceTotalCharge').val() || 0;

        let invoiceTotal = 0;
        if (!(invoiceSaleCreditNoteCode.val() === '03' && invoiceDocumentCode.val() === '07')){
            invoiceTotal = parseFloat(sumInvoiceTotals) + parseFloat(invoiceTotalCharge) + parseFloat(plasticBagTax);
        }
        $('#invoiceTotal').val(RoundCurrency(invoiceTotal));
    };

    // Calc item invoice items and search
    const executeSearchItemCalc = (uniqueId)=> {
        let total,
            totalBaseIgv,
            totalBaseIsc,
            igv,
            unitPrice,
            unitValue,
            totalValue;

        let affectationInput = $(`#affectation${uniqueId}`),
            quantityInput    = $(`#quantity${uniqueId}`),
            discountInput    = $(`#discount${uniqueId}`);

        let taxIscInput             = $(`#taxIsc${uniqueId}`),
            systemIscCodeInput      = $(`#systemIscCode${uniqueId}`),
            iscInput                = $(`#isc${uniqueId}`);

        let totalItemInput = $(`#totalItem${uniqueId}`);

        let ICBPERYears = {
                '2019' : 0.1,
                '2020' : 0.2,
                '2021' : 0.3,
                '2022' : 0.4,
                '2023' : 0.5,
            },
            invoiceDateOfIssueInput = $('#invoiceDateOfIssue');

        // Calc Item
        const calcInvoiceItem = ()=>{
            let quantity    = quantityInput.val() || 0,
                discount    = discountInput.val() || 0;

            let taxIsc             = taxIscInput.val() || 0,
                systemIscCode   = systemIscCodeInput.val() || 0,
                isc        = 0;

            const calcISC = (includeIsc = false) => {
                switch (systemIscCode) {
                    case "01":
                        if (includeIsc){
                            return  unitValue / (1+(taxIsc/100));
                        } else {
                            totalBaseIsc = unitValue * quantity;
                            return totalBaseIsc * (taxIsc / 100);
                        }
                    case "02":
                        if (includeIsc){
                            return  unitValue / taxIsc;
                        }else {
                            totalBaseIsc = quantity;
                            return totalBaseIsc * taxIsc;
                        }
                    case "03":
                        if (includeIsc){
                            return  unitValue / (1+(taxIsc/100));
                        } else {
                            totalBaseIsc = unitValue * quantity;
                            return totalBaseIsc * (taxIsc / 100);
                        }
                    default:
                        return 0;
                }
            };

            if (businessIncludeIgv){
                unitPrice = $(`#unitPrice${uniqueId}`).val() || 0;

                if (affectationInput.val() === "10"){
                    if (taxIsc > 0){
                        unitValue = unitPrice / (1 + igvPercentage);
                        unitValue = calcISC(true);
                        isc = calcISC();
                        totalValue = (quantity * unitValue) - discount;
                        totalBaseIgv = totalValue + isc;
                        igv = totalBaseIgv * igvPercentage;
                        total = totalValue + igv;
                    } else {
                        unitValue = unitPrice / (1 + igvPercentage);
                        totalValue = (quantity * unitValue) - discount;
                        totalBaseIgv = totalValue;
                        igv = totalBaseIgv * igvPercentage;
                        total = totalValue + igv;
                    }
                }else {
                    if (taxIsc > 0){
                        unitValue = unitPrice;
                        unitValue = calcISC(true);
                        isc = calcISC();
                        totalValue = (quantity * unitValue) - discount;
                        totalBaseIgv = totalValue + isc;
                        igv = 0;
                        total = totalValue + igv;
                    } else {
                        unitValue = unitPrice;
                        totalValue = (quantity * unitValue) - discount;
                        totalBaseIgv = totalValue;
                        igv = 0;
                        total = totalValue + igv;
                    }
                }
                $(`#unitValue${uniqueId}`).val(unitValue);
                $(`#totalValueItem${uniqueId}`).val(RoundCurrency(totalValue));
                $(`#totalBaseIsc${uniqueId}`).val(totalBaseIsc);
                $(`#isc${uniqueId}`).val(isc);
                $(`#totalBaseIgv${uniqueId}`).val(totalBaseIgv);
                $(`#igv${uniqueId}`).val(igv);
                $(`#totalItem${uniqueId}`).val(RoundCurrency(total));

                $(`#totalValueItemDecimal${uniqueId}`).val(totalValue);
                $(`#totalItemDecimal${uniqueId}`).val(total);
            } else {
                unitValue = $(`#unitValue${uniqueId}`).val() || 0;

                if (affectationInput.val() === "10"){
                    if (taxIsc > 0){
                        unitPrice = (unitValue + isc) * (1 + igvPercentage);
                        isc = calcISC();
                        totalValue = (quantity * unitValue) - discount;
                        totalBaseIgv = totalValue + isc;
                        igv = totalBaseIgv * igvPercentage;
                        total =totalValue + igv + isc;
                    } else {
                        unitPrice = unitValue * (1 + igvPercentage);
                        totalValue = (quantity * unitValue) - discount;
                        totalBaseIgv = totalValue;
                        igv = totalValue * igvPercentage;
                        total = totalValue + igv;
                    }
                } else {
                    if(taxIsc > 0) {
                        unitPrice = unitValue + isc;
                        isc = calcISC();
                        totalValue = (quantity * unitValue) - discount;
                        totalBaseIgv = totalValue;
                        igv = 0;
                        total = totalValue + igv + isc;
                    } else {
                        unitPrice = unitValue;
                        totalValue = (quantity * unitValue) - discount;
                        totalBaseIgv = totalValue;
                        igv = 0;
                        total =totalValue + igv;
                    }
                }
                $(`#unitPrice${uniqueId}`).val(unitPrice);
                $(`#totalValueItem${uniqueId}`).val(RoundCurrency(totalValue));
                $(`#totalBaseIsc${uniqueId}`).val(totalBaseIsc);
                $(`#isc${uniqueId}`).val(isc);
                $(`#totalBaseIgv${uniqueId}`).val(totalBaseIgv);
                $(`#igv${uniqueId}`).val(igv);
                $(`#totalItem${uniqueId}`).val(RoundCurrency(total));

                $(`#totalValueItemDecimal${uniqueId}`).val(totalValue);
                $(`#totalItemDecimal${uniqueId}`).val(total);
            }

            if($(`#plasticBagTaxEnabled${uniqueId}`).is(':checked')){
                let quantity    = $(`#quantity${uniqueId}`).val() || 0;
                let invoiceDateOfIssue = invoiceDateOfIssueInput.val(),
                    currentYear = parseFloat(invoiceDateOfIssue.split('-')[0]);
                let plasticBagTaxed = currentYear > 2023 ? ICBPERYears[2023] : ICBPERYears[currentYear] * quantity;
                $(`#plasticBagTax${uniqueId}`).val(RoundCurrency(plasticBagTaxed));
            }else {
                $(`#plasticBagTax${uniqueId}`).val(RoundCurrency(0));
            }

            calcTotalInvoice();
        };
        const reCalcInvoiceItemByTotal = () => {
            let quantity    = quantityInput.val() || 0,
                discount    = discountInput.val() || 0,
                totalItem   = totalItemInput.val() || 0;

            // let quantityCalculate;
            //
            // if (includeIgv){
            //     unitPrice = $(`#unitPrice${uniqueId}`).val() || 0;
            //     quantityCalculate = totalItem / unitPrice;
            //
            //     if (affectationInput.val() === "10"){
            //         unitValue = unitPrice / (1 + igvPercentage);
            //         totalValue = quantityCalculate * unitValue;
            //         igv = totalValue * igvPercentage;
            //     } else {
            //         unitValue = unitPrice;
            //         totalValue = quantityCalculate * unitValue;
            //         igv = 0;
            //     }
            //
            //     $(`#quantity${uniqueId}`).val(quantityCalculate);
            //     $(`#unitValue${uniqueId}`).val(unitValue);
            //     $(`#totalValueItem${uniqueId}`).val(RoundCurrency(totalValue));
            //     $(`#igv${uniqueId}`).val(igv);
            //     // $(`#totalItem${uniqueId}`).val(RoundCurrency(totalItem));
            //
            //     $(`#totalValueItemDecimal${uniqueId}`).val(totalValue);
            //     $(`#totalItemDecimal${uniqueId}`).val(totalItem);
            // } else {
            //     unitValue = $(`#unitValue${uniqueId}`).val() || 0;
            //     quantityCalculate = totalItem / (1 + igvPercentage) / unitValue;
            //
            //     if (affectationInput.val() === "10"){
            //         unitPrice = unitValue * (1 + igvPercentage);
            //         totalValue = quantityCalculate * unitValue;
            //         igv = totalValue * igvPercentage;
            //         totalItem = totalValue + igv;
            //     }else {
            //         unitPrice = unitValue;
            //         totalValue = quantityCalculate * unitValue;
            //         igv= 0;
            //         totalItem = totalValue + igv;
            //     }
            //
            //     $(`#quantity${uniqueId}`).val(quantityCalculate);
            //     $(`#unitPrice${uniqueId}`).val(unitPrice);
            //     $(`#totalValueItem${uniqueId}`).val(RoundCurrency(totalValue));
            //     $(`#igv${uniqueId}`).val(igv);
            //     // $(`#totalItem${uniqueId}`).val(RoundCurrency(totalItem));
            //
            //     $(`#totalValueItemDecimal${uniqueId}`).val(totalValue);
            //     $(`#totalItemDecimal${uniqueId}`).val(totalItem);
            // }
            // calcTotalInvoice();
        };

        // Search product
        let invoiceSearchProductOptions = {
            ajax: {
                url: service.apiPath + '/Product/Search',
                type: 'POST',
                dataType: 'json',
                data: {
                    q: "{{{q}}}"
                }
            },
            locale: {
                emptyTitle: 'Seleccionar un Producto/Servicio...',
            },
            preprocessData: function (response) {
                let i;
                let data = response.data;
                let l = data.length;
                let array = [];

                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push(
                            $.extend(true, data[i], {
                                text:  `${data[i].description}`,
                                value: data[i].product_id,
                                data: {
                                    subtext: `${data[i].unit_measure_code}`
                                }
                            })
                        );
                    }
                }
                return array;
            }
        };
        let productSearchSelect = $( `#selectProduct${uniqueId}`);
        productSearchSelect.selectpicker('setStyle','btn-sm','add')
            .filter(".with-ajax")
            .ajaxSelectPicker(invoiceSearchProductOptions)
            .on('changed.bs.select',(e) => {
                $.ajax({
                    url: `${service.apiPath}/Product/ByID`,
                    dataType: 'json',
                    type: 'post',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        product_id: e.target.value
                    }),
                    success: response => {
                        if(businessIncludeIgv){
                            $(`#unitPrice${uniqueId}`).val(response.data.unit_price_sale_igv);
                            $(`#unitValue${uniqueId}`).attr('type','hidden');
                        }else {
                            $(`#unitValue${uniqueId}`).val(response.data.unit_price_sale);
                            $(`#unitPrice${uniqueId}`).attr('type','hidden');
                        }

                        if ( response.data.system_isc_code !== "" ){
                            $(`#systemIscCode${uniqueId}`).val(response.data.system_isc_code);
                            $(`#taxIsc${uniqueId}`).val(response.data.isc);
                            $(`#iscRow${uniqueId}`).removeClass('d-none');
                        } else {
                            $(`#iscRow${uniqueId}`).addClass('d-none');
                        }

                        $(`#affectation${uniqueId}`).val(response.data.affectation_code);
                        $(`#description${uniqueId}`).val(response.data.description);
                        $(`#unitMeasure${uniqueId}`).val(response.data.unit_measure_code.code);
                        $(`#productCode${uniqueId}`).val(response.data.product_code.code);

                        calcInvoiceItem();
                    }
                });
            });

        // Events
        $(`#newProduct${uniqueId}`).on('click',()=>{
            ProductForm.ClearForm();
            $(`#productModal`).modal('show');

            let successCallback = response => {
                if (response.success){
                    $.ajax({
                        url: `${service.apiPath}/Product/ById`,
                        dataType: 'json',
                        type: 'post',
                        contentType: 'application/json',
                        data: JSON.stringify({ product_id: response.data }),
                        success: res =>{
                            $(`#unitValue${uniqueId}`).val(res.data.unit_price_sale_igv || 0);

                            productSearchSelect.html(`
                                <option value="${res.data.product_id}" title="${res.data.description}" selected="selected">${res.data.description}</option>
                            `).selectpicker('refresh');
                            productSearchSelect.selectpicker('val', res.data.product_id);
                            productSearchSelect.trigger('change');

                            $(`#productModal`).modal('hide');
                            calcInvoiceItem();
                        }
                    })
                }else {
                    Swal.fire({
                        type: 'error',
                        title: '¡Algo salió mal!',
                        text: response.message,
                    });

                    if ( typeof(response.error) == 'object' ){
                        let keys = Object.keys(response.error);
                        $('#productForm input').removeClass('is-invalid');
                        $('#productForm select').removeClass('is-invalid');
                        keys.forEach(k => {
                            $(`#productForm #product_${k}`).addClass('is-invalid');
                            $(`#productForm .product_${k}-feedback`).html(response.error[k]);
                        });
                    }
                }
            };

            productForm.setModeForm('create');
            productForm.setSubmitCallBack(successCallback);
        });
        $(`#remove${uniqueId}`).on('click',()=>{
            $(`#invoiceItem${uniqueId}`).remove();
            calcInvoiceItem();
        });
        $(`#quantity${uniqueId}, #discount${uniqueId}, #unitPrice${uniqueId}, #unitValue${uniqueId}, #taxIsc${uniqueId}`).on('change keyup paste',e=>{
            if(ValidateInputIsNumber(e.target)){
                return false;
            }
            calcInvoiceItem();
        });
        $(`#prepaymentRegulation${uniqueId}`).on('change',e => {
            let isChecked = $(e.target).is(':checked');
            $(`#prepaymentDocumentSerie${uniqueId}`).prop('readonly',!isChecked);
            $(`#prepaymentDocumentCorrelative${uniqueId}`).prop('readonly',!isChecked);
            calcInvoiceItem();
        });
        $(`#plasticBagTaxEnabled${uniqueId}`).on('change keyup paste',e => {
            if($(`#plasticBagTaxEnabled${uniqueId}`).is(':checked')){
                $(`#plasticBagRow${uniqueId}`).removeClass('d-none');
            }else {
                $(`#plasticBagRow${uniqueId}`).addClass('d-none');
            }
            calcInvoiceItem();
        });
        affectationInput.on('change keyup', calcInvoiceItem);
        totalItemInput.on('change keyup paste', e => {
            if(ValidateInputIsNumber(e.target)){
                return false;
            }
            reCalcInvoiceItemByTotal();
        });

        // execute calc
        calcInvoiceItem();
    };

    // Load Invoice
    let detailSaleTableBodyChildren = [...detailSaleTableBody.children()];
    detailSaleTableBodyChildren.forEach(item => {
        let uniqueId = item.dataset.uniqueid;
        if (!isNaN(uniqueId)){
            executeSearchItemCalc(uniqueId);
        }
    });

    // Invoice Events
    $('#addItemInvoice').on('click',() => {
        let uniqueId = GenerateUniqueId();
        let withPrepayment = (invoiceOperationCode.val() === '0104') ? '' : 'd-none';

        let itemTemplate = $('#addItemInvoice').data('itemtemplate');
        itemTemplate = eval('`' + itemTemplate + '`');

        detailSaleTableBody.append(itemTemplate);
        executeSearchItemCalc(uniqueId);
    });
    $('#invoiceGlobalDiscountPercentage').on('change keyup paste',e=>{
        if (ValidateInputIsNumber(e.target)){
            return false;
        }
        calcTotalInvoice();
    });
    $('#invoiceTotalCharge').on('change keyup paste',e=>{
        if (ValidateInputIsNumber(e.target)){
            return false;
        }
        calcTotalInvoice();
    });
    invoiceOperationCode.on('change', e => {
        let operationValue = invoiceOperationCode.val();
        $('.JSPrepaymentRow').toggleClass('d-none',!(invoiceOperationCode.val() === '0104'));
        $('#InvoicePerceptionEnableRow').toggleClass('d-none', (operationValue === '1001' || operationValue === '1002' || operationValue === '1003' || operationValue === '1004') );
        $('#InvoiceDetractionEnableRow').toggleClass('d-none', !(operationValue === '1001' || operationValue === '1002' || operationValue === '1003' || operationValue === '1004') );
        calcTotalInvoice();
    });
};
InvoiceScripts();

// Submit Validate
$('#jsInvoiceFormCommit').on('click', e => {
    e.preventDefault();
    const customSwal = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary mr-2 ml-2',
            cancelButton: 'btn btn-danger mr-2 ml-2'
        },
        buttonsStyling: false
    });

    let isValid = true;
    let message = '';

    if(!$('#detailSaleTableBody').children().length){
        isValid = false;
        message += '<strong>Debes Agregar al menos un item al documento electrónico...</strong><br/>';
    }
    if($('#selectCustomerSearch').val().trim() === ''){
        isValid = false;
        message += '<strong>Debes seleccionar un cliente válido</strong><br/>';
    }

    if (!isValid){
        customSwal.fire({
            type: 'error',
            title: 'Error',
            html: message,
        });
        return;
    }

    let invoiceTotalDiscount = parseFloat($('#invoiceTotalDiscount').val() || 0);
    let invoiceTotalPrepayment = parseFloat($('#invoiceTotalPrepayment').val() || 0);
    let invoiceTotalIsc = parseFloat($('#invoiceTotalIsc').val() || 0);
    let invoiceTotalPlasticBagTax = parseFloat($('#invoiceTotalPlasticBagTax').val() || 0);

    let invoiceTotalExonerated = parseFloat($('#invoiceTotalExonerated').val() || 0);
    let invoiceTotalUnaffected = parseFloat($('#invoiceTotalUnaffected').val() || 0);
    let invoiceTotalTaxed = parseFloat($('#invoiceTotalTaxed').val() || 0);
    let invoiceTotalFree = parseFloat($('#invoiceTotalFree').val() || 0);
    let invoiceTotalIgv = parseFloat($('#invoiceTotalIgv').val() || 0);
    let invoiceTotal = parseFloat($('#invoiceTotal').val() || 0);

    let invoiceCurrencySymbol = $('#invoiceCurrencyCode').val();
    let invoiceDocumentCode = $('#invoiceDocumentCode').val();

    let operationText = '';
    switch (invoiceDocumentCode) {
        case '01':
            operationText = 'Se creará y se enviara a las SUNAT la factura electrónica con los siguientes datos!';
            break;
        case '03':
            operationText = 'Se creará la boleta electrónica con los siguientes datos!';
            break;
        case '07':
            operationText = 'Se creará: Nota de credito';
            break;
        case '08':
            operationText = 'Se creará: Nota de debito';
            break;
    }

    customSwal.fire({
        type: 'warning',
        title: 'Necesitamos de tu Confirmación',
        html: `<div>
                    <div><strong> ${operationText}</strong></div>
                    <div class="mt-4 mb4 pl-2" style="border-left: dashed 1px rgba(0,0,0,0.2);">
                        <h6>Resumen:</h6>
                        <div class="table-responsive no-border">
                            <table class="table">
                                <tbody>
                                    <tr class="${invoiceTotalDiscount === 0 ? 'd-none' : ''}"><td class="text-left"><span class="text-danger">(-)</span> Descuento:</td><td class="text-right">${invoiceCurrencySymbol} ${invoiceTotalDiscount}</td></tr>
                                    <tr class="${invoiceTotalPrepayment === 0 ? 'd-none' : ''}"><td class="text-left">Anticipo:</td><td class="text-right">${invoiceCurrencySymbol} ${invoiceTotalPrepayment}</td></tr>
                                    <tr class="${invoiceTotalExonerated === 0 ? 'd-none' : ''}"><td class="text-left">Exonerada:</td><td class="text-right">${invoiceCurrencySymbol} ${invoiceTotalExonerated}</td></tr>
                                    <tr class="${invoiceTotalUnaffected === 0 ? 'd-none' : ''}"><td class="text-left">Inafecta:</td><td class="text-right">${invoiceCurrencySymbol} ${invoiceTotalUnaffected}</td></tr>
                                    <tr class="${invoiceTotalTaxed === 0 ? 'd-none' : ''}"><td class="text-left">Gravada:</td><td class="text-right">${invoiceCurrencySymbol} ${invoiceTotalTaxed}</td></tr>
                                    <tr class="${invoiceTotalIsc === 0 ? 'd-none' : ''}"><td class="text-left">ISC:</td><td class="text-right">${invoiceCurrencySymbol} ${invoiceTotalIsc}</td></tr>
                                    <tr class="${invoiceTotalIgv === 0 ? 'd-none' : ''}"><td class="text-left">IGV:</td><td class="text-right">${invoiceCurrencySymbol} ${invoiceTotalIgv}</td></tr>
                                    <tr class="${invoiceTotalFree === 0 ? 'd-none' : ''}"><td class="text-left">Gratuita:</td><td class="text-right">${invoiceCurrencySymbol} ${invoiceTotalFree}</td></tr>
                                    <tr class="${invoiceTotalPlasticBagTax === 0 ? 'd-none' : ''}"><td class="text-left">ICBPER:</td><td class="text-right">${invoiceCurrencySymbol} ${invoiceTotalPlasticBagTax}</td></tr>
                                    <tr class="${invoiceTotal === 0 ? 'd-none' : ''}"><td class="text-left">Total:</td><td class="text-primary font-weight-bold text-right">${invoiceCurrencySymbol} ${invoiceTotal}</td></tr>
                                </tbody>
                            </table>            
                        </div>
                    </div>
                    <div><span class="text-success font-weight-bold">¿Está Usted de Acuerdo?</span></div>
                </div>`,
        cancelButtonText: 'Cancelar!',
        reverseButtons: true,
        showCancelButton: true,
        confirmButtonText: 'Si, Adelante!'
    }).then(result => {
        if (result.value){
            $('#jsInvoiceFormCommit').off('click').click();
        }
    });
});

// Search sale
$('.filterSaleSearch').selectpicker()
    .filter(".with-ajax")
    .ajaxSelectPicker({
        ajax: {
            url: service.apiPath + '/Invoice/JsonSearch',
            type: 'POST',
            dataType: 'json',
            data: {
                q: "{{{q}}}"
            }
        },
        preprocessData: function (response) {
            let i;
            let data = response.data;
            let l = data.length;
            let array = [];

            if (l) {
                for (i = 0; i < l; i++) {
                    array.push(
                        $.extend(true, data[i], {
                            text:  `${data[i].serie}-${data[i].correlative} ( ${data[i].document_type_code_description} ) ${data[i].date_of_issue}`,
                            value: data[i].sale_id,
                        })
                    );
                }
            }

            return array;
        }
    });

$('.filterSaleNoteSearch').selectpicker()
    .filter(".with-ajax")
    .ajaxSelectPicker({
        ajax: {
            url: service.apiPath + '/InvoiceNote/JsonSearch',
            type: 'POST',
            dataType: 'json',
            data: {
                q: "{{{q}}}"
            }
        },
        preprocessData: function (response) {
            let i;
            let data = response.data;
            let l = data.length;
            let array = [];

            if (l) {
                for (i = 0; i < l; i++) {
                    array.push(
                        $.extend(true, data[i], {
                            text:  `${data[i].serie}-${data[i].correlative} ( ${data[i].document_type_code_description} ) ${data[i].date_of_issue}`,
                            value: data[i].sale_note_id,
                        })
                    );
                }
            }

            return array;
        }
    });

// ---------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------
// Referral Guide
// ---------------------------------------------------------------------------------------------------------------------------
let ReferralGuidePhysical = {
    loadItem(){
        let detailSaleTableBodyChildren = [...$('#invoiceReferralGuideTableBody').children()];
        detailSaleTableBodyChildren.forEach(item => {
            let uniqueId = item.dataset.uniqueid;
            if (!isNaN(uniqueId)){
                this.executeItem(uniqueId);
            }
        });
    },
    removeItem(uniqueId){
        $(`#referralGuideItem${uniqueId.trim()}`).remove();
    },
    executeItem(uniqueId){
        // console.log(uniqueId);
    },
    addItem(){
        let uniqueId = GenerateUniqueId();
        let itemTemplate = $('#ReferralGuidePhysicalAddItem').data('itemtemplate');
        itemTemplate = eval('`' + itemTemplate + '`');
        $('#invoiceReferralGuideTableBody').append(itemTemplate);
        this.executeItem(uniqueId);
    }
};
document.addEventListener('DOMContentLoaded',()=>{
    ReferralGuidePhysical.loadItem();
});






// ---------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------
// Geographic Location
// ---------------------------------------------------------------------------------------------------------------------------

// Search customer select picker
let geographicalLocationSearchOptions = {
    ajax: {
        url: service.apiPath + '/GeographicalLocationCode/Search',
        type: 'POST',
        dataType: 'json',
        data: {
            q: "{{{q}}}"
        }
    },
    preprocessData: function (response) {
        let i;
        let data = response.data;
        let l = data.length;
        let array = [];

        if (l) {
            for (i = 0; i < l; i++) {
                array.push(
                    $.extend(true, data[i], {
                        text:  `${data[i].code} - ${data[i].district} ${data[i].province} ${data[i].department}`,
                        value: data[i].code,
                    })
                );
            }
        }
        return array;
    }
};

// Search product
let geographicalLocationSearch = $( `.geographicalLocationSearch`);
geographicalLocationSearch.selectpicker()
    .filter(".with-ajax")
    .ajaxSelectPicker(geographicalLocationSearchOptions);










// ---------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------
// Geographic Location
// ---------------------------------------------------------------------------------------------------------------------------
// Search customer select picker
const ReferralGuideScript = () => {
    let referralGuideTableBody = $('#referralGuideTableBody');
    let guideSearchProductOptions = {
        ajax: {
            url: service.apiPath + '/Product/Search',
            type: 'POST',
            dataType: 'json',
            data: {
                q: "{{{q}}}"
            }
        },
        preprocessData: function (response) {
            let i;
            let data = response.data;
            let l = data.length;
            let array = [];

            if (l) {
                for (i = 0; i < l; i++) {
                    array.push(
                        $.extend(true, data[i], {
                            text:  data[i].description,
                            value: data[i].product_id,
                        })
                    );
                }
            }
            return array;
        }
    };

    // Script personalizado para cada item o linea
    const executeReferralGuideItem = (uniqueId)=> {
        let productSearchSelect = $( `#selectProduct${uniqueId}`);
        productSearchSelect.selectpicker('setStyle','btn-sm','add')
            .filter(".with-ajax")
            .ajaxSelectPicker(guideSearchProductOptions)
            .on('changed.bs.select',(e) => {
                    $.ajax({
                        url: `${service.apiPath}/Product/ByID`,
                        dataType: 'json',
                        type: 'post',
                        contentType: 'application/json',
                        data: JSON.stringify({
                            product_id: e.target.value
                        }),
                        success: response => {
                            $(`#description${uniqueId}`).val(response.data.description);
                            $(`#unitMeasure${uniqueId}`).val(response.data.unit_measure_code.code);
                            $(`#productCode${uniqueId}`).val(response.data.product_code.code);
                        }
                    });
                });

        $(`#remove${uniqueId}`).on('click',()=>{
            $(`#referralGuideItem${uniqueId}`).remove();
        });

        // validate
        $(`#quantity${uniqueId}`).on('change keyup paste', e => {
            return ValidateInputIsNumber(e.target);
        });
    };

    // Carga la tabla cuando ya esta pintado desde el backend
    let detailSaleTableBodyChildren = [...referralGuideTableBody.children()];
    detailSaleTableBodyChildren.forEach(item => {
        let uniqueId = item.dataset.uniqueid;
        if (!isNaN(uniqueId)){
            executeReferralGuideItem(uniqueId);
        }
    });

    // Agrega una nueva item o linea
    $('#addItemReferralGuide').on('click',() => {
        let uniqueId = GenerateUniqueId();
        referralGuideTableBody.append(`
            <tr id="referralGuideItem${uniqueId}">
                <td>
                    <select class="selectpicker with-ajax" data-live-search="true" data-width="100%" id="selectProduct${uniqueId}" name="guide[item][${uniqueId}][product_id]" required></select>
                    <input type="hidden" id="productCode${uniqueId}" name="guide[item][${uniqueId}][product_code]">
                    <input type="hidden" id="unitMeasure${uniqueId}" name="guide[item][${uniqueId}][unit_measure]">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="guide[item][${uniqueId}][description]" id="description${uniqueId}">
                </td>
                <td>
                    <input type="number" step="any" min="0" class="form-control form-control-sm" name="guide[item][${uniqueId}][quantity]" id="quantity${uniqueId}" required>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-light" id="remove${uniqueId}" title="Quitar item">
                        <i class="fas fa-times text-danger"></i>
                    </button>
                </td>
            </tr>
        `);
        executeReferralGuideItem(uniqueId);
    });
};
ReferralGuideScript();


// Search customer select picker
let searchReferralGuideOptions = {
    ajax: {
        url: service.apiPath + '/ReferralGuide/JsonSearch',
        type: 'POST',
        dataType: 'json',
        data: {
            q: "{{{q}}}"
        }
    },
    preprocessData: function (response) {
        let i;
        let data = response.data;
        let l = data.length;
        let array = [];

        if (l) {
            for (i = 0; i < l; i++) {
                array.push(
                    $.extend(true, data[i], {
                        text:  `${data[i].serie} - ${data[i].correlative}`,
                        value: data[i].referral_guide_id,
                    })
                );
            }
        }

        return array;
    }
};

// Search sale
let searchReferralGuide = $(".searchReferralGuide");
searchReferralGuide.selectpicker()
    .filter(".with-ajax")
    .ajaxSelectPicker(searchReferralGuideOptions);

// ---------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------
// Ticket Summary
// ---------------------------------------------------------------------------------------------------------------------------
function JsDetailTicketSummaryModal(summaryId){
    $("#detailTicketSummaryModal").modal('show');
    $.ajax({
        url: service.apiPath + '/InvoiceSummary/DetailTicketSummary',
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            ticket_summary_id: summaryId,
        }),
        success: response => {
            if (response.data){
                let tableBody = '';
                response.data.forEach(item => {
                    tableBody += `
                        <tr>
                            <td>${item.sale_date_of_issue}</td>
                            <td>${item.document_type_code_description}</td>
                            <td>${item.sale_serie}</td>
                            <td>${item.sale_correlative}</td>
                            <td>${item.customer_social_reason}</td>
                            <td>${item.sale_currency_code}</td>
                            <td>${item.sale_total}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    `;
                });
                $("#detailTicketSummaryModalTableBody").html(tableBody);
            }
        },
    });
}

//  VOIDED
// Submit Validate
$('#jsSaleVoidedFormCommit').on('click', e => {
    e.preventDefault();
    Swal.fire({
        type: 'warning',
        title: 'Debes confirmar esta acción!',
        text: "¿Realmente deseas dar de baja el presente documento? No podrás revertir esta acción!...",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si adelante'
    }).then(result => {
        if (result.value){
            $('#jsSaleVoidedFormCommit').off('click').click();
        }
    });
});


let DocumentPrinter = {
    print(){
        let frm = document.querySelector('#documentPrinterIframe iframe');
        if (frm){
            frm.contentWindow.print();
        }
    },
    showModal(url, showPrinter = false){
        if (!showPrinter){
            $("#documentPrinterModal").modal('show');
        }
        let salePrintModalIContent = $("#documentPrinterIframe");
        let documentPrinterOpenBrowser = $("#documentPrinterOpenBrowser");
        salePrintModalIContent.html('');
        salePrintModalIContent.html(`<iframe src="${service.path}/${url}" width="100%" height="600" frameborder="0" id="documentPrinterIframe"></iframe>`);
        documentPrinterOpenBrowser.attr('href',`${service.path}/${url}`);
        if (showPrinter){
            this.print();
        }
    }
};
