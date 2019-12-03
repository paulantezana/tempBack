// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.select2').select2({ minimumResultsForSearch: -1 });

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

