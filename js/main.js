$(document).ready(function() {
    $('#horizontalTab').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion           
        width: 'auto', //auto or any width like 600px
        fit: true   // 100% fit in a container
    });
    
     $('#verticalTab').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true
        });

    var buttons = {
        previous: $('#jslidernews2 .button-previous'),
        next: $('#jslidernews2 .button-next')
    };
    $('#jslidernews2').lofJSidernews({
        interval: 5000,
        easing: 'easeInOutQuad',
        duration: 1200,
        navigatorHeight: 92,
//        navigatorWidth: 310,
        auto: true,
        maxItemDisplay: 4
    });
});

