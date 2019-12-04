let Invoice = {
    list(page = 1, limit = 10, search = ''){
        let light = $("#invoiceContainer");
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
            documentCode: $('#filterDocumentCode').val(),
            customerDocumentNumber: $('#filterCustomerDocumentNumber').val(),
            startDate: $('#filterStartDate').val(),
            endDate: $('#filterEndDate').val(),
            invoiceId: $('#filterInvoiceId').val(),
        };

        $.ajax({
            url: service.path + `/Invoice/Table?limit=${limit}&page=${page}&search=${search}`,
            method: 'POST',
            data: filter,
            success: res => {
                $('#invoiceTable').html(res);
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
    }
};


$(document).ready(() => {
    $("#filterRangeDate").daterangepicker(
        {
            singleDatePicker: false,
            startDate: moment().subtract(30, 'days'),
            endDate: moment(),
            minDate: moment().subtract(365, 'days'),
            maxDate: moment(),
            locale: {
                format: 'DD/MM/YYYY',
                daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
                monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                ],
                monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul', 'Ago','Sep','Oct','Nov','Dic'],
                firstDay: 1
            }
        }, function(start, end) {
            $("#filterStartDate").val(start.format('YYYY-MM-DD'));
            $("#filterEndDate").val(end.format('YYYY-MM-DD'));
            Invoice.list();
        }
    );

    $('#filterDocumentCode').on('change',() => Invoice.list() );
    $('#filterCustomerDocumentNumber').on('change',() => Invoice.list() );
    $('#filterInvoiceId').on('change',() => Invoice.list() );

    Invoice.list();
});