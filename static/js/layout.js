/*!
 * layout.js (http://agence.guettsoft.com)
 * Copyright 2017, Álvaro Güette.
 * Publicado bajo licencia MIT license. (https://raw.githubusercontent.com/alvaroraafael/prototipo-agence/master/LICENSE.md)
 */

(function($){
	$(function(){

		// Plugins iniciales de materialize
		$('.modal').modal();
		$('.scrollspy').scrollSpy();
		$('.button-collapse').sideNav({'edge': 'left'});
		$('select').not('.disabled').material_select();

		//Toggle
		var toggleContainersButton = $('#container-toggle-button');
		toggleContainersButton.click(function(){
			$('body .browser-window .container, .had-container').each(function(){
				$(this).toggleClass('had-container');
				$(this).toggleClass('container');
				if ($(this).hasClass('container')) {
					toggleContainersButton.text("Turn off Containers");
				}
				else {
					toggleContainersButton.text("Turn on Containers");
				}
			});
		});

		//Detecta pantalla tactil
		function is_touch_device() {
			try {
				document.createEvent("TouchEvent");
				return true;
			} catch (e) {
				return false;
			}
		}
		if (is_touch_device()) {
			$('#nav-mobile').css({ overflow: 'auto'});
		}

		// muestra el preloader
		function mostrarPrecarga(){
			$(".preloader-background").fadeIn();
			$(".progress").show();
		};

		// oculta el preloader
		function ocultarPrecarga(){
			$(".preloader-background").fadeOut();
			$(".progress").hide();
		};

	});

})(jQuery);
