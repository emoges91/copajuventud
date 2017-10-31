
function sure() {
    if (confirm('Esta seguro que desea eliminar?')) {
        return true;
    } else {
        return false;
    }
}

function sureDisable() {
    if (confirm('Esta seguro que desea desactivar la opcion?')) {
        return true;
    } else {
        return false;
    }
}

function sure_volt() {
    if (confirm('Esta seguro/a que desea voltear los equipos?')) {
        return true;
    } else {
        return false;
    }
}

$(function() {

    // Activate fastLiveFilter w/ callback
    $("#filter_input").fastLiveFilter("#list_to_filter", {
    });


    $("#list_to_filter, #grupos").sortable({
        connectWith: ".contenedor_equipos"
    }).disableSelection();
});

