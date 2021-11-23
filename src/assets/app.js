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

        console.log("scroll");
        //Hacemos que al cargar la pagina, vaya al ultimo elemento del chat
        // Handler for .ready() called.

        if($('.bocadillo').last().length) { //checkeamos que haya mensaje sino pa ke coño hacemos scroll
            $('.mensajes, html').animate({
                scrollTop: $('.bocadillo').last().offset().top
            }, 'slow');
        }

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

                    if(data.mensajes.length){ //si no hay mensajes no tiene sentido hacer nada.

                        if($('#noMensaje').length){//si no habia antes mensajes, eliminamos el cartel de "no hay mensajes"
                            $('#noMensaje').remove();
                            while(i !== 0){
                                ultimosMensajes.push(data.mensajes.at(i));
                                i--;
                            }

                        }else{
                            if(!idUltimo && data.mensajes.length && data.mensajes.at(i).texto){
                                console.log("no existen mensajes aun pero hay uno preparado  " + data.mensajes.at(i).texto)
                                location.reload();

                            }else{
                                while(data.mensajes.at(i)['id'] !== idUltimo && data.mensajes.at(i)['id'] > idUltimo){//Recorremos el array de mensajes desde el ultimo hasta que encuentro el ultimo recibido (mirando la id)
                                    ultimosMensajes.push(data.mensajes.at(i));
                                    i--;
                                }
                            }
                        }

                        console.log(ultimosMensajes)
                        ultimosMensajes.reverse();//le damos la vuelta al array porque al introducir los valores nuevo para imprimir, se introducen empezando por el mas nuevo y si no lo hacemos imprimiriamos antes el nuevo


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
                    }

                }
            })
        }, 3000);
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

            if($('#noMensaje')){//si no habia antes mensajes, eliminamos el cartel de "no hay mensajes"
                $('#noMensaje').remove();
            }

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


//JS ajax para enviar Likes
//---------------------------------------------

$( document ).ready(function(){
    $( '.matchKo' ).click(function() {

        var id_chat = $( this ).data("idMatch")
        var elemento = $( this );

        $.ajax({
            type: "POST",
            url: "/likes/set",
            data: {receptor:id_chat},
            async:true,
            dataType: "json",
            success: function(data)
            {
                //añadir pintar el corason gitano de rojo
                elemento.removeClass("matchKo")
                elemento.addClass("matchOk")
                console.log(data);
            }
        });
        console.log("corasonsito " + $( this ).data("idMatch"))
    });
});


//---------------------------------------------
//JS ajax para enviar Likes


//JS ajax para eliminar fotos o subirlas
//---------------------------------------------

$("div").mouseenter(function(){
    if($(this).is(".fotoAjaxOk")) {
        //console.log("hoverOk Enter");
        $( this ).children(".eliminarFoto").removeClass("d-none");
    }
    else if($(this).is(".fotoAjaxKo")){
        //console.log("hoverKo Enter");
        $( this ).children().removeClass("d-none");
        $( this ).children().addClass("d-flex");
    }
});

$("div").mouseleave(function(){
    if($(this).is(".fotoAjaxOk")) {
        console.log("hoverOk Leave");
        $( this ).children(".eliminarFoto").addClass("d-none");
    }
    else if($(this).is(".fotoAjaxKo")){
        console.log("hoverKo Leave");
        $( this ).children().addClass("d-none");
    }
});

//Ajax para subir la foto
$(".fileupload").change(function (e) { uploadFoto(e); });

