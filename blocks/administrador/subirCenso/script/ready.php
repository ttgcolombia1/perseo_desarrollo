for(var i=0;i<100;i++)
        {

            // Asociar el widget de validación al formulario
            $("#Eleccion" + i).validationEngine({
                promptPosition : "bottomLeft",
                scroll: false,
                autoHidePrompt: true,
                autoHideDelay: 3000
            });

            $(function() {
                $("#Eleccion" + i).submit(function() {
                    $resultado=$("#Eleccion" + i).validationEngine("validate");

                    if ($resultado)
                    {
                        return true;
                    }else
                    {
                        return false;
                    }
                });
            });

        }

        $(function() {
		$(document).tooltip();
});

// Asociar el widget tabs a la división cuyo id es tabs
$(function() {
	$("#tabs").tabs();
});

$(function() {
    $("button").button().click(function(event) {
            event.preventDefault();
    });

    $("#botonCrearA").button().click(function(event) {
            event.preventDefault();
            console.log("crear");
            var urlNuevo = $("input[name=urlNuevo]").val();
            location.replace(urlNuevo);

    });
});


// Engine de validacion para campos

$("#consultaCenso").validationEngine({
    promptPosition : "centerRight",
    scroll: false
});

$(function() {
    $("#consultaCenso").submit(function() {
    $resultado=$("#consultaCenso").validationEngine("validate");
    if ($resultado) {

        return true;

    }
    return false;
    });
});

$("#nuevoVotante").validationEngine({
    promptPosition : "centerRight",
    scroll: false
});

$(function() {
    $("#nuevoVotante").submit(function() {
    $resultado=$("#nuevoVotante").validationEngine("validate");
    if ($resultado) {
        return true;
    }
    return false;
    });
});


$(function() {
    $("#regresar").submit(function() {
    $resultado=$("#subirCenso").validationEngine("validate");
    if ($resultado) {
        return true;
    }
    return false;
    });
});