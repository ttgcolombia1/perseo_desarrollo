
//Para que funcione el dataTable(),
//$('#example').dataTable();

// Asociar el widget de validación al formulario
$("#consultaCenso").validationEngine({
    promptPosition : "centerRight", 
    scroll: false
});

$(function() {
    $("#consultaCenso").submit(function() {
        $resultado=$("#consultaCenso").validationEngine("validate");
        if ($resultado) {
            // console.log(filasGrilla);
            return true;
        }
        return false;
    });
});

$("#facultad").select2();
$("#carrera").select2();
$("#tipoDocNuevo").select2();



//// Asociar el widget de validación al formulario
//$("#consultarEntrada").validationEngine({
//    promptPosition : "centerRight", 
//    scroll: false
//});
//
////Asociar el widget para selección de fecha a los campos
//$("#fechaEntrada").datepicker({
//    showOn: 'both',
//    buttonImage: 'theme/basico/img/calendar.png',
//    buttonImageOnly: true,
//    changeYear: true,
//    numberOfMonths: 2,	
//});
//
//$("#tipoEntrada").select2();
//$("#estadoEntrada").select2();
//$("#ordenador").select2();

$(function() {
    $( "button" )
    .button()
    .click(function( event ) {
        event.preventDefault();
    });
});


$(function() {
    $( document ).tooltip();
});

//Asociar el widget tabs a la división cuyo id es tabs
$(function() {
    $( "#tabs" ).tabs();
});


/************************/




//Asociar el widget para selección de fecha a los campos
//$("#fechaSalida").datepicker({
//    showOn: 'both',
//    buttonImage: 'theme/basico/img/calendar.png',
//    buttonImageOnly: true,
//    changeYear: true,
//    numberOfMonths: 2,	
//});

//
//$(function() {
//    $( "button" )
//    .button()
//    .click(function( event ) {
//        event.preventDefault();
//    });
//});
//
//
//$(function() {
//    $( document ).tooltip();
//});
//
////Asociar el widget tabs a la división cuyo id es tabs
//$(function() {
//    $( "#tabs" ).tabs();
//});
//        
//$(function() {
//    $("button").button().click(function(event) {
//        event.preventDefault();
//    });
//});
//
//$(function() {
//    $(document).tooltip();
//});
//
//// Asociar el widget tabs a la división cuyo id es tabs
//$(function() {
//    $("#tabs").tabs();
//});

//$("#facultad").menu();
//$("#facultad").select2(); 
