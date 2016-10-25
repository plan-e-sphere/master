function isBissextile(year){
    if((year%4 === 0 && year%100 !== 0) || year%400 === 0){
        return true;
    }else{
        return false;
    }
}
function isValidDate(d){
    var time=d.split(" ")[1];
    var date=d.split(" ")[0];

    var year=date.split("-")[2];
    var month=date.split("-")[1];
    var day=date.split("-")[0];

    var hour=time.split(":")[0];
    var minutes=time.split(":")[1];

    if(1>day || day>31 || 1>month || month>12 || 0>hour || hour>23 || 0>minutes || minutes>59){
        return false;
    }else if(isBissextile(year) && month==2 && day>29){
        return false;
    }else if(!isBissextile(year) && month==2 && day>28){
        return false;
    }else if((month==4 || month==06 || month==09 || month==11) && day>30){
        return false;
    }else{
        return true;
    }
}

function set_alert_message(type, message){
    $("#div_message_alert").html('<div id="message_alert" class="alert-message-'+type+'">'+message+'</div>');
    showMessage();
}