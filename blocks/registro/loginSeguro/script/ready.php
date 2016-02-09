<?php 

$_REQUEST['tiempo']=time();


?>

// Asociar el widget de validación al formulario
$("#<?php echo sha1('login'.$_REQUEST['tiempo']);?>").validationEngine({
	promptPosition : "centerRight",
	scroll : false
});

$('#<?php echo sha1('usuario'.$_REQUEST['tiempo']);?>').keydown(function(e) {
    if (e.keyCode == 13) {
        $('#login').submit();
    }
});

$('#<?php echo sha1('clave'.$_REQUEST['tiempo']);?>').keydown(function(e) {
    if (e.keyCode == 13) {
        $('#<?php echo sha1('login'.$_REQUEST['tiempo']);?>').submit();
    }
});

$(function() {
	$(document).tooltip({
		position : {
			my : "left+15 center",
			at : "right center"
		}
	},
	{ hide: { duration: 500 } }
	);
});

$(function() {
	$("button").button().click(function(event) {
		event.preventDefault();
	});
});
