//$(function(){
//	// Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
//	
//        $("#agregar").on('click', function(){
//                var table = document.getElementById('tablaCandidatos');
//                var rowCount = table.rows.length;
//		var nuevoTr = $("#tablaCandidatos tbody tr:eq(0)").clone();
//                nuevoTr.removeClass('fila-base').appendTo("#tablaCandidatos tbody").attr("id","candidato" + rowCount);
//	});
// 
//	// Evento que selecciona la fila y la elimina 
//	$(document).on("click",".eliminar",function(){
//		var parent = $(this).parents().get(0);
//		$(parent).remove();
//	});
//});

function agregarfila(idEleccion)
{
    //$("#agregar" + idEleccion).on('click', function(){
            var table = document.getElementById('tablaCandidatos' + idEleccion);
            var rowCount = table.rows.length;
            var nuevoTr = $("#tablaCandidatos" + idEleccion + " tbody tr:eq(0)").clone();
            nuevoTr.removeClass('fila-base').appendTo("#tablaCandidatos" + idEleccion + " tbody").attr("id","candidato" + rowCount);
    //});

    // Evento que selecciona la fila y la elimina 
    $(document).on("click",".eliminar",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
    });
}

function agregarfilaLista(idEleccion)
{
    //$("#agregar" + idEleccion).on('click', function(){
            var table = document.getElementById('tablaListas' + idEleccion);
            var rowCount = table.rows.length;
            var nuevoTr = $("#tablaListas" + idEleccion + " tbody tr:eq(0)").clone();
            nuevoTr.removeClass('fila-base').appendTo("#tablaListas" + idEleccion + " tbody").attr("id","lista" + rowCount);
    //});

    // Evento que selecciona la fila y la elimina 
    $(document).on("click",".eliminarLista",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
    });
}