$(function(){

    //$( "#barraProgreso" ).progressbar();
    
     var progressbar = $( "#barraProgreso" ), progressLabel = $( "#labelProgreso" );
     
    // progressbar.css({ 'background': 'LightYellow' });
    // $("#barraProgreso > div").css({ 'background': 'Orange' });
    
    progressbar.progressbar({
    change: function() {
    progressLabel.text( "Procesando " + progressbar.progressbar( "value" ) + "%" );
    },
    complete: function() {
    progressLabel.text( "Completo!" );
    }
    });
    function progress() {
    var val = progressbar.progressbar( "value" ) || 0;
    progressbar.progressbar( "value", val + 1 );
    if ( val < 99 ) {
    setTimeout( progress, 100 );
    }
    }
    setTimeout( progress, 3000 );

});

function cambiarProgreso(valor)
{
    alert(valor);
    $( "#barraProgreso" ).progressbar( "value", valor );   
}