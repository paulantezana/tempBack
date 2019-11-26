function CustomGenerateSummary() {
    const detailCustomSummaryTableBody = $('#detailCustomSummaryTableBody');

    let summaryUserReferenceId = $('#summaryUserReferenceId');
    let summaryUserReferenceIdValue = 0;
    summaryUserReferenceId.on('change',()=>{
        summaryUserReferenceIdValue = parseInt(summaryUserReferenceId.val());
    });

    const executeAddItemCustomSummary = uniqueId => {
        // Search Invoice
        summaryUserReferenceIdValue = parseInt(summaryUserReferenceId.val());

        let selectSaleSearchOptions = {
            ajax: {
                url: service.apiPath + '/Summary/SearchByReferenceUser',
                type: 'POST',
                dataType: 'json',
                data: {
                    q: "{{{q}}}",
                    userReferenceId: summaryUserReferenceIdValue,
                }
            },
            locale: {
                emptyTitle: 'Seleccionar un comprobante...',
            },
            preprocessData: function (response) {
                let i;
                let result = response.result;
                let l = result.length;
                let array = [];

                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push(
                            $.extend(true, result[i], {
                                text: `${result[i].serie}-${result[i].correlative} ( ${result[i].document_type_code_description} ) ${result[i].date_of_issue}`,
                                value: result[i].sale_id,
                            })
                        );
                    }
                }
                return array;
            }
        };
        let selectSearchSale = $(`#selectSearchSale${uniqueId}`);
        selectSearchSale.selectpicker('setStyle','btn-sm','add')
            .filter(".with-ajax")
            .ajaxSelectPicker(selectSaleSearchOptions);

        $(`#remove${uniqueId}`).on('click',()=>{
            $(`#rowItemCustomSummary${uniqueId}`).remove();
        });
    };

    $('#addItemCustomSummary').on('click',()=>{
        let uniqueId = GenerateUniqueId();
        detailCustomSummaryTableBody.append(`
            <tr id="rowItemCustomSummary${uniqueId}">
                <td>
                    <select class="selectpicker with-ajax" data-live-search="true" id="selectSearchSale${uniqueId}" name="summary[item][${uniqueId}][sale_id]" required></select>
                </td>
                <td>
                    <select id="summaryStateCode${uniqueId}" class="form-control form-control-sm" name="summary[item][${uniqueId}][summary_state_code]" required>
                        <option value="1">Adicionar</option>
                        <option value="2">Modificar</option>
                        <option value="3">Anulado</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-light" id="remove${uniqueId}" title="Quitar item">
                        <i class="fas fa-times text-danger"></i>
                    </button>
                </td>
            </tr>
        `);
        executeAddItemCustomSummary(uniqueId);
    });
}

CustomGenerateSummary();


function JsDetailTicketSummaryModal(summaryId){
    $("#detailTicketSummaryModal").modal('show');
    $.ajax({
        url: service.apiPath + '/Summary/DetailTicketSummary',
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
