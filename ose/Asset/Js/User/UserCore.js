$(document).ready(function() {
    $('.select2').select2({ minimumResultsForSearch: -1 });
    $(".datePiker").daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'YYYY-MM-DD',
            daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
            monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ],
            monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul', 'Ago','Sep','Oct','Nov','Dic'],
            firstDay: 1
        }
    });

    $('.searchCustomer').select2({
        ajax: {
            url: service.apiPath + '/Customer/Search',
            dataType: 'json',
            type: "POST",
            processResults:  res =>  {
                if (res.success)
                    return  { results: res.result.map(item => ({ id: item.document_number, text: item.social_reason }))};
                else
                    return {};
            }
        }
    });

    $('.invoiceSearch').select2({
        ajax: {
            url: service.apiPath + '/Invoice/Search',
            dataType: 'json',
            type: "POST",
            processResults:  res =>  {
                if (res.success)
                    return  { results: res.result.map(item => ({ id: item.invoice_id, text: `${item.document_type_code_description}: ${item.serie} - ${item.correlative}` }))};
                else
                    return {};
            }
        }
    });

    $('.invoiceNoteSearch').select2({
        ajax: {
            url: service.apiPath + '/InvoiceNote/Search',
            dataType: 'json',
            type: "POST",
            processResults:  res =>  {
                if (res.success)
                    return  { results: res.result.map(item => ({ id: item.invoice_note_id, text: `${item.document_type_code_description}: ${item.serie} - ${item.correlative}` }))};
                else
                    return {};
            }
        }
    });

    // Layout
    $(".UserSidebar-dropdown > a").on('click',function(){
        $(".UserSidebar-submenu").slideUp(200);
        if (
            $(this).parent().hasClass("active")
        ) {
            $(".UserSidebar-dropdown").removeClass("active");
            $(this).parent().removeClass("active");
        } else {
            $(".UserSidebar-dropdown").removeClass("active");
            $(this).next(".UserSidebar-submenu").slideDown(200);
            $(this).parent().addClass("active");
        }
    });

    $("#UserSidebar-toggle").on('click',function(e){
        $('#UserLayout').toggleClass('UserSidebar-show');
    });
    $('.UserSidebar-wrapper').on('click',function (e) {
        if (e.target === this){
            $('#UserLayout').removeClass('UserSidebar-show');
        }
    });

    $.ajax({
        url: service.apiPath + '/Business/GetBusinessInfo',
        dataType: 'json',
        success: res => {
            if (res.success){
                if (res.result.business !== undefined){
                    if (res.result.business.environment == '1'){
                        $('#businessEnvironmentInfo').addClass('production').html('<i class="icon-check mr-2"></i> Produción');
                    }else {
                        $('#businessEnvironmentInfo').addClass('demo').html('<i class="icon-check mr-2"></i> Demo');
                    }
                }

                if (res.result.businessLocals){
                    let businessLocalsOptions = '<option value="">Seleccionar local</option>';
                    [...res.result.businessLocals].forEach(item => {
                        let defaultLocal = parseInt(item.businessLocalId) === parseInt(res.result.currentLocal) ? 'selected' :'';
                        businessLocalsOptions += `<option value="${item.businessLocalId}" ${defaultLocal}>${item.shortName}</option>`;
                    });
                    $('#businessCurrentLocalInfo').html(businessLocalsOptions).trigger('change').on('change',function (e) {
                        console.log(this);
                    });
                }
            }else {

            }
        },
    })
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
