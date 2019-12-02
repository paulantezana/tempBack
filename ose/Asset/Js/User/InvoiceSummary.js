const GetInvoiceNotSummary = () => {
    $.ajax({
        url: service.path + `/InvoiceSummary/GetInvoiceNotSummary`,
        type: "POST",
        data: { dateOfIssue: $('#dateOfReference').val() },
        success: res => {
            $('#productTable').html(res);
            //$(light).unblock();
        },
        error: message => {
            /*swal({
                title: 'Error',
                text: message,
                html: true,
                icon: "error",
                confirmButtonText: "Ok"
            }).then(() => {
                $(light).unblock();
            })
            */
        },
    });
}
