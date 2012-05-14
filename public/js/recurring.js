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
    case 'monthly':
        var doms = controls.find('.rain-recurring-dom a.active');
        console.log(doms);
        var days = [];
        for(var i=0;i<doms.length;i++) { 
            days.push(doms[i].innerHTML)
        }
        obj.dom = days;
    }

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
    $('.rain-recurring-dom a').bind('toggled',function(e){
        var controls = $(this).closest('.controls');
        rainRecurringBuildObject(controls);
    });
});