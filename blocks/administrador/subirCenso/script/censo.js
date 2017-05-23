$(function () {
    var homeUrl = $("input[name=homeUrl]").val();
    $("#dialog-confirm").hide();
    var inputEliminar = $("input[name=eliminarVotante]");
    if (inputEliminar) {
        $("#botonEliminar").click(function (e) {
            e.preventDefault();
            $("#dialog-confirm").dialog({
                resizable: false,
                height: "auto",
                width: 400,
                modal: false,
                buttons: {
                    "Eliminar": function () {
                        // Borrar
                        var urlEliminar = $("input[name=urlEliminar]").val();
                        var self = this;
                        $.get(urlEliminar,function(response){

                            location.replace(homeUrl);

                            $(self).dialog("close");
                        });

                    },
                    Cancelar: function () {
                        $(this).dialog("close");
                    }
                }
            });
        });
    }
});