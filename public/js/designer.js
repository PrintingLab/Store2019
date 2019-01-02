var golbal_color=""
var golbal_dropper=false 
function golbalcolor(a) {
	golbal_color=a
	$('.background-color').colorpicker('close')
	$('.text-color').colorpicker('close')
	$('.fill-color').colorpicker('close')
	$('.border-color').colorpicker('close')
}
function dropper(i) {
	golbal_dropper=true 
	$('.background-color').colorpicker('close')
	$('.text-color').colorpicker('close')
	$('.fill-color').colorpicker('close')
	$('.border-color').colorpicker('close')
	$('.upper-canvas').addClass('dropper')
}
function tip() { 
	$('.background-color').colorpicker('open')
}
function tip2() {
	$('.text-color').colorpicker('open')
}

var designerapp = angular.module('designer-v1', []);
designerapp.directive('dragbox', function ($document) {
	return {
		restrict: 'A',
		scope: {
			dragOptions: '=ngDraggable'
		},
		link: function(scope, elem, attr) {
			var startX, startY, x = 0, y = 0,
			start, stop, drag, container;

			var width  = elem[0].offsetWidth,
			height = elem[0].offsetHeight;

      // Obtain drag options
      if (scope.dragOptions) {
      	start  = scope.dragOptions.start;
      	drag   = scope.dragOptions.drag;
      	stop   = scope.dragOptions.stop;
      	var id = scope.dragOptions.container;
      	if (id) {
      		container = document.getElementById(id).getBoundingClientRect();
      	}
      }

      // Bind mousedown event
      elem.on('mousedown', function(e) {
      	e.preventDefault();
      	startX = e.clientX - elem[0].offsetLeft;
      	startY = e.clientY - elem[0].offsetTop;
      	$document.on('mousemove', mousemove);
      	$document.on('mouseup', mouseup);
      	if (start) start(e);
      });

      // Handle drag event
      function mousemove(e) {
      	y = e.clientY - startY;
      	x = e.clientX - startX;
      	setPosition();
      	if (drag) drag(e);
      }

      // Unbind drag events
      function mouseup(e) {
      	$document.unbind('mousemove', mousemove);
      	$document.unbind('mouseup', mouseup);
      	if (stop) stop(e);
      }

      // Move element, within container if provided
      function setPosition() {
      	if (container) {
      		if (x < container.left) {
      			x = container.left;
      		} else if (x > container.right - width) {
      			x = container.right - width;
      		}
      		if (y < container.top) {
      			y = container.top;
      		} else if (y > container.bottom - height) {
      			y = container.bottom - height;
      		}
      	}

      	elem.css({
      		top: y + 'px',
      		left:  x + 'px'
      	});
      }
  }
}
});
designerapp.controller('designercontroller',function($scope,$http){
	WebFont.load({
		google: {
			families: ['Shrikhand','Roboto','Pangolin','Open Sans','Montserrat','Lato','Titan One','Oswald','Roboto Slab','Raleway','Playfair Display','Arimo','Nunito','Inconsolata','Libre Baskerville','Yanone Kaffeesatz'
			,'Gloria Hallelujah','Gugi','Oxygen','Lobster','Bree Serif','Pacifico','Abril Fatface','Shadows Into Light','Berkshire Swash','Cinzel','Cormorant Unicase','Permanent Marker','Philosopher','Orbitron'
			,'Fredoka One','Luckiest Guy','Monoton','Bangers','Architects Daughter','VT323']
		}
	});

	var canvas
	var canvasback
	var circle
	var triangle
	var textbox
	var square
	var arraydropper=["<button><p>dropper</p><i class='fas fa-eye-dropper'></i></button>"]
	var arrayhtml=[]
	$scope.btntemplate= true;
	$scope.btnuploadimgurl = true
	$scope.myItem=" "
	$scope.size=" "
	$scope.back=false
	$scope.front=true
	$scope.Entertext=true
	$scope.shapeoption=true
	$scope.texdisabled=true
	$scope.scissors=true
	$scope.pickcolor=true
	$scope.cutipe
	$scope.icons='Select icon'
	$scope.btnchangeside=true	
	$scope.backgroundCol='rgba(250, 250, 250, 1)'
	$scope.cutbackground='rgba(204, 154, 129, 0)'
	$scope.canvasborder='1px rgba(156, 156, 156, 1) solid'
	$scope.canvashadow='5px 5px 6px -6px'
	$scope.textselectedcolor='#fff'
	$scope.topval=0
	$scope.leftval=0
	$scope.canvasX=0
	$scope.canvasY=0
	$scope.desing_formdata =[]
	$scope.uploadimgurllist = []
	$scope.canvasurl="../public/img/noImg.jpg"
	$scope.canvasbackurl="../public/img/noImg.jpg"
	$scope.Opacity=1
	$scope.cvside=true
	var _config = {
		canvasState             : [],
		currentStateIndex       : -1,
		undoStatus              : false,
		redoStatus              : false,
		undoFinishedStatus      : 1,
		redoFinishedStatus      : 1,
	}
	var _configback = {
		canvasState             : [],
		currentStateIndex       : -1,
		undoStatus              : false,
		redoStatus              : false,
		undoFinishedStatus      : 1,
		redoFinishedStatus      : 1,
	}
	$('#shapeoption').hide()
	$('#Entertext').hide()
	$("#toolcontainer").hide();
	$('#safelines').hide()
	$scope.loaduserimg = function () {
		$.ajax({
            url: 'userimg', // point to server-side PHP script
            type: 'get',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function(data) {
            	$scope.uploadimgurllist = data.user_imgs
            	$scope.$apply()
            }
        });
	}
$scope.HideToobar = true
$scope.fHideToobar= function(argument) {
	if ($scope.HideToobar) {
		$scope.HideToobar =false
	}else{
		$scope.HideToobar =true
	}
}

	var grid =25
	$scope.init = function(i){
		canvas = new fabric.Canvas('canvas',
		{
			preserveObjectStacking	: true,

		});
		canvasback = new fabric.Canvas('canvasback', 

		{
			preserveObjectStacking	: true,
		});
		canvas.backgroundColor='#ffffff';
		canvas.renderAll();
		canvasback.backgroundColor='#ffffff';
		canvasback.renderAll();
		$scope.canvasWidth=canvas.width+2+'px';
		$scope.canvasHeight=canvas.height+2+'px';
		$scope.cutWidth=canvas.width+30+'px';
		$scope.cutHeight=canvas.height+30+'px';
		$scope.canvasbackWidth=canvasback.width+2+'px';
		$scope.canvasbackHeight=canvasback.height+2+'px';
		$scope.loaduserimg()
		
	}()
	$scope.updateobjet = function(argument) {
		for (var i = 0; i < canvas.getObjects().length; ++i) {
			console.log(canvas.getObjects().length)
		}
	}
	$scope.templatetype = function(a) {
		$scope.templatetypefilter=a
	}

	$scope.changeside = function(i){
		console.log(i)
		$scope.quickinputarray=[]
		$scope.quicklayersarray=[]
		if (i=='f') {
			$scope.cvside=true;
			$scope.back=false
			$scope.front=true

			$scope.btnchangeside=true			
			$scope.backgroundselectedcolor=canvas.backgroundColor
			$scope.popquicklayer=false
		}else{
			$scope.front=false
			$scope.back=true
			$scope.cvside=false;

			$scope.btnchangeside=false	
			$scope.backgroundselectedcolor=canvasback.backgroundColor
			$scope.popquicklayer=false

		}
	}

	$scope.Copy = function(){

		if ($scope.cvside) {
			canvas.getActiveObject().clone(function(cloned) {
				_clipboard = cloned;
			});
		}else{
			canvasback.getActiveObject().clone(function(cloned) {
				_clipboard = cloned;
			});
		}
	}

	$scope.Paste = function(){
		if ($scope.cvside) {
			_clipboard.clone(function(clonedObj) {
				canvas.discardActiveObject();
				clonedObj.set({
					left: clonedObj.left + 10,
					top: clonedObj.top + 10,
					evented: true,
				});
				if (clonedObj.type === 'activeSelection') {
					clonedObj.canvas = canvas;
					clonedObj.forEachObject(function(obj) {
						canvas.add(obj)
						$scope.reloadquicklayers()
					});
					clonedObj.setCoords()
				} else {
					canvas.add(clonedObj)
					$scope.reloadquicklayers()
				}
				_clipboard.top += 10;
				_clipboard.left += 10;
				canvas.setActiveObject(clonedObj)
				canvas.requestRenderAll()
			})
		}else{
			_clipboard.clone(function(clonedObj) {
				canvasback.discardActiveObject()
				clonedObj.set({
					left: clonedObj.left + 10,
					top: clonedObj.top + 10,
					evented: true,
				});
				if (clonedObj.type === 'activeSelection') {
					clonedObj.canvasback = canvasback;
					clonedObj.forEachObject(function(obj) {
						canvasback.add(obj);
						$scope.reloadquicklayers()
					});
					clonedObj.setCoords();
				} else {
					canvasback.add(clonedObj);
					$scope.reloadquicklayers()
				}
				_clipboard.top += 10;
				_clipboard.left += 10;
				canvasback.setActiveObject(clonedObj);
				canvasback.requestRenderAll();
			})
		}
	}

	$scope.addico = function(i,file) {
		$scope.updateobjet()
		var url = i+$scope.namefolderico+'/'+file
		console.log(url)
		if ($scope.cvside) {
			fabric.loadSVGFromURL(url,function(objects,options) {
				var loadedObjects = fabric.util.groupSVGElements(objects, options);
				loadedObjects.set({
					top: canvas.height/2,
					left: canvas.width/2,
					originX: 'center',
					originY: 'center',
				});
				loadedObjects.scaleToWidth(25);
				loadedObjects.scaleToHeight(25);
				canvas.add(loadedObjects);
				$scope.reloadquicklayers()
				canvas.renderAll();

			});
		}else{
			fabric.loadSVGFromURL(url,function(objects,options) {
				var loadedObjects = fabric.util.groupSVGElements(objects, options);
				loadedObjects.set({
					top: canvasback.height/2,
					left: canvasback.width/2,
					originX: 'center',
					originY: 'center'
				});
				loadedObjects.scaleToWidth(25);
				loadedObjects.scaleToHeight(25);
				canvasback.add(loadedObjects);
				$scope.reloadquicklayers()
				canvasback.renderAll();

			});
		}

	}
	$scope.addImg = function(i,file) {
		var url = i+file
		console.log(url)
		$scope.updateobjet()
		if ($scope.cvside) {
			fabric.Image.fromURL(url, function(oImg) {
				oImg.scaleToWidth(canvas.width/2);
				oImg.set('flipX', false);
				oImg.set('top', 0);
				oImg.set('left', 0);
				oImg.set('cornerColor', '#ff46b4');
				oImg.set('borderColor', '#ff46b4');
				oImg.set('cornerSize', 6);
				oImg.set('transparentCorners', false);
				canvas.add(oImg);  
				$scope.reloadquicklayers()

			});
		}else{
			fabric.Image.fromURL(url, function(oImg) {
				oImg.scaleToWidth(canvasback.width/2);
				oImg.set('flipX', false);
				oImg.set('top', 0);
				oImg.set('left', 0);
				oImg.set('cornerColor', '#ff46b4');
				oImg.set('borderColor', '#ff46b4');
				oImg.set('cornerSize', 6);
				oImg.set('transparentCorners', false);
				canvasback.add(oImg);  
				$scope.reloadquicklayers()

			});
		}

	}

	$scope.addSquare = function() {
		if ($scope.cvside) {
			square = new fabric.Rect({
				width: 180,
				height: 180,
				left: (canvas.width/2) - (180 * 1/2),
				top: (canvas.height/2) - (180 * 1/2),
				fill: '#f7ffb1',
				stroke: '#495057',
				strokeWidth: 3,
				cornerColor: '#ff46b4',
				borderColor: '#ff46b4',
				cornerSize: 6,
				transparentCorners: false
				
			});
			canvas.add(square);
			$scope.reloadquicklayers()
		}else{
			square = new fabric.Rect({
				width: 180,
				height: 180,
				left: (canvasback.width/2) - (180 * 1/2),
				top: (canvasback.height/2) - (180 * 1/2),
				fill: '#f7ffb1',
				stroke: '#495057',
				strokeWidth: 3,
				cornerColor: '#ff46b4',
				borderColor: '#ff46b4',
				cornerSize: 6,
				transparentCorners: false
			});
			canvasback.add(square);
			$scope.reloadquicklayers()
		}
	}

	$scope.addCircle = function() {
		if ($scope.cvside) {
			circle = new fabric.Circle({
				radius: 90,
				left: (canvas.width/2) - (180 * 1/2),
				top: (canvas.height/2) - (180 * 1/2),
				fill: '#f7ffb1',
				stroke: '#495057',
				strokeWidth: 3,
				cornerColor: '#ff46b4',
				borderColor: '#ff46b4',
				cornerSize: 6,
				transparentCorners: false

			});
			canvas.add(circle);
			$scope.reloadquicklayers()
		}else{
			circle = new fabric.Circle({
				radius: 90,
				left: (canvasback.width/2) - (180 * 1/2),
				top: (canvasback.height/2) - (180 * 1/2),
				fill: '#f7ffb1',
				stroke: '#495057',
				strokeWidth: 3,
				cornerColor: '#ff46b4',
				borderColor: '#ff46b4',
				cornerSize: 6,
				transparentCorners: false
			});
			canvasback.add(circle);
			$scope.reloadquicklayers()
		}

	}

	$scope.addTriangle = function() {
		if ($scope.cvside) {
			triangle = new fabric.Triangle({
				width: 180,
				height: 180,
				left: (canvas.width/2) - (180 * 1/2),
				top: (canvas.height/2) - (180 * 1/2), 
				fill: '	#80e6e6',
				stroke: '#495057',
				strokeWidth: 3,
				cornerColor: '#ff46b4',
				borderColor: '#ff46b4',
				cornerSize: 6,
				transparentCorners: false
			});
			canvas.add(triangle);
			$scope.reloadquicklayers()
		}else{
			triangle = new fabric.Triangle({
				width: 180,
				height: 180,
				left: (canvasback.width/2) - (180 * 1/2),
				top: (canvasback.height/2) - (180 * 1/2),
				fill: '#f7ffb1',
				stroke: '#495057',
				strokeWidth: 3,
				cornerColor: '#ff46b4',
				borderColor: '#ff46b4',
				cornerSize: 6,
				transparentCorners: false
			});
			canvasback.add(triangle);
			$scope.reloadquicklayers()
		}
	}

	$scope.horizontaline = function() {
		if ($scope.cvside) {
			Hline = new fabric.Line([50, 50, 200, 50], { 
				left: (canvas.width/2) - (200 * 1/2),
				top: (canvas.height/2) - (2 * 1/2),
				fill: 'rgba(154,205,50,0)',
				stroke: '#495057',
				strokeWidth: 4,
				cornerColor: '#ff46b4',
				borderColor: '#ff46b4',
				cornerSize: 6,
				transparentCorners: false
			});
			Hline .setControlsVisibility({
				mt: true, mb: true, ml: true, mr: true, bl: false,br: false, tl: false, tr: false,mtr: true,
			});
			canvas.add(Hline);
			$scope.reloadquicklayers()
		}else{
			Hline = new fabric.Line([50, 50, 200, 50], { 
				left: (canvasback.width/2) - (200 * 1/2),
				top: (canvasback.height/2) - (2 * 1/2),
				fill: 'rgba(154,205,50,0)',
				stroke: '#495057',
				strokeWidth: 4,
				cornerColor: '#ff46b4',
				borderColor: '#ff46b4',
				cornerSize: 6,
				transparentCorners: false
			});
			Hline .setControlsVisibility({
				mt: true, mb: true, ml: true, mr: true, bl: false,br: false, tl: false, tr: false,mtr: true,
			});
			canvasback.add(Hline);
			$scope.reloadquicklayers()
		}
	}

	$scope.verticaline = function() {
		if ($scope.cvside) {
			Vline = new fabric.Line([50, 50,50, 200], {
				left: (canvas.width/2) - (2 * 1/2),
				top: (canvas.height/2) - (200 * 1/2),
				fill: 'rgba(154,205,50,0)',
				stroke: '#495057',
				strokeWidth: 4,
				cornerColor: '#ff46b4',
				borderColor: '#ff46b4',
				cornerSize: 6,
				transparentCorners: false
			});
			Vline .setControlsVisibility({
				mt: true, mb: true, ml: true, mr: true, bl: false,br: false, tl: false, tr: false,mtr: true,
			});
			canvas.add(Vline);
			$scope.reloadquicklayers()
		}else{
			Vline = new fabric.Line([50, 50,50, 200],{
				left: (canvasback.width/2) - (2 * 1/2),
				top: (canvasback.height/2) - (200 * 1/2),
				fill: 'rgba(154,205,50,0)',
				stroke: '#495057',
				strokeWidth: 4,
				cornerColor: '#ff46b4',
				borderColor: '#ff46b4',
				cornerSize: 6,
				transparentCorners: false
			});
			Vline .setControlsVisibility({
				mt: true, mb: true, ml: true, mr: true, bl: false,br: false, tl: false, tr: false,mtr: true,
			});
			canvasback.add(Vline);
			$scope.reloadquicklayers()
		}
	}
	function rgb2hex(rgb){
		rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
		return (rgb && rgb.length === 4) ? "#" +
		("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
		("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
		("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
	}
	$scope.changecolor = function(i) {
		var col = rgb2hex(i)
		console.log(col)
		if ($scope.cvside) {
			canvas.backgroundColor=col;
			canvas.renderAll();
			golbal_color=""
		}else{
			canvasback.backgroundColor=col;
			canvasback.renderAll();
			golbal_color=""	
		}
	}
	$scope.delete = function() {
		if ($scope.cvside) {
			var activeObject = canvas.getActiveObjects();
			canvas.discardActiveObject();
			canvas.remove(...activeObject);
			$('#shapeoption').hide()
			$('#Entertext').hide()
			$scope.reloadquicklayers()
		}else{
			var activeObject = canvasback.getActiveObjects();
			canvasback.discardActiveObject();
			canvasback.remove(...activeObject);
			$('#shapeoption').hide()
			$('#Entertext').hide()
			$scope.reloadquicklayers()

		}

	}
	$scope.keyover=true
	$( "#valuetext" ).click(function() {
		$scope.keyover=false
	});

	if ($scope.keyover) {
		window.addEventListener("keydown", function(e) {
			if([ 37, 38, 39, 40].indexOf(e.keyCode) > -1) {
				e.preventDefault();
			}
		}, false);
	}
	
	document.onkeydown = info;
	function info(elEvento) {
		if ($scope.cvside) {
			console.log(elEvento.keyCode)
			if(  elEvento.ctrlKey && elEvento.keyCode === 67 ){
				$scope.Copy()
			}
			else if( elEvento.ctrlKey && elEvento.keyCode === 86 ){
				$scope.Paste()
			}
			if(  elEvento.ctrlKey && elEvento.keyCode === 90 ){
				$scope.undo()
			}
			else if( elEvento.ctrlKey && elEvento.keyCode === 89 ){
				$scope.redo()
			}
			if ($scope.keyover) {
				switch(elEvento.keyCode) {
					case 46:
					$scope.delete()
					break;
					case 37:
					console.log(elEvento.keyCode+' left')
					if(canvas.getActiveObject()){
						canvas.getActiveObject().left -= 1;
						canvas.renderAll();
					}
					break;
					case 38:
					console.log(elEvento.keyCode+' up')
					if(canvas.getActiveObject()){
						canvas.getActiveObject().top -= 1;
						canvas.renderAll();
					}
					break;
					case 39:
					console.log(elEvento.keyCode+' right')
					if(canvas.getActiveObject()){
						canvas.getActiveObject().left += 1;
						canvas.renderAll();
					}
					break;
					case 40:
					console.log(elEvento.keyCode+' down')
					if(canvas.getActiveObject()){
						canvas.getActiveObject().top += 1;
						canvas.renderAll();
					}
					case 17:
					console.log(elEvento.keyCode+' down')
					// canvas.on('object:moving', function(options) {
					// 	options.target.set({
					// 		left: Math.round(options.target.left / grid) * grid,
					// 		top: Math.round(options.target.top / grid) * grid
					// 	});
					// });
					break;
					default:
				}
			}
		}else{
			if(  elEvento.ctrlKey && elEvento.keyCode === 67 ){
				$scope.Copy()
			}
			else if( elEvento.ctrlKey && elEvento.keyCode === 86 ){
				$scope.Paste()
			}
			if(  elEvento.ctrlKey && elEvento.keyCode === 90 ){
				$scope.undo()
			}
			else if( elEvento.ctrlKey && elEvento.keyCode === 89 ){
				$scope.redo()
			}
			switch(elEvento.keyCode) {
				case 46:
				$scope.delete()
				break;
				case 37:
				console.log(elEvento.keyCode+' left')
				if(canvasback.getActiveObject()){
					canvasback.getActiveObject().left -= 1;
					canvasback.renderAll();
				}
				break;
				case 38:
				console.log(elEvento.keyCode+' up')
				if(canvasback.getActiveObject()){
					canvasback.getActiveObject().top -= 1;
					canvasback.renderAll();
				}
				break;
				case 39:
				console.log(elEvento.keyCode+' right')
				if(canvasback.getActiveObject()){
					canvasback.getActiveObject().left += 1;
					canvasback.renderAll();
				}
				break;
				case 40:
				console.log(elEvento.keyCode+' down')
				if(canvasback.getActiveObject()){
					canvasback.getActiveObject().top += 1;
					canvasback.renderAll();
				}
				break;
				default:
			}

		}

	}

	$scope.addShape = function(i) {

		if (i === 'Square') {
			$scope.addSquare();
		} else if (i === 'Triangle'){
			$scope.addTriangle();
		} else if (i === 'Circle') {
			$scope.addCircle();
		} else {
		}
	};

	$scope.textAlign = function(i) {
		if ($scope.cvside) {
			if (i === 'left') {
				canvas.getActiveObject().set("textAlign", i);
				canvas.renderAll();
			} else if (i === 'center') {
				canvas.getActiveObject().set("textAlign", i);
				canvas.renderAll();
			} else if (i === 'right') {
				canvas.getActiveObject().set("textAlign", i);
				canvas.renderAll();
			} else {
			}
		}else{
			if (i === 'left') {
				canvasback.getActiveObject().set("textAlign", i);
				canvasback.renderAll();
			} else if (i === 'center') {
				canvasback.getActiveObject().set("textAlign", i);
				canvasback.renderAll();
			} else if (i === 'right') {
				canvasback.getActiveObject().set("textAlign", i);
				canvasback.renderAll();
			} else {
			}
		}
	};
	
	$scope.sendorder = function(argument) {
		$scope.savecanvas()
		//$scope.desing_formdata.side1=canvas.toDataURL("image/png")
		//$scope.desing_formdata.side2=canvasback.toDataURL("image/png")
		var desing_formdata = new FormData();
		desing_formdata.append('side1', canvas.toDataURL("image/png"));
		desing_formdata.append('side2', canvasback.toDataURL("image/png"));
		desing_formdata.append('side1svg', canvas.toSVG());
		desing_formdata.append('side2svg', canvasback.toSVG());
		desing_formdata.append('faces', $('#caras').val());
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('meta[name=_token]').attr('content')
			}
		});
		$.ajax({
            url: 'desingimg', // point to server-side PHP script
            data: desing_formdata,
            type: 'POST',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function(data) { 
            	console.log(data)      
            	//$("#pageload").show();
            	//$("#preloader").show();
            	$('#side1').val(data.ladoA)
            	$('#side2').val(data.ladoB)
            	console.log(data.folder)
            	$scope.movefiles(data.folder)
            	$.dialog({
            		title: 'Success!',
            		content: 'Design added to cart',
            	});
            	//$.alert('design added to the cart');
            	setTimeout(function() {
            		$( "#form-desiner" ).submit();
            	}, 2000);
            	
            }
        });
		//////////$scope.submit()
	}

	$scope.movefiles = function(i) { 
		var filetomovename = i
		var files_formdata = new FormData(); 
		for (var i = 0; i < canvas.getObjects().length; ++i) { 
			if (canvas.item(i).type == 'image' ) { 	
				console.log(canvas.item(i))
				files_formdata.append('filetomove', canvas.item(i)._element.currentSrc);
				files_formdata.append('path', filetomovename);
				$.ajaxSetup({
					headers: {
						'X-CSRF-Token': $('meta[name=_token]').attr('content')
					}
				});
				$.ajax({
            url: 'moveimg', // point to server-side PHP script
            data: files_formdata,
            type: 'POST',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function(data) {       
            	console.log(data)
            }
        });
			}
		}	
	}

	$scope.lockactivelayer = function(act,a) {
		if ($scope.cvside) {
			for (var i = canvas.getObjects().length- 1; i >= 0; i--) {
				if (canvas.item(i).id == act ) { 
					if (a=='1') {
						if (canvas.item(i).selectable) {
							canvas.item(i).set({ hasControls: false, hasBorders: false, selectable: false });
							canvas.discardActiveObject()
							canvas.renderAll();
							$scope[act] = canvas.item(i).selectable
						}else{
							canvas.item(i).set({ hasControls: true, hasBorders: true, selectable: true });
							canvas.discardActiveObject()
							canvas.renderAll();
							$scope[act] = canvas.item(i).selectable
						}
					}else{ 
						if (canvas.item(i).visible) {
							canvas.item(i).set({ visible: false});
							canvas.renderAll();
							$scope[act+'2'] = canvas.item(i).visible
						}else{
							canvas.item(i).set({ visible: true });
							canvas.renderAll();
							$scope[act+'2'] = canvas.item(i).visible
						}
					}

				}	
			}	
		}else{
			for (var i = canvasback.getObjects().length- 1; i >= 0; i--) {
				if (canvasback.item(i).id == act ) { 
					if (a=='1') {
						if (canvasback.item(i).selectable) {
							canvasback.item(i).set({ hasControls: false, hasBorders: false, selectable: false });
							canvasback.discardActiveObject()
							canvasback.renderAll();
							$scope[act] = canvasback.item(i).selectable
						}else{
							canvasback.item(i).set({ hasControls: true, hasBorders: true, selectable: true });
							canvasback.discardActiveObject()
							canvasback.renderAll();
							$scope[act] = canvasback.item(i).selectable
						}
					}else{ 
						if (canvasback.item(i).visible) {
							canvasback.item(i).set({ visible: false});
							canvasback.renderAll();
							$scope[act+'2'] = canvasback.item(i).visible
						}else{
							canvasback.item(i).set({ visible: true });
							canvasback.renderAll();
							$scope[act+'2'] = canvasback.item(i).visible
						}
					}

				}	
			}	

		}
	}


	$scope.setactivelayer = function(act) {
		if ($scope.cvside) {
			$('#quicklayer div').removeClass('quicklayerselec')
			$('#'+act+'').addClass('quicklayerselec')
			$('#'+act+'').focus()
			for (var i = canvas.getObjects().length- 1; i >= 0; i--) {
				if (canvas.item(i).id == act ) { 
					canvas.setActiveObject(canvas.item(i));
					canvas.item(i).hasControls = true;
					canvas.item(i).set('cornerColor', '#ff46b4');
					canvas.item(i).set('borderColor', '#ff46b4');
					canvas.item(i).set('cornerSize', 6);
					canvas.item(i).set('transparentCorners', false);
					canvas.renderAll();
					console.log(canvas.item(i).selectable)
				}	
			}
		}else{
			$('#quicklayer div').removeClass('quicklayerselec')
			$('#'+act+'').addClass('quicklayerselec')
			$('#'+act+'').focus()
			for (var i = canvasback.getObjects().length- 1; i >= 0; i--) {
				if (canvasback.item(i).id == act ) { 
					canvasback.setActiveObject(canvasback.item(i));
					canvas.item(i).hasControls = true;
					canvas.item(i).set('cornerColor', '#ff46b4');
					canvas.item(i).set('borderColor', '#ff46b4');
					canvas.item(i).set('cornerSize', 6);
					canvas.item(i).set('transparentCorners', false);
					canvasback.renderAll();
					console.log(canvasback.item(i).selectable)
				}	
			}
		}
	}
	$scope.reloadquicklayers = function() {
		if ($scope.cvside) {
			$scope.quicklayersarray=[]
			$scope.quickinputarray=[]
			for (var i = canvas.getObjects().length- 1; i >= 0; i--) {
				canvas.item(i).set("id", 'ly'+i);
				var act ='ly'+i
				$scope[act] = canvas.item(i).selectable
				$scope[act+'2'] = canvas.item(i).visible
				if (canvas.item(i).type=="image") {
					$scope.quicklayersarray.push({id:'ly'+i,name:canvas.item(i).type,img:canvas.item(i).src})
				}else{
					$scope.quicklayersarray.push({id:'ly'+i,name:canvas.item(i).type,img:canvas.item(i).toDataURL("image/png")})
				}

				console.log($scope.quicklayersarray)
				canvas.renderAll();
			//$('.quickinput').append("<input type='' value='"+canvas.item(i).text+"' name='"+canvas.item(i).text+"' placeholder='"+canvas.item(i).text+"'><br>");
		}
	}else{
		$scope.quicklayersarray=[]
		$scope.quickinputarray=[]
		for (var i = canvasback.getObjects().length- 1; i >= 0; i--) {
			canvasback.item(i).set("id", 'ly'+i);
			var act ='ly'+i
			$scope[act] = canvasback.item(i).selectable
			$scope[act+'2'] = canvasback.item(i).visible
			if (canvasback.item(i).type=="image") {
				$scope.quicklayersarray.push({id:'ly'+i,name:canvasback.item(i).type,img:canvasback.item(i).src})
			}else{
				$scope.quicklayersarray.push({id:'ly'+i,name:canvasback.item(i).type,img:canvasback.item(i).toDataURL("image/png")})
			}
			console.log($scope.quicklayersarray)
			canvasback.renderAll();
			//$('.quickinput').append("<input type='' value='"+canvas.item(i).text+"' name='"+canvas.item(i).text+"' placeholder='"+canvas.item(i).text+"'><br>");
		}
	}
}




$scope.quicklayers = function() {
	if ($scope.popquicklayer) {
		$scope.btnlayersbackground='#fff'
		$scope.btnlayerscolor='#000'
		$scope.popquicklayer=false
	}else{
		$scope.popquicklayer=true
		$scope.btnlayersbackground='#000'
		$scope.btnlayerscolor='#fff'
	}
	if ($scope.cvside) {
		$scope.quicklayersarray=[]
		$scope.quickinputarray=[]
		for (var i = canvas.getObjects().length- 1; i >= 0; i--) {
			canvas.item(i).set("id", 'ly'+i);
			var act ='ly'+i
			$scope[act] = canvas.item(i).selectable
			$scope[act+'2'] = canvas.item(i).visible
			if (canvas.item(i).type=="image") {
				$scope.quicklayersarray.push({id:'ly'+i,name:canvas.item(i).type,img:canvas.item(i).src})
			}else{
				$scope.quicklayersarray.push({id:'ly'+i,name:canvas.item(i).type,img:canvas.item(i).toDataURL("image/png")})
			}
			console.log($scope.quicklayersarray)
			canvas.renderAll();
			//$('.quickinput').append("<input type='' value='"+canvas.item(i).text+"' name='"+canvas.item(i).text+"' placeholder='"+canvas.item(i).text+"'><br>");
		}
	}else{
		$scope.quicklayersarray=[]
		$scope.quickinputarray=[]
		for (var i = canvasback.getObjects().length- 1; i >= 0; i--) {
			canvasback.item(i).set("id", 'ly'+i);
			var act ='ly'+i
			$scope[act] = canvasback.item(i).selectable
			$scope[act+'2'] = canvasback.item(i).visible
			if (canvasback.item(i).type=="image") {
				$scope.quicklayersarray.push({id:'ly'+i,name:canvasback.item(i).type,img:canvasback.item(i).src})
			}else{
				$scope.quicklayersarray.push({id:'ly'+i,name:canvasback.item(i).type,img:canvasback.item(i).toDataURL("image/png")})
			}
			console.log($scope.quicklayersarray)
			canvasback.renderAll();
			//$('.quickinput').append("<input type='' value='"+canvas.item(i).text+"' name='"+canvas.item(i).text+"' placeholder='"+canvas.item(i).text+"'><br>");
		}
	}
}

$scope.Quitinput = function() {
	if ($scope.cvside) {
		$scope.quickinputarray=[]
		$scope.quicklayersarray=[]
		for (var i = canvas.getObjects().length- 1; i >= 0; i--) {
			if (canvas.item(i).type == 'textbox' ) { 	
				canvas.item(i).set("id", i);
				$scope.quickinputarray.push({id:i,name:canvas.item(i).text})
				console.log($scope.quickinputarray)
				canvas.renderAll();
			//$('.quickinput').append("<input type='' value='"+canvas.item(i).text+"' name='"+canvas.item(i).text+"' placeholder='"+canvas.item(i).text+"'><br>");
		}
	}
}else{
	$scope.quickinputarray=[]
	$scope.quicklayersarray=[]
	for (var i = canvasback.getObjects().length- 1; i >= 0; i--) {
		if (canvasback.item(i).type == 'textbox' ) { 	
			canvasback.item(i).set("id", i);
			$scope.quickinputarray.push({id:i,name:canvasback.item(i).text})
			console.log($scope.quickinputarray)
			canvasback.renderAll();
			//$('.quickinput').append("<input type='' value='"+canvas.item(i).text+"' name='"+canvas.item(i).text+"' placeholder='"+canvas.item(i).text+"'><br>");

		}
	}
}
}
$scope.quickinputchange= function(val,id) {
	if ($scope.cvside) {
		for (var i = canvas.getObjects().length- 1; i >= 0; i--) {
			if (canvas.item(i).type == 'textbox' ) { 
				if (canvas.item(i).id == id) {
					canvas.setActiveObject(canvas.item(i))
					canvas.item(i).set("text", val);
					canvas.renderAll();
				}	
			//$('.quickinput').append("<input type='' value='"+canvas.item(i).text+"' name='"+canvas.item(i).text+"' placeholder='"+canvas.item(i).text+"'><br>");
		}
	}
}else{
	for (var i = canvasback.getObjects().length- 1; i >= 0; i--) {
		if (canvasback.item(i).type == 'textbox' ) { 
			if (canvasback.item(i).id == id) {
				canvasback.setActiveObject(canvasback.item(i))
				canvasback.item(i).set("text", val);
				canvasback.renderAll();
			}	

			//$('.quickinput').append("<input type='' value='"+canvas.item(i).text+"' name='"+canvas.item(i).text+"' placeholder='"+canvas.item(i).text+"'><br>");
		}
	}
}
}



$scope.addText = function() {
	$scope.textval=" "
	if ($scope.cvside) {
		textbox  = new fabric.Textbox('New Text Box', {
			width: 180 ,
			left: (canvas.width/2) - (canvas.width/2 * 1/2),
			top: (canvas.height/2) - (canvas.height/2 * 1/2),
			fontSize: 30,
			radius: 100,
			textAlign: 'left',
			fixedWidth: 180,
			cornerColor: '#ff46b4',
			borderColor: '#ff46b4',
			cornerSize: 6,
			transparentCorners: false
		});
		textbox .setControlsVisibility({
			mt: false, mb: false, ml: true, mr: true, bl: false,br: false, tl: false, tr: false,mtr: true, 
		});
		canvas.add(textbox);
		$scope.reloadquicklayers()
	}else{
		textbox  = new fabric.Textbox('New Text Box', {
			width: 180,
			height:50,
			left: (canvasback.width/2) - (canvasback.width/2 * 1/2),
			top: (canvasback.height/2) - (canvasback.height/2 * 1/2),
			fontSize: 30,
			textAlign: 'left',
			fixedWidth: 180,
			cornerColor: '#ff46b4',
			borderColor: '#ff46b4',
			cornerSize: 6,
			transparentCorners: false

		});
		textbox .setControlsVisibility({
			mt: false, mb: false, ml: true, mr: true, bl: false,br: false, tl: false, tr: false,mtr: true, 
		});
		canvasback.add(textbox);
		$scope.reloadquicklayers()
	}
}

canvasback.on('mouse:down', function(options) {
	if (options.target!=null) {
		$('#quicklayer div').removeClass('quicklayerselec')
		$('#'+options.target.id+'').addClass('quicklayerselec')
		options.target.hasControls = true;
		options.target.set('cornerColor', '#ff46b4');
		options.target.set('borderColor', '#ff46b4');
		options.target.set('cornerSize', 6);
		options.target.set('transparentCorners', false);
		switch(options.target.type) {
			case 'activeSelection':
			$('#shapeoption').show()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.fillselectedcolor=options.target.fill
			$scope.bordeselectedcolor=options.target.stroke
			$scope.topval=Math.round(canvas.height+25)+'px'
			$scope.leftval=(Math.round(canvas.height))+'px'
			$scope.Opacity=options.target.opacity
			$scope.$apply();
			break;
			case 'group':
			$('#shapeoption').show()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.fillselectedcolor=options.target.fill
			$scope.bordeselectedcolor=options.target.stroke
			$scope.topval=Math.round(canvas.height+25)+'px'
			$scope.leftval=(Math.round(canvas.height))+'px'
			$scope.Opacity=options.target.opacity
			$scope.$apply();
			break;
			case 'path':
			$('#shapeoption').show()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.fillselectedcolor=options.target.fill
			$scope.bordeselectedcolor=options.target.stroke
			$scope.topval=Math.round(canvas.height+25)+'px'
			$scope.leftval=(Math.round(canvas.height))+'px'
			$scope.Opacity=options.target.opacity
			$scope.$apply();
			break;
			case 'rect':
			$('#shapeoption').show()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.fillselectedcolor=options.target.fill
			$scope.bordeselectedcolor=options.target.stroke
			$scope.topval=Math.round(canvas.height+25)+'px'
			$scope.leftval=(Math.round(canvas.height))+'px'
			$scope.Opacity=options.target.opacity
			$scope.$apply();
			break;
			case 'line':
			$('#shapeoption').show()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.fillselectedcolor=options.target.fill
			$scope.bordeselectedcolor=options.target.stroke
			$scope.topval=Math.round(canvas.height+25)+'px'
			$scope.leftval=(Math.round(canvas.height))+'px'
			$scope.Opacity=options.target.opacity
			$scope.$apply();
			break;


			case 'circle':
			$('#shapeoption').show()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.fillselectedcolor=options.target.fill
			$scope.bordeselectedcolor=options.target.stroke
			$scope.topval=Math.round(canvas.height+25)+'px'
			$scope.leftval=(Math.round(canvas.height))+'px'
			$scope.Opacity=options.target.opacity
			$scope.$apply();
			break;
			case 'image':
			$('#shapeoption').hide()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.Opacity=options.target.opacity
				// $scope.fillselectedcolor=options.target.fill
				// $scope.bordeselectedcolor=options.target.stroke
				// $scope.topval=Math.round(options.target.top)+'px'
				// $scope.leftval=(Math.round(options.target.left)) - 360 +'px'
				$scope.$apply();
				break;
				case 'triangle':
				$('#shapeoption').show()
				$('#Entertext').hide()
				$scope.texdisabled=true
				$scope.fillselectedcolor=options.target.fill
				$scope.bordeselectedcolor=options.target.stroke
				$scope.topval=Math.round(canvas.height+25)+'px'
				$scope.leftval=(Math.round(canvas.height))+'px'
				$scope.Opacity=options.target.opacity
				$scope.$apply();
				break;
				case 'textbox':
				fabric.log('JSON without default values: ',canvas.getObjects())
				$('#Entertext').show()
				$('#shapeoption').hide()
				options.target.setControlsVisibility({
					mt: false, mb: false, ml: true, mr: true, bl: false,br: false, tl: false, tr: false,mtr: true, 
				});
				$scope.myfont=options.target.fontFamily
				$scope.myfontSize=options.target.fontSize
				$scope.texdisabled=false
				$scope.textselectedcolor=options.target.fill
				$scope.textval=options.target.text
				$scope.topval=Math.round(options.target.top)+'px'
				$scope.leftval=(Math.round(options.target.left)) - 195 +'px'
				$scope.Opacity=options.target.opacity
				if (options.target.top < 20 || options.target.left < 20 || options.target.top+(options.target.height*options.target.scaleY) > canvasback.height-25 || options.target.left+(options.target.width*options.target.scaleX) > canvasback.width-25) {
					var leftposition = (options.target.left < 0) ? options.target.left = 0 : options.target.left;
					var topposition = (options.target.top < 0) ? options.target.top = 0 : options.target.top;
					$scope.alerta=false
					$scope.alertatop=topposition-25+'px'
					$scope.alertaleft=leftposition+'px'
				}else{
					$scope.alerta=true
				}
				$scope.$apply();
				break;
				default:
				$('#shapeoption').hide()
				$('#Entertext').hide()
				$scope.texdisabled=true
				$scope.Opacity=1
				$scope.$apply();
			}
		} else {
			
			$('#shapeoption').hide()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.Opacity=1
			$scope.$apply();

		}
		var x = document.getElementById("cutipe");
		Bsquare = new fabric.Rect({ 
			width: canvasback.width-50,
			height: canvasback.height-50,
			left: 25,
			top: 25,
			fill: 'rgba(154,205,50,0)',
			strokeDashArray: [4, 4],
			stroke: '#007bff',
			strokeWidth: 1,
			selectable: false,
			id: 5986,
			cornerColor: '#ff46b4'
		});

		var ellipse = new fabric.Ellipse({
			left: 25,
			top: 25,
			rx: canvasback.width / 2 - 25,
			ry: canvasback.height / 2 - 25,
			fill: 'rgba(154,205,50,0)',
			strokeDashArray: [4, 4],
			stroke: '#007bff',
			strokeWidth: 1,
			selectable: false,
			id: 5986,
			cornerColor: '#ff46b4'
		});
		// cutsquare = new fabric.Rect({ 
		// 	width: canvasback.width-30,
		// 	height: canvasback.height-30,
		// 	left: 15,
		// 	top: 15,
		// 	fill: 'rgba(154,205,50,0)',
		// 	strokeDashArray: [9, 4],
		// 	stroke: 'red',
		// 	strokeWidth: 2,
		// 	selectable: false,
		// 	id: 5987,
		// 	cornerColor: '#ff46b4'
		// });
		Bcircle = new fabric.Circle({
			radius: canvasback.width / 2 - 25,
			fill: 'rgba(154,205,50,0)',
			strokeDashArray: [4, 4],
			stroke: '#007bff',
			selectable: false,
			left: 25, 
			top: 25,
			id: 5986,
			cornerColor: '#ff46b4'
		});
		// cutcircle = new fabric.Circle({
		// 	radius: canvasback.width / 2 - 15,
		// 	fill: 'rgba(154,205,50,0)',
		// 	strokeDashArray: [4, 4],
		// 	stroke: 'red',
		// 	selectable: false,
		// 	left: 15, 
		// 	top: 15,
		// 	id: 5987,
		// 	cornerColor: '#ff46b4'
		// });
		// fabric.Image.fromURL('img/tijeras-01.svg', function(img) {
		// 	var cutscissorsImg = img.set({ width:250,height:250, left: canvasback.width / 2-15, top: 2,id: 5988,selectable: false,}).scale(0.15);
		// 	canvasback.add(cutscissorsImg)
		// });
		if (x.value == 3) {
			canvasback.add(Bcircle);
		} else if (x.value == 1) {
			canvasback.add(Bsquare)
		} else if (x.value == 4) {
			canvasback.add(Bsquare)
		} else if (x.value == 6) {
			canvasback.add(ellipse)
		} 
		else {
			canvasback.add(Bsquare)
		}
		$scope.keyover=true
		$scope.scissors=false
		$('#safelines').show()
		$scope.safelinetop='-11px'
		$scope.safelineleft=canvasback.width/4+'px'
		$scope.canvashadow='0px 0px 0px 0px'
		$scope.cutbackground=canvasback.backgroundColor+'c9'
		$scope.canvasborder='1px red dotted'
		$scope.$apply()
		if (golbal_dropper) {
			$('.upper-canvas').removeClass('dropper')
			golbal_dropper=false
			$scope.pickcolor=true
		}
	});
canvas.on('mouse:down', function(options) {
	console.log(options.target)
	if (options.target!=null) {
		$('#quicklayer div').removeClass('quicklayerselec')
		$('#'+options.target.id+'').addClass('quicklayerselec')
		options.target.hasControls = true;
		options.target.set('cornerColor', '#ff46b4');
		options.target.set('borderColor', '#ff46b4');
		options.target.set('cornerSize', 6);
		options.target.set('transparentCorners', false);
		switch(options.target.type) {
			case 'activeSelection':
			$('#shapeoption').show()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.fillselectedcolor=options.target.fill
			$scope.bordeselectedcolor=options.target.stroke
			$scope.topval=Math.round(canvas.height+25)+'px'
			$scope.leftval=(Math.round(canvas.height))+'px'
			$scope.Opacity=options.target.opacity
			$scope.$apply();
			break;
			case 'group':
			$('#shapeoption').show()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.fillselectedcolor=options.target.fill
			$scope.bordeselectedcolor=options.target.stroke
			$scope.topval=Math.round(canvas.height+25)+'px'
			$scope.leftval=(Math.round(canvas.height))+'px'
			$scope.Opacity=options.target.opacity
			$scope.$apply();
			break;
			case 'path':
			$('#shapeoption').show()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.fillselectedcolor=options.target.fill
			$scope.bordeselectedcolor=options.target.stroke
			$scope.topval=Math.round(canvas.height+25)+'px'
			$scope.leftval=(Math.round(canvas.height))+'px'
			$scope.Opacity=options.target.opacity
			$scope.$apply();
			break;
			case 'rect':
			$('#shapeoption').show()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.fillselectedcolor=options.target.fill
			$scope.bordeselectedcolor=options.target.stroke
			$scope.topval=Math.round(canvas.height+25)+'px'
			$scope.leftval=(Math.round(canvas.height))+'px'
			$scope.Opacity=options.target.opacity
			$scope.$apply();
			break;
			case 'line':
			$('#shapeoption').show()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.fillselectedcolor=options.target.fill
			$scope.bordeselectedcolor=options.target.stroke
			$scope.topval=Math.round(canvas.height+25)+'px'
			$scope.leftval=(Math.round(canvas.height))+'px'
			$scope.Opacity=options.target.opacity
			$scope.$apply();
			break;
			case 'circle':
			$('#shapeoption').show()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.fillselectedcolor=options.target.fill
			$scope.bordeselectedcolor=options.target.stroke
			$scope.topval=Math.round(canvas.height+25)+'px'
			$scope.leftval=(Math.round(canvas.height))+'px'
			$scope.Opacity=options.target.opacity
			$scope.$apply();
			break;
			case 'image':
			$('#shapeoption').hide()
			$('#Entertext').hide()
			$scope.texdisabled=true
			$scope.Opacity=options.target.opacity
				// $scope.fillselectedcolor=options.target.fill
				// $scope.bordeselectedcolor=options.target.stroke
				// $scope.topval=Math.round(options.target.top)+'px'
				// $scope.leftval=(Math.round(options.target.left)) - 360 +'px'
				$scope.$apply();
				break;
				case 'triangle':
				$('#shapeoption').show()
				$('#Entertext').hide()
				$scope.texdisabled=true
				$scope.fillselectedcolor=options.target.fill
				$scope.bordeselectedcolor=options.target.stroke
				$scope.topval=Math.round(canvas.height+25)+'px'
				$scope.leftval=(Math.round(canvas.height))+'px'
				$scope.Opacity=options.target.opacity
				//console.log(options.target)
				$scope.$apply();
				break;
				case 'textbox':
				$('#Entertext').show()
				$('#shapeoption').hide()
				options.target.setControlsVisibility({
					mt: false, mb: false, ml: true, mr: true, bl: false,br: false, tl: false, tr: false,mtr: true, 
				});
				$scope.myfont=options.target.fontFamily
				$scope.myfontSize=options.target.fontSize
				$scope.texdisabled=false
				$scope.textselectedcolor=options.target.fill
				$scope.textval=options.target.text
				$scope.topval=Math.round(options.target.top)+'px'
				$scope.leftval=(Math.round(options.target.left)) - 195 +'px'
				$scope.Opacity=options.target.opacity
				//console.log(options.target.opacity)
				if (options.target.top < 20 || options.target.left < 20 || options.target.top+(options.target.height*options.target.scaleY) > canvas.height-25 || options.target.left+(options.target.width*options.target.scaleX) > canvas.width-25) {
					var leftposition = (options.target.left < 0) ? options.target.left = 0 : options.target.left;
					var topposition = (options.target.top < 0) ? options.target.top = 0 : options.target.top;
					$scope.alerta=false
					$scope.alertatop=topposition-25+'px'
					$scope.alertaleft=leftposition+'px'
				}else{
					$scope.alerta=true
				}

				$scope.$apply();
				break;
				default:
				$('#shapeoption').hide()
				$('#Entertext').hide()
				$scope.texdisabled=true
				$scope.Opacity=1
				$scope.$apply();
			}
		} else {
			$('#shapeoption').hide()
			$('#Entertext').hide()
			
			$scope.texdisabled=true
			$scope.Opacity=1
			$scope.$apply();
		}
		var x = document.getElementById("cutipe");
		Bsquare = new fabric.Rect({ 
			width: canvas.width-50,
			height: canvas.height-50,
			left: 25,
			top: 25,
			fill: 'rgba(154,205,50,0)',
			strokeDashArray: [4, 4],
			stroke: '#007bff',
			strokeWidth: 1,
			selectable: false,
			id: 5986,
			cornerColor: '#ff46b4'
		});
		var ellipse = new fabric.Ellipse({
			left: 25,
			top: 25,
			rx: canvas.width / 2 - 25,
			ry: canvas.height / 2 - 25,
			fill: 'rgba(154,205,50,0)',
			strokeDashArray: [4, 4],
			stroke: '#007bff',
			strokeWidth: 1,
			selectable: false,
			id: 5986,
			cornerColor: '#ff46b4'
		});
		Bcircle = new fabric.Circle({
			radius: canvas.width / 2 - 25,
			fill: 'rgba(154,205,50,0)',
			strokeDashArray: [4, 4],
			stroke: '#007bff',
			selectable: false,
			left: 25, 
			top: 25,
			id: 5986,
			cornerColor: '#ff46b4'
		});
		if (x.value == 3) {
			canvas.add(Bcircle);
		} else if (x.value == 1) {
			canvas.add(Bsquare)
		} else if (x.value == 4) {
			canvas.add(Bsquare)
		}else if (x.value == 6){
			canvas.add(ellipse)
		} else {
			canvas.add(Bsquare)
		}
		$scope.keyover=true
		$scope.scissors=false
		$('#safelines').show()
		$scope.safelinetop='-11px'
		$scope.safelineleft=canvas.width/6+'px'
		$scope.canvashadow='0px 0px 0px 0px'
		$scope.cutbackground=canvas.backgroundColor+'c9'	
		$scope.canvasborder='1px red dotted'
		$scope.$apply()
		if (golbal_dropper) {
			$('.upper-canvas').removeClass('dropper')
			golbal_dropper=false
			$scope.pickcolor=true
		}
	});

canvasback.on('mouse:up', function(options) {
	$('.outline1').hide()
	$('.outline2').hide()
	$('#safelines').hide()
	$scope.scissors=true
	$scope.backgroundCol='rgb(248, 249, 250,1)'
	$scope.canvashadow='5px 5px 6px -6px'
	$scope.cutbackground='rgb(248, 249, 250,0)'
	$scope.canvasborder='1px rgba(156, 156, 156, 1) solid'
	$scope.$apply()
	for (var i = 0; i < canvasback.getObjects().length; ++i) { 
		if (canvasback.item(i).id == 5986 || canvasback.item(i).id == 9986) { 	
			canvasback.remove(canvasback.item(i));
		}
	}
});

canvas.on('mouse:up', function(options) {
	$('.outline1').hide()
	$('.outline2').hide()
	$('#safelines').hide()
	$scope.scissors=true
	$scope.backgroundCol='rgb(248, 249, 250,0)'
	$scope.canvashadow='5px 5px 6px -6px'
	$scope.cutbackground='rgb(248, 249, 250,0)'
	$scope.canvasborder='1px rgba(156, 156, 156, 1) solid'
	$scope.$apply()
	for (var i = 0; i < canvas.getObjects().length; ++i) { 
		if (canvas.item(i).id == 5986  || canvas.item(i).id == 9986) { 	
			canvas.remove(canvas.item(i));
		}

	}
});
$scope.handle_targetH=0
$scope.handle_targetW=0
$scope.handle_targetT=0
$scope.handle_targetL=0
canvas.on('mouse:over', function(options) {
	if (options.target!=null) {
		console.log(options.target.top)
		//options.target.set('borderColor', 'red');
		//options.target.hasControls = false;
		//canvas.setActiveObject(options.target);
		//canvas.renderAll()
		 //$scope.handle_targetH=options.target.height * options.target.scaleY+'px'
		 //$scope.handle_targetW=options.target.width * options.target.scaleX+'px'
		 //$scope.handle_targetT=options.target.top+15+'px'
		 //$scope.handle_targetL=options.target.left+15+'px'
		 //$scope.$apply()
		}

    //options.target.setActiveObject()
});
$scope.alertatext=true
$scope.alerta=true
$scope.showalerta = function() {
	if ($scope.alertatext) {
		$scope.alertawidth='215px';
		$scope.alertaheight='85px';
		$scope.alertatext=false
	}else{
		$scope.alertawidth='37px';
		$scope.alertaheight='42px';
		$scope.alertatext=true
	}
	
}
canvas.on('object:moving', function(options) {
	// if (options.target.type=='activeSelection') {
	// 	if (options.target.top < 20 || options.target.left < 20 || options.target.top+(options.target.height*options.target.scaleY) > canvas.height-25 || options.target.left+(options.target.width*options.target.scaleX) > canvas.width-25) {
	// 		var leftposition = (options.target.left < 0) ? options.target.left = 0 : options.target.left;
	// 		var topposition = (options.target.top < 0) ? options.target.top = 0 : options.target.top;
	// 		$scope.alerta=false
	// 		$scope.alertatop=topposition-25+'px'
	// 		$scope.alertaleft=leftposition+'px'
	// 	}else{
	// 		$scope.alerta=true
	// 	}
	// }
	// if (options.target.type=='textbox') {
	//     if (options.target.top < 25 ) {
	// 	    options.target.top = 25}
	//     if (options.target.left < 25) {
	// 	    options.target.left = 25}
	// 	if (options.target.top+(options.target.height*options.target.scaleY) > canvas.height-25 ) {
	// 	    options.target.top = (canvas.height)-(options.target.height*options.target.scaleY)-25}
	//     if (options.target.left+(options.target.width*options.target.scaleX) > canvas.width-25) {
	// 	    options.target.left = (canvas.width)-(options.target.width*options.target.scaleY)-25}
	// }
	$('#shapeoption').hide()
	$('#Entertext').hide()
	// alinglineH = new fabric.Line([10, 10, canvas.width*2, 10], { 
	// 	left: 0,
	// 	top: options.target.top,
	// 	fill: 'rgba(154,205,50,0)',
	// 	stroke: '#f4005b',
	// 	strokeWidth: 1,
	// 	id:9986
	// });
	// alinglineV = new fabric.Line([10, 10,10, canvas.width*2], {
	// 	left: options.target.left,
	// 	top: 0,
	// 	fill: 'rgba(154,205,50,0)',
	// 	stroke: '#f4005b',
	// 	strokeWidth: 1,
	// 	id:9986
	// });
	// canvas.add(alinglineV);
	// canvas.add(alinglineH);
	setTimeout(function() {	
		for (var i = 0; i < canvas.getObjects().length; ++i) { 
			if (canvas.item(i).id == 9986) { 	
				canvas.remove(canvas.item(i));
			}

		}
	}, 50);

});

canvasback.on('object:moving', function(options){
	// if (options.target.type=='activeSelection') {
	// 	if (options.target.top < 20 || options.target.left < 20 || options.target.top+(options.target.height*options.target.scaleY) > canvasback.height-25 || options.target.left+(options.target.width*options.target.scaleX) > canvasback.width-25) {
	// 		var leftposition = (options.target.left < 0) ? options.target.left = 0 : options.target.left;
	// 		var topposition = (options.target.top < 0) ? options.target.top = 0 : options.target.top;
	// 		$scope.alerta=false
	// 		$scope.alertatop=topposition-25+'px'
	// 		$scope.alertaleft=leftposition+'px'
	// 	}else{
	// 		$scope.alerta=true
	// 	}
	// }
	// if (options.target.type=='textbox') {
	//     if (options.target.top < 25 ) {
	// 	    options.target.top = 25}
	//     if (options.target.left < 25) {
	// 	    options.target.left = 25}
	// 	if (options.target.top+(options.target.height*options.target.scaleY) > canvasback.height-25 ) {
	// 	    options.target.top = (canvasback.height)-(options.target.height*options.target.scaleY)-25}
	//     if (options.target.left+(options.target.width*options.target.scaleX) > canvasback.width-25) {
	// 	    options.target.left = (canvasback.width)-(options.target.width*options.target.scaleY)-25}

	// }
	$('#shapeoption').hide()
	$('#Entertext').hide()
	// alinglineH = new fabric.Line([10, 10, canvasback.width*2, 10], { 
	// 	left: 0,
	// 	top: options.target.top,
	// 	fill: 'rgba(154,205,50,0)',
	// 	stroke: '#f4005b',
	// 	strokeWidth: 1,
	// 	id:9986
	// });
	// alinglineV = new fabric.Line([10, 10,10, canvasback.width*2], {
	// 	left: options.target.left,
	// 	top: 0,
	// 	fill: 'rgba(154,205,50,0)',
	// 	stroke: '#f4005b',
	// 	strokeWidth: 1,
	// 	id:9986
	// });
	// canvasback.add(alinglineV);
	// canvasback.add(alinglineH);
	setTimeout(function() {	
		for (var i = 0; i < canvasback.getObjects().length; ++i) { 
			if (canvasback.item(i).id == 9986) { 	
				canvasback.remove(canvasback.item(i));
			}

		}
	}, 50);

});


canvas.on('mouse:move', function(e) {
	if (golbal_dropper) {
		$scope.pickcolor=false
		var mouse = canvas.getPointer(e.e);
		var x = parseInt(mouse.x);
		var y = parseInt(mouse.y);
		var px = canvas.getContext().getImageData(x, y, 1, 1).data;
		$scope.pos_x=x+50+'px'
		$scope.pos_y=y-25+'px'
		$scope.pos_color='rgb(' + px[0] + ',' + px[1] + ',' + px[2] +','+ px[3] +')'
		$scope.$apply()
		switch($scope.pikertype) {
			case 1:
			$scope.changecolor($scope.pos_color)
			break;
			case 2:
			$scope.changecolorborder($scope.pos_color)
			break;
			case 3:
			$scope.changecolortext($scope.pos_color)
			break;
			case 4:
			$scope.changecolortext($scope.pos_color)
			break;
			default:
		}
	}	
});
canvasback.on('mouse:move', function(e) {
	if (golbal_dropper) {
		$scope.pickcolor=false
		var mouse = canvasback.getPointer(e.e);
		var x = parseInt(mouse.x);
		var y = parseInt(mouse.y);
		var px = canvasback.getContext().getImageData(x, y, 1, 1).data;
		$scope.pos_x=x+50+'px'
		$scope.pos_y=y-25+'px'
		$scope.pos_color='rgb(' + px[0] + ',' + px[1] + ',' + px[2] +','+ px[3] +')'
		$scope.$apply()
		switch($scope.pikertype) {
			case 1:
			$scope.changecolor($scope.pos_color)
			break;
			case 2:
			$scope.changecolorborder($scope.pos_color)
			break;
			case 3:
			$scope.changecolortext($scope.pos_color)
			break;
			case 4:
			$scope.changecolortext($scope.pos_color)
			break;
			default:
		}
	}	
});


$scope.canvassize = function() {
	if ($scope.cvside) {
		$scope.canvasX=canvas.getActiveObject().width * canvas.getActiveObject().scaleX
		$scope.canvasY=canvas.getActiveObject().height * canvas.getActiveObject().scaleY
		canvas.renderAll();
	}else{
		$scope.canvasX=canvasback.getActiveObject().width * canvasback.getActiveObject().scaleX
		$scope.canvasY=canvasback.getActiveObject().height * canvasback.getActiveObject().scaleY
		canvasback.renderAll();
	}
}
// $scope.changezoom = function(i) {
// 	console.log('zoom val is:  '+i)
// 	zoomLevel = i;
// 	canvas.setZoom(1.1);
// 	canvas.setDimensions({
// 		width: canvas.width * 1.1,
// 		height: canvas.height * 1.1
// 	});
// }
$scope.showentertext = function() {
	$scope.Entertext=false
}

canvas.on('object:scaling', function(options) {
 //    if (options.target.type=='activeSelection') {
	// 	if (options.target.top < 20 || options.target.left < 20 || options.target.top+(options.target.height*options.target.scaleY) > canvas.height-25 || options.target.left+(options.target.width*options.target.scaleX) > canvas.width-25) {
	// 		var leftposition = (options.target.left < 0) ? options.target.left = 0 : options.target.left;
	// 		var topposition = (options.target.top < 0) ? options.target.top = 0 : options.target.top;
	// 		$scope.alerta=false
	// 		$scope.alertatop=topposition-25+'px'
	// 		$scope.alertaleft=leftposition+'px'
	// 	}else{
	// 		$scope.alerta=true
	// 	}
	// }
	// if (options.target.type=='textbox') {
	//     if (options.target.top < 25 ) {
	// 	    options.target.top = 25}
	//     if (options.target.left < 25) {
	// 	    options.target.left = 25}
	// 	if (options.target.top+(options.target.height*options.target.scaleY) > canvas.height-25 ) {
	// 	    options.target.top = (canvas.height)-(options.target.height*options.target.scaleY)-25}
	//     if (options.target.left+(options.target.width*options.target.scaleX) > canvas.width-25) {
	// 	    options.target.left = (canvas.width)-(options.target.width*options.target.scaleY)-25}
	// }

	
	$scope.canvassize()	
	$('#shapeoption').hide()
	$('#Entertext').hide()
	$('.outline1').show()
	$('.outline2').show()
	console.log(((canvas.getActiveObject().width * canvas.getActiveObject().scaleX)/2)/96+' x '+((canvas.getActiveObject().height * canvas.getActiveObject().scaleY)/2)/96);
	$scope.outlinetop=parseFloat(((canvas.getActiveObject().width * canvas.getActiveObject().scaleX)/2)/96).toFixed(2)
	$scope.outlinerigth=parseFloat(((canvas.getActiveObject().height * canvas.getActiveObject().scaleY)/2)/96).toFixed(2)
	$scope.outlinetopval=canvas.getActiveObject().top-25+'px'
	$scope.outlineleftval=canvas.getActiveObject().left+((canvas.getActiveObject().width * canvas.getActiveObject().scaleX)/2)+'px'
	$scope.outline2topval=canvas.getActiveObject().top+((canvas.getActiveObject().height * canvas.getActiveObject().scaleY)/2)+'px'
	$scope.outline2leftval=canvas.getActiveObject().left+((canvas.getActiveObject().width * canvas.getActiveObject().scaleX)+20)+'px'
	$scope.$apply()
});

canvasback.on('object:scaling', function(options) {
	// if (options.target.type=='activeSelection') {
	// 	if (options.target.top < 20 || options.target.left < 20 || options.target.top+(options.target.height*options.target.scaleY) > canvasback.height-25 || options.target.left+(options.target.width*options.target.scaleX) > canvasback.width-25) {
	// 		var leftposition = (options.target.left < 0) ? options.target.left = 0 : options.target.left;
	// 		var topposition = (options.target.top < 0) ? options.target.top = 0 : options.target.top;
	// 		$scope.alerta=false
	// 		$scope.alertatop=topposition-25+'px'
	// 		$scope.alertaleft=leftposition+'px'
	// 	}else{
	// 		$scope.alerta=true
	// 	}
	// }
	// if (options.target.type=='textbox') {
	//     if (options.target.top < 25 ) {
	// 	    options.target.lockScalingY = true}
	//     if (options.target.left < 25) {
	// 	    options.target.left = 25}
	// 	if (options.target.top+(options.target.height*options.target.scaleY) > canvasback.height-25 ) {
	// 	    options.target.top = (canvasback.height)-(options.target.height*options.target.scaleY)-25}
	//     if (options.target.left+(options.target.width*options.target.scaleX) > canvasback.width-25) {
	// 	    options.target.left = (canvasback.width)-(options.target.width*options.target.scaleY)-25}

	// }
	$scope.canvassize()	
	$('#shapeoption').hide()
	$('#Entertext').hide()
	$('.outline1').show()
	$('.outline2').show()
	console.log(((canvasback.getActiveObject().width * canvasback.getActiveObject().scaleX)/2)/96+' x '+((canvasback.getActiveObject().height * canvasback.getActiveObject().scaleY)/2)/96);
	$scope.outlinetop=parseFloat(((canvasback.getActiveObject().width * canvasback.getActiveObject().scaleX)/2)/96).toFixed(2)
	$scope.outlinerigth=parseFloat(((canvasback.getActiveObject().height * canvasback.getActiveObject().scaleY)/2)/96).toFixed(2)
	$scope.outlinetopval=canvasback.getActiveObject().top-25+'px'
	$scope.outlineleftval=canvasback.getActiveObject().left+((canvasback.getActiveObject().width * canvasback.getActiveObject().scaleX)/2)+'px'
	$scope.outline2topval=canvasback.getActiveObject().top+((canvasback.getActiveObject().height * canvasback.getActiveObject().scaleY)/2)+'px'
	$scope.outline2leftval=canvasback.getActiveObject().left+((canvasback.getActiveObject().width * canvasback.getActiveObject().scaleX)+20)+'px'
	$scope.$apply()
});
// canvas.on('mouse:dblclick', function(e) {

// 	e.target.set({ hasControls: true, hasBorders: true, selectable: true });
// 	var type1 =e.target.type
// 	if (type1 ==='textbox') {
// 		canvas.renderAll();
// 		$scope.showentertext()
// 	} 
// });


// canvasback.on('mouse:dblclick', function(e) {

// 	e.target.set({ hasControls: true, hasBorders: true, selectable: true });
// 	var type1 =e.target.type
// 	if (type1 ==='textbox') {
// 		canvasback.renderAll();
// 		$scope.showentertext()

// 	} 
// });


canvas.on("object:added", function (e) {
	if (e.target.id==undefined ) {
		for (var i = 0; i < canvas.getObjects().length; ++i) { 
			if (canvas.item(i).id == 5986 ) { 
				canvas.remove(canvas.item(i));
			}
			if (canvas.item(i).id == 5987 ) {
				canvas.remove(canvas.item(i));
			}
			if (canvas.item(i).id == 5988 ) {
				canvas.remove(canvas.item(i));
			}
		}
		if((_config.undoStatus == false && _config.redoStatus == false)){
			var jsonData        = canvas.toJSON();
			var canvasAsJson        = JSON.stringify(jsonData);
			if(_config.currentStateIndex < _config.canvasState.length-1){
				var indexToBeInserted                  = _config.currentStateIndex+1;
				_config.canvasState[indexToBeInserted] = canvasAsJson;
				var numberOfElementsToRetain           = indexToBeInserted+1;
				_config.canvasState                    = _config.canvasState.splice(0,numberOfElementsToRetain);
			}else{
				_config.canvasState.push(canvasAsJson);
				//console.log(_config.canvasState)
			}
			_config.currentStateIndex = _config.canvasState.length-1;
			if((_config.currentStateIndex == _config.canvasState.length-1) && _config.currentStateIndex != -1){
				//_config.redoButton.disabled= "disabled";
				$scope.redoButton=true
			}
		}
	}

});


canvasback.on("object:added", function (e) {

	if (e.target.id==undefined ) {
		for (var i = 0; i < canvasback.getObjects().length; ++i) { 
			if (canvasback.item(i).id == 5986 ) { 	
				canvasback.remove(canvasback.item(i));
			}
		}
		for (var i = 0; i < canvasback.getObjects().length; ++i) { 
			if (canvasback.item(i).id == 9986) { 	
				canvasback.remove(canvasback.item(i));
			}

		}
		if((_configback.undoStatus == false && _configback.redoStatus == false)){
			var jsonData        = canvasback.toJSON();
			var canvasAsJson        = JSON.stringify(jsonData);
			if(_configback.currentStateIndex < _configback.canvasState.length-1){
				var indexToBeInserted                  = _configback.currentStateIndex+1;
				_configback.canvasState[indexToBeInserted] = canvasAsJson;
				var numberOfElementsToRetain           = indexToBeInserted+1;
				_configback.canvasState                    = _configback.canvasState.splice(0,numberOfElementsToRetain);
			}else{
				_configback.canvasState.push(canvasAsJson);
				//console.log(_config.canvasState)
			}
			_configback.currentStateIndex = _configback.canvasState.length-1;
			if((_configback.currentStateIndex == _configback.canvasState.length-1) && _configback.currentStateIndex != -1){
				//_config.redoButton.disabled= "disabled";
				$scope.redoButton=true
			}
		}
	}

});

canvas.on("object:modified", function (e) {
	for (var i = 0; i < canvas.getObjects().length; ++i) { 
		if (canvas.item(i).id == 5986 ) { 	
			canvas.remove(canvas.item(i));
		}
	}
	if (e.target.id==undefined ) {
		if((_config.undoStatus == false && _config.redoStatus == false)){
			var jsonData        = canvas.toJSON();
			var canvasAsJson        = JSON.stringify(jsonData);
			if(_config.currentStateIndex < _config.canvasState.length-1){
				var indexToBeInserted                  = _config.currentStateIndex+1;
				_config.canvasState[indexToBeInserted] = canvasAsJson;
				var numberOfElementsToRetain           = indexToBeInserted+1;
				_config.canvasState                    = _config.canvasState.splice(0,numberOfElementsToRetain);
			}else{
				_config.canvasState.push(canvasAsJson);
				//console.log(_config.canvasState.length)
			}
			_config.currentStateIndex = _config.canvasState.length-1;
			if((_config.currentStateIndex == _config.canvasState.length-1) && _config.currentStateIndex != -1){
				//_config.redoButton.disabled= "disabled";
				$scope.redoButton=true
			}
		}
	}
});

canvasback.on("object:modified", function (e) {
	for (var i = 0; i < canvasback.getObjects().length; ++i) { 
		if (canvasback.item(i).id == 5986 ) { 	
			canvasback.remove(canvasback.item(i));
		}
	}
	if (e.target.id==undefined ) {
		if((_configback.undoStatus == false && _configback.redoStatus == false)){
			var jsonData        = canvasback.toJSON();
			var canvasAsJson        = JSON.stringify(jsonData);
			if(_configback.currentStateIndex < _configback.canvasState.length-1){
				var indexToBeInserted                  = _configback.currentStateIndex+1;
				_configback.canvasState[indexToBeInserted] = canvasAsJson;
				var numberOfElementsToRetain           = indexToBeInserted+1;
				_configback.canvasState                    = _configback.canvasState.splice(0,numberOfElementsToRetain);
			}else{
				_configback.canvasState.push(canvasAsJson);
				//console.log(_config.canvasState.length)
			}
			_configback.currentStateIndex = _configback.canvasState.length-1;
			if((_configback.currentStateIndex == _configback.canvasState.length-1) && _configback.currentStateIndex != -1){
				//_config.redoButton.disabled= "disabled";
				$scope.redoButton=true
			}
		}
	}
});

$scope.undo = function(i){
	if ($scope.cvside) {
		if(_config.undoFinishedStatus){
			if(_config.currentStateIndex == -1){
				_config.undoStatus = false;
			}
			else{
				if (_config.canvasState.length >= 1) {
					_config.undoFinishedStatus = 0;
					if(_config.currentStateIndex != 0){
						_config.undoStatus = true;
						canvas.loadFromJSON(_config.canvasState[_config.currentStateIndex-1],function(){
							var jsonData = JSON.parse(_config.canvasState[_config.currentStateIndex-1]);
							canvas.renderAll();
							_config.undoStatus = false;
							_config.currentStateIndex -= 1;
							$scope.undoButton=false
							//_config.undoButton.removeAttribute("disabled");
							if(_config.currentStateIndex !== _config.canvasState.length-1){
								//_config.redoButton.removeAttribute('disabled');
								$scope.redoButton=false
							}
							_config.undoFinishedStatus = 1;
						});
					}
					else if(_config.currentStateIndex == 0){
						canvas.clear();
						_config.undoFinishedStatus = 1;
						$scope.undoButton=true
						$scope.redoButton=false
						//_config.undoButton.disabled= "disabled";
						//_config.redoButton.removeAttribute('disabled');
						_config.currentStateIndex -= 1;
					}
				}
			}
		}
	}else{
		if(_configback.undoFinishedStatus){
			if(_configback.currentStateIndex == -1){
				_configback.undoStatus = false;
			}
			else{
				if (_configback.canvasState.length >= 1) {
					_configback.undoFinishedStatus = 0;
					if(_configback.currentStateIndex != 0){
						_configback.undoStatus = true;
						canvasback.loadFromJSON(_configback.canvasState[_configback.currentStateIndex-1],function(){
							var jsonData = JSON.parse(_configback.canvasState[_configback.currentStateIndex-1]);
							canvasback.renderAll();
							_configback.undoStatus = false;
							_configback.currentStateIndex -= 1;
							$scope.undoButton=false
							//_config.undoButton.removeAttribute("disabled");
							if(_configback.currentStateIndex !== _configback.canvasState.length-1){
								//_config.redoButton.removeAttribute('disabled');
								$scope.redoButton=false
							}
							_configback.undoFinishedStatus = 1;
						});
					}
					else if(_configback.currentStateIndex == 0){
						canvasback.clear();
						_configback.undoFinishedStatus = 1;
						$scope.undoButton=true
						$scope.redoButton=false
						//_config.undoButton.disabled= "disabled";
						//_config.redoButton.removeAttribute('disabled');
						_configback.currentStateIndex -= 1;
					}
				}
			}
		}

	}

}
$scope.redo = function(i){
	if ($scope.cvside) {
		if(_config.redoFinishedStatus){
			if((_config.currentStateIndex == _config.canvasState.length-1) && _config.currentStateIndex != -1){
				//_config.redoButton.disabled= "disabled";
				$scope.redoButton=true
			}else{
				if (_config.canvasState.length > _config.currentStateIndex && _config.canvasState.length != 0){
					_config.redoFinishedStatus = 0;
					_config.redoStatus = true;
					canvas.loadFromJSON(_config.canvasState[_config.currentStateIndex+1],function(){
						var jsonData = JSON.parse(_config.canvasState[_config.currentStateIndex+1]);
						canvas.renderAll();
						_config.redoStatus = false;
						_config.currentStateIndex += 1;
						if(_config.currentStateIndex != -1){
							$scope.undoButton=false
							//_config.undoButton.removeAttribute('disabled');
						}
						_config.redoFinishedStatus = 1;
						if((_config.currentStateIndex == _config.canvasState.length-1) && _config.currentStateIndex != -1){
							//_config.redoButton.disabled= "disabled";
							$scope.redoButton=true
						}
					});
				}
			}
		}
	}else{
		if(_configback.redoFinishedStatus){
			if((_configback.currentStateIndex == _configback.canvasState.length-1) && _configback.currentStateIndex != -1){
				//_config.redoButton.disabled= "disabled";
				$scope.redoButton=true
			}else{
				if (_configback.canvasState.length > _configback.currentStateIndex && _configback.canvasState.length != 0){
					_configback.redoFinishedStatus = 0;
					_configback.redoStatus = true;
					canvasback.loadFromJSON(_configback.canvasState[_configback.currentStateIndex+1],function(){
						var jsonData = JSON.parse(_configback.canvasState[_configback.currentStateIndex+1]);
						canvasback.renderAll();
						_configback.redoStatus = false;
						_configback.currentStateIndex += 1;
						if(_configback.currentStateIndex != -1){
							$scope.undoButton=false
							//_config.undoButton.removeAttribute('disabled');
						}
						_configback.redoFinishedStatus = 1;
						if((_configback.currentStateIndex == _configback.canvasState.length-1) && _configback.currentStateIndex != -1){
							//_config.redoButton.disabled= "disabled";
							$scope.redoButton=true
						}
					});
				}
			}
		}
	}
}

$scope.changlayer = function(i){
	if ($scope.cvside) {
		switch(i) {
			case 'up':
			canvas.getActiveObject().bringForward();
			canvas.renderAll();
			break;
			case 'down':
			canvas.getActiveObject().sendBackwards();
			canvas.renderAll();
			break;
			default:
		}
	}else{
		switch(i) {
			case 'up':
			canvasback.getActiveObject().bringForward();
			canvasback.renderAll();
			break;
			case 'down':
			canvasback.getActiveObject().sendBackwards();
			canvasback.renderAll();
			break;
			default: 
		}	
	}	
}

$scope.Aling = function(i) {
	if ($scope.cvside) {
		switch(i) {
			case 'left':
			canvas.getActiveObject().set("left", 35);
			canvas.getActiveObject().setCoords();
			canvas.renderAll();
			break;
			case 'Center':
			canvas.getActiveObject().set("left", (canvas.width/2) - ((canvas.getActiveObject().width * canvas.getActiveObject().scaleX)/2));
			canvas.getActiveObject().setCoords();
			canvas.renderAll();
			break;
			case 'Right':
			canvas.getActiveObject().set("left", canvas.width - (canvas.getActiveObject().width * canvas.getActiveObject().scaleX) - 35);
			canvas.getActiveObject().setCoords();
			canvas.renderAll();

			case 'Top':
			canvas.getActiveObject().set("top", 35);
			canvas.getActiveObject().setCoords();
			canvas.renderAll();
			break;
			case 'Middle':
			canvas.getActiveObject().set("top", (canvas.height/2) - ((canvas.getActiveObject().height * canvas.getActiveObject().scaleX)/2));
			canvas.getActiveObject().setCoords();
			canvas.renderAll();
			break;
			case 'Bottom':
			canvas.getActiveObject().set("top", canvas.height - (canvas.getActiveObject().height * canvas.getActiveObject().scaleY) - 35);
			canvas.getActiveObject().setCoords();
			canvas.renderAll();
			break;
			default:
			break;
		}5
	}else{
		switch(i) {
			case 'left':
			canvasback.getActiveObject().set("left", 35);
			canvasback.getActiveObject().setCoords();
			canvasback.renderAll();
			break;
			case 'Center':
			canvasback.getActiveObject().set("left", (canvasback.width/2) - ((canvasback.getActiveObject().width * canvasback.getActiveObject().scaleX)/2));
			canvasback.getActiveObject().setCoords();
			canvasback.renderAll();
			break;
			case 'Right':
			canvasback.getActiveObject().set("left", canvasback.width - (canvasback.getActiveObject().width * canvasback.getActiveObject().scaleX) - 35);
			canvasback.getActiveObject().setCoords();
			canvasback.renderAll();

			case 'Top':
			canvasback.getActiveObject().set("top", 35);
			canvasback.getActiveObject().setCoords();
			canvasback.renderAll();
			break;
			case 'Middle':
			canvasback.getActiveObject().center();
			canvasback.renderAll();
			break;
			case 'Bottom':
			canvasback.getActiveObject().set("top", canvasback.height - (canvasback.getActiveObject().height * canvasback.getActiveObject().scaleY) - 35);
			canvasback.getActiveObject().setCoords();
			canvasback.renderAll();
			break;
			default: 
			break;
		}
	}
}
var prev_zoom = 1;
$scope.Zoom = function(argument) {
	var SCALE_FACTOR=argument;		
	canvas.setHeight(canvas.height * SCALE_FACTOR);
	canvas.setWidth(canvas.width * SCALE_FACTOR);
	canvas.calcOffset();					
	var objects = canvas.getObjects();
	(jQuery).each(objects,function(i,obj){
		console.log(obj)
		obj.scaleX=obj.scaleX/prev_zoom*SCALE_FACTOR;
		obj.scaleY=obj.scaleY/prev_zoom*SCALE_FACTOR;
		obj.left=obj.left/prev_zoom*SCALE_FACTOR;
		obj.top=obj.top/prev_zoom*SCALE_FACTOR;
		obj.setCoords();
	});
	canvas.renderAll();
	prev_zoom = SCALE_FACTOR;
}
	


$scope.changesize = function(i){
	if ($scope.cvside) {
		canvas.getActiveObject().set("fontSize", Math.round(i*1.333333));
		canvas.renderAll();
	}else{
		canvasback.getActiveObject().set("fontSize", Math.round(i*1.333333));
		canvasback.renderAll();
	}
}

$scope.changecolortext = function(fill) {
	if ($scope.cvside) {
		if (canvas.getActiveObject()._objects==undefined) {
			canvas.getActiveObject().set("fill", fill);
			canvas.renderAll();
			golbal_color=""
		}else{
			for (var i = canvas.getActiveObject()._objects.length - 1; i >= 0; i--) {
				canvas.getActiveObject()._objects[i].set("fill", fill);
				canvas.renderAll();
				golbal_color=""
			}
			
		}
		
	}else{
		if (canvasback.getActiveObject()._objects==undefined) {
			canvasback.getActiveObject().set("fill", fill);
			canvasback.renderAll();
			golbal_color=""
		}else{
			for (var i = canvasback.getActiveObject()._objects.length - 1; i >= 0; i--) {
				canvasback.getActiveObject()._objects[i].set("fill", fill);
				canvasback.renderAll();
				golbal_color=""
			}
			
		}
	}
}

$scope.changecolorborder = function(fill) {
	if ($scope.cvside) {
		if (canvas.getActiveObject()._objects==undefined) {
			canvas.getActiveObject().set("stroke", fill);
			canvas.renderAll();
			golbal_color=""
		}else{
			for (var i = canvas.getActiveObject()._objects.length - 1; i >= 0; i--) {
				canvas.getActiveObject()._objects[i].set("stroke", fill);
				canvas.renderAll();
				golbal_color=""
			}
			
		}
		
	}else{
		if (canvasback.getActiveObject()._objects==undefined) {
			canvasback.getActiveObject().set("stroke", fill);
			canvasback.renderAll();
			golbal_color=""
		}else{
			for (var i = canvasback.getActiveObject()._objects.length - 1; i >= 0; i--) {
				canvasback.getActiveObject()._objects[i].set("stroke", fill);
				canvasback.renderAll();
				golbal_color=""
			}
			
		}
	}
}

$scope.changestroke = function(stroke){
	if ($scope.cvside) {
		if (canvas.getActiveObject()._objects==undefined) {
			canvas.getActiveObject().set("strokeWidth", stroke);
			canvas.renderAll();
		}else{
			for (var i = canvas.getActiveObject()._objects.length - 1; i >= 0; i--) {
				canvas.getActiveObject()._objects[i].set("strokeWidth", stroke);
				canvas.renderAll();
			}
		}
		
	}else{
		if (canvasback.getActiveObject()._objects==undefined) {
			canvasback.getActiveObject().set("strokeWidth", stroke);
			canvasback.renderAll();
		}else{
			for (var i = canvasback.getActiveObject()._objects.length - 1; i >= 0; i--) {
				canvasback.getActiveObject()._objects[i].set("strokeWidth", stroke);
				canvasback.renderAll();
			}
		}
	}
} 
$scope.changestrokeweigth = function(h,q,a,j){
	if ($scope.cvside) {
		if (canvas.getActiveObject()._objects==undefined) {
			canvas.getActiveObject().set("strokeDashArray", [h,q,a,j]);
			canvas.renderAll();
		}else{
			for (var i = canvas.getActiveObject()._objects.length - 1; i >= 0; i--) {
				canvas.getActiveObject()._objects[i].set("strokeDashArray", [h,q,a,j]);
				canvas.renderAll();
			}
		}
	}else{
		if (canvasback.getActiveObject()._objects==undefined) {
			canvasback.getActiveObject().set("strokeDashArray", [h,q,a,j]);
			canvasback.renderAll();
		}else{
			for (var i = canvasback.getActiveObject()._objects.length - 1; i >= 0; i--) {
				canvasback.getActiveObject()._objects[i].set("strokeDashArray", [h,q,a,j]);
				canvasback.renderAll();
			}
		}
		
	}
}




$scope.lock = function(i) {
	if ($scope.cvside) {
		objectolock = canvas.getActiveObject()
		if (objectolock.selectable) {
			objectolock.set({ hasControls: false, hasBorders: false, selectable: false });
			canvas.discardActiveObject()
			canvas.renderAll();
			$scope.reloadquicklayers()
		}else{
			objectolock.set({ hasControls: true, hasBorders: true, selectable: true });
			canvas.renderAll();
			$scope.reloadquicklayers()
		}
	}else{
		objectolock = canvasback.getActiveObject()
		if (objectolock.selectable) {
			objectolock.set({ hasControls: false, hasBorders: false, selectable: false });
			canvasback.discardActiveObject()
			canvasback.renderAll();
			$scope.reloadquicklayers()
		}else{
			objectolock.set({ hasControls: true, hasBorders: true, selectable: true });
			canvasback.renderAll();
			$scope.reloadquicklayers()
		}
	}
}
$scope.changefontStyle = function(i) {
	if ($scope.cvside) {
		var fontstyle=canvas.getActiveObject()
		console.log(fontstyle.underline)
		switch(i) {
			case 'bold':
			if (fontstyle.fontWeight=='bold'){
				canvas.getActiveObject().set("fontWeight", "normal")
				canvas.renderAll();
			}else {
				canvas.getActiveObject().set("fontWeight", i)
				canvas.renderAll();
			}
			break;
			case 'oblique':
			if (fontstyle.fontStyle=='oblique'){
				canvas.getActiveObject().set("fontStyle", "normal")
				canvas.renderAll();
			}else{
				canvas.getActiveObject().set("fontStyle", i)
				canvas.renderAll();
			}
			break;
			case 'underline':
			if (fontstyle.underline==true){
				canvas.getActiveObject().set("underline", false)
				canvas.renderAll();
			}else{
				canvas.getActiveObject().set("underline", true)
				canvas.renderAll();
			}
			break;
			default: 
		}
	}else{
		var fontstyle2=canvasback.getActiveObject()
		switch(i) {
			case 'bold':
			if (fontstyle2.fontWeight=='bold'){
				canvasback.getActiveObject().set("fontWeight", "normal")
				canvasback.renderAll();
			}else {
				canvasback.getActiveObject().set("fontWeight", i)
				canvasback.renderAll();
			}
			break;
			case 'oblique':
			if (fontstyle2.fontStyle=='oblique'){
				canvasback.getActiveObject().set("fontStyle", "normal")
				canvasback.renderAll();
			}else{
				canvasback.getActiveObject().set("fontStyle", i)
				canvasback.renderAll();
			}
			break;
			case 'underline':
			if (fontstyle2.underline==true){
				canvasback.getActiveObject().set("underline", false)
				canvasback.renderAll();
			}else{
				canvasback.getActiveObject().set("underline", true)
				canvasback.renderAll();
			}
			break;
			default: 
		}		
	}
}

$scope.changeopacity = function(i){
	if ($scope.cvside) {
		var opacityval = i
		console.log(opacityval)
		canvas.getActiveObject().set("opacity", opacityval);
		canvas.renderAll()
	}else{
		var opacityval = i
		console.log(opacityval)
		canvasback.getActiveObject().set("opacity", opacityval);
		canvasback.renderAll()
	}
}

$scope.changetext = function(i){
	if ($scope.cvside) {
		canvas.getActiveObject().set("text", i);
		canvas.renderAll();
	}else{
		canvasback.getActiveObject().set("text", i);
		canvasback.renderAll();
	}
}

$scope.changefont = function(i){
	if ($scope.cvside) {
		$scope.myItem=i
		canvas.getActiveObject().set("fontFamily", i);
		canvas.requestRenderAll();
	}else{
		$scope.myItem=i
		canvasback.getActiveObject().set("fontFamily", i);
		canvasback.requestRenderAll();	
	}
}

$scope.grid = function function_name() {
	if ($scope.cvside) {
		for (var i = 0; i < (canvas.width / 50); i++) {
			canvas.add(new fabric.Line([ i * 50, 0, i * 50, canvas.height], { type:'line', stroke: '#ccc', selectable: false }));
			canvas.add(new fabric.Line([ 0, i * 50, canvas.width, i * 50], { type: 'line', stroke: '#ccc', selectable: false }))
		}
	}else{
		for (var i = 0; i < (canvasback.width / 50); i++) {
			canvasback.add(new fabric.Line([ i * 50, 0, i * 50, canvasback.height], { type:'line', stroke: '#ccc', selectable: false }));
			canvasback.add(new fabric.Line([ 0, i * 50, canvasback.width, i * 50], { type: 'line', stroke: '#ccc', selectable: false }))
		}	
	}
}
$scope.iconsurl = []
$scope.callicons = function (url) {
	//console.log(url.icons)
	$scope.namefolderico= url.icons
	var icondata = new FormData();
	icondata.append('name', url.icons);
	$.ajaxSetup({
		headers: {
			'X-CSRF-Token': $('meta[name=_token]').attr('content')
		}
	});
	$.ajax({
            url: 'icons', // point to server-side PHP script
            data: icondata,
            type: 'POST',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function(data) {       
            	$scope.iconsurl = data.success
            	// $scope.uploadimgurllist = data.user_imgs
            	console.log(data.success)
            	// $("#uploadFile").val('');
            	// $('#image_preview').append("");   
            	$scope.$apply()
            }
        });
}

$scope.deleteImg = function (i,url) {
	//console.log(i)
	$.ajax({
            url: 'deleteimg', // point to server-side PHP script
            data: {id:i,name:url},
            type: 'get',
            success: function(data) {       
            	$scope.uploadimgurl = data.url
            	$scope.uploadimgurllist = data.user_imgs
            	console.log(data) 
            	$scope.$apply()
            }
        });
}
$scope.preview = function() {  
	if (!fabric.Canvas.supports('toDataURL')) {
		alert('This browser doesn\'t provide means to serialize canvas to an image');
	}
	else {
		$scope.canvasurl=canvas.toDataURL("image/png")
		$scope.canvasbackurl=canvasback.toDataURL("image/png")
	}
}
if ($scope.canvastemplate==null) {
	$scope.canvastemplate=[]
}
$scope.touploadcanvastemplate=[]
$scope.SelctedTemplatename=''
$scope.SelctedTemplateval=false
//$scope.canvastemplate=[]
$scope.editemplate = function(idtemplate,nm,i1,i2) {
	$("#preloader").show();
	$("#pageload").show();
	$scope.SelctedTemplateval=true
	$.ajaxSetup({
		headers: {
			'X-CSRF-Token': $('meta[name=_token]').attr('content')
		}
	});
	$.ajax({
            url: 'BDJsonupload', // point to server-side PHP script
            data: {action:5,id:idtemplate},
            type: 'POST',
            //contentType: false, // The content type used when sending data to the server.
            //cache: false, // To unable request pages to be cached
            //processData: false,
            success: function(data) {   
            	console.log(data.success[0].id) 
            	canvas.loadFromJSON(data.success[0].cv);
            	canvas.renderAll();
            	canvasback.loadFromJSON(data.success[0].cv2);
            	canvasback.renderAll();
            	$scope.SelctedTemplateid=idtemplate
            	$scope.SelctedTemplatename=nm
            	$scope.SelctedTemplateimg1=i1
            	$scope.SelctedTemplateimg2=i2
            	setTimeout(function() {	
            		$("#preloader").hide();
            		$("#pageload").hide();
            	}, 500); 

            }
        });
}
$scope.SelctedTemplate = function(idtemplate,nm,side) {
	console.log(side)
	$("#preloader").show();
	$("#pageload").show();
	$.ajaxSetup({
		headers: {
			'X-CSRF-Token': $('meta[name=_token]').attr('content')
		}
	});
	$.ajax({
            url: 'BDJsonupload', // point to server-side PHP script
            data: {action:5,id:idtemplate},
            type: 'POST',
            success: function(data) {   
            	if (side) {
            		canvas.loadFromJSON(data.success[0].cv);
            		canvas.renderAll();
            		canvasback.loadFromJSON(data.success[0].cv2);
            		canvasback.renderAll();
            		$scope.SelctedTemplateval=false
            	}else{
            		canvasback.loadFromJSON(data.success[0].cv);
            		canvasback.renderAll();
            		canvas.loadFromJSON(data.success[0].cv2);
            		canvas.renderAll();
            		$scope.SelctedTemplateval=false
            	}
            	setTimeout(function() {	
            		$("#preloader").hide();
            		$("#pageload").hide();
            	}, 500); 
            }
        });
}
$scope.sendingtemplate = function(name,act){
	$scope.tempsave1        = canvas.toJSON();
	$scope.tempAsJson1        = JSON.stringify($scope.tempsave1);
	$scope.tempsave2        = canvasback.toJSON();
	$scope.tempAsJson2        = JSON.stringify($scope.tempsave2);
	$scope.touploadcanvastemplate.push({'id':$('#idcard').val(),'name':name,'cv':$scope.tempAsJson1,'img':canvas.toDataURL("image/png"),'cv2':$scope.tempAsJson2,'img2':canvasback.toDataURL("image/png")})
	console.log($scope.touploadcanvastemplate)
	console.log(name)
	$scope.BDtemplate(act)
	$("#pageload").show();
	$("#preloader").show();
}
$scope.addtemplate = function(t){
	                	//$scope.uploadtemplate(2)
	                	if ($scope.SelctedTemplateval) {
	                		setTimeout(function() {	
	                		}, 500);
	                		$scope.deletetemplate($scope.SelctedTemplateid,$scope.SelctedTemplatename,$scope.SelctedTemplateimg1,$scope.SelctedTemplateimg2)
	                		$scope.sendingtemplate($scope.SelctedTemplatename,1)
	                	}else{
	                		$.confirm({
	                			title: 'Save this Template?',
	                			content: '' +
	                			'<form action="" class="formName">' +
	                			'<div class="form-group">' +
	                			'<label>Please enter Template name</label>' +
	                			'<input type="text" placeholder="Template name" class="name form-control" required />' +
	                			'</div>' +
	                			'</form>',
	                			buttons: {
	                				formSubmit: {
	                					text: 'Save',
	                					btnClass: 'btn-blue',
	                					action: function () {
	                						var name = this.$content.find('.name').val();
	                						if(!name){
	                							$.alert('provide a valid name');
	                							return false;
	                						}
	                						for (var i = $scope.canvastemplate.length - 1; i >= 0; i--) {
	                							if ($scope.canvastemplate[i].name ==name && $scope.canvastemplate[i].type ==t) {
	                								$.confirm({
	                									title: 'This name already exists',
	                									content: '',
	                									buttons: {
	                										
	                										cancel: function () {

	                										},
	                									}
	                								});
	                								return true;
	                							}
	                						}

	                						$scope.sendingtemplate(name,1)
	                					}
	                				},
	                				cancel: function () {
                          //close
                      },
                  },
                  onContentReady: function () {
                         // bind to events
                         var jc = this;
                         this.$content.find('form').on('submit', function (e) {
                   // if the user submits the form by pressing enter in the field.
                   e.preventDefault();
                  jc.$$formSubmit.trigger('click'); // reference the button and click it
              });
                     }
                 });
	                	}
	                }
	                $scope.uploadtemplate = function(i){
	                	var Templatedata = new FormData();
	                	if (i==1) {
	                		Templatedata.append('json', JSON.stringify($scope.canvastemplate));
	                		$.ajaxSetup({
	                			headers: {
	                				'X-CSRF-Token': $('meta[name=_token]').attr('content')
	                			}
	                		});
	                		$.ajax({
            url: 'Jsonupload', // point to server-side PHP script
            data: Templatedata,
            type: 'POST',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function(data) {       
            	$scope.canvastemplate =data
            	console.log('de deonde'+$scope.canvastemplate)
            }
        });
	                	}else{
	                		Templatedata.append('json', 2);
	                		$.ajaxSetup({
	                			headers: {
	                				'X-CSRF-Token': $('meta[name=_token]').attr('content')
	                			}
	                		});
	                		$.ajax({
            url: 'Jsonupload', // point to server-side PHP script
            data: Templatedata,
            type: 'POST',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function(data) {        
            	$scope.touploadcanvastemplate= JSON.parse(data.success)  
            	$scope.$apply()
            	console.log($scope.touploadcanvastemplate)
            	$("#preloader2").hide();
            }
        });
	                	}
	                }
	                $scope.deletetemplate = function(idT,valname,i1,i2) {
	                	console.log(i1)
	                	$.ajaxSetup({
	                		headers: {
	                			'X-CSRF-Token': $('meta[name=_token]').attr('content')
	                		}
	                	});
	                	$.ajax({
            url: 'BDJsonupload', // point to server-side PHP script
            data: {action:4,name:valname,id:idT,img1:i1,img2:i2},
            type: 'POST',
            success: function(data) { 
            	$("#preloader2").show();   
            	$scope.BDtemplate(2)  
            }
        });
	                }
	                $scope.updatetemplate = function(valname) {
	                	$.ajaxSetup({
	                		headers: {
	                			'X-CSRF-Token': $('meta[name=_token]').attr('content')
	                		}
	                	});
	                	for (var i = $scope.touploadcanvastemplate.length - 1; i >= 0; i--) {
	                		$.ajax({
            url: 'BDJsonupload', // point to server-side PHP script
            data: {action:3,id:$scope.touploadcanvastemplate[i].id,name:$scope.touploadcanvastemplate[i].name,cv:$scope.touploadcanvastemplate[i].cv,cv2:$scope.touploadcanvastemplate[i].cv2,img:$scope.touploadcanvastemplate[i].img,img2:$scope.touploadcanvastemplate[i].img2},
            type: 'POST',
            success: function(data) { 
            	$("#preloader2").show();   
            	$scope.BDtemplate(2)  
            }
        });

	                	}
	                }
	                $scope.claaremplate = function(i) {
	                	for (var i = canvas.getObjects().length - 1; i >= 0; i--) {
	                		canvas.remove(canvas.item(i));

	                	}
	                	canvas.backgroundColor='#ffffff';
	                	for (var i = canvasback.getObjects().length - 1; i >= 0; i--) {
	                		canvasback.remove(canvasback.item(i));

	                	}
	                	canvasback.backgroundColor='#ffffff';
	                }
	                $scope.ngRepeatFinished = function(i) {
	                	$("#pageload").hide();
	                	$("#preloader").hide();
	                	$("#preloader2").hide();
	                }
	                $scope.BDtemplate = function(val) {
	                	$.ajaxSetup({
	                		headers: {
	                			'X-CSRF-Token': $('meta[name=_token]').attr('content')
	                		}
	                	});
	                	switch(val) {
	                		case 1:
	                		for (var i = $scope.touploadcanvastemplate.length - 1; i >= 0; i--) {
	                			$.ajax({
            url: 'BDJsonupload', // point to server-side PHP script
            data: {action:1,id:$scope.touploadcanvastemplate[i].id,name:$scope.touploadcanvastemplate[i].name,cv:$scope.touploadcanvastemplate[i].cv,cv2:$scope.touploadcanvastemplate[i].cv2,img:$scope.touploadcanvastemplate[i].img,img2:$scope.touploadcanvastemplate[i].img2,textsize:$('#TextSize').val(),orientation:$('#Orientation').val()},
            type: 'POST',
            //contentType: false, // The content type used when sending data to the server.
            //cache: false, // To unable request pages to be cached
            //processData: false,
            success: function(data) {    
            	console.log(data)
            	$scope.BDtemplate(2)   
            	$scope.touploadcanvastemplate=[]
            	$scope.$apply()
            }
        });
	                		}
	                		break;
	                		case 2:
	                		$.ajax({
            url: 'BDJsonupload', // point to server-side PHP script
            data: {action:2,filter:$('#idcard').val(),OrientationFilter:$('#Orientation').val(),SizeFilter:$('#TextSize').val()},
            type: 'POST',
            //contentType: false, // The content type used when sending data to the server.
            //cache: false, // To unable request pages to be cached
            //processData: false,
            success: function(data) {    
            	console.log(data)   
            	$scope.canvastemplate=data.success
            	$scope.touploadcanvastemplate=[]
            	$scope.$apply()
            	$("#preloader2").show(); 
            	$("#Modaltemplate").modal("toggle");
            	setTimeout(function() {	
            		$("#preloader2").hide();
            	}, 1000);
            }
        });
	                		break;
	                		case 3:
	                		for (var i = $scope.touploadcanvastemplate.length - 1; i >= 0; i--) {
	                			$.ajax({
            url: 'BDJsonupload', // point to server-side PHP script
            data: {action:3,id:$scope.touploadcanvastemplate[i].id,name:$scope.touploadcanvastemplate[i].name,cv:$scope.touploadcanvastemplate[i].cv,cv2:$scope.touploadcanvastemplate[i].cv2,img:$scope.touploadcanvastemplate[i].img,img2:$scope.touploadcanvastemplate[i].img2},
            type: 'POST',
            //contentType: false, // The content type used when sending data to the server.
            //cache: false, // To unable request pages to be cached
            //processData: false,
            success: function(data) {    
            	console.log(data)
            	$scope.BDtemplate(2)   
            	$scope.touploadcanvastemplate=[]
            	$scope.$apply()
            }
        });
	                		}
	                		break;
	                		case 4:
	                		for (var i = $scope.touploadcanvastemplate.length - 1; i >= 0; i--) {

	                		}
	                		break;
	                		default: 
	                	}

	                }

	                $scope.deltemplate = function() {
	                	$scope.BDtemplate(4)
	                	$scope.btntemplate=true
	                	setTimeout(function() {
	                		location.reload(); 
	                	}, 800);

	                }
	                $scope.jsonsave1;
	                $scope.jsonsave2;
	                $scope.jsonsaveAsJson1;
	                $scope.jsonsaveAsJson2;
	                $scope.savecanvas = function(i){
	                	$scope.btnuploadimgurl = true
	                	$scope.jsonsave1        = canvas.toJSON();
	                	$scope.jsonsaveAsJson1        = JSON.stringify($scope.jsonsave1);
	                	$scope.jsonsave2        = canvasback.toJSON();
	                	$scope.jsonsaveAsJson2        = JSON.stringify($scope.jsonsave2);
	                	var cname1 ="canvassave1"
	                	var cname2 ="canvassave2"
	                	var cvalue = "3564fr54dsf5d4sf5dsdsfdsfdsfsdds"
	                	var expires= "Thu, 18 Dec 2013 12:00:00 UTC"

	                	document.cookie = cname1 + "=" + $scope.jsonsaveAsJson1  + ";" + expires + ";path=/";
	                	document.cookie = cname2 + "=" + $scope.jsonsaveAsJson2  + ";" + expires + ";path=/";
	                }

	                function getCookie(cname) {
	                	var name = cname + "=";
	                	var ca = document.cookie.split(';');
	                	for(var i = 0; i < ca.length; i++) {
	                		var c = ca[i];
	                		while (c.charAt(0) == ' ') {
	                			c = c.substring(1);
	                		}
	                		if (c.indexOf(name) == 0) {
	                			return c.substring(name.length, c.length);
	                		}
	                	}
	                	return "";
	                }

	                $scope.enviar = function(i) {
	                	console.log(i)
	                }

	                $scope.loadacanvas = function(i){
	                	var x = getCookie('canvassave1')
	                	canvas.loadFromJSON(x);
	                	canvas.renderAll();
	                	var y= getCookie('canvassave2')
	                	canvasback.loadFromJSON(y);
	                	canvasback.renderAll();
	                }

	                $scope.fileSelected = function (element) {
	                	var contentdata = new FormData();
	                	$scope.fileupload=element.files[0]
	                	contentdata.append('file', element.files[0]);
	                	contentdata.append('destino', 'algunlado');
	                	contentdata.append('oldfilename', 5464);
	                	$.ajax({
	                		url:'upload',
	                		type:'post',
	                		data: {id:'ssd'},
	                		headers: {
	                			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                		},
		          //processData: false,
		          success:function(data){
		          	console.log(data);
		          },
		          error:function(){
		          }
		      })
	                };

	                function validateForm() {
	                	Alert("e")
	                }
	                $("#uploadFile").change(function(){
	                	$('#image_preview').html("");
	                	var total_file=document.getElementById("uploadFile").files.length;
	                	for(var i=0;i<total_file;i++)
	                	{
	                		$('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>");
	                	}
	                });
	                $("#uploadfile-form").on("submit", function(e) {
	                	$scope.btnuploadimgurl = false
	                	e.preventDefault();
	                	var extension = $('#uploadFile').val().split('.').pop().toLowerCase();
	                	var file_data = $('#uploadFile').prop('files')[0];
	                	var file_name = file_data.name;
	                	var form_data = new FormData();
	                	form_data.append('file', file_data);
	                	form_data.append('name', file_name);
	                	$.ajaxSetup({
	                		headers: {
	                			'X-CSRF-Token': $('meta[name=_token]').attr('content')
	                		}
	                	});
	                	$.ajax({
            url: 'upload', // point to server-side PHP script
            data: form_data,
            type: 'POST',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function(data) {       
            	$scope.uploadimgurl = data.url
            	$scope.uploadimgurllist = data.user_imgs
            	console.log($scope.uploadimgurllist.length)
            	$("#uploadFile").val('');
            	$('#image_preview').append("");   
            	$scope.$apply()
            }
        });
	                });
	                $scope.insertimg = function(i) { 
	                	$scope.addImg(i,$scope.uploadimgurl) 
	                }
	                window.onload = function () {
	                	$scope.loadacanvas()
	                	$(function() {
	                		$('.text-color').colorpicker({
	                			parts:  ['map', 'bar', 'hex',
	                			'cmyk', 'rgb','alpha', 'preview',
	                			'swatches', 'footer'],
	                			alpha: true,
	                			altField:' ',
	                			altOnChange: true,
	                			colorFormat:'RGBA',
	                			stop  :	function(event, color) {
	                				arrayhtml.push("<div class='colorpicker-saved' onclick='golbalcolor(\""+color.formatted+"\")' style='background-color:"+color.formatted+"''></div>");
	                				console.log(arrayhtml)
	                				$("#colorgrid").append("<div class='colorpicker-saved' onclick='golbalcolor(\""+color.formatted+"\")' style='background-color:"+color.formatted+"''></div>");
	                				if (golbal_color!="") {
	                					$scope.textselectedcolor=golbal_color
	                					$scope.changecolortext(golbal_color)
	                					$scope.$apply()
	                				}else{
	                					$scope.textselectedcolor=color.formatted
	                					$scope.changecolortext(color.formatted)
	                					$scope.$apply()
	                				}
	                			},
	                			close   :	function(event, color) {
	                				if (golbal_color!="") {
	                					$scope.textselectedcolor=golbal_color
	                					$scope.changecolortext(golbal_color)
	                					$scope.$apply()
	                				}
	                			},
	                			open  :	function(event, color) {
	                				$scope.pikertype=4
	                				$("#colorgrid").append(arrayhtml);
					//arrayhtml.push("<div class='colorpicker-saved' style='background-color:"+color.formatted+"''></div>");
				},
				select:	function(event, color) {
					$scope.textselectedcolor=color.formatted
					$scope.changecolortext(color.formatted)
					$scope.$apply()
				}

			});
	                		$('.fill-color').colorpicker({
	                			parts:  ['map', 'bar', 'hex',
	                			'cmyk', 'rgb', 'alpha', 'preview',
	                			'swatches', 'footer'],
	                			alpha: true,
	                			altField:' ',
	                			altOnChange: true,
	                			colorFormat:'RGBA',
	                			stop  :	function(event, color) {
	                				arrayhtml.push("<div class='colorpicker-saved' onclick='golbalcolor(\""+color.formatted+"\")' style='background-color:"+color.formatted+"''></div>");
	                				console.log(arrayhtml)
	                				$("#colorgrid").append("<div class='colorpicker-saved' onclick='golbalcolor(\""+color.formatted+"\")' style='background-color:"+color.formatted+"''></div>");
	                				if (golbal_color!="") {
	                					$scope.fillselectedcolor=golbal_color
	                					$scope.changecolortext(golbal_color)
	                					$scope.$apply()
	                				}else{
	                					$scope.fillselectedcolor=color.formatted
	                					$scope.changecolortext(color.formatted)
	                					$scope.$apply()
	                				}
	                			},
	                			close   :	function(event, color) {
	                				if (golbal_color!="") {
	                					$scope.fillselectedcolor=golbal_color
	                					$scope.changecolortext(golbal_color)
	                					$scope.$apply()
	                				}
	                			},
	                			open  :	function(event, color) {
	                				$scope.pikertype=3
	                				$("#colorgrid").append(arrayhtml);
					//arrayhtml.push("<div class='colorpicker-saved' style='background-color:"+color.formatted+"''></div>");
				},
				select:	function(event, color) {
					$scope.fillselectedcolor=color.formatted
					$scope.changecolortext(color.formatted)
					$scope.$apply()
				}

			});
	                		$('.border-color').colorpicker({
	                			parts:  ['map', 'bar', 'hex',
	                			'cmyk', 'rgb', 'alpha', 'preview',
	                			'swatches', 'footer'],
	                			alpha: true,
	                			altField:' ',
	                			altOnChange: true,
	                			colorFormat:'RGBA',
	                			stop  :	function(event, color) {
	                				arrayhtml.push("<div class='colorpicker-saved' onclick='golbalcolor(\""+color.formatted+"\")' style='background-color:"+color.formatted+"''></div>");
	                				$("#colorgrid").append("<div class='colorpicker-saved' onclick='golbalcolor(\""+color.formatted+"\")' style='background-color:"+color.formatted+"''></div>");
	                				if (golbal_color!="") {
	                					$scope.bordeselectedcolor=golbal_color
	                					$scope.changecolorborder(golbal_color)
	                					$scope.$apply()
	                				}else{
	                					$scope.bordeselectedcolor=color.formatted
	                					$scope.changecolorborder(color.formatted)
	                					$scope.$apply()
	                				}
	                			},
	                			close   :	function(event, color) {
	                				if (golbal_color!="") {
	                					$scope.bordeselectedcolor=golbal_color
	                					$scope.changecolorborder(golbal_color)
	                					$scope.$apply()
	                				}
	                			},
	                			open  :	function(event, color) {
	                				$scope.pikertype=2
	                				$("#colorgrid").append(arrayhtml);
					//arrayhtml.push("<div class='colorpicker-saved' style='background-color:"+color.formatted+"''></div>");
				},
				select:	function(event, color) {
					$scope.bordeselectedcolor=color.formatted
					$scope.changecolorborder(color.formatted)
					$scope.$apply()
				}

			});
	                		$('.background-color').colorpicker({
	                			parts:  ['map', 'bar', 'hex',
	                			'cmyk', 'rgb', 'alpha', 'preview',
	                			'swatches', 'footer'],
	                			alpha: true,
	                			altField:' ',
	                			altOnChange: true,
	                			colorFormat:'RGBA',
	                			stop  :	function(event, color) {
	                				arrayhtml.push("<div class='colorpicker-saved' onclick='golbalcolor(\""+color.formatted+"\")' style='background-color:"+color.formatted+"''></div>");
	                				console.log(arrayhtml)
	                				$("#colorgrid").append("<div class='colorpicker-saved' onclick='golbalcolor(\""+color.formatted+"\")' style='background-color:"+color.formatted+"''></div>");
	                				if (golbal_color!="") {
	                					$scope.backgroundselectedcolor=golbal_color
	                					$scope.changecolor(golbal_color)
	                					$scope.$apply()
	                				}else{
	                					$scope.backgroundselectedcolor=color.formatted
	                					$scope.changecolor(color.formatted)
	                					$scope.$apply()
	                				}

	                			},
	                			close  :function(event, color) {
	                				if (golbal_color!="") {
	                					$scope.backgroundselectedcolor=golbal_color
	                					$scope.changecolor(golbal_color)
	                					$scope.$apply()
	                				}

	                			},
	                			open  :	function(event, color) {
	                				$scope.pikertype=1
	                				$("#colorgrid").append(arrayhtml);
					//arrayhtml.push("<div class='colorpicker-saved' style='background-color:"+color.formatted+"''></div>");
				},
				select:	function(event, color) {
					$scope.backgroundselectedcolor=color.formatted
					$scope.changecolor(color.formatted)
					$scope.$apply()
				}
			});
	                	});
setTimeout(function() {	
	//$scope.uploadtemplate(2)
	//$scope.BDtemplate(2)
	console.log(document.cookie.indexOf('canvassave1='))
	if (document.cookie.indexOf('canvassave1=') > 1) {

	}else{
		$scope.BDtemplate(2)
	}
	$("#pageload").hide();
	$("#preloader").hide();
	$("#toolcontainer").show();
	$("#canvashidden").show();
}, 2000);

}

});
////end angularjs ////


//K()b{O-HmuC5

