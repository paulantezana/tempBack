let BusinessLocal = {
    loadItem(){
        // let detailSaleTableBodyChildren = [$('#businessLocalAddItem').children()];
        // detailSaleTableBodyChildren.forEach(item => {
        //     let uniqueId = item.dataset.uniqueid;
        //     if (!isNaN(uniqueId)){
        //         this.executeItem(uniqueId);
        //     }
        // });
    },
    removeItem(uniqueId){
        $(`#businessLocalItem${uniqueId}`).remove();
    },
    executeItem(uniqueId){
        console.log(uniqueId);
    },
    addItem(){
        let uniqueId = GenerateUniqueId();
        let itemTemplate = $('#businessLocalAddItem').data('itemtemplate');
        itemTemplate = eval('`' + itemTemplate + '`');
        $('#businessLocalSeriesTableBody').append(itemTemplate);
        this.executeItem(uniqueId);
    }
};
document.addEventListener('DOMContentLoaded',()=>{
    BusinessLocal.loadItem();
});