function uploadFoto(e) {

    const file = e.target.files[0];
    console.log(file);
    let formData = new FormData();
    formData.append("file",file);

    const validImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/jpg'];//comprobamos que es una imagen

    if (validImageTypes.includes(file['type'])) {
        let fotoPadre = $(e.target).parent().parent();
        let filename = e.target.files[0].name;//Nombre del archivo

        if(fotoPadre.is("#fotoPerfil")){
            $.ajax({
                type: "POST",
                url: "/fotoPerfil/upload",
                data: formData,
                async:true,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data)
                {
                    console.log(data.error ? data.error : data);
                    fotoPadre.removeClass("fotoAjaxKo");
                    fotoPadre.addClass("fotoAjaxOk");
                    fotoPadre.children().remove();
                    fotoPadre.append($('<p class="p-1 pe-4 ps-2 text-white mb-auto align-self-end eliminarFoto d-none">Eliminar</p> '));
                    fotoPadre.append($('<p class="p-1 pe-4 ps-2 text-white mb-2 align-self-start cartelRojoIzq">Foto Perfil</p> '));
                    fotoPadre.css("background-image", "url("+ data.pathFoto + data.nombreFoto+")");
                    fotoPadre.children().bind( "click", deleteFoto);

                    $('.fotoGrid').children().remove();
                    $('.fotoGrid').append($('<div class="imagenUsuario m-2 "></div> '));
                    $('.fotoGrid').children().css("background-image", "url("+ data.pathFoto + data.nombreFoto+")");

                }
            });
        }else{
            $.ajax({
                type: "POST",
                url: "/galeria/upload",
                data: formData,
                async:true,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data)
                {
                    console.log(data.error ? data.error : data);
                    fotoPadre.removeClass("fotoAjaxKo");
                    fotoPadre.addClass("fotoAjaxOk");
                    fotoPadre.children().remove();
                    fotoPadre.append($('<p class="p-1 pe-4 ps-2 text-white mb-auto align-self-end eliminarFoto d-none">Eliminar</p> '));
                    fotoPadre.css("background-image", "url("+ data.pathFoto + data.nombreFoto+")");
                    fotoPadre.children().bind( "click", deleteFoto);
                }
            });
        }
    }
    else{
        console.log("No trolles campeon");
    }

}

//Ajax para eliminar la foto
$('.eliminarFoto').on( "click",deleteFoto );

function deleteFoto() {

    let padre = $(this).parent();
    var nombreFoto = $( this ).parent().data("nombreFoto");
    var idFoto = $( this ).parent().attr('id');

    if(padre.is("#fotoPerfil")){//comprobamos si es la foto de perfil para hacer el ajax a otra url
        $.ajax({
            type: "POST",
            url: "/fotoPerfil/delete",
            data: {
                foto:nombreFoto,
                idFoto:idFoto,
            },
            async:true,
            dataType: "json",
            success: function(data)
            {
                console.log(data);
                console.log(padre);
                padre.css("background-image", "url("+data.pathFotoDefault+"fotodefecto.png)");
                padre.removeAttr('data-nombre-foto');
                padre.removeClass("fotoAjaxOk");
                padre.addClass("fotoAjaxKo");
                padre.children().remove();
                padre.append(
                    $('    <div class="nofoto w-100 h-100 bg-white rounded d-none align-items-center d-flex flex-column">\n' +
                        '        <input style="visibility:hidden;" class="w-100 fileupload" id="fileupload" type="file" name="fileupload" accept="image/x-png,image/gif,image/jpeg" />\n' +
                        '        <label for="fileupload" class="btn"><i class="bi bi-plus-square mx-auto mx-auto "></i></label>\n' +
                        '    </div>')
                );
                padre.children().children().bind( "change", function (e) { uploadFoto(e); });

                $('.fotoGrid').children().remove();
                $('.fotoGrid').append($('<p>Sin foto de perfil</p> '));
            }
        });
    }else{//sino es que es una foto de la galeria
        $.ajax({
            type: "POST",
            url: "/galeria/delete",
            data: {
                foto:nombreFoto,
                idFoto:idFoto,
            },
            async:true,
            dataType: "json",
            success: function(data)
            {
                console.log(data);
                console.log(padre);
                padre.css("background-image", "url("+data.pathFotoDefault+"fotodefecto.png)");
                padre.removeAttr('data-nombre-foto');
                padre.removeClass("fotoAjaxOk");
                padre.addClass("fotoAjaxKo");
                padre.children().remove();
                padre.append(
                    $('    <div class="nofoto w-100 h-100 bg-white rounded d-none align-items-center d-flex flex-column">\n' +
                        '        <input style="visibility:hidden;" class="w-100 fileupload" id="fileupload" type="file" name="fileupload" accept="image/x-png,image/gif,image/jpeg" />\n' +
                        '        <label for="fileupload" class="btn"><i class="bi bi-plus-square mx-auto mx-auto "></i></label>\n' +
                        '    </div>')
                );
                padre.children().children().bind( "change", function (e) { uploadFoto(e); });
            }
        });
    }

}
//---------------------------------------------
//JS ajax para eliminar fotos o subirlas