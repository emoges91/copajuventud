/* JS File */

// Start Ready
$(document).ready(function() {

    // Icon Click Focus
    $('div.icon').click(function() {
        $('input#search').focus();
    });

    // Live Search
    // On Search Submit and Get Results
    function search() {
        var query_value = $('input#search').val();
        $('b#search-string').html(query_value);
        if (query_value !== '') {
            $.ajax({
                type: "POST",
                url: "torneo_jugador_search.php",
                data: {search_name: query_value},
                cache: false,
                success: function(html) {
                    $("ul#results").html(html);
                }
            });
        }


        return false;
    }

    $("input#search").on("keyup", function(e) {
        // Set Timeout
        clearTimeout($.data(this, 'timer'));

        // Set Search String
        var search_string = $(this).val();

        // Do Search
        if (search_string == '') {
            $("ul#results").fadeOut();
            $('h4#results-text').fadeOut();
        } else {
            $("ul#results").fadeIn();
            $('h4#results-text').fadeIn();
            $(this).data('timer', setTimeout(search, 100));
        }
        ;
    });

    $("ul#results").on('click', 'li', function(e) {
        var $clicked = $(this);
        var $PerID = $clicked.find('.PersonaID').val();
        var $PerCED = $clicked.find('.PersonaCED').val();
        var $PerName = $clicked.find('.PersonaName').val();
        var $PerLastName1 = $clicked.find('.PersonaLastName1').val();
        var $PerLastName2 = $clicked.find('.PersonaLastName2').val();
        //
        var $PerJug = $clicked.find('.PersonaJug').val();
        var $PerDT = $clicked.find('.PersonaDT').val();
        var $PerDTA = $clicked.find('.PersonaDTA').val();
        var $PerRep = $clicked.find('.PersonaRep').val();
        var $PerSup = $clicked.find('.PersonaSup').val();


        $('#PerID').val($PerID);
        $('#PerCED').val($PerCED);
        $('#PerName').val($PerName);
        $('#PerApe1').val($PerLastName1);
        $('#PerApe2').val($PerLastName2);
        //

        if ($PerJug > 0) {
            $('#CHJug').prop('checked', true);
        } else {
            $('#CHJug').prop('checked', false);
        }
        if ($PerDT > 0) {
            $('#CHDT').prop('checked', true);
        } else {
            $('#CHDT').prop('checked', false);
        }
        if ($PerDTA > 0) {
            $('#CHDT_Asis').prop('checked', true);
        } else {
            $('#CHDT_Asis').prop('checked', false);
        }
        if ($PerRep > 0) {
            $('#CHRep').prop('checked', true);
        } else {
            $('#CHRep').prop('checked', false);
        } 
         if ($PerSup > 0) {
            $('#CHSup').prop('checked', true);
        } else {
            $('#CHSup').prop('checked', false);
        } 
        
        

    });

    $('input#search').focusout(function() {
        $("ul#results").fadeOut();

    });
    $('input#search').focusin(function() {
        $("ul#results").fadeIn();
    });


});