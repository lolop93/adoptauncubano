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
$('.perfilHeader div').click(function(){

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
        p.css('padding-top', '0px');



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
        p.css('padding-top', '20px');


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
    };
};

$( document ).ready(function() {

    const isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;

    if(!isMobile) {
        var windowLoc = $(location).attr('pathname');
        console.log(windowLoc);

        if (!windowLoc.includes("/mensajes") && windowLoc != '/' && windowLoc != '/login' && windowLoc != '/register' && windowLoc != '/admin') {
            console.log('polla');

            $('body').append( //Solo necesitamos el popup en escritorio (meter un if en funcion de si es movil o no)
                $('<div>', {'class': 'popupMensajes d-flex align-items-center'}).append(
                    $('<i class="botonPopUp bi bi-chat-fill mx-auto text-white" style="font-size: 2.7658em"></i>'),
                    $('<div class="chatPopup" style="width: 300px; height: 400px; display: none ; position: absolute;top: -420px;left: -380px;"> ' +
                        '<div class="w-100 h-100 gridContactos " >' +
                        '<div class="textoCabeceraPoUp ms-2 text-white"><p>Contactos</p></div>' +
                        '<div class="icono1Cabecera text-white">' +
                        '<i class="bi bi-search ms-5"></i>' +
                        '</div>' +
                        '<div class="icono2Cabecera me-3 text-white">' +
                        '<i class="bi bi-three-dots-vertical ms-3"></i>' +
                        '</div>' +
                        '<div class="contenidoPopUp overflow-auto">' +
                        '<div class="mensajesPopUp">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        ' </div>')
                )
            );
        }

        $('.botonPopUp').click(function () {
            $('.chatPopup').fadeToggle();
        });

        //ejecutamos las funciones de relleno de la conversacion
        insertMensajes(10);
    }
});
//---------------------------------------------
//Pop up conversaciones


//JS ajax para consultar mensajes
//---------------------------------------------


$( document ).ready(function() {


    //comprobamos que hay un chat sino pa que coño vamos a ejecutar un listener xDDD
    if($('#textoChat').length){

        //Hacemos que al cargar la pagina, vaya al ultimo elemento del chat
        // Handler for .ready() called.
        $('.mensajes').animate({
            scrollTop: $('.bocadillo').last().offset().top
        }, 'slow');

        setInterval(function(){           //ejecutamos una funcion cada x segundos
            //this code runs every x second
            var idChat = $('#textoChat').data('idChat');

            $.ajax({
                type: 'POST',
                url: "/getmensajes",
                data: {chat:idChat},
                async:true,
                dataType: "json",
                success: function (data){
                    console.log('La conversacion es la ' + data['id_conversacion'] + ' y los mensajes del otro usuario son ' + JSON.stringify(data['mensajes']));

                    var elementoUltimo = $( ".me-auto" ).last();//cogemos el ultimo elemento del otro usuario
                    var idUltimo = $(elementoUltimo.children()[0]).data('idMensaje');//cogemos la id del ultimo elemento del otro usuario

                    var i = data.mensajes.length - 1;//cogemos la posicion del ultimo elemento que nos devuelve la consulta

                    var ultimosMensajes = [];

                    console.log(JSON.stringify(data.mensajes));
                    console.log(idUltimo)

                    while(data.mensajes.at(i)['id'] !== idUltimo && data.mensajes.at(i)['id'] > idUltimo){//Recorremos el array de mensajes desde el ultimo hasta que encuentro el ultimo recibido (mirando la id)
                        ultimosMensajes.push(data.mensajes.at(i));
                        i--;
                    }
                    console.log(ultimosMensajes)
                    ultimosMensajes.reverse();//le damos la vuelta al array porque al introducir los valores nuevo para imprimir, se introducen empezando por el mas nuevo y si no lo hacemos imprimiriamos antes el nuevo

                    //for aqui
                    ultimosMensajes.forEach( function(mensaje, indice, array) {
                        console.log("En el índice " + indice + " hay este valor: " + mensaje.texto);
                        var elemento = $('.mensajes').append(
                            $(
                                '<div class="me-auto">' +
                                '<p class="bocadillo bg-white rounded ms-3 " data-id-mensaje="'+mensaje.id+'">'+ mensaje.texto +'</p>' +
                                '</div>'
                            )
                        );
                        //elementoUltimo = elementoUltimo.last();
                        elementoUltimo[0].scrollIntoView();
                    });
                    //for aqui

                }
            })
        }, 5000);
    }


});
//---------------------------------------------
//JS ajax para consultar mensajes


//JS ajax para enviar mensajes
//---------------------------------------------
$( document ).ready(function(){
    $('#envioMensaje').unbind().submit(function(e){
        e.preventDefault();
        var idEmisor = $('#textoChat').data('idEmisor');
        var idChat = $('#textoChat').data('idChat');
        var mensaje = $('#textoChat').val();
        $('#textoChat').val('');//borramos el contenido del mensaje
        Enviar(mensaje,idEmisor,idChat);
    });
});

function Enviar(texto,emisor,id_chat){
    $.ajax({
        type: "POST",
        url: "/mensajes",
        data: {texto:texto,emisor:emisor,chat:id_chat},
        async:true,
        dataType: "json",
        success: function(data)
        {
            console.log(data);

            $('.mensajes').append(
                $(
                    '<div class="ms-auto">' +
                        '<p class="bocadillo bg-white rounded me-3 ">'+ data.mensaje +'</p>' +
                    '</div>'
                )
            );

            var elementoUltimo = $( ".bocadillo" ).last();
            elementoUltimo[0].scrollIntoView();
        }
    });
}
//---------------------------------------------
//JS ajax para enviar mensajes
