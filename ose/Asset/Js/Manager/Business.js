let  Business = {
    currentModeForm : 'create',
    loading : false,

    search(event){
        event.preventDefault();
        this.list(1,10, event.target.value);
    },

    list(page = 1, limit = 10, search = ''){
        $.ajax({
            url: service.path + `/Business/Table?limit=${limit}&page=${page}&search=${search}`,
            success: res => $('#businessTable').html(res),
        });
    },

    setLoading(state){
        this.loading = state;
        let submitButton = document.getElementById('businessSubmit');
        let jsBusinessOption = document.querySelectorAll('.jsBusinessOption');
        if (this.loading){
            if(submitButton){
                submitButton.setAttribute('disabled','disabled');
                submitButton.classList.add('loading');
            }
            if (jsBusinessOption) {
                jsBusinessOption.forEach(item => {
                    item.setAttribute('disabled', 'disabled');
                });
            }
        } else {
            if(submitButton){
                submitButton.removeAttribute('disabled');
                submitButton.classList.remove('loading');
            }
            if (jsBusinessOption) {
                jsBusinessOption.forEach(item => {
                    item.removeAttribute('disabled');
                });
            }
        }
    },

    submit(event){
        event.preventDefault();
        this.setLoading(true);

        let url = '';
        let businessData = {};
        businessData.ruc = $('#businessRuc').val();
        businessData.socialReason = $('#businessSocialReason').val();
        businessData.commercialReason = $('#businessCommercialReason').val();
        businessData.phone = $('#businessPhone').val();
        businessData.email = $('#businessEmail').val();
        businessData.detractionBankAccount = $('#businessDetractionBankAccount').val();

        if (this.currentModeForm === 'create'){
            url = '/Business/Create';
        }
        if (this.currentModeForm === 'update'){
            url = '/Business/Update';
            businessData.businessId = document.getElementById('businessId').value || 0;
        }

        $.ajax({
            url: service.path + url,
            type: "POST",
            dataType : 'json',
            data: businessData,
            success: res => {
                if (res.success){
                    Swal.fire({
                        type: 'success',
                        html: res.successMessage,
                        title: '<h2>Ok</h2>',
                        timer: 1500
                    });
                    this.list();
                } else {
                    Swal.fire({
                        title: 'Algo salio mal!',
                        type: 'error',
                        html: res.errorMessage,
                    });
                }
            },
            complete: ()=> this.setLoading(false)
        });
    },
    delete(businessId, content = '') {
        let _setLoading = this.setLoading;
        let _list = this.list;

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
                    url: service.apiPath + '/Business/Delete',
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
        });
    },

    showModalCreate(){
        this.currentModeForm = 'create';
        $('#businessForm').trigger("reset");
        $('#businessModal').modal('show');
    },

    showModalUpdate(businessId, mode = 'normal'){
        this.setLoading(true);
        this.currentModeForm = 'update';
        $('#businessForm').trigger("reset");

        $.ajax({
            url: service.path + '/Business/Id',
            dataType : 'json',
            type: "POST",
            data: { businessId },
            success: res => {
                if (res.success){
                    $('#businessRuc').val(res.result.ruc);
                    $('#businessSocialReason').val(res.result.social_reason);
                    $('#businessCommercialReason').val(res.result.commercial_reason);
                    $('#businessPhone').val(res.result.phone);
                    $('#businessEmail').val(res.result.email);
                    $('#businessDetractionBankAccount').val(res.result.detraction_bank_account);
                    $('#businessModal').modal('show');
                } else {
                    Swal.fire({
                        title: 'Algo salio mal!',
                        type: 'error',
                        html: res.errorMessage,
                    });
                }
            },
            complete: ()=> this.setLoading(false)
        });
    }
};

$(document).ready(()=>Business.list());
