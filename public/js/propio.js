$('.carousel').carousel({
  pause:true,
  interval: 5000
});


function modalSignsLab(){

  if (getCookie('popup')=='' ) {
    var now = new Date();
    now.setTime(now.getTime() + 1 * 1800 * 1000);
    document.cookie = "popup=popup; expires=" + now.toUTCString() + "; path=/";
    $('#exampleModal').modal();
  }


}



function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
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


document.getElementById('dropdownMenuButton2').addEventListener("click",Menubotton)
document.getElementById('dropdownMenuButton3').addEventListener("click",Menubotton)

function Menubotton(){
  $(".index_container").css({'display':'block','background':'rgba(31, 31, 31, 0.45)','position':'fixed','z-index':'1',
  'top':'0','width':'100%','height':'100vh'});
  //$("body").addClass("no_scroll");
}

$('.dropdown').on('hidden.bs.dropdown', function () {
  $('.index_container').css({'display':'none'});
  //$("body").removeClass("no_scroll");
});

var $win=$(window);
var $pos=38;
$win.scroll(function(){
  if ($win.scrollTop()<= $pos ) {
    $('#btn_HambDisplayPc').addClass('displayNone');
  }else {
    $('#btn_HambDisplayPc').removeClass('displayNone');
  }

})


$(window).scroll(function() {
  // $('.dropdown').dropdown('hide')
  //$('#dropdownMenuButton2').dropdown('hide')
  $('.index_container').css({'display':'none'});
  if ($(this).scrollTop() > 200) {
    $('.go-top').fadeIn(200);
  } else {
    $('.go-top').fadeOut(200);
  }
});
$('.go-top').click(function(event) {
  event.preventDefault();
  $('html, body').animate({scrollTop: 0}, 300);
});
