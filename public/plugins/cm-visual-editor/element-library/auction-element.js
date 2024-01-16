cmbAllElements['cmb_featured_title'] = {
    allowedParent: ['cmb_column'],
    addButtonText: 'Featured Title',
    title: 'Featured Title',
    icon: '<i class="cm cm-title-default"></i>',
    elementTabName: 'header',
    elementType: 'static-layout',
    allowedActionElement: ['cmb-option-prev','cmb-option-next', 'cmb-option-delete', 'cmb-option-copy', 'cmb-option-settings'],
    avoidableTabs : ['position', 'background'],
    avoidableTabSettings: {
        design : ['text-align']
    },
    subWrapper: '.cmb-title',
    settings:{
        title : {
            title: 'Title Settings',
            options: [
                {
                    'border-color' : {
                        title: 'Border Color',
                        subTitle : 'Select a border color',
                        type: 'input',
                        inputType : 'colorPicker',
                        attribute : 'style',
                        styleName : 'border-color',
                        childItem : '.cmb-title',
                    },
                    'horizontal-line-color' : {
                        title: 'Horizontal Line Color',
                        subTitle : 'Select a  color',
                        type: 'input',
                        inputType : 'colorPicker',
                        attribute : 'style',
                        styleName : 'border-color',
                        childItem : '.cmb-title-border',
                    },
                    'color' : {
                        title: 'Title Color',
                        subTitle : 'You can use solid color and opacity.',
                        type: 'input',
                        inputType : 'colorPicker',
                        attribute: 'style',
                        styleName: 'color',
                        childItem : '.cmb-title'
                    },
                    'highlight-color' : {
                        title: 'Highlight Color',
                        subTitle : 'You can use solid color and opacity.',
                        type: 'input',
                        inputType : 'colorPicker',
                        attribute: 'style',
                        styleName: 'color',
                        childItem : '.cmb-title-highlight-color'
                    },
                    'link-color' : {
                        title: 'Link Color',
                        subTitle : 'You can use solid color and opacity.',
                        type: 'input',
                        inputType : 'colorPicker',
                        attribute: 'style',
                        styleName: 'color',
                        childItem : '.cmb-title-link'
                    },
                    'link-hover-color' : {
                        title: 'Link Hover Color',
                        subTitle : 'You can use solid color and opacity.',
                        type: 'input',
                        inputType : 'colorPicker',
                        attribute: 'style',
                        styleName: 'color',
                        childItem : '.cmb-title-link',
                        childPseudo : ':hover',
                    },
                    'link' : {
                        title: 'Link',
                        subTitle : 'Image Link',
                        type: 'input',
                        attribute : 'prop',
                        inputType: 'text',
                        childItem: '.cmb-title-link',
                        tagProp: 'href',
                    },
                    'target' : {
                        title: 'Target',
                        subTitle : 'Specifies where to open the linked document',
                        type: 'input',
                        attribute : 'prop',
                        inputType: 'switch',
                        tagProp: 'target',
                        childItem: '.cmb-title-link',
                        fieldParam : cmbStyleTypes['anchorTargetType']
                    },
                    'hide-link' : {
                        title: 'Hide Link',
                        subTitle : 'You can show or hide title back link option',
                        type: 'input',
                        inputType: 'toggle',
                        attribute : 'custom-class',
                        defaultValue: 'd-none',
                        childItem: '.cmb-title-link',
                    },
                }
            ]
        },
    },
    html: `<div class="cmb-margin-bottom cmb_featured_title cmb-element">
            <div class="cmb-title-wrapper">
                <h2 class="cmb-title"><span class="cmb-single-line-editable-text cmb-title-highlight-color">Theme </span> <span class="cmb-single-line-editable-text">Title</span></h2>
                <div class="cmb-title-border"></div>
                <div class="ml-auto">
                    <a href="#" class="cmb-title-link"><span class="cmb-single-line-editable-text">View All Auction</span></a>
                </div>
            </div>
        </div>`,
};
cmbAllElements['cmb_auction']= {
    allowedParent: ['cmb_container', 'cmb_column'],
    addButtonText: 'Auction',
    title: 'Auction',
    icon: '<i class="fa fa-th"></i>',
    elementTabName: 'dynamic-layout',
    elementType: 'dynamic-layout',
    settings:{
        auction: {
            title: 'Auction',
            subtitle: '',
            options :[{
                column: {
                    title: 'Number of Columns ',
                    subtitle : 'Set the number of columns per row.',
                    placeholder: '3',
                    type: 'input',
                    inputType: 'range',
                    attribute: 'dynamic-layout',
                    relatedDynamicField: 'column',
                    fieldParam: {
                        step: 1,
                        min: 1,
                        max: 4
                    }
                },
                item: {
                    title: 'Posts Per Page',
                    subtitle : 'Select number of posts per page. Set to 3 to 21',
                    placeholder: '10',
                    type: 'input',
                    inputType: 'range',
                    attribute: 'dynamic-layout',
                    relatedDynamicField: 'item',
                    fieldParam: {
                        step: 1,
                        min: 3,
                        max: 21
                    }
                },
                type: {
                    title: 'Type',
                    subtitle : 'Select a auction type',
                    type: 'input',
                    inputType: 'select',
                    attribute: 'dynamic-layout',
                    relatedDynamicField: 'type',
                    fieldParam: {
                        latest: 'latest',
                        popular: 'popular',
                    }
                }
            }]
        }
    },
    dynamicOptions: {
        column: 3,
        item: 6,
        type: 'latest',
        name: 'short_code_auction_list'
    },
    onLoad: function (){
        if ($('body').find('.lf-counter').length > 0)
        {
            $('.lf-counter').each(function (){
                let availableTime= +$(this).attr('data-time');
                if(availableTime && availableTime>0){
                    lfTimer(availableTime, $(this));
                }
            })
        }
        
        function lfTimer(availableTime,item){
            if(availableTime>0){
                setTimeout(
                    function(){
                        availableTime = availableTime-1;
                        let days = parseInt(availableTime/86400);
                        let restTime = availableTime - days*86400;
                        let hours = parseInt(restTime/3600);
                        restTime = restTime - hours*3600;
                        let minutes = parseInt(restTime/60);
                        let seconds = restTime - minutes*60;
                        spliter(days, item.find('.day'));
                        spliter(hours, item.find('.hour'));
                        spliter(minutes, item.find('.min'));
                        spliter(seconds, item.find('.sec'));

                        lfTimer(availableTime,item)
                    }, 1000
                );
            }
            else{
                item.find('.timer-unit').remove();
                item.find('.d-none').removeClass('d-none');
            }
        }
        function spliter(digits, item){
            if(digits<10){
                digits = '0'+digits;
            }
            else{
                digits = digits.toString()
            }
            digits = Array.from(digits);
            let htmlData = '';
            $.each(digits,function (key, val){
                htmlData = htmlData + '<span class="number">'+val+'</span>'
            })
            item.find('.timer-inner').html(htmlData)
        }
    }
};
