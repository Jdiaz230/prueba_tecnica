
document.addEventListener('DOMContentLoaded', function () {
  var calendar                            = null; // Initialize a variable to hold the calendar instance
  let formulario                          = document.getElementById("formulario");

  // Function to generate the calendar with specific parameters
  function generateCalendar(start, id_placa) {
      var calendarEl = document.getElementById('calendar');

      // Destroy the existing calendar if it exists
      if (calendar) {
          calendar.destroy();
      }

      // Initialize the calendar with the specified parameters
      calendar = new FullCalendar.Calendar(calendarEl, {
        initialDate : start,
        initialView       :'dayGridMonth',
        locale            :"es",
        displayEventTime  :false,
        headerToolbar     : {
          left            :'',
          center          :'title',
          right           :''
        },
          events: {
            url: baseURL + "/calendario/mostrar/"+ id_placa ,
            method: 'GET',
            extraParams: {
              start: new Date(start).toISOString(),
              end: new Date(start).toISOString(),
               
            },
          },
          eventClick:function(info){
                  var evento                          = info.event;
                  console.log(evento);
            
                  axios.get(baseURL+"/calendario/ver_vida_util/"+info.event.id).
                  then(
                    
                    (respuesta)=>{
                      formulario.id_componente.value             = respuesta.data.id_componente;
                      formulario.id_tipo_actividad.value         = respuesta.data.id_tipo_actividad;
                      formulario.descripcion.value               = respuesta.data.descripcion;
                      //formulario.start.value                     = respuesta.data.created_at;
                      formulario.start.value                     = new Date(respuesta.data.created_at).toISOString().slice(0, 10);
                      $("#evento").modal("show");
                    }
                    ).catch(
                      error=>{
                        if(error.response){
                          console.log(error.response.data);
                        }
                      }
                    );
                  },
      });

      // Render the calendar
      calendar.render();
  }

  // Button click event handler
  // $('#generar').on('click', function () {
  //     var startDate                                   = $('#month').val();
  //     var id_placa                                    = $('#placa').val();
  //     $.get(baseURL+ '/calendario/create_formato/' + id_placa, function (data) {
  //       // Append the view content to a container on your page
  //       $('#formato').html(data).modal('show');
  //     // });
  //    $("#formato").modal("show");
  // });

  $('#calendarForm').submit(function (e) {
      e.preventDefault();
      var startDate                                   = $('#month').val();
      var id_placa                                    = $('#placa').val();
      
      console.log(startDate);
      
      generateCalendar(startDate, id_placa);
});
// async function url() {

//   var id_placa                        = parseInt($("#placa").val());
//   return (id_placa);
 
// }
});
