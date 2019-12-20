function BusinessLocalRemoveItem(uniqueId){
    $(`#businessLocalItem${uniqueId}`).remove();
}

function BusinessLocalAddItem(){
    let uniqueId = GenerateUniqueId();
    let itemTemplate = $('#businessLocalAddItem').data('itemtemplate');
    itemTemplate = eval('`' + itemTemplate + '`');
    $('#businessLocalSeriesTableBody').append(itemTemplate);
    $(`#documentCode${uniqueId}`).select2({ minimumResultsForSearch: -1 });
}
