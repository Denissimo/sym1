$(document).ready(function () {

    $('.collapse_row').hide();
    $('#field_timezone').parent().hide();
    $.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
        currentText: 'Сегодня',
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн',
            'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        weekHeader: 'Не',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        showButtonPanel: false,
        yearSuffix: ''
    };

    $.datepicker.setDefaults($.datepicker.regional['ru']);

    $("#create_from").datepicker();

    $("#create_to").datepicker();

    $("#update_from").datepicker();

    $("#update_to").datepicker();

    $(".reminder").datepicker();


    $('[data-toggle="buttons"] .btn').on('click', function () {
        // toggle style
        $(this).toggleClass('btn-success active');
        // toggle checkbox
        var $chk = $(this).find('[type=checkbox]');
        $chk.prop('checked', !$chk.prop('checked'));

        return false;
    });

    $('.comments_collaps').click(function () {
        var targ = '.' + $(this).attr('rel');
        $(targ).toggle('fade');
            // console.log(targ);
        }
    );

    $('.ctype').change(function () {
        var val = parseInt($(this).val());
        if(val == 1) {
            $('.recall').css('display', 'block');
        } else {
            $('.recall').css('display', 'none');
        }

        if(val == 10) {
            $('.notice').css('display', 'block');
        } else {
            $('.notice').css('display', 'none');
        }
        console.log($(this).val());
    });

});