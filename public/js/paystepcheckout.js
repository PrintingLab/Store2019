// Tooltips Initialization
var designerapp = angular.module('designer-v1', []);
designerapp.controller('cartcontroller',function($scope,$http){
  var TransId
  var form = $( "#AuthorizePayForm" );
  form.validate();
  var valido = false

  $scope.nexstep = function(argument) {
   $('#payste'+argument).removeClass('btn-disbled').addClass('btn-actived');
   switch(argument) {
    case 'p2':
    //onAmazonPaymentsReady()
    $("#pageload").show();
    $("#preloader").show();
    $('#addressBookWidgetDiv').show()
    $scope.shipingarray =[]
    setTimeout(function() { 
     $scope.shipingarray =[] 
     $scope.callshiping()
   }, 2000);
    break;
    case 'p3':
     var address = $("#Address").val()+", "+$("#city").val()+", "+$("#zipcode").val()+", "+$("#inputState").val();
    var tel = $("#phone").val();
     $("#cltadress").val(address);
     $("#cltphone").val(tel);
    break;
    case 'p4':
    console.log(argument)
    break;
    default:
  }
}

$scope.backstep = function(argument) {

  $('#paystep'+argument).removeClass('btn-actived').addClass('btn-disbled');
  switch(argument) {
    case 4:
    console.log(argument)
    break;
    case 3:
     // $('#Shipto').hide()
   // $('#p3').hide()
   $('#BtnDelivery').show()
   $('#btnnext3').show()
   $("#zipcode-val").val('')
   break;
   case 2:
    //$('#Shipto').hide()
    $('#p3').show()
    $('#BtnDelivery').show()
    $("#zipcode-val").val('')
    break;
    default:
  }
  $('#addressBookWidgetDiv').show()
  
  if (argument==4) {
    $('#BtnDelivery').show()
    //$('#p3').hide()
  }
}
$( "#address" ).change(function() {
  $scope.callshiping()
});
$( "#zipcode" ).change(function() {
  $scope.callshiping()
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

// Steppers
$(document).ready(function () {
  $().pre
  $('#errordiv').hide()
  var navListItems = $('div.setup-panel-2 div a'),
  allWells = $('.setup-content-2'),
  allNextBtn = $('.nextBtn-2'),
  allPrevBtn = $('.prevBtn-2');
  allWells.hide();
  navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
    $item = $(this);

    if (!$item.hasClass('disabled')) {
      navListItems.removeClass('btn-amber').addClass('btn-blue-grey');
      $item.addClass('btn-amber');
      allWells.hide();
      $target.show();
      $target.find('input:eq(0)').focus();
    }
  });
  allPrevBtn.click(function(){
    var curStep = $(this).closest(".setup-content-2"),
    curStepBtn = curStep.attr("id"),
    prevStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
    prevStepSteps.removeAttr('disabled').trigger('click');
  });


  allNextBtn.click(function(){
    var stepid= this.id
    var curStep = $(this).closest(".setup-content-2"),
    curStepBtn = curStep.attr("id"),
    nextStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
    curInputs = curStep.find("input[type='text'],input[type='url']"),
    isValid = true;
    $(".form-group").removeClass("has-error");
    for(var i=0; i< curInputs.length; i++){
      if (!curInputs[i].validity.valid){
        isValid = false;
        valido = false
        $('#errordiv').show()
        switch(stepid) {
         case 'p2':
         $('#errordiv').text("Please Complete all fields")
         break;
         case 'p3':
         $('#errordiv').text("Please Complete all fields")
         break;
         case 'p4':
         break;
         default:
       }

       $(curInputs[i]).closest(".form-group").addClass("has-error");
     }else{

     }
   }
   if (isValid){
    $('#errordiv').hide()
    nextStepSteps.removeAttr('disabled').trigger('click');
    $scope.nexstep(stepid)
  }
});
  $('div.setup-panel-2 div a.btn-amber').trigger('click');
});


$scope.shipingarray =[]
var shipingmetods = ["GND","3DS","2DA","1DA"];
var Warehouse = ['07074', '27616', '33169', '45424','60148', '76011', '77080', '84119','85040','90039','95035','98354','91202'];
function closest (num, arr) {
  var curr = arr[0];
  var diff = Math.abs (num - curr);
  for (var val = 0; val < arr.length; val++) {
    var newdiff = Math.abs (num - arr[val]);
    if (newdiff < diff) {
      diff = newdiff;
      curr = arr[val];
    }
  }
  return curr;
}
$scope.UPSShipping = function(zipval,shp) {

  //$("#pleasewait").show();
  var totslcards = '<?php echo $totalcount; ?>'
    //totslcard =  parseInt(totslcards) * 0.0356
    console.log(0.0356 * parseInt(totslcards))
    var shipingname
    var zipfrom = closest(zipval, Warehouse)
    switch(shp) {
      case "GND":
      shipingname = "UPS Ground"
      break;
      case "3DS":
      shipingname = "UPS Three-Day Select"
      break;
      case "2DA":
      shipingname = "UPS Second Day Air"
      break;
      case "1DA":
      shipingname = "UPS Next Day Air"
      break;
      default:
    }
    $.post("./Apicalls/UPS-Shipping.php", {
      zipcode:zipval,
      shipingmode:shp,
      fromzipcode:zipfrom,
    }).done(function (data) {
           // console.log(data)
           try {
            var idval = shipingname.replace(/\s/g, '');
            var shipingdetails = JSON.parse(data)
            filter=Math.round(shipingdetails.RatedShipment.TotalCharges.MonetaryValue)
            $scope.shipingarray.push({index:filter,id:shipingdetails.RatedShipment.TotalCharges.MonetaryValue.replace('.', ''),name:shipingname,value:shipingdetails.RatedShipment.TotalCharges.MonetaryValue,days:shipingdetails.RatedShipment.GuaranteedDaysToDelivery})
             // console.log(shipingdetails.RatedShipment.GuaranteedDaysToDelivery)
              //$("#Shipto").append("<div id='dv"+shipingdetails.RatedShipment.TotalCharges.MonetaryValue.replace('.', '')+"' onclick='selectshiping("+shipingdetails.RatedShipment.TotalCharges.MonetaryValue+")' class='row shipingrow'><div class='col-md-8 col-sm-8'><strong>"+shipingname+"</strong></div><div class='col-md-4 col-sm-4'>$ "+shipingdetails.RatedShipment.TotalCharges.MonetaryValue+"</div><div class='col-md-12 col-sm-12'>"+shipingdetails.RatedShipment.GuaranteedDaysToDelivery+" Day Transit</div></div>");
              console.log($scope.shipingarray)
              $scope.$apply();
              //$("#pleasewait").hide();
            } catch (err) {
             // console.log(err)
             //$("#pleasewait").hide();
             // $("#Shipto").html('Zip code not valid')

           } 
         });
  }

  $scope.callshiping = function() {
    console.log($scope.confirmed)
    $scope.shipingarray = []
    for (var i = shipingmetods.length - 1; i >= 0; i--) {
      $scope.UPSShipping($('#zipcode').val(),shipingmetods[i])
    }
  }

  $scope.contentzip =function(){

    var resutlt_cook=getCookie('zip')
    if (resutlt_cook!=''){
      var envio=getCookie('cookie_envio')
      var  zip=getCookie('zip')
      var  tax=getCookie('tax')
      $('#zipcode').val(zip)
      $('#shipping-cost').html(envio)
      $("#tax").html(tax)
      //$scope.callshiping()
    }
  }
  function getCookie(cook_vacio_zip) {
    var name = cook_vacio_zip + "=";
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
  function comparacion(zip){
    var new_jersey_zips=['07001','07002','07003','07004','07005','07006','07007','07008','07009','07010','07011','07012','07013','07014','07015','07016','07017','07018','07019','07020','07021','07022','07023','07024','07026','07027','07028','07029','07030','07031','07032','07033','07034','07035','07036','07039','07040','07041','07042','07043','07044','07045','07046','07047','07050','07051','07052','07054','07055',
    '07057','07058','07059','07060','07061','07062','07063','07064','07065','07066','07067','07068','07069','07070','07071','07072','07073','07074','07075','07076','07077','07078','07079','07080','07081','07082','07083','07086','07087','07088','07090','07091','07092','07093','07094','07095','07096','07097','07099','07101','07102','07103','07104','07105','07106','07107','07108','07109','07110','07111',
    '07112','07114','07175','07184','07188','07189','07191','07192','07193','07195','07198','07199','07201','07202','07203','07204','07205','07206','07207','07208','07302','07303','07304','07305','07306','07307','07308','07310','07311','07395','07399','07401','07403','07405','07407','07410','07416','07417','07418','07419','07420','07421','07422','07423','07424','07428','07430','07432','07435','07436',
    '07438','07439','07440','07442','07444','07446','07450','07451','07452','07456','07457','07458','07460','07461','07462','07463','07465','07470','07474','07480','07481','07495','07501','07502','07503','07504','07505','07506','07507','07508','07509','07510','07511','07512','07513','07514','07522','07524','07533','07538','07543','07544','07601','07602','07603','07604','07605','07606','07607','07608',
    '07620','07621','07624','07626','07627','07628','07630','07631','07632','07640','07641','07642','07643','07644','07645','07646','07647','07648','07649','07650','07652','07653','07656','07657','07660','07661','07662','07663','07666','07670','07675','07676','07677','07699','07701','07702','07703','07704','07709','07710','07711','07712','07715','07716','07717','07718','07719','07720','07721','07722',
    '07723','07724','07726','07727','07728','07730','07731','07732','07733','07734','07735','07737','07738','07739','07740','07746','07747','07748','07750','07751','07752','07753','07754','07755','07756','07757','07758','07760','07762','07763','07764','07765','07799','07801','07802','07803','07806','07820','07821','07822','07823','07825','07826','07827','07828','07829','07830','07831','07832','07833',
    '07834','07836','07837','07838','07839','07840','07842','07843','07844','07845','07846','07847','07848','07849','07850','07851','07852','07853','07855','07856','07857','07860','07863','07865','07866','07869','07870','07871','07874','07875','07876','07877','07878','07879','07880','07881','07882','07885','07890','07901','07902','07920','07921','07922','07924','07926','07927','07928','07930','07931',
    '07932','07933','07934','07935','07936','07938','07939','07940','07945','07946','07950','07960','07961','07962','07963','07970','07974','07976','07977','07978','07979','07980','07981','07999','08001','08002','08003','08004','08005','08006','08007','08008','08009','08010','08011','08012','08014','08015','08016','08018','08019','08020','08021','08022','08023','08025','08026','08027','08028','08029',
    '08030','08031','08032','08033','08034','08035','08036','08037','08038','08039','08041','08042','08043','08045','08046','08048','08049','08050','08051','08052','08053','08054','08055','08056','08057','08059','08060','08061','08062','08063','08064','08065','08066','08067','08068','08069','08070','08071','08072','08073','08074','08075','08076','08077','08078','08079','08080','08081','08083','08084',
    '08085','08086','08087','08088','08089','08090','08091','08092','08093','08094','08095','08096','08097','08098','08099','08101','08102','08103','08104','08105','08106','08107','08108','08109','08110','08201','08202','08203','08204','08205','08210','08212','08213','08214','08215','08217','08218','08219','08220','08221','08223','08224','08225','08226','08230','08231','08232','08234','08240','08241',
    '08242','08243','08244','08245','08246','08247','08248','08250','08251','08252','08260','08270','08302','08310','08311','08312','08313','08314','08315','08316','08317','08318','08319','08320','08321','08322','08323','08324','08326','08327','08328','08329','08330','08332','08340','08341','08342','08343','08344','08345','08346','08347','08348','08349','08350','08352','08353','08360','08361','08362',
    '08401','08402','08403','08404','08405','08406','08501','08502','08504','08505','08510','08511','08512','08514','08515','08518','08520','08525','08526','08527','08528','08530','08533','08534','08535','08536','08540','08541','08542','08543','08544','08550','08551','08553','08554','08555','08556','08557','08558','08559','08560','08561','08562','08601','08602','08603','08604','08605','08606','08607',
    '08608','08609','08610','08611','08618','08619','08620','08625','08628','08629','08638','08640','08641','08645','08646','08647','08648','08650','08666','08690','08691','08695','08701','08720','08721','08722','08723','08724','08730','08731','08732','08733','08734','08735','08736','08738','08739','08740','08741','08742','08750','08751','08752','08753','08754','08755','08756','08757','08758','08759',
    '08801','08802','08803','08804','08805','08807','08808','08809','08810','08812','08816','08817','08818','08820','08821','08822','08823','08824','08825','08826','08827','08828','08829','08830','08831','08832','08833','08834','08835','08836','08837','08840','08844','08846','08848','08850','08852','08853','08854','08855','08857','08858','08859','08861','08862','08863','08865','08867','08868','08869',
    '08870','08871','08872','08873','08875','08876','08879','08880','08882','08884','08885','08886','08887','08888','08889','08890','08899','08901','08902','08903','08904','08906','08933','08989']
    for (var i = 0; i < new_jersey_zips.length; i++){
      //  console.log(new_jersey_zips[i])
      if (new_jersey_zips[i]===zip) {
        var igual=1
        i=new_jersey_zips.length
      }
    }
    if (igual==1 ) {
      var total =totalphp
      total=parseInt(total)
      total = ((total*6.62)/100).toFixed(2);
      total=String(total)
      return total
    }else{
      return 0
    }
  }




  $scope.selectshiping = function(argument,argument2) {
    $('#Shipto div').removeClass('shipfocus');
    $("#dv"+argument.toString().replace('.', '')+"").addClass("shipfocus")
    if (totalmount != 0) {
      var ups_reponse =parseFloat(argument)
      var resutlt_cook=getCookie('zip')
      var zip_value=$('#zipcode').val()
      var result=comparacion(zip_value)
      var zip_value=String(zip_value)
      var ups_reponse=String(ups_reponse)
      var cook_vacio_zip="zip"
      var expires= "Thu, 18 Dec 2013 12:00:00 UTC"
      document.cookie = cook_vacio_zip + "=" + zip_value + ";" + expires + ";path=/";
      console.log(getCookie('zip'))
      var cook_valor="cookie_envio"
      document.cookie = cook_valor + "=" + ups_reponse + ";" + expires + ";path=/";
      var cook_tax="tax"
      document.cookie = cook_tax + "=" + result + ";" + expires + ";path=/";
      totalmount = 0
      totalmount = totalphp
      tofixdvalue = parseFloat(totalmount)+parseFloat(argument)+parseFloat(result)
      totalmount = tofixdvalue.toFixed(2)
      Shipingtypename = argument2
      Shipingtypeval = argument
      tax =result
      $("#total_val").html(totalmount)
      $("#shipingcontrol").val(totalmount)
      $("#camount").val(totalmount)
      $("#tax").html(result)
    }

    ShippingHandling =argument
    $("#shipping-cost").html(argument)
    $("#Shipping_val").html(argument)
    $("#zipcode-val").val(argument)
        //  onAmazonPaymentsReady()
      }

      $scope.AuthorizePay = function() {
        if (form.valid()) {
          var Paydata = new FormData();
          Paydata.append('Name', $("#Name").val());
          Paydata.append('cnumber', $("#cnumber").val());
          Paydata.append('card_expiry_month', $("#cardexpirymonth").val());
          Paydata.append('card_expiry_year', $("#cardexpiryyear").val());
          Paydata.append('ccode', $("#ccode").val());
          Paydata.append('camount', $("#camount").val());
          Paydata.append('CAddress', $("#CAddress").val());
          Paydata.append('Ccity', $("#Ccity").val());
          Paydata.append('CinputState', $("#CinputState").val());
          Paydata.append('Czipcode', $("#Czipcode").val());
          $.ajaxSetup({
            headers: {
              'X-CSRF-Token': $('meta[name=_token]').attr('content')
            }
          });
          $.ajax({
            url: 'Authentication', // point to server-side PHP script
            data: Paydata,
            type: 'POST',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function(data) {
              if (data.success.ResultCode =="Error") {
               $('#errordiv').show()
               $('#errordiv').text(data.success.Result+':  '+data.success.Errormessage)
             }
             if (data.success.ResultCode =="Ok") {
               if (data.success.Result =="Transaction Failed") {
               $('#errordiv').show()
               $('#errordiv').text(data.success.Result+':  '+data.success.Errormessage)
             }else{
              $('#p3').trigger('click');
             }
              
            }
            console.log(data.success)
            TransId = data.success.getTransId
            //setTimeout(function() { 
            //}, 500); 
          }
        });

        }
        
      }

      $scope.placeorder = function() {
        console.log(TransId)
        $.confirm({
          title: 'Confirm Order?',
          buttons: {
            confirm: function () {
              $("#pageload").show();
              $("#preloader").show();
              $.ajaxSetup({
                headers: {
                  'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
              });
              $.ajax({
            url: 'checkout', // point to server-side PHP script
            data: {ID:TransId},
            type: 'POST',
            //contentType: false, // The content type used when sending data to the server.
            //cache: false, // To unable request pages to be cached
            //processData: false,
            success: function(data) {
              if (data.success.ResultCode =="Error") {
               $('#errordiv').show()
               $('#errordiv').text(data.success.Result+':  '+data.success.Errormessage)
             }
             if (data.success.ResultCode =="Ok") {
             }
             console.log(data.success)
             setTimeout(function() { 
             }, 500); 
             $.ajax({
                    url: 'ordercomplete', // point to server-side PHP script
                    data: {OrderID:TransId,Total:totalmount,name:$('#firstname').val(),Shiping:Shipingtypename,email:$('#email').val(),Tax:tax,Shipingvalue:Shipingtypeval},
                    type: 'POST',
                    success: function(data) {    
                      console.log(data)
                      $('#idorder').val(data.success)
                      $( "#orderconfirm").submit();
                    }
                  });
           }
         });
            },
            cancel: function () {

            },

          }
        });
      }

//       $scope.cookie = function() {
//         var call = getCookie('zip_vacio')

//         console.log(getCookie('zip_vacio'))
//         console.log(JSON.parse(call))
//        $('#pre').val(getCookie('zip_vacio'))
//      }

//      $scope.testcookie = function() {
//       var ups_reponse = '55555'
//       var zip_value='1546'
//       var cook_vacio_zip="zip_vacio"
//       var expires= "Thu, 18 Dec 2013 12:00:00 UTC"
//       var items = '{"zip":'+zip_value+',"total" :'+ups_reponse+'}'
//       document.cookie = cook_vacio_zip + "=" +  items + ";" + expires + ";path=/";
//     }
// function getCookie(cname) {
//                     var name = cname + "=";
//                     var ca = document.cookie.split(';');
//                     for(var i = 0; i < ca.length; i++) {
//                       var c = ca[i];
//                       while (c.charAt(0) == ' ') {
//                         c = c.substring(1);
//                       }
//                       if (c.indexOf(name) == 0) {
//                         return c.substring(name.length, c.length);
//                       }
//                     }
//                     return "";
//                   }

$scope.init = function(i){
        //$("#pleasewait").hide();



        $scope.contentzip()
        $scope.callshiping()
      }();

    });
// American Express

// 378282246310005

// American Express

// 371449635398431

// American Express Corporate

// 378734493671000

// Australian BankCard

// 5610591081018250

// Diners Club

// 30569309025904

// Diners Club

// 38520000023237

// Discover

// 6011111111111117

// Discover

// 6011000990139424

// JCB

// 3530111333300000

// JCB

// 3566002020360505

// MasterCard

// 5555555555554444

// MasterCard

// 5105105105105100

// Visa

// 4111111111111111

// Visa

// 4012888888881881

// Visa

// 4222222222222

// Note : Even though this number has a different character count than the other test numbers, it is the correct and functional number.

// Processor-specific Cards

// Dankort (PBS)

// 76009244561

// Dankort (PBS)

// 5019717010103742

// Switch/Solo (Paymentech)

// 6331101999990016


//8xN4364Z3mg4DbwL


// 93ubT5Hpcc2C
// 2E3z6KruR
// 48Cy6rk4H82xD6b9
//554Y7vat82GEu93e
//63ubT5Hpcc2J

