<?php
/*
    Plugin Name: Consulta Céd - Hacienda CR
    Description: Un plugin de WordPress que carga un widget con un formulario AJAX.
*/

//Accion Hook
add_action('wp_dashboard_setup','query_ID_hacienda_widget');

//Agregar Widget
function query_ID_hacienda_widget(){
	wp_add_dashboard_widget('query_id_widget','Consultar Céd','wrap_query_ID_hacienda_context');
}

//Mostrar Widget
function wrap_query_ID_hacienda_context(){
?>
        <form id="mi-formulario">
            <label for="identificacion">Identificación Nacional:</label>
            </br>
            <input type="text" id="identificacion" name="identificacion">
            <input type="submit" value="Consultar">
        </form>
        <div id="resultado"></div>
        <script>
            jQuery(document).ready(function($) {
                $('#mi-formulario').on('submit', function(e) {
                    e.preventDefault();
                    var identificacion = $('#identificacion').val();
                    $.ajax({
                        url: 'https://api.hacienda.go.cr/fe/ae',
                        data: { identificacion: identificacion },
                        dataType: 'json',
                        success: function(data) {
                            let thisHTML = "Identificación no encontrada.";
                            if(data){
                                thisHTML =  "<p>Nombre del dueño del Céd: " + data.nombre + "</p>";
                                thisHTML += "<p>Tipo de Céd: " + data.tipoIdentificacion + "</p>";

                                $('#resultado').html(thisHTML);
                            }else{
                                $('#resultado').html(thisHTML);
                            }
                        },
                        error: function() {
                            $('#resultado').text('Hemos hecho muchas consultas al servidor, por favor intenta más tarde.');
                        }
                    });
                });
            });
        </script>
<?php
}

