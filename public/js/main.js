$(document).ready(function(){

    $.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
        currentText: 'Сегодня',
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
            'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
            'Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        weekHeader: 'Не',
        dateFormat: 'yymmdd000000',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        showButtonPanel: false,
        yearSuffix: ''};

    $.datepicker.setDefaults($.datepicker.regional['ru']);

    $( "#datepick_create_from" ).datepicker({
        onSelect: function (dateText, inst) {
            $('#create_from').val(dateText).effect('highlight', {color: '#FFFF00'}, 200);
        }
    });

    $( "#datepick_create_to" ).datepicker({
        onSelect: function (dateText, inst) {
            $('#create_to').val(dateText).effect('highlight', {color: '#FFFF00'}, 200);
        }
    });

    $( "#datepick_update_from" ).datepicker({
        onSelect: function (dateText, inst) {
            $('#update_from').val(dateText).effect('highlight', {color: '#FFFF00'}, 200);
        }
    });

    $( "#datepick_update_to" ).datepicker({
        onSelect: function (dateText, inst) {
            $('#update_to').val(dateText).effect('highlight', {color: '#FFFF00'}, 200);
        }
    });

});