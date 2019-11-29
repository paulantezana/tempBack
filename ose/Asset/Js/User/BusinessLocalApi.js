let BusinessLocalApi = {
    copy(inputId){
        let range = document.createRange();
        let inputElement = document.getElementById(inputId);

        if(inputElement){
            range.selectNode(inputElement);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            document.execCommand("copy");
            window.getSelection().removeAllRanges();

            $(`#${inputId}btn`).removeClass('btn-primary');
            $(`#${inputId}btn`).addClass('btn-success');

            setTimeout(()=>{
                $(`#${inputId}btn`).removeClass('btn-success');
                $(`#${inputId}btn`).addClass('btn-primary');   
            },3000);
        }
    },
};