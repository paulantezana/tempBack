let  Product = {
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

        $('.searchProductCode').select2({
            ajax: {
                url: service.path + '/ProductCode/Search',
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

    search(event){
        event.preventDefault();
        this.list(1,10, event.target.value);
    },

    list(page = 1, limit = 10, search = ''){
        let light = $("#productContainer");
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
            url: service.path + `/Product/Table?limit=${limit}&page=${page}&search=${search}`,
            success: res => {
                $('#productTable').html(res);
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
        let light = $("#productFormContainer");
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
        let productData = {};
        productData.unitMeasureCode = $('#productUnitMeasureCode').val();
        productData.description= $('#productDescription').val();
        productData.productCode= $('#productProductCode').val();
        productData.unitPriceSale= $('#productUnitPriceSale').val();
        productData.unitPriceSaleIgv= $('#productUnitPriceSaleIgv').val();
        productData.affectationCode= $('#productAffectationIgvTypeCode').val();
        productData.systemIscCode= $('#productSystemIscTypeCode').val();
        productData.isc= $('#productIsc').val();

        if (this.currentModeForm === 'create'){
            url = '/Product/Create';
        }
        if (this.currentModeForm === 'update'){
            url = '/Product/Update';
            productData.productId = $('#productId').val();
        }

        $.ajax({
            url: service.path + url,
            type: "POST",
            dataType : 'json',
            data: productData,
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
                        $('#productModal').modal('hide');
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

    delete(productId, content = '') {
        let light = $("#productContainer");
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
            text: "¿Estás seguro que deseas eliminar este producto?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DC3545",
            confirmButtonText: "Si, Adelante!",
            closeOnConfirm: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: service.apiPath + '/Product/Delete',
                    type: "POST",
                    dataType: 'json',
                    data: { productId },
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
        $('#productForm').trigger("reset");
        $("#productUnitMeasureCode").val(null).trigger("change");
        $("#productProductCode").val(null).trigger("change");
        $('#productAffectationIgvTypeCode').val($('#productAffectationIgvTypeCode option:eq(0)').val()).trigger('change');
        $("#productSystemIscTypeCode").val(null).trigger("change");
    },

    showModalCreate(){
        this.currentModeForm = 'create';
        this.clearForm();
        $('#productModal').modal('show');
    },

    showModalUpdate(productId, mode = 'normal'){
        this.currentModeForm = 'update';
        $('#productModal').modal('show');
        this.clearForm();

        let light = $("#productFormContainer");
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
            url: service.path + '/Product/ById',
            dataType : 'json',
            type: "POST",
            data: { productId },
            success: res => {
                if (res.success){
                    $('#productId').val(res.result.product_id);
                    $('#productDescription').val(res.result.description);
                    $('#productUnitPriceSale').val(res.result.unit_price_sale);
                    $('#productUnitPriceSaleIgv').val(res.result.unit_price_sale_igv);
                    $('#productIsc').val(res.result.isc);
                    let newUnitMeasureOption = new Option(res.result.unit_measure_code_description, res.result.unit_measure_code, true, true);
                    $("#productUnitMeasureCode").append(newUnitMeasureOption).trigger("change");
                    let newProductCodeOption = new Option(res.result.product_code_description, res.result.product_code, true, true);
                    $("#productProductCode").append(newProductCodeOption).trigger("change");
                    $("#productAffectationIgvTypeCode").val(res.result.affectation_code).trigger("change");
                    $("#productSystemIscTypeCode").val(res.result.system_isc_code).trigger("change");
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

$(document).ready(() => Product.init());
