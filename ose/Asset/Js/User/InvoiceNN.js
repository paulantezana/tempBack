$(document).ready(() => {
    $("#rangofechas").daterangepicker(
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
            $("#fechainicio").val(start.format('YYYY-MM-DD'));
            $("#fechafinal").val(end.format('YYYY-MM-DD'));
        }
    );
});
