// $('#archivounouno').on('change', function(e)
// {
// 	//validación peso del archivo en by
// 	var input = document.getElementById('archivounouno');
// 	var clicked = e.target;
// 	var file = clicked.files[0];
// 	if (file.size>20000000 )
// 	{
// 		alert("The file can not exceed 20Mb");
// 	}else {
// 		var filePath = 	document.getElementById('archivounouno').value;
// 		var allowedExtensions = /(.jpg|.psd|.png|.ai|.pdf|.zip|.ZIP|.PSD|.PNG|.AI|.PDF|.jpeg)$/i;
// 		//validacion extension
// 		if (!allowedExtensions.exec(filePath)) {
// 			alert("The extension of the file is not allowed");
// 			fileInput.value = '';
// 			return false;
// 		}else{
// 			var ruta = $(this).val();
// 			var substr = ruta.replace('C:\\fakepath\\', '');
// 			$('.output p').text(substr);
// 			$('.output').css({
// 				"opacity": 1,
// 				"transform": "translateY(0px)"
// 			});
// 			$('.file > p').addClass('change');
// 		}
// 	}
// });
//
//
// $('#archivox').on('change', function(e){
// 	//validación peso del archivo en by
// 	var input = document.getElementById('archivox');
// 	var clicked = e.target;
// 	var file = clicked.files[0];
// 	if (file.size>200000 ) {
// 		alert("The file can not exceed 200Mb");
// 	}else {
// 		var filePath = 	document.getElementById('archivox').value;
// 		var allowedExtensions = /(.jpg|.psd|.png|.ai|.pdf)$/i;
// 		//validacion extension
// 		if (!allowedExtensions.exec(filePath)) {
// 			alert("The extension of the file is not allowed");
// 			fileInput.value = '';
// 			return false;
// 		}else{
// 			var ruta = $(this).val();
// 			var substr = ruta.replace('C:\\fakepath\\', '');
// 			$('.outputx p').text(substr);
// 			$('.outputx').css({
// 				"opacity": 1,
// 				"transform": "translateY(0px)"
// 			});
// 			$('.filex > p').addClass('change');
// 		}
// 	}
// });
// $('#archivoy').on('change', function(e){
// 	//validación peso del archivo en by
// 	var input = document.getElementById('archivoy');
// 	var clicked = e.target;
// 	var file = clicked.files[0];
// 	if (file.size>200000 ) {
// 		alert("The file can not exceed 200Mb");
// 	}else {
// 		var filePath = 	document.getElementById('archivoy').value;
// 		var allowedExtensions = /(.jpg|.psd|.png|.ai|.pdf)$/i;
// 		//validacion extension
// 		if (!allowedExtensions.exec(filePath)) {
// 			alert("The extension of the file is not allowed");
// 			fileInput.value = '';
// 			return false;
// 		}else{
// 			var ruta = $(this).val();
// 			var substr = ruta.replace('C:\\fakepath\\', '');
// 			$('.outputy p').text(substr);
// 			$('.outputy').css({
// 				"opacity": 1,
// 				"transform": "translateY(0px)"
// 			});
// 			$('.filey > p').addClass('change');
// 		}
// 	}
// });
