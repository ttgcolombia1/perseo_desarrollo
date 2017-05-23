$(function() {
   $("#resultado_censo").hide();
   $("#noCargados").hide();
   $("#resultado_clave").hide();
   $("#Censo").hide();
   
    var progressbar = $("#progressbar"),
        progressLabel = $(".progress-label");

    if ($("input[name=cargaasync]").val()){
        var urlCarga = $("input[name=cargaasync]").val();
        $.get(urlCarga,function(response){
           var cargados = response.cargados;
           var existentes = response.existentes;

             $("#resultado_censo").show();
             $("#totalRegistros").html(cargados);
             if(parseInt(existentes)> 0){
                $("#noCargados").show();
                $("#totalNoCargados").html(existentes);
             }
        });
    }

    if ($("input[name=claveasync]").val()){
        var urlCarga = $("input[name=claveasync]").val();
        $.get(urlCarga,function(response){
           var cargados = response.cargados;
           var total = response.total;
             $("#resultado_clave").show();
             $("#totalRegistros").html(cargados);
             if(parseInt(total)> 0){
                $("#Censo").show();
                $("#totalCenso").html(total);
             }
        });
    }

    function progress() {
      if ($("input[name=cargaasync]").val()){
        var endpoint = $("input[name=progreso_endpoint]").val();
        $.get(endpoint,function(response){
          var progreso = parseInt(response.progreso);
          console.log("update "+progreso);
          progressbar.progressbar("value", progreso);
          if(progreso > 98){
            progressbar.progressbar("value", 100);
          }
        });
      }
      
    if ($("input[name=claveasync]").val()){
        var endpoint = $("input[name=progreso_endpoint]").val();
        $.get(endpoint,function(response){
          var progreso = parseInt(response.progreso);
          console.log("update "+progreso);
          progressbar.progressbar("value", progreso);
          if(progreso > 98){
            progressbar.progressbar("value", 100);
          }
        });
      }
    }


    progressbar.progressbar({
        value: false,
        change: function() {
            progressLabel.text(progressbar.progressbar("value") + "%");
        },
        complete: function() {
            progressLabel.text("Completado!");
        }
    });



    setInterval(progress, 1000);


});
