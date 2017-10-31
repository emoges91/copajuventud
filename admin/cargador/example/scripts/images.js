$(function(){
	/**
	 * Validació amb Ajax
	 */
	var _loadingDiv = $("#ajaxLoad");

	// Muestra la capa #flashMessage encima de la capa con clase .add-info
	function flashMessage(message,classe){
		$(document.createElement('div'))
			.css('display', 'none')
			.attr('id','flashMessage')
			.addClass(classe)
			.html(message)
			.insertBefore($(".add-info")).fadeIn();
	}

// Sólo para Auth
//	function onTimeOut(data){
//		flashMessage(data.message,'error');
//	    window.setTimeout(function() {
//	        window.location.href = webroot + 'users/login';
//	    }, 2500);
//	}
// Fin Auth
	
	// Contador de IDs
	var item = 0;
	$('#imageFile').uploadify({
		'uploader' : webroot + 'flash/uploadify.swf',
		'script' : webroot +'images/upload/'+sessionId,
		'buttonText' : 'Buscar imágenes',
		'cancelImg' : webroot + 'img/botons/cancel.png',
		'auto' : 'true',
		'multi' : 'true',
		'simUploadLimit' : 3,
		'queueSizeLimit' : 3,
		'sizeLimit' : 800*1024,
		'fileExt' : '*.jpg;*.png;*.jpeg;*.gif',
		'fileDesc' : 'Imágenes',
		'onComplete' : function(evt, queueId, fileObj, response, data){
						// Interpretamos la respuesta JSON como un objeto
						var imageObj = eval('(' + response + ')');
    					if (imageObj.success){
							$(".input.upload").append(
								// Creamos una capa que contenga la imagen resultante de fondo
								$("<div></div>").css({
									'background': 'left center no-repeat url(' + webroot + 'img/upload/tmp/' + imageObj.success.data + ')',
									'width': '385px'
									}).attr('id','imatge'+item)
									// Creamos una capa con los inputs
									.append($("<div></div>").css({
										'margin-left': '105px'
										// Afegim missatge d'èxit i inputs
									}).append(imageObj.success.message + '<br/>' +
										'<label for="ImageName'+item+'">Nombre de la imagen<em>*</em></label>'+
										'<input maxlength="45" type="text" name="data[Image][name]['+item+']" value="' + 
										imageObj.success.data.replace(/\.([a-zA-Z]){3,4}$/,'') + '" id="ImageName'+item+'" />' + 
										'<label for="ImageDescription'+item+'">Descripción (255 caracteres máximo)</label>' +
										'<input maxlength="255" type="text" name="data[Image][description]['+item+']" id="ImageDescription'+item+'" />' + 
										'<label for="ImageTags'+item+'">Etiquetas (separadas por comas)</label>' + 
										'<textarea name="data[Image][tags]['+item+']" id="ImageTags'+item+'"></textarea>' +
										'<input type="hidden" name="data[Image][file]['+item+']" value="' + imageObj.success.data + '" />' +
										'<div style="clear:both"></div>'
									)
								)
							);
							// Incrementamos contador de ids
							item++;
    					}else if (imageObj.errors) {
							// En caso de error mostramos flashmessage
        					flashMessage(imageObj.errors.message,'error');
    					}
// Sólo para Auth
//						else if (imageObj.sessionTimeOut){
//							onTimeOut(imageObj.sessionTimeOut);
//						}
// Fin auth
						},
		'onAllComplete' : function(evt, data){
						flashMessage('Se han subido todas las imágenes. Recuerda enviar el formulario','info');
						$("#imageFile, #imageFileUploader").fadeOut('fast');
						$(":submit").removeAttr('disabled');
					}
	});

	// Convierte una_frase a unaFrase
	function camelize(string) {
		var a = string.split('_'), i;
		s = [];
		for (i=0; i<a.length; i++){
			s.push(a[i].charAt(0).toUpperCase() + a[i].substring(1));
		}
		s = s.join('');
		return s;
	}
	
	// Decide qué función ejecutar según los datos recibidos (si es "error" o "success")
	function afterValidate(data, status){
		$(".error-message, #flashMessage").remove();
		if (data.errors || data.saved) {
			if(data.saved){
				onSaved(data.saved);
			}
			onError(data.errors);
		} else if (data.success) {
			onSuccess(data.success);
		}
// Auth
//		 else if (data.sessionTimeOut){
//			onTimeOut(data.sessionTimeOut);
//		}
// fin Auth
	}

	// Esta función sirve para eliminar imágenes de la pantalla
	// del usuario cuando estas han sido guardadas correctamente
	function onSaved(data){
		$.each(data, function(id, item){
			$("#imatge"+id).slideUp('slow',function(){
				$(this).css({'background': 'none'})
					.html('<b class="ok">'+item.message+'</b>').slideDown('slow');
			});
		});
	}

	// En caso de error hacemos un bucle entre los errores y 
	// los mostramos cada uno en su input correspondiente
	function onError(data){
	    flashMessage(data.message,'error');
		$(".add-info :submit").removeAttr('disabled');
		$("#ajaxLoad").fadeOut();
	    $.each(data.data, function(key){
			$.each(data.data[key], function(model, errors){
				for (fieldName in this) {
					var element = $("#" + camelize(model + '_' + fieldName) + key);
					var _insert = $(document.createElement('div')).insertAfter(element).hide()
					.addClass('error-message').text(this[fieldName]).slideDown();
				}
			});
		});
	};
	
	// En caso de guardarse todo correctamente mostramos mensaje
	// y redirigimos al usuario donde queramos
	function onSuccess(data){
		$("#ImageAddForm").slideUp('slow');
		flashMessage(data.message,'info');
		$("#ajaxLoad").fadeOut();
		window.setTimeout(function() {
			window.location.href = webroot + 'images/add';
		}, 1500);
	};

	// Envío del formulario mediante Ajax
	$('#ImageAddForm').submit(function(){
		// Desactivamos el botón de submit
		$(".add-info :submit").attr('disabled','disabled');
		// Mostramos imagen de carga
		$("#ajaxLoad").fadeIn();
		// Eliminamos (si hubiera) mensajes de error
		$("#flashMessage").fadeOut();
		$(".error-message").slideUp();
		$.post(webroot + 'images/ajaxAdd',
			$(this).serializeArray(),
			afterValidate,
			"json"
		);
		return false;
	});
});