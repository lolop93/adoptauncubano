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
        p.css('bottom', '-135px');

    }
});
// Funcion para el menu desplegable de cabecera

//Pop up conversaciones

$( document ).ready(function() {
    var windowLoc = $(location).attr('pathname');

    if (windowLoc != '/mensajes' && windowLoc != '/' && windowLoc != '/login' && windowLoc != '/register' && windowLoc != '/admin'){
        console.log('polla');

        $('body').append(
            $('<div>', {'class':'popupMensajes d-flex align-items-center'}).append(
                $('<i class="bi bi-chat-fill mx-auto text-white" style="font-size: 2.7658em"></i>'),
                $('<div class="text-black-50 chatPopup bg-white" style="width: 400px; height: 400px; display: none ; position: absolute;top: -420px;left: -420px;"> ' +
                        '<div class="w-100 h-100 gridContactos" >' +
                            '<div class="textoCabeceraPoUp bg-white"><p>Polla</p></div>'+
                            '<div class="icono1Cabecera bg-secondary"><p>Polla</p></div>'+
                            '<div class="icono2Cabecera bg-danger"><p>Polla</p></div>'+
                            '<div class="contenidoPopUp bg-dark"><p>Polla</p></div>'+
                        '</div>' +
                    ' </div>')
            )
        );
    }

    $('.popupMensajes').click(function(){
        $('.chatPopup').toggle();
    });
});


//Pop up conversaciones