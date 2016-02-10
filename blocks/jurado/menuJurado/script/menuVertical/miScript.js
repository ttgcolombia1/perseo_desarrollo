function hora(){
    
    var hora=fecha.getHours();
    var minutos=fecha.getMinutes();
    var segundos=fecha.getSeconds();
    if(hora<10){ hora='0'+hora;}
    if(minutos<10){minutos='0'+minutos; }
    if(segundos<10){ segundos='0'+segundos; }     
    var fech = "<center><b><h3>Fecha: " + fecha.getDate() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getFullYear() + " </h3><br> <h1>Hora: " + hora +":"+minutos+":"+segundos + "<h1></b></center>";
    document.getElementById('clockDiv').innerHTML=fech;
    fecha.setSeconds(fecha.getSeconds()+1);
    setTimeout("hora()",1000);
}