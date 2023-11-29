$(document).ready(function(){
  $("#alert").hide();
  
  $(".btn-delete").click(function(e){
  	e.preventDefault();
  	if ( ! confirm(" Estas Seguro de Eliminar?")) {
  		return false;
  	}
  	var row 	= $(this).parents("tr");
  	var id 		= $(this).data("id");
  	
	  $.ajax({
	  	   	url: 'permisos/destroy/'+id,
            type: 'GET',
            dataType: "JSON",
            data: { },
           success: function(data)
           {
			  	if (data.accion == 1) {
				  	row.fadeOut();
			  		$("#total").html(data.total);
			  		PrintToasts('bg-success', 'Eliminado Con Exito', data.message)
			  	}else{
			  		$("#total").html(data.total);
			  		PrintToasts('bg-danger', 'ERROR', data.message)
			  	}
  		    }
  	  });
  });

});

////////////////////////////// FUNCION PARA INGRSAR UN NUEVO REGISTRO //////////////////////////////
function insert(){  	
	var url  = "permisos/create"; // El script a dónde se realizará la petición. 		
	  $.ajax({
            url: url,
            type: "GET",
            data: { },
            success: function(data)
            {
           	  $("#response").html(data);
              $('#modal_create').modal('show');
            }
    });
}

function Save(){  	
	var form  = $("#form");
	var url   = form.attr("action");	
	$('#btn-submit').attr("disabled", true);       	  	
	$.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        data: form.serialize(),
        beforeSend: function (){
      		$('#modal_create').modal('hide');
        },
        success: function(data)
        {
			$('#modal_create').modal('hide');
	  		$("#total").html(data.total);
        	$("#tabla tr:first").after('<tr><td>'+data.id+'</td><td>'+data.nombre+'</td><td>'+data.observacion+'</td><td>'+data.estado+'</td><td><a href="#" class="btn-delete" data-id="'+data.id+'" >Eliminar</a></td></tr>');
        },
	    error: function (data) {
	        if( data.status === 422 ) {
	            var errors = $.parseJSON(data.responseText);
	            $.each(errors, function (key, value) {
	            // console.log(key+ " " +value);
	            //$('#alert').removeClass('alert-info');
	            //$('#alert').addClass('alert-danger');

	                if($.isPlainObject(value)) {
	                    $.each(value, function (key, value) {                       
	                        console.log(key+ " " +value);
	            //        $('#alert').show().append(value+"<br/>");
	        			    PrintToasts('bg-danger', 'Validacion', value);
	       	            });
	            		$('#btn-submit').attr("disabled", false);       	  	
	                }else{
		                //$('#alert').show().append(value+"<br/>"); //this is my div with messages
		           		PrintToasts('bg-danger', 'Validacion', value);
						$('#btn-submit').attr("disabled", false);       	  	
	                }
	            });
		    }else{
	            PrintToasts('bg-danger', data.status, 'Ha Ocurrido Un Error.');
	       		$('#btn-submit').attr("disabled", false);       	  	
		    }
      	}
    });
}
