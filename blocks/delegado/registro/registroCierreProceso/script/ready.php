 $(function() {
    $( "#accordion" )
        .accordion({
            header: "> div > h3"
            })
            .sortable({
            axis: "y",
            handle: "h3",
            stop: function( event, ui ) {
            // IE doesn't register the blur when sorting
            // so trigger focusout handlers to remove .ui-state-focus
            ui.item.children( "h3" ).triggerHandler( "focusout" );
        }
    });
});

tinymce.init({
    selector: "textarea#textoActa",
    theme: "modern",
    language : 'es',
    theme: "modern",
    width: 800,
    height: 500,
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor "
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]


    }); 




$(function() {
	$("button").button().click(function(event) {
		event.preventDefault();
	});
});



$('#formDecodificarVotos').submit(function() {
	
	decodificarVoto();	
	return false;
});

$('#formMostrarResultados').submit(function() {
	
	
    $("#contenedorResultados").toggle(400);	
	return false;
});


$("#formDecodificarVotos").validationEngine({
	promptPosition : "centerRight",
	scroll : false
});



$(function() {
    $("#contenedorPaso1").hide();
    $("#contenedorPaso2").hide();
    $("#contenedorPaso3").hide();
});


$("#paso1").bind('click',function(){
    $("#contenedorPaso1").toggle(400);    
    $("#contenedorPaso2").slideUp();
    $("#contenedorPaso3").slideUp();
});

$("#paso2").bind('click',function(){
    $("#contenedorPaso1").slideUp();    
    $("#contenedorPaso2").toggle(400);
    $("#contenedorPaso3").slideUp();
});

$("#paso3").bind('click',function(){
    $("#contenedorPaso1").slideUp();    
    $("#contenedorPaso2").slideUp();
    $("#contenedorPaso3").toggle(400);
});

// Asociar el widget tabs a la división cuyo id es tabs
$(function() {
        $("#tabs").tabs();
});