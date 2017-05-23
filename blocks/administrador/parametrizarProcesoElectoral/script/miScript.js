$(function(){
    $("body").on('click','.eliminar',function(e){

        var r = confirm("Va a eliminar un candidato, esta seguro?");
        if (r === true) {
            var id = $(this).next("input").val();
            var url_eliminar = $("input[name=candidato_url]").val();
            $.post(url_eliminar, {'documento': id},function(data){
                console.log(data);
            });

            $(this).closest("tr").remove();
        }
    });
});

// Evento que selecciona la fila y la elimina
function agregarfila(idEleccion)
{
    //$("#agregar" + idEleccion).on('click', function(){
            var table = document.getElementById('tablaCandidatos' + idEleccion);
            var rowCount = table.rows.length;
            var nuevoTr = $("#fila-base" + idEleccion).clone();
            nuevoTr.removeClass('fila-base').appendTo("#tablaCandidatos" + idEleccion + " tbody").attr("id","candidato" + rowCount);
            document.getElementById("scroll").style.width="90%"; 
            document.getElementById("marcoDatosCandidatos").style.width="90%"; 
    //});


}

function agregarfilaLista(idEleccion)
{
    //$("#agregar" + idEleccion).on('click', function(){
            var table = document.getElementById('tablaListas' + idEleccion);
            var rowCount = table.rows.length;
            var nuevoTr = $("#tablaListas" + idEleccion + " tbody tr:eq(0)").clone();
            nuevoTr.removeClass('fila-base').appendTo("#tablaListas" + idEleccion + " tbody").attr("id","lista" + rowCount);
            document.getElementById("scroll").style.width="90%"; 
            document.getElementById("marcoDatosCandidatos").style.width="90%"; 
    //});

    // Evento que selecciona la fila y la elimina 
    $(document).on("click",".eliminarLista",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
    });    
}

function cambiarTitulo(eleccion)
{
        if($.trim($("#nombreEleccion" + eleccion).val()) !== '')
        {
            document.getElementById("tabtabEleccion" + (eleccion - 1)).innerHTML = $("#nombreEleccion" + eleccion).val();
        }else
        {
            document.getElementById("tabtabEleccion" + (eleccion - 1)).innerHTML = "Elección " + eleccion ;
        }

}

function calculoPonderado(eleccion)
{
    
    if($( "#tiporesultados" + eleccion).val() === '2')
    {
        var estudiantes = $( "#resulEstudiantes" + eleccion).val();
        var docentes = $( "#resulDocentes" + eleccion).val();
        var egresados = $( "#resulEgresados" + eleccion).val();
        var funcionarios = $( "#resulFuncionarios" + eleccion).val();
        var docvinespecial = $( "#resulDocenteVinEspecial" + eleccion).val();

        var total = parseFloat(estudiantes) + parseFloat(docentes) + parseFloat(egresados) + parseFloat(funcionarios) + parseFloat(docvinespecial);
        
        $("#resulSuma"+eleccion).val(total);
    }
}

function validarIdentificacion(idEleccion)
{
    //var arregloIdentificacion = $("#identificacion" + idEleccion + "[]").val();
    var campo = document.getElementsByName("identificacion" + idEleccion + "[]");
    for (var i = 0; i < campo.length; i++) 
    {
        for(c = i + 1; c < campo.length;c++)
        {
            if(campo[i].value !== '')
            {
                if(campo[i].value === campo[c].value)
                {
                alert("Se detecto que la identificación "+ campo[i].value +" ya se encuentra en el listado\nPor favor verifique");
                return false;
                }
            }            
        }
    }
}