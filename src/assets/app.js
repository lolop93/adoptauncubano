/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// You can specify which plugins you need
//import { Tooltip, Toast, Popover } from 'bootstrap';

// start the Stimulus application
import './bootstrap';


// loads the jquery package from node_modules
//import jquery from 'jquery';

//import $ from 'jquery';

// require jQuery normally
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

//importamos nuestro custom js

import './custom.js';



// Funcion para el menu desplegable de cabecera
//---------------------------------------------
$('.perfilHeader img').click(function(){

    console.log("Prueba perfil");
    var perfil = $('.perfilHeader');
    var p = $('.contenedorMenu');
    var menu = $('.menuDesplegable');

    if (perfil.hasClass("flex-column")){
        perfil.addClass("flex-row");
        perfil.removeClass("flex-column");
        perfil.css("border-bottom-right-radius", '360px');
        perfil.css("border-bottom-left-radius", '360px');

        menu.addClass('d-none');
        menu.removeClass('d-block');

        p.css('background-color', '');
        p.removeClass("order-2");
        p.css('position', '');
        p.css('bottom', '');


    }
    else{
        perfil.addClass("flex-column");
        perfil.removeClass("flex-row");
        perfil.css("border-bottom-right-radius", '0');
        perfil.css("border-bottom-left-radius", '0');

        menu.removeClass('d-none');
        menu.addClass('d-block');

        p.css('background-color', '#CE5353FF');
        p.addClass("order-2");
        p.css('position', 'absolute');
        p.css('bottom', '-110px');

    }
});
//---------------------------------------------
// Funcion para el menu desplegable de cabecera


//Pop up conversaciones
//---------------------------------------------
function getMensajes() {
    
};

function insertMensajes(mensajes) {
    mensajes=10;
    for (let i = 0; i < mensajes; i++) {
        console.log("pollamensajes");
        $('.mensajesPopUp').append(
            $(
                '<div class="mensajePopUp p-3 border-bottom border-1 border-dark">'+
                    '<img src="https://github.com/mdo.png" alt="mdo" width="40" height="40" class="rounded-circle  me-3">'+
                        '<div class="infoMensajePopUp">'+
                            '<p style="font-size: 15px">Nombre</p>'+
                            '<p style="font-size: 11px">Mensaje..........</p>'+
                        '</div>'+
                        '<div class="notificacionMensajePopUp ms-auto rounded-circle text-white">'+
                            '2'+
                        '</div>'+
                '</div>'
            )
        );
    }
}

$( document ).ready(function() {
    var windowLoc = $(location).attr('pathname');

    if (windowLoc != '/mensajes' && windowLoc != '/' && windowLoc != '/login' && windowLoc != '/register' && windowLoc != '/admin'){
        console.log('polla');

        $('body').append(
            $('<div>', {'class':'popupMensajes d-flex align-items-center'}).append(
                $('<i class="botonPopUp bi bi-chat-fill mx-auto text-white" style="font-size: 2.7658em"></i>'),
                $('<div class="chatPopup" style="width: 400px; height: 400px; display: none ; position: absolute;top: -420px;left: -420px;"> ' +
                        '<div class="w-100 h-100 gridContactos " >' +
                            '<div class="textoCabeceraPoUp ms-2 text-white"><p>Contactos</p></div>'+
                            '<div class="icono1Cabecera text-white">' +
                                '<i class="bi bi-search ms-5"></i>' +
                            '</div>'+
                            '<div class="icono2Cabecera me-3 text-white">' +
                                '<i class="bi bi-three-dots-vertical ms-3"></i>' +
                            '</div>'+
                            '<div class="contenidoPopUp overflow-auto">' +
                                '<div class="mensajesPopUp">' +
                                '</div>'+
                            '</div>'+
                        '</div>' +
                    ' </div>')
            )
        );
    }

    $('.botonPopUp').click(function(){
        $('.chatPopup').fadeToggle();
    });

    //ejecutamos las funciones de relleno de la conversacion
    insertMensajes(10);
});
//---------------------------------------------
//Pop up conversaciones