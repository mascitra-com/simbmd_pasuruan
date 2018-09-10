$(document).ready(function() {
    clock.setClock();
    numeral.register('locale', 'in', {
        delimiters: {
            thousands: '.',
            decimal: ','
        },
        abbreviations: {
            thousand: 'rb',
            million: 'jt',
            billion: 'm',
            trillion: 't'
        },
        ordinal : function (number) {
            return number === 1 ? 'er' : 'ème';
        },
        currency: {
            symbol: 'Rp'
        }
    });

    // switch between locales
    numeral.locale('in');

    var num;
    $("input[name^='nilai'], input[name^='addendum_nilai'], input[name='corrected_value']").attr('type', 'text').on('blur', function(){
        num = numeral($(this).val()).format('0,0.00');
        $(this).val(num);
    }).on('focus', function(){
        num = numeral($(this).val()).format('0.00');
        $(this).val(num);
    });

    // MARQUEE
    $('.marquee').marquee({
        //speed in milliseconds of the marquee
        duration: 12000,
        //gap in pixels between the tickers
        gap: 30,
        //time in milliseconds before the marquee will start animating
        delayBeforeStart: 0,
        //'left' or 'right'
        direction: 'left',
        //true or false - should the marquee be duplicated to show an effect of continues flow
        duplicated: true
    });

});