jQuery(function($){
    var bodyBlock = $('body'),
        bodyHtmlBlock = $('body, html'),
        periodBlock = $('.period_block'),
        periodDots = periodBlock.find('.itm'),
        periodDotsL = periodDots.length,
        frequency = $('.frequency li'),
        keywordsSelectItem = $('.keywords .select_dropdown p'),
        tariffMore = $('.tariff_more'),
        tariffPop = $('.tariff_block_pop'),
        ctSwitcherItem = $('.ct_switcher > div'),
        totalDiscountVal = $('.total_discount .box > div'),
        dailyRank = $('.daily_rank > p'),
        ctInp = $('.ct_inp input'),
        actionBlockUp = $('.action_block .val_up'),
        actionBlockDown = $('.action_block .val_down'),
        calculateAdaptBtn = $('.calculate_adapt .btn'),
        calculateAdaptBlock = $('.page_wrap_subscription .calc_tariff .side_right'),
        arrowOpenCalc = $('.arrow_open_calc'),
        mobPopHeader = $('.mob_pop_header'),
        mobPopHeaderBtn = $('.mob_pop_header .btn');

    // period dots
    periodDots.on('click', function() {
        var self = $(this),
            index = self.index();


        periodDots.removeClass('active');

        for (var i = 0; i <= index; i++) {
            periodDots.eq(i).addClass('active');
        }

        for (var i = 0; i <= periodDotsL; i++) {
            periodBlock.removeClass('per' + i);
        }

        periodBlock.addClass('per' + index);

        sliderUpdate();

        totalDiscountVal.text(totalDiscount());
    });

    // frequency
    frequency.on('click', function() {
        var self = $(this);

        self.addClass('active').siblings().removeClass('active');
        updatePrice(self.data('monitoring'));

        totalDiscountVal.text(totalDiscount());
    });

    // total discount
    function totalDiscount() {
        var frequencyPercent = +frequency.siblings('.active').attr('data-discount'),
            periodPercent = +periodDots.siblings('.active').last().attr('data-discount');

        return frequencyPercent + periodPercent;
    }

    // keywords items
    keywordsSelectItem.on('click', function() {
        var self = $(this),
            selfIndex = self.index();

        setTimeout(function(){
            var curDataTariff = self.closest('[data-tariff]').attr('data-tariff'),
                curTariff = $('[data-tariff="' + curDataTariff + '"]'),
                curTariffKeywords = curTariff.find('.keywords .select_dropdown'),
                curAudit = curTariff.find('.website_audit'),
                curBacklinks = curTariff.find('.monitoring_backlinks'),

                selfDataAuditAccount = self.attr('data-audit-account'),
                selfDataAuditProject = self.attr('data-audit-project'),
                selfDataBacklinks = self.attr('data-backlinks');

            curAudit.attr('data-hint-vars', selfDataAuditAccount + "`,`" + selfDataAuditProject)
                .find('strong').text(selfDataAuditAccount);
            curBacklinks.attr('data-hint-vars', selfDataBacklinks)
                .find('strong').text(selfDataBacklinks);

            curTariff.find('.keywords .select_block > p').text(self.text());

            for (var i = 0; i < curTariffKeywords.length; i++) {
                curTariffKeywords.eq(i).find('p')
                    .eq(selfIndex).addClass('active')
                    .siblings('p').removeClass('active');
            }

            if (curDataTariff === 'personal') {
                updatePersonalPrice();
            } else if(curDataTariff === 'optimum') {
                updateOptimumPrice();
            } else if(curDataTariff === 'plus') {
                updatePlusPrice();
            } else if(curDataTariff === 'enterprise') {
                updateEnterprisePrice();
            }

            console.log(curDataTariff);

        }, 50);
    });

    // tariff_more
    tariffMore.on('click', function(event) {
        event.preventDefault();

        var self = $(this),
            curDataTariff = self.closest('[data-tariff]').attr('data-tariff'),
            curTariff = $('[data-tariff="' + curDataTariff + '"]');

        tariffPop.find('.itm').removeClass('show').end()
            .find('[data-tariff="' + curDataTariff + '"]').addClass('show');

        tariffPop.addClass('show').removeClass('show_header');

        tariffPop.find('.pop_cont').scrollTop(0);

        bodyBlock.addClass('overflow_hidden');
    });

    mobPopHeader.on('click', function(event) {
        event.stopPropagation();
    });

    mobPopHeaderBtn.on('click', function(event) {

        $(this).attr('href', $('.pop_block').find('.itm.show .top .btn').attr('href'));
    });

    $('.pop_block, .pop_close').on('click', function(event) {
        bodyBlock.removeClass('overflow_hidden');
    });

    tariffPop.find('.pop_cont').on('scroll', function() {
        var self = $(this),
            thisScrollTop = self.scrollTop(),
            thisPop = self.closest('.pop_block');

        if (thisScrollTop > 200) {
            thisPop.addClass('show_header');
        } else {
            thisPop.removeClass('show_header');
        }
    });



    // ct_switcher
    ctSwitcherItem.on('click', function() {
        $(this).addClass('active').siblings('div').removeClass('active');
    });


    ctInp.on('keypress', function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57) && event.which != 8 && event.which != 0) {
            event.preventDefault();
        }
    });

    ctInp.on('keyup', function() {
        var self = $(this);

        checkCtInp(self);
        Calc('[data-tariff=\"calculator\"]');
    });

    function checkCtInp(self) {
        if (self.hasClass('ct_websites')) {
            if (+self.val() > 100) {
                self.val(100);
            } else if (+self.val() < 1) {
                self.val(1);
            }
        }

        if (self.hasClass('ct_queries')) {
            if (+self.val() > 20000) {
                self.val(20000);
            } else if (+self.val() < 1) {
                self.val(1);
            }
        }

        if (self.hasClass('ct_engines')) {
            if (+self.val() > 5) {
                self.val(5);
            } else if (+self.val() < 1) {
                self.val(1);
            }
        }
    }

    dailyRank.on('click', function() {
        Calc('[data-tariff=\"calculator\"]');
    });

    // calc_tariff block
    actionBlockUp.on('click', function() {
        var thisInp = $(this).closest('.ct_inp').find('input'),
            thisInpVal = +thisInp.val();

        thisInp.val(++thisInpVal);

        checkCtInp(thisInp);
        Calc('[data-tariff=\"calculator\"]');
    });

    actionBlockDown.on('click', function() {
        var thisInp = $(this).closest('.ct_inp').find('input'),
            thisInpVal = +thisInp.val();

        thisInp.val(--thisInpVal);

        checkCtInp(thisInp);
        Calc('[data-tariff=\"calculator\"]');
    });

    // calc_adapt
    calculateAdaptBtn.on('click', function(event) {
        event.preventDefault();
        !calculateAdaptBlock.hasClass('show') ? calculateAdaptBlock.addClass('show') : calculateAdaptBlock.removeClass('show');
        bodyHtmlBlock.animate({scrollTop: $('.side_right').offset().top - 40}, 300);
    });

    arrowOpenCalc.on('click', function() {
        !calculateAdaptBlock.hasClass('show') ? calculateAdaptBlock.addClass('show') : calculateAdaptBlock.removeClass('show');
        bodyHtmlBlock.animate({scrollTop: $('.side_right').offset().top - 40}, 300);
    });






    function moneyFormat(amountUsd) {
        if (isRub) {
            return (amountUsd * 50).toFixed(0)+' &#8381;';
        } else {
            return '<i>' + curancy + '</i>' + amountUsd;
        }
    }

    function floorN(x, n)
    {
        var mult = Math.pow(10, n);
        return Math.floor(x*mult)/mult;
    }

    function updatePrice(val) {

        OPTIONS_frequency = val;
        switch (val)
        {

            default :
            case 'CHECK_DAILY':
                procent_skidka=0;
                break;
            case 'CHECK_WEEKLY':
                procent_skidka=20;
                break;
            case 'CHECK_1IN3_DAYS':
                procent_skidka=10;
                break;
            case 'CHECK_ON_YANDEX_UP':
                procent_skidka=20;
                break;
        }

        var personal_price = +$('[data-tariff="personal"] .tariff_values p.active').attr('data-price');
        var optimum_price = +$('[data-tariff="optimum"] .tariff_values p.active').attr('data-price');
        var plus_price = +$('[data-tariff="plus"] .tariff_values p.active').attr('data-price');
        var enterprise_price = +$('[data-tariff="enterprise"] .tariff_values p.active').attr('data-price');

        var percentPersonal = 1;
        // personal
        var price1 = floorN(floorN((personal_price*percentPersonal),0)-(floorN((personal_price*percentPersonal),0)*(procent_skidka/100)), 2);
        // optimum
        var price2 = floorN(floorN((optimum_price*percent),0)-(floorN((optimum_price*percent),0)*(procent_skidka/100)), 1);
        // plus
        var price3 = floorN(floorN((plus_price*percent),0)-(floorN((plus_price*percent),0)*(procent_skidka/100)), 1);
        // corp
        var price4 = floorN(floorN((enterprise_price*percent),0)-(floorN((enterprise_price*percent),0)*(procent_skidka/100)), 0);

        $(".price1").html(moneyFormat(price1));
        $(".price2").html(moneyFormat(price2));
        $(".price3").html(moneyFormat(price3));
        $(".price4").html(moneyFormat(price4));

        $('.billed_price span').html(moneyFormat((price1/12).toFixed(2)));

        var month_text = '';
        switch (month)
        {

            default :
            case 1:
                month_text='1m';
                break;
            case 3:
                month_text='3m';
                break;
            case 6:
                month_text='6m';
                break;
            case 9:
                month_text='9m';
                break;
            case 12:
                month_text='1y';
                break;
        }

        var personal_value = $('[data-tariff="personal"] .tariff_values p.active').attr('data-value');
        var optimum_value = $('[data-tariff="optimum"] .tariff_values p.active').attr('data-value');
        var plus_value = $('[data-tariff="plus"] .tariff_values p.active').attr('data-value');
        var enterprise_value = $('[data-tariff="enterprise"] .tariff_values p.active').attr('data-value');

        switch (personal_value)
        {
            default :
            case '4604320':
                personal_month_text = '1y';
                break;
            case '4616846':
                personal_month_text = '1yNEW100';
                break;
        }
        switch (optimum_value)
        {
            default :
            case '4604321':
                optimum_month_text = month_text+'PREM';
                break;
            case '4616882':
                optimum_month_text = month_text+'NEW500';
                break;
            case '4616883':
                optimum_month_text = month_text+'NEW750';
                break;
        }
        switch (plus_value)
        {
            default :
            case '4604323':
                plus_month_text = month_text+'PLUS';
                break;
            case '4616884':
                plus_month_text = month_text+'NEW1750';
                break;
        }
        switch (enterprise_value)
        {
            default :
            case '4604324':
                enterprise_month_text = month_text+'ENTER';
                break;
            case '4616886':
                enterprise_month_text = month_text+'NEW5000';
                break;
            case '4616887':
                enterprise_month_text = month_text+'NEW10000';
                break;
            case '4616888':
                enterprise_month_text = month_text+'NEW20000';
                break;
        }

        /*$(".4604320").attr("href", "https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS="+personal_value+"&OPTIONS"+personal_value+"="+personal_month_text+","+OPTIONS_frequency+ref_service+"&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html");
        $(".4604321").attr("href", "https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS="+optimum_value+"&OPTIONS"+optimum_value+"="+optimum_month_text+","+OPTIONS_frequency+ref_service+"&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html");
        $(".4604323").attr("href", "https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS="+plus_value+"&OPTIONS"+plus_value+"="+plus_month_text+","+OPTIONS_frequency+ref_service+"&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html");
        $(".4604324").attr("href", "https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS="+enterprise_value+"&OPTIONS"+enterprise_value+"="+enterprise_month_text+","+OPTIONS_frequency+ref_service+"&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html");*/
    }

    function updatePricePositionTracking(val) {

        var procent_skidka = 0,
            percent = 1;

        switch (val){

            default :
            case 'CHECK_DAILY':
                procent_skidka=0;
                break;
            case 'CHECK_WEEKLY':
                procent_skidka=20;
                break;
            case 'CHECK_1IN3_DAYS':
                procent_skidka=10;
                break;
            case 'CHECK_ON_YANDEX_UP':
                procent_skidka=20;
                break;
        }

        var calcHide = $(".calc_hide"),
            optimum_price = +calcHide.attr('optimum-price'),
            personal_price = +calcHide.attr('personal-price'),
            enterprise_price = +calcHide.attr('enterprise-price');

        var percentPersonal = 1;
        // personal
        var price1 = floorN(floorN((personal_price*percent),0)-(floorN((personal_price*percent),0)*(procent_skidka/100)), 1);
        // optimum
        var price2 = floorN(floorN((optimum_price*percent),0)-(floorN((optimum_price*percent),0)*(procent_skidka/100)), 1);
        // corp
        var price4 = floorN(floorN((enterprise_price*percent),0)-(floorN((enterprise_price*percent),0)*(procent_skidka/100)), 0);

        $(".price1").html(moneyFormat(price1));
        $(".price2").html(moneyFormat(price2));
        $(".price4").html(moneyFormat(price4));


        checkBilled(price1);
    }


    function updatePersonalPrice() {

        var month_text = '';
        switch (month)
        {

            default :
            case 1:
                month_text='1m';
                break;
            case 3:
                month_text='3m';
                break;
            case 6:
                month_text='6m';
                break;
            case 9:
                month_text='9m';
                break;
            case 12:
                month_text='1y';
                break;
        }

        var personal_price = +$('[data-tariff="personal"] .tariff_values p.active').attr('data-price');
        var personal_value = $('[data-tariff="personal"] .tariff_values p.active').attr('data-value');

        switch (personal_value)
        {
            default :
            case '4604320':
                personal_month_text = '1y';
                console.log(1);
                break;
            case '4616846':
                personal_month_text = '1yNEW100';
                console.log(2);
                break;
        }
        console.log(personal_value,personal_month_text);
        var percentPersonal = 1;
        var price = floorN(floorN((personal_price*percentPersonal),0)-(floorN((personal_price*percentPersonal),0)*(procent_skidka/100)), 2);
        $(".price1").html(moneyFormat(price));
        //$(".4604320").attr("href", "https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS="+personal_value+"&OPTIONS"+personal_value+"="+personal_month_text+","+OPTIONS_frequency+ref_service+"&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html");


        $('.billed_price span').html(moneyFormat((price/12).toFixed(2)));

    }

    function updateOptimumPrice() {
        var month_text = '';
        switch (month)
        {

            default :
            case 1:
                month_text='1m';
                break;
            case 3:
                month_text='3m';
                break;
            case 6:
                month_text='6m';
                break;
            case 9:
                month_text='9m';
                break;
            case 12:
                month_text='1y';
                break;
        }
        var optimum_price = +$('[data-tariff="optimum"] .tariff_values p.active').attr('data-price');
        var optimum_value = $('[data-tariff="optimum"] .tariff_values p.active').attr('data-value');

        switch (optimum_value)
        {
            default :
            case '4604321':
                optimum_month_text = month_text+'PREM';
                break;
            case '4616882':
                optimum_month_text = month_text+'NEW500';
                break;
            case '4616883':
                optimum_month_text = month_text+'NEW750';
                break;
        }
        var price = floorN(floorN((optimum_price*percent),0)-(floorN((optimum_price*percent),0)*(procent_skidka/100)), 1);
        $(".price2").html(moneyFormat(price));
        //$(".4604321").attr("href", "https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS="+optimum_value+"&OPTIONS"+optimum_value+"="+optimum_month_text+","+OPTIONS_frequency+ref_service+"&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html");
    }

    function updatePlusPrice() {
        var month_text = '';
        switch (month)
        {

            default :
            case 1:
                month_text='1m';
                break;
            case 3:
                month_text='3m';
                break;
            case 6:
                month_text='6m';
                break;
            case 9:
                month_text='9m';
                break;
            case 12:
                month_text='1y';
                break;
        }
        var plus_price = +$('[data-tariff="plus"] .tariff_values p.active').attr('data-price');
        var plus_value = $('[data-tariff="plus"] .tariff_values p.active').attr('data-value');
        $("#backlinks3").html($(".plus option:selected").data('backlinks'));

        switch (plus_value)
        {
            default :
            case '4604323':
                plus_month_text = month_text+'PLUS';
                break;
            case '4616884':
                plus_month_text = month_text+'NEW1750';
                break;
        }
        var price = floorN(floorN((plus_price*percent),0)-(floorN((plus_price*percent),0)*(procent_skidka/100)), 1);
        $(".price3").html(moneyFormat(price));
        //$(".4604323").attr("href", "https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS="+plus_value+"&OPTIONS"+plus_value+"="+plus_month_text+","+OPTIONS_frequency+ref_service+"&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html");

    }

    function updateEnterprisePrice() {
        var month_text = '';
        switch (month)
        {

            default :
            case 1:
                month_text='1m';
                break;
            case 3:
                month_text='3m';
                break;
            case 6:
                month_text='6m';
                break;
            case 9:
                month_text='9m';
                break;
            case 12:
                month_text='1y';
                break;
        }
        var enterprise_price = +$('[data-tariff="enterprise"] .tariff_values p.active').attr('data-price');
        var enterprise_value = $('[data-tariff="enterprise"] .tariff_values p.active').attr('data-value');

        switch (enterprise_value)
        {
            default :
            case '4604324':
                enterprise_month_text = month_text+'ENTER';
                break;
            case '4616886':
                enterprise_month_text = month_text+'NEW5000';
                break;
            case '4616887':
                enterprise_month_text = month_text+'NEW10000';
                break;
            case '4616888':
                enterprise_month_text = month_text+'NEW20000';
                break;
        }
        var price = floorN(floorN((enterprise_price*percent),0)-(floorN((enterprise_price*percent),0)*(procent_skidka/100)), 0);
        $(".price4").html(moneyFormat(price));

        //$(".4604324").attr("href", "https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS="+enterprise_value+"&OPTIONS"+enterprise_value+"="+enterprise_month_text+","+OPTIONS_frequency+ref_service+"&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html");

    }

    function Plus(container, id, delim, max){
        var ish = parseInt($('#'+container+' #'+id).val());
        ish = ish + delim;
        if (max!=0){
            if (ish>max){
                ish  = max;
            }
        }
        $('#'+container+' #'+id).val(ish);
        Calc(container);
    }
    function Minus(container, id, delim, min){
        var ish = parseInt($('#'+container+' #'+id).val());
        ish = ish - delim;
        if (ish<min){
            ish  = min;
        }
        $('#'+container+' #'+id).val(ish);
        Calc(container);
    }

    function PlusK(container, id, delim, max){
        var ish = parseInt($('#'+container+' #'+id).val());
        ish = ish + delim;
        if (max!=0){
            if (ish>max){
                ish  = max;
            }
        }
        $('#'+container+' #'+id).val(ish);
        Calc(container);
    }
    function MinusK(container, id, delim, min){
        var ish = parseInt($('#'+container+' #'+id).val());
        ish = ish - delim;
        if (ish<min){
            ish  = min;
        }
        $('#'+container+' #'+id).val(ish);
        Calc(container);
    }

    function SetDt(container, dt){
        $("#"+container+" a[id^='dt-']").removeClass("actives");
        $("#"+container+" #dt-"+dt).addClass("actives");
        $("#"+container+" #dt").text(dt);
        Calc(container);
    }

    function sliderUpdate() {

        var personal_value = $('[data-tariff="personal"] .tariff_values p.active').attr('data-value');
        var optimum_value = $('[data-tariff="optimum"] .tariff_values p.active').attr('data-value');
        var plus_value = $('[data-tariff="plus"] .tariff_values p.active').attr('data-value');
        var enterprise_value = $('[data-tariff="enterprise"] .tariff_values p.active').attr('data-value');

        var text1 = $(".period_block .itm.active").last().attr('data-month');

        switch (personal_value)
        {
            default :
            case '4604320':
                personal_month_text = '';
                break;
            case '4616846':
                personal_month_text = 'NEW100';
                break;
        }
        switch (optimum_value)
        {
            default :
            case '4604321':
                optimum_month_text = 'PREM';
                break;
            case '4616882':
                optimum_month_text = 'NEW500';
                break;
            case '4616883':
                optimum_month_text = 'NEW750';
                break;
        }
        switch (plus_value)
        {
            default :
            case '4604323':
                plus_month_text = 'PLUS';
                break;
            case '4616884':
                plus_month_text = 'NEW1750';
                break;
        }
        switch (enterprise_value)
        {
            default :
            case '4604324':
                enterprise_month_text = 'ENTER';
                break;
            case '4616886':
                enterprise_month_text = 'NEW5000';
                break;
            case '4616887':
                enterprise_month_text = 'NEW10000';
                break;
            case '4616888':
                enterprise_month_text = 'NEW20000';
                break;
        }


        if (text1 == 1) {
            month = 1;
            percent = 1;
        }
        if (text1 == 4) {
            month = 3;
            percent = 0.95;
        }
        if (text1 == 7) {
            month = 6;
            percent = 0.90;
        }
        if (text1 == 10){
            month = 9;
            percent = 0.85;
        }
        if (text1 == 13){
            month = 12;
            percent = 0.80;
        }

        var personal_price = $('[data-tariff="personal"] .tariff_values p.active').attr('data-price');
        var optimum_price = $('[data-tariff="optimum"] .tariff_values p.active').attr('data-price');
        var plus_price = $('[data-tariff="plus"] .tariff_values p.active').attr('data-price');
        var enterprise_price = $('[data-tariff="enterprise"] .tariff_values p.active').attr('data-price');
        var percentPersonal = 1;

        var price1 = floorN(floorN((personal_price*percentPersonal),0)-(floorN((personal_price*percentPersonal),0)*(procent_skidka/100)), 2);
        $(".price1").html(moneyFormat(price1));

        var price2 = floorN(floorN((optimum_price*percent),0)-(floorN((optimum_price*percent),0)*(procent_skidka/100)), 1);
        $(".price2").html(moneyFormat(price2));

        var price3 = floorN(floorN((plus_price*percent),0)-(floorN((plus_price*percent),0)*(procent_skidka/100)), 1);
        $(".price3").html(moneyFormat(price3));

        var price4 = floorN(floorN((enterprise_price*percent),0)-(floorN((enterprise_price*percent),0)*(procent_skidka/100)), 0);
        $(".price4").html(moneyFormat(price4));
    }

    function Calc(container){
        var cena_za_proverku = 0;
        var tarif_za_proverku = '';
        switch (+ctSwitcherItem.siblings('.active').text()) {

            case 200:
                cena_za_proverku = 0.002;
                tarif_za_proverku = '10 КОПЕЕК';
                break;
            case 100:
            default:
                cena_za_proverku = 0.001;
                tarif_za_proverku = '5 КОПЕЕК';
                break;
        }

        var chastota_proverok = 30;
        var mnogitel = 1;
        var check = 'CHECK_DAILY';

        var fregs = +dailyRank.siblings('.active').attr('data-rank');

        switch (parseInt(fregs)) {
            case 1:
                chastota_proverok = 30;
                mnogitel = 1;
                check = 'CHECK_DAILY';
                break;
            case 2:
                chastota_proverok = 10;
                mnogitel = 0.8;
                check = 'CHECK_1IN3_DAYS';
                break;
            case 3:
                chastota_proverok = 4;
                mnogitel = 0.6;
                check = 'CHECK_WEEKLY';
                break;
            case 4:
                chastota_proverok = 5;
                mnogitel = 0.6;
                check = 'CHECK_ON_YANDEX_UP';
                break;
            default:
                chastota_proverok = 30;
                mnogitel = 1;
                check = 'CHECK_DAILY';
        }

        var total_v_mes_za_proverku = parseInt($('.ct_queries').val())*parseInt($('.ct_engines').val())*cena_za_proverku*chastota_proverok;

        // var manualPriceText = '';
        // if (isRub) {
        // 	manualPriceText = moneyFormat(total_v_mes_za_proverku);
        // } else {
        // 	manualPriceText = '$'+total_v_mes_za_proverku.toFixed(2);
        // }

        var colichestvo_saitov = parseInt($('.ct_websites').val());
        var searches = parseInt($('.ct_queries').val());
        var price_za_online = 7,
            name_za_online = 'PERSONAL 50',
            cur_keywords = 50;

        $(container + " .billed_annually").hide();
        if (colichestvo_saitov<=5){
            if (searches<=50) {
                price_za_online = calc_price1/12;
                name_za_online = 'PERSONAL 50';
                $(container + " .billed_annually").show();
            } else if ((searches>50) && (searches<=100)) {
                price_za_online = calc_price1_1/12;
                name_za_online = 'PERSONAL 100';
                $(container + " .billed_annually").show();
            } else if ((searches>100) && (searches<=250)) {
                price_za_online = calc_price2;
                name_za_online = 'OPTIMUM 250';
            } else if ((searches>250) && (searches<=500)) {
                price_za_online = calc_price2_1;
                name_za_online = 'OPTIMUM 500';
            } else if ((searches>500) && (searches<=750)) {
                price_za_online = calc_price2_2;
                name_za_online = 'OPTIMUM 750';
            } else if ((searches>750) && (searches<=1000)) {
                price_za_online = calc_price3;
                name_za_online = 'PLUS 1000';
            } else if ((searches>1000) && (searches<=1750)) {
                price_za_online = calc_price3_1;
                name_za_online = 'PLUS 1750';
            } else if ((searches>1750) && (searches<=2500)) {
                price_za_online = calc_price4;
                name_za_online = 'ENTERPRISE 2500';
            } else if ((searches>2500) && (searches<=5000)) {
                price_za_online = calc_price4_1;
                name_za_online = 'ENTERPRISE 5000';
            } else if ((searches>5000) && (searches<=10000)) {
                price_za_online = calc_price4_2;
                name_za_online = 'ENTERPRISE 10000';
            } else {
                price_za_online = calc_price4_3;
                name_za_online = 'ENTERPRISE 20000';
            }
        } else if ((colichestvo_saitov>5) && (colichestvo_saitov<=10)) {
            if (searches<=250) {
                price_za_online = 39;
                name_za_online = 'OPTIMUM 250';
            } else if ((searches>250) && (searches<=500)) {
                price_za_online = 54;
                name_za_online = 'OPTIMUM 500';
            } else if ((searches>500) && (searches<=750)) {
                price_za_online = 69;
                name_za_online = 'OPTIMUM 750';
            } else if ((searches>750) && (searches<=1000)) {
                price_za_online = 89;
                name_za_online = 'PLUS 1000';
            } else if ((searches>1000) && (searches<=1750)) {
                price_za_online = 149;
                name_za_online = 'PLUS 1750';
            } else if ((searches>1750) && (searches<=2500)) {
                price_za_online = 189;
                name_za_online = 'ENTERPRISE 2500';
            } else if ((searches>2500) && (searches<=5000)) {
                price_za_online = 349;
                name_za_online = 'ENTERPRISE 5000';
            } else if ((searches>5000) && (searches<=10000)) {
                price_za_online = 549;
                name_za_online = 'ENTERPRISE 10000';
            } else {
                price_za_online = 899;
                name_za_online = 'ENTERPRISE 20000';
            }
        }else{
            if (searches<=1000) {
                price_za_online = 89;
                name_za_online = 'PLUS 1000';
            } else if ((searches>1000) && (searches<=1750)) {
                price_za_online = 149;
                name_za_online = 'PLUS 1750';
            } else if ((searches>1750) && (searches<=2500)) {
                price_za_online = 189;
                name_za_online = 'ENTERPRISE 2500';
            } else if ((searches>2500) && (searches<=5000)) {
                price_za_online = 349;
                name_za_online = 'ENTERPRISE 5000';
            } else if ((searches>5000) && (searches<=10000)) {
                price_za_online = 549;
                name_za_online = 'ENTERPRISE 10000';
            } else {
                price_za_online = 899;
                name_za_online = 'ENTERPRISE 20000';
            }
        }
        var url_za_online = 'https://www.fiverr.com/youngceaser/rank-you-1st-in-google-guaranteed';
        switch (name_za_online) {
            case 'PERSONAL 50':
                cur_keywords = '50';
                //url_za_online = 'https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS=4604320&OPTIONS4604320=1y,'+check+ref_service+'&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html';
                break;
            case 'PERSONAL 100':
                cur_keywords = '100';
                //url_za_online = 'https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS=4616846&OPTIONS4616846=1yNEW100,'+check+ref_service+'&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html';
                break;
            case 'OPTIMUM 250':
                cur_keywords = '250';
                //url_za_online = 'https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS=4604321&OPTIONS4604321=1mPREM,'+check+ref_service+'&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html';
                break;
            case 'OPTIMUM 500':
                cur_keywords = '500';
                //url_za_online = 'https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS=4616882&OPTIONS4616882=1mNEW,'+check+ref_service+'&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html';
                break;
            case 'OPTIMUM 750':
                cur_keywords = '750';
                //url_za_online = 'https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS=4616883&OPTIONS4616883=1mNEW,'+check+ref_service+'&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html';
                break;
            case 'PLUS 1000':
                cur_keywords = '1,000';
                //url_za_online = 'https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS=4604323&OPTIONS4604323=1mPLUS,'+check+ref_service+'&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html';
                break;
            case 'PLUS 1750':
                cur_keywords = '1,750';
                //url_za_online = 'https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS=4616884&OPTIONS4616884=1mNEW,'+check+ref_service+'&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html';
                break;
            case 'ENTERPRISE 2500':
                cur_keywords = '2,500';
                //url_za_online = 'https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS=4604324&OPTIONS4604324=1mENTER,'+check+ref_service+'&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html';
                break;
            case 'ENTERPRISE 5000':
                cur_keywords = '5,000';
                //url_za_online = 'https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS=4616886&OPTIONS4616886=1mNEW,'+check+ref_service+'&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html';
                break;
            case 'ENTERPRISE 10000':
                cur_keywords = '10,000';
                //url_za_online = 'https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS=4616887&OPTIONS4616887=1mNEW,'+check+ref_service+'&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html';
                break;
            case 'ENTERPRISE 20000':
                cur_keywords = '20,000';
                //url_za_online = 'https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS=4616888&OPTIONS4616888=1mNEW,'+check+ref_service+'&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html';
                break;
            default:
                //url_za_online = 'https://secure.avangate.com/order/checkout.php?CARD=2&DESIGN_TYPE=1&PRODS=4616846&OPTIONS4616846=1mNEW,'+check+ref_service+'&BACK_REF=http%3A%2F%2Fonline.seranking.com%2Flogin.html';
                cur_keywords = '50';
        }

        // var cur_tarif_info = $('.wrp-body-tariff.wbt-personal'),
        // 	cur_pop_link = '#plan-full-1';

        // if (name_za_online.indexOf('PERSONAL') !== -1) {
        // 	cur_pop_link = '#plan-full-1';
        // 	cur_tarif_info = $('.wrp-body-tariff.wbt-personal');
        // } else if (name_za_online.indexOf('OPTIMUM') !== -1) {
        // 	cur_pop_link = '#plan-full-2';
        // 	cur_tarif_info = $('.wrp-body-tariff.wbt-optimum');
        // } else if (name_za_online.indexOf('PLUS') !== -1) {
        // 	cur_pop_link = '#plan-full-3';
        // 	cur_tarif_info = $('.wrp-body-tariff.wbt-plus');
        // } else if (name_za_online.indexOf('ENTERPRISE') !== -1) {
        // 	cur_pop_link = '#plan-full-4';
        // 	cur_tarif_info = $('.wrp-body-tariff.wbt-enterprise');
        // }

        var price = floorN((price_za_online * mnogitel), 2);
        if (isRub) {
            var priceText = moneyFormat(price);
        } else {
            var priceText = moneyFormat(price);
        }


        // change data
        var tariffInfo = name_za_online.split(' '),
            tariffName = tariffInfo[0].toLowerCase(),
            tariffKeywords = tariffInfo[1],
            tariffNeed = $('[data-tariff=\"' + tariffName + '\"]').eq(0),
            tariffNeedSites = tariffNeed.find('.tariff_sites').text(),
            tariffNeedWrap = tariffNeed.find('.tariff_wrap').children().clone(true),
            containerSites = $(container).find('.tariff_sites'),
            containerSitesL = containerSites.length,
            containerWrap = $(container).find('.tariff_wrap');

        $(container + " .ct_price").html(priceText);
        $(container + " .ct_name").text(name_za_online);
        $(container + " .ct_url").attr('href', url_za_online);
        $(container + " .ct_keywords").text(cur_keywords);

        containerSites.text(tariffNeedSites);

        containerWrap.html(tariffNeedWrap);


        var tariffNeedKeywords = tariffNeed.find('.tariff_values > p'),
            tariffNeedKeywordsL = tariffNeedKeywords.length;

        var containerAudit = $(container).find('.website_audit'),
            containerAuditL = containerAudit.length,
            containerBacklinks = $(container).find('.monitoring_backlinks'),
            containerBacklinksL = containerBacklinks.length,
            ctAccount = '',
            ctProject = '',
            ctBacklinks = '';


        for (var t = 0; t < tariffNeedKeywordsL; t++) {
            var curBlock = tariffNeedKeywords.eq(t);

            if (curBlock.text().split(' ')[0].trim() === cur_keywords) {
                ctAccount = curBlock.attr('data-audit-account');
                ctProject = curBlock.attr('data-audit-project');
                ctBacklinks = curBlock.attr('data-backlinks');
            }
        }

        for (var ca = 0; ca < containerAudit.length; ca++) {
            containerAudit.eq(ca).attr('data-hint-vars', ctAccount + "`,`" + ctProject)
                .find('strong').text(ctAccount);
        }

        for (var cb = 0; cb < containerAudit.length; cb++) {
            containerBacklinks.eq(cb).attr('data-hint-vars', ctBacklinks)
                .find('strong').text(ctBacklinks);
        }

    }

    function checkBilled(price) {
        if ($('select.personal option').length) {
            $('.billed_price span').html('<i>' + curancy + '</i>' + (+$('select.personal option').eq(0).attr('price')/12).toFixed(2));
        } else if ($('.calc_hide').length) {
            if (price) {
                $('.billed_price span').html('<i>' + curancy + '</i>' + (price/12).toFixed(2));
            } else {
                $('.billed_price span').html('<i>' + curancy + '</i>' + (+$('.calc_hide').attr('personal-price')/12).toFixed(2));
            }
        }
    }


    checkBilled();

    if ($('.calc_frequency').length) {
        $('.calc_frequency').on('click', 'li', function() {
            $('.calc_frequency li').removeClass('active');
            updatePricePositionTracking($(this).data('monitoring'));
            $(this).addClass('active');

            $('.calc_block .discount > div').text($(this).attr('data-discount') + "%")
        });

        $('.calc_frequency li').eq(1).trigger('click');
    } else if (window.percent_for !== undefined) {
        updatePricePositionTracking(percent_for);
    }


});


