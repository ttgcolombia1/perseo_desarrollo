
$(function() {
    $( "input[type=submit],button" )
    .button()
    .click(function( event ) {
        event.preventDefault();
    });
});


$(function() 
{
    $("#votoTarjeton").submit(function() {
        if($("#candidatoSeleccionado").val() === '')
        {
            return false;
        }else
        {
            return true;
        }        
    });
});




$(function() {
    $( document ).tooltip();
});
        
   