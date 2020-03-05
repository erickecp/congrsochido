$(document).ready(function() {
// Script para cuando mostramos un listado de input para copiar al portapapeles |inicio//--->
    $("body").on("click", ".copylink", function () {
        var id_link = $(this).attr("id");
        $("#lnk\\["+id_link+"\\]").attr('type', 'text');
        $("#lnk\\["+id_link+"\\]").select();
        document.execCommand("copy");
        $("#lnk\\["+id_link+"\\]").attr('type', 'hidden');
        $("#"+id_link).tooltip('hide');
        $(this).empty();
        $(this).append('<span class="glyphicon glyphicon-ok text-success"></span>');
        $("#"+id_link).attr('data-original-title', 'Texto copiado!');
        $("#"+id_link).tooltip('show');
        setTimeout(function(){
            $("#"+id_link).empty();
            $("#"+id_link).append('<span class="glyphicon glyphicon-copy"></span>');
        },1000);
    });
// <---|fin

// Script para cuando mostramos un sólo input para copiar al portapapeles |inicio//--->
    $("#portapapeles").bind("click", function() {
        $("input#link_copy").attr("disabled", false);
        $("input#link_copy").select();
        document.execCommand("copy");
        $("input#link_copy").attr("disabled", true);
        $(this).tooltip('hide');
        $(this).empty();
        $(this).append('<span class="glyphicon glyphicon-ok text-success"></span>');
        $(this).attr('data-original-title', 'Texto copiado!');
        $(this).tooltip('show');
        setTimeout(function(){
            $("#portapapeles").empty();
            $("#portapapeles").append('<span class="glyphicon glyphicon-copy"></span>');
        },1000);
    });
// <---|fin
});