jQuery(function($){
    var popBlock = $('.pop_block'),
        popBlockCont = popBlock.find('.pop_cont'),
        popBlockClose = popBlock.find('.pop_close');

    popBlock.on('click', function(event) {
        $(this).removeClass('show');
    });

    popBlockClose.on('click', function(event) {
        event.stopPropagation();
        $(this).closest('.pop_block').removeClass('show');
    });

    popBlockCont.on('click', function(event) {
        event.stopPropagation();
    });
});

jQuery(function($){

    var wind = $(window),
        selectBlock = $('.select_block'),
        selectItm = $('.select_dropdown p');

    selectBlock.on('mouseover', function() {
        var self = $(this);

        self.addClass('show');
    });

    selectBlock.on('mouseleave', function() {
        var self = $(this);

        self.removeClass('show');
    });

    selectItm.on('click', function(event) {
        event.stopPropagation();

        var self = $(this),
            thisSelectBlock = self.closest('.select_block'),
            thisSelectBlockLabel = thisSelectBlock.find('> p');

        self.addClass('active').siblings('p').removeClass('active');

        thisSelectBlockLabel.text(self.text());

        thisSelectBlock.removeClass('show');
    });

});

jQuery(function($){
    var hintTrigger = $('.hint_trigger'),
        wind = $(window),
        customOffset = 20,
        hintDelimiter = '`,`';

    if (hintTrigger.lenght !== 0) {
        $('body').append('<div class="hint_pop show"></div>');

        var hintPop = $('.hint_pop');

        hintTrigger.on('mouseenter', function(event) {
            var self = $(this),
                selfCont = self.attr('data-hint-cont');

            if (selfCont) {
                if (self.attr('data-hint-vars')) {
                    var varsArray = self.attr('data-hint-vars').split(hintDelimiter),
                        varsArrayL = varsArray.length;

                    for (var i = 0; i < varsArrayL; i++) {
                        selfCont = selfCont.replace(new RegExp("\\%s" + i, "gm"), varsArray[i]);
                    }
                }
                hintPop.html(selfCont).addClass('show');

                hintPosition(event);
            }
        });

        hintTrigger.on('mouseleave', function() {
            hintPop.removeClass('show');
        });

        hintTrigger.on('mousemove', function(event) {
            if (!$(this).hasClass('hint_fixed')) {
                hintPosition(event);
            }
        });
    }

    function hintPosition(event) {
        hintPop.width('');

        var curX = event.clientX,
            curY = event.clientY,
            hintL,
            hintT,
            windW = wind.width(),
            windH = wind.height(),
            hintPopW = hintPop.innerWidth(),
            hintPopH = hintPop.innerHeight();



        if (hintPopW <= windW) {
            if ((curX + hintPopW + (customOffset+10)) <= windW) {
                hintL = curX + customOffset;
            } else if ((curX - hintPopW - customOffset) >= 0 ) {
                hintL = curX - hintPopW - customOffset;
            } else {
                hintL = (windW - hintPopW)/2;
            }
        } else {
            hintPop.width('100%');
        }

        if (hintPopH <= windH) {
            if ((curY + hintPopH + (customOffset+10)) <= windH) {
                hintT = curY + customOffset;
            } else {
                hintT = curY - hintPopH - customOffset;
            }
        } else {
            hintT = curY - customOffset - hintPopH;
        }

        hintPop.css({
            top: hintT + 'px',
            left: hintL + 'px'
        });
    }
});

