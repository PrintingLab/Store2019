$('.carousel').carousel({
  pause:true,
  interval: 40000
});

document.getElementById('dropdownMenuButton2').addEventListener("click",Menubotton)
document.getElementById('dropdownMenuButton3').addEventListener("click",Menubotton)

function Menubotton(){
  $(".index_container").css({'display':'block','background':'rgba(31, 31, 31, 0.9)','position':'fixed','z-index':'1',
  'top':'0','width':'100%','height':'100vh'});
  $("body").addClass("no_scroll");
}

$('.dropdown').on('hidden.bs.dropdown', function () {
  $('.index_container').css({'display':'none'});
  $("body").removeClass("no_scroll");
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
