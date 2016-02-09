function seleccionarTarjeton(idTarjeton, seleccionado)
{
    for (var i = 0; i < 100; i++)
    {
        if ($("#seleccion" + i).hasClass('fondoElegido'))
        {
            $("#seleccion" + i).removeClass("fondoElegido").addClass("fondoLimpio");
        }
    }
    $("#" + idTarjeton).removeClass("fondoLimpio").addClass("fondoElegido");
    $("#candidatoSeleccionado").val(seleccionado);
}

$(function()
{
    $("#votoTarjeton").submit(function() {
        if ($("#candidatoSeleccionado").val() === '')
        {
            alert('Debe seleccionar un tarjetón para continuar con la votación');
            return false;
        } else
        {
            return true;
        }
    });
});




$(function() {
    $(document).tooltip();
});