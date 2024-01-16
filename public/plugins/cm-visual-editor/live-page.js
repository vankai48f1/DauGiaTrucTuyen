var cmbRequiredJsForRealPage = {
    cmbNavTab: function(){
        $(document).on('click', '.cmb_tab_item', function () {
            $(this).addClass('tab-active').siblings('.cmb_tab_item').removeClass('tab-active').closest('.tab-nav').siblings('.tab-body').children('.tab-inner').eq($(this).index()).addClass('tab-active').siblings('.tab-inner').removeClass('tab-active');
        });
    },
    cmbPfolio: function () {
        if($('.cm-pfbox').length>0){
            $('.cm-pfbox').cmPfolio();
        }
    },
    cmSlider: function () {
        if($('.cm-slider').length>0){
            cmSliderMethods.sliderRun($('.cm-slider'),true)
        }
    },
    cmAccordion: function () {
        if($('.cmb-accordion').length>0){
            $(document).on('click', '.cmb-accordion-handler', function () {
                if($(this).closest('.cmb-accordion-item').hasClass('active')){
                    $(this).html('&#10011;').closest('.cmb-accordion-item').removeClass('active');
                }
                else{
                    $(this).html('&#10005;').closest('.cmb-accordion-item').addClass('active');
                }
                if(!$(this).closest('.cmb-accordion').attr('data-individual')){
                    $(this).closest('.cmb-accordion-item').siblings('.cmb-accordion-item').removeClass('active').find('.cmb-accordion-handler').html('&#10011;');
                }
            });
        }
    }
}

function cmbRealPageJs(){
    Object.values(cmbRequiredJsForRealPage).map(value => {
        if(typeof value === 'function') {
            value.call();
        }
    });
}

cmbRealPageJs();
