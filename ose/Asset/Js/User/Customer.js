let  Customer = {
    currentModeForm : 'create',
    loading : false,

    init(){
        this.list();
        $('.searchUnitMeasureTypeCode').select2({
            ajax: {
                url: service.path + '/UnitMeasureTypeCode/Search',
                dataType: 'json',
                type: "POST",
                processResults:  res =>  {
                    if (res.success)
                        return  { results: res.result.map(item => ({ id: item.code, text: item.description }))};
                    else
                        return {};
                }
            }
        });
    },

    searchPublicDocumentExtractor(){
        $('#SearchPublicDocumentExtractor').prop('disabled',true);
        $.ajax({
            url: service.apiPath + '/Customer/SearchPublicDocumentExtractor',
            type: "POST",
            dataType: 'json',
            data: { documentNumber: $('#customerDocumentNumber').val() },
            success: response => {
                $('#customerDocumentNumber').val(response.result.documentNumber);
                $('#customerIdentityDocumentCode').val(response.result.identityDocumentCode).trigger('change');
                $('#customerSocialReason').val(response.result.socialReason);
                $('#customerCommercialReason').val(response.result.commercialReason);
                $('#customerFiscalAddress').val(response.result.fiscalAddress);
            },
            complete: e => {
                $('#SearchPublicDocumentExtractor').prop('disabled',false);
            }
        });
    },

    search(event){
        event.preventDefault();
        this.list(1,10, event.target.value);
    },

    list(page = 1, limit = 10, search = ''){
        let light = $("#customerContainer");
        $(light).block({
            message: '<div class="spinner-border text-info" role="status">\
                          <span class="sr-only">Loading...</span>\
                     </div> <p> <br />Guardando ...</p>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });

        let filter = {

        };

        $.ajax({
            url: service.path + `/Customer/Table?limit=${limit}&page=${page}&search=${search}`,
            success: res => {
                $('#customerTable').html(res);
                $(light).unblock();
            },
            error: message => {
                swal({
                    title: 'Error',
                    text: message,
                    html: true,
                    icon: "error",
                    confirmButtonText: "Ok"
                }).then(()=>{
                    $(light).unblock();
                })
            },
        });
    },

    submit(event){
        event.preventDefault();
        let light = $("#customerFormContainer");
        $(light).block({
            message: '<div class="spinner-border text-info" role="status">\
                          <span class="sr-only">Loading...</span>\
                     </div> <p> <br />Guardando ...</p>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });

        let url = '';
        let customerData = {};
        customerData.documentNumber= $('#customerDocumentNumber').val();
        customerData.identityDocumentCode= $('#customerIdentityDocumentCode').val();
        customerData.socialReason= $('#customerSocialReason').val();
        customerData.commercialReason= $('#customerCommercialReason').val();
        customerData.fiscalAddress= $('#customerFiscalAddress').val();
        customerData.mainEmail= $('#customerMainEmail').val();
        customerData.optionalEmail1= $('#customerOptionalEmail1').val();
        customerData.telephone= $('#customerTelephone').val();

        if (this.currentModeForm === 'create'){
            url = '/Customer/Create';
        }
        if (this.currentModeForm === 'update'){
            url = '/Customer/Update';
            customerData.customerId = $('#customerId').val();
        }

        $.ajax({
            url: service.path + url,
            type: "POST",
            dataType : 'json',
            data: customerData,
            success: res => {
                if (res.success){
                    Swal.fire({
                        text: res.successMessage,
                        html: true,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        this.list();
                        $(light).unblock();
                        $('#customerModal').modal('hide');
                    });
                } else {
                    Swal({
                        title:'Error',
                        text: res.errorMessage,
                        icon: "error",
                        confirmButtonText: "Ok",
                    }).then(()=>{
                        $(light).unblock();
                    })
                }
            },
            error: error => {
                Swal({
                    title: 'Error',
                    text: error.responseText,
                    html: true,
                    icon: "error",
                    confirmButtonText: "Ok"
                }).then(()=>{
                    $(light).unblock();
                })
            }
        })
    },

    delete(customerId, content = '') {
        let light = $("#customerContainer");
        $(light).block({
            message: '<div class="spinner-border text-info" role="status">\
                          <span class="sr-only">Loading...</span>\
                     </div> <p> <br />Guardando ...</p>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });

        Swal.fire({
            title: "Confirmación!",
            text: "¿Estás seguro que deseas eliminar este customero?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DC3545",
            confirmButtonText: "Si, Adelante!",
            closeOnConfirm: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: service.apiPath + '/Customer/Delete',
                    type: "POST",
                    dataType: 'json',
                    data: { customerId },
                    success: res => {
                        if (res.success) {
                            Swal.fire({
                                text: res.successMessage,
                                html: true,
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                this.list();
                                $(light).unblock();
                            });
                        } else {
                            swal({
                                title:'Error',
                                text: res.errorMessage,
                                icon: "error",
                                confirmButtonText: "Ok",
                            }).then(()=>{
                                $(light).unblock();
                            })
                        }
                    },
                    error: message => {
                        swal({
                            title: 'Error',
                            text: message,
                            html: true,
                            icon: "error",
                            confirmButtonText: "Ok"
                        }).then(()=>{
                            $(light).unblock();
                        })
                    },
                })
            } else {
                $(light).unblock();
            }
        });
    },

    clearForm(){
        $('#customerForm').trigger("reset");
        // $("#customerUnitMeasureCode").val(null).trigger("change");
        // $("#customerCustomerCode").val(null).trigger("change");
        // $('#customerAffectationIgvTypeCode').val($('#customerAffectationIgvTypeCode option:eq(0)').val()).trigger('change');
        // $("#customerSystemIscTypeCode").val(null).trigger("change");
    },

    showModalCreate(){
        this.currentModeForm = 'create';
        this.clearForm();
        $('#customerModal').modal('show');
    },

    showModalUpdate(customerId, mode = 'normal'){
        this.currentModeForm = 'update';
        $('#customerModal').modal('show');
        this.clearForm();

        let light = $("#customerFormContainer");
        $(light).block({
            message: '<div class="spinner-border text-info" role="status">\
                          <span class="sr-only">Loading...</span>\
                     </div> <p> <br />Guardando ...</p>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });

        $.ajax({
            url: service.path + '/Customer/ById',
            dataType : 'json',
            type: "POST",
            data: { customerId },
            success: res => {
                if (res.success){
                    $('#customerId').val(res.result.customer_id);
                    $('#customerDescription').val(res.result.description);
                    $('#customerUnitPriceSale').val(res.result.unit_price_sale);
                    $('#customerUnitPriceSaleIgv').val(res.result.unit_price_sale_igv);
                    $('#customerIsc').val(res.result.isc);
                    let newUnitMeasureOption = new Option(res.result.unit_measure_code_description, res.result.unit_measure_code, true, true);
                    $("#customerUnitMeasureCode").append(newUnitMeasureOption).trigger("change");
                    let newCustomerCodeOption = new Option(res.result.customer_code_description, res.result.customer_code, true, true);
                    $("#customerCustomerCode").append(newCustomerCodeOption).trigger("change");
                    $("#customerAffectationIgvTypeCode").val(res.result.affectation_code).trigger("change");
                    $("#customerSystemIscTypeCode").val(res.result.system_isc_code).trigger("change");
                    $(light).unblock();
                } else {
                    Swal({
                        title:'Error',
                        text: res.errorMessage,
                        icon: "error",
                        confirmButtonText: "Ok",
                    }).then(()=>{
                        $(light).unblock();
                    })
                }
            },
            error: message => {
                Swal({
                    title: 'Error',
                    text: message,
                    html: true,
                    icon: "error",
                    confirmButtonText: "Ok"
                }).then(()=>{
                    $(light).unblock();
                })
            },
        });
    }
};

$(document).ready(() => Customer.init());
