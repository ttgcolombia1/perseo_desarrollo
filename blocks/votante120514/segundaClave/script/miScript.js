function reiniciar(){
    contador = 0;
    $('#clave').val('');
}

function escribirClave(numero){
    contador ++;

    if(contador<=4){
        $('#clave').val($('#clave').val() + numero);
        $('#clave').focus();
    }
    return;
}