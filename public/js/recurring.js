var rainRecurringBuildObject = function(controls) {
    var obj = {
        "enabled":controls.hasClass('rain-recurring-on')
    };
    if(obj.enabled) {
        obj.frequency = controls.find('.rain-recurring-freq option:selected').val();
    } else {
        controls.find('input[name="recurring"]').val(JSON.stringify(obj));
    }
    switch(obj.frequency) {
    case 'weekly':
        var days = [];
        var dows = controls.find('.rain-recurring-dow input:checked');
        for(var i=0;i<dows.length;i++) { 
            days.push($(dows[i]).val())
        }
        obj.dow = days;
        break;
    case 'monthly':
        var doms = controls.find('.rain-recurring-dom input:checked');
        var days = [];
        for(var i=0;i<doms.length;i++) { 
            days.push($(doms[i]).val())
        }
        obj.dom = days;
        break;
    case 'every':
        obj.x = controls.find('.rain-recurring-x').val();
        obj.x = controls.find('.rain-recurring-duration').val();
        break;
    }

    

    if(controls.find('.rain-recurring-public-holidays input:checked').length)
        obj.excludePublicHolidays = true; 
    if(controls.find('.rain-recurring-business input:checked').length)
        obj.businessDaysOnly = true; 

    if(obj.excludePublicHolidays || obj.businessDaysOnly) {
        controls.find('.rain-recurring-else').show();
        obj.inCase = controls.find('.rain-recurring-else option:selected').val();
    }
    else
        controls.find('.rain-recurring-else').hide();

    obj.until = controls.find('.rain-recurring-until option:selected').val();
    if(obj.until!='forever')
        obj.untilX = controls.find('.rain-recurring-until-x').val();

    controls.find('input[name="recurring"]').val(JSON.stringify(obj));
}

$(document).ready(function() {
    
    $('.rain-recurring').bind('click.toggleRecurring',function(e){
        var controls = $(this).closest('.controls');
        if(controls.hasClass('rain-recurring-on')) {
            controls.removeClass('rain-recurring-on');
            controls.removeClass('rain-recurring-'+controls.find('.rain-recurring-freq option:selected').val());
        } else { 
            controls.addClass('rain-recurring-on');
            controls.addClass('rain-recurring-'+controls.find('.rain-recurring-freq option:selected').val());
        }
        $('.rain-recurring-until').change();
        rainRecurringBuildObject(controls);
    });
    $('.rain-recurring-freq').bind('change.recurringFreq',function(e){
        var controls = $(this).closest('.controls');
        controls.removeClass('rain-recurring-daily');
        controls.removeClass('rain-recurring-weekly');
        controls.removeClass('rain-recurring-fortnightly');
        controls.removeClass('rain-recurring-monthly');
        controls.removeClass('rain-recurring-quarterly');
        controls.removeClass('rain-recurring-yearly');
        controls.removeClass('rain-recurring-every');
        controls.addClass('rain-recurring-'+controls.find('.rain-recurring-freq option:selected').val());
        rainRecurringBuildObject(controls);
    });
    $('.rain-recurring-dow-day').bind('click.recurringDow',function(e){
        var controls = $(this).closest('.controls');
        rainRecurringBuildObject(controls);
    });
    $('.rain-recurring-dom input').bind('click.recurringDom',function(e){
        var controls = $(this).closest('.controls');
        rainRecurringBuildObject(controls);
    });
    $('.rain-recurring-until').bind('change.recurringUntil',function(e){
        var controls = $(this).closest('.controls');
        if($(this).find('option:selected').val()!='forever')
            controls.find('.rain-recurring-until-x').show();
        else
            controls.find('.rain-recurring-until-x').hide();
        rainRecurringBuildObject(controls);
    });
    $('.rain-recurring-until-x').bind('change.recurringUntilX',function(e){
        var controls = $(this).closest('.controls');
        rainRecurringBuildObject(controls);
    });
    $('.rain-recurring-public-holidays input').bind('click.recurringPublicHolidays',function(e){
        var controls = $(this).closest('.controls');             
        rainRecurringBuildObject(controls);
    });
    $('.rain-recurring-business input').bind('click.recurringBusiness',function(e){
        var controls = $(this).closest('.controls');
        rainRecurringBuildObject(controls);
    });
    $('.rain-recurring-else').bind('change.recurringElse',function(e){
        var controls = $(this).closest('.controls');
        rainRecurringBuildObject(controls);
    });
});