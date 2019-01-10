
shopApp.filter('unique', function() {
    return function(collection, keyname) {
       var output = [], 
           keys = [];
 
       angular.forEach(collection, function(item) {
           var key = item[keyname];
           if(keys.indexOf(key) === -1) {
               keys.push(key);
               output.push(item);
           }
       });
 
       return output;
    };
 });

shopApp.controller('shopcontroller',function($scope,$http,$document){
    $scope.rangeofprices=[
        {"Pinicial": 0.01, "Pfinal":0.99,"porcentaje":1500},
        {"Pinicial":1, "Pfinal":1.99,"porcentaje":1200},
        {"Pinicial":2, "Pfinal":2.99,"porcentaje":900},
        {"Pinicial":3, "Pfinal":3.99,"porcentaje":800},
        {"Pinicial":4, "Pfinal":4.99,"porcentaje":700},
        {"Pinicial":5, "Pfinal":5.99,"porcentaje":600},
        {"Pinicial":6, "Pfinal":9.99,"porcentaje":550},
        {"Pinicial":10, "Pfinal":14.99,"porcentaje":500},
        {"Pinicial":15, "Pfinal":19.99,"porcentaje":450},
        {"Pinicial":20, "Pfinal":24.99,"porcentaje":400},
        {"Pinicial":25, "Pfinal":29.99,"porcentaje":350},
        {"Pinicial":30, "Pfinal":34.99,"porcentaje":300},
        {"Pinicial":35, "Pfinal":39.99,"porcentaje":290},
        {"Pinicial":40, "Pfinal":44.99,"porcentaje":280},
        {"Pinicial":45, "Pfinal":49.99,"porcentaje":270},
        {"Pinicial":50, "Pfinal":54.99,"porcentaje":260},
        {"Pinicial":55, "Pfinal":59.99,"porcentaje":250},
        {"Pinicial":60, "Pfinal":74.99,"porcentaje":240},
        {"Pinicial":75, "Pfinal":80.99,"porcentaje":230},
        {"Pinicial":81, "Pfinal":100.9 ,"porcentaje":220},
        {"Pinicial":101, "Pfinal":120.99,"porcentaje":210},
        {"Pinicial":121, "Pfinal":140.99,"porcentaje":200},
        {"Pinicial":141, "Pfinal":160.99,"porcentaje":190},
        {"Pinicial":161, "Pfinal":200.99,"porcentaje":180},
        {"Pinicial":201, "Pfinal":380.99,"porcentaje":175},
        {"Pinicial":381, "Pfinal":560.99,"porcentaje":170},
        {"Pinicial":561, "Pfinal":740.99,"porcentaje":165},
        {"Pinicial":741, "Pfinal":100000,"porcentaje":160}
          ]
    $scope.stoknames=[
        {"Name":"100GLC", "value":"100lb Gloss Cover"}, 
        {"Name":"100LB", "value":"Linen"},
        {"Name":"14PT", "value":"Standard (14pt)"},
        {"Name":"14PTUC", "value":"Standard Uncoated (14pt)"},
        {"Name":"16PT", "value":"Premium (16pt)"},
        {"Name":"20PTCL", "value":"Clear Plastic (20pt)"},
        {"Name":"20PTFR", "value":" Frosted Plastic (20pt)"},
        {"Name":"20PTWH", "value":"White Plastic (20pt)"},
        {"Name":"100LBWS", "value":"100lb White Stipple"},
        {"Name":"100GLB", "value":"100lb Gloss Book"},
        {"Name":"4/0 (4 color front)", "value":"Front Only"},
        {"Name":"4/4 (4 color both sides)", "value":"Front and Back"},
        {"Name":"32PTUC", "value":"32 Point"},
        {"Name":"18PTC1S", "value":"Premium + (18pt)"},
        {"Name":"18PTC1S", "value":"Premium + (18pt)"},
        {"Name":"70LB", "value":"70LB"}
      ]
      $scope.btndisigned=true
    $scope.priceshow=false
    $scope.moreoptions=true
    $scope.showcorners=true
    $scope.prdselect1=$('#coating').val();
    $scope.Dimensions=$('#dimensions').val();
    $scope.Coatingarraylist=[]
    $scope.roundcorners=$('#roundcorners').val();
$scope.load4overproducts = function () {
    $scope.prtdarray=prtd
    endurl='https://api.4over.com/printproducts/categories/'+apiID+'/products'
        $http({
            method:'post',
            url:'/4overproducts',
            data: {endpoint:endurl},
        }).then(function mySuccess(response) {
             $scope.products=response.data.success.entities;
             console.log($scope.products)
           //$scope.builderchangue()
           setTimeout(function(){  $scope.builderbydimencion() }, 100);
            
            }, function myError(response) {
                console.log(response.statusText);
        });
}();
$scope.pricetosend = function(val) {
    // pricetransform($scope.buildprice)
     return $scope.buildprice
 }
 
$scope.pricetransform = function (inprice) {
    for (let index = 0; index < $scope.rangeofprices.length; index++) {
        if (inprice >= $scope.rangeofprices[index].Pinicial && inprice <= $scope.rangeofprices[index].Pfinal ) {
            return ((parseFloat(inprice)*parseFloat($scope.rangeofprices[index].porcentaje))/100).toFixed(2);
        }
    }

}




$scope.stockname = function (name) {
    if (prtdname == "Business Cards") {
        switch (name) {
            case "100GLC":
            $("#stock option[value='" + name + "']").remove();
                break;
            case "100LBWS":
            $("#stock option[value='" + name + "']").remove();   
                break;    
            case "18PTC1S":
            $("#stock option[value='" + name + "']").remove() 
                break;
                case "18PTC1S":
            $("#stock option[value='" + name + "']").remove() 
                break; 
                case "4/1":
            $("#side option[value='" + name + "']").remove() 
                break;
            default:
                break;
        }  
    }

    for (let index = 0; index < $scope.stoknames.length; index++) {
        if ($scope.stoknames[index].Name == name) {
            return $scope.stoknames[index].value
        }
    }
}


$scope.baseprice = function (endurl) {
            $http({
                method:'post',
                url:'/4overproducts',
                data: {endpoint:endurl},
            }).then(function mySuccess(response) {
                $scope.productbaseprice=response.data.success.entities;
                }, function myError(response) {
                    console.log(response.statusText);
            });
}
$scope.builderchangue = function () {
    var matches = $scope.$eval('products | filter:prdselect1 ');
    if (matches.length == 0) {
        console.log("null")
    }else{
        $scope.productuuid=matches[0].product_uuid
        $scope.productcode=matches[0].product_code
        $scope.productdesc=matches[0].product_description
        $scope.baseprice(matches[0].product_base_prices)
        $scope.load4overproductsOptions(matches[0].product_option_groups) 
    }
   
}
$scope.builderbydimencion = function () {
    $scope.stockarry=[]
    var matches = $scope.$eval('products | filter:Dimensions');
    console.log($scope.Dimensions)
    if (matches.length == 0) {
        console.log("null")
    }else{
        for (let index = 0; index < matches.length; index++) {
            if (matches[index].product_description.slice(0,3) =='LOW' || matches[index].product_description.slice(0,3) =='ALL' ) {   
            }else{
                $scope.stockarry.push({product_option_groups:matches[index].product_option_groups,product_description:matches[index].product_description,product_code:matches[index].product_code,option:matches[index].product_code.substr(0,matches[index].product_code.indexOf('-')),value:matches[index].product_code.substr(0,matches[index].product_code.indexOf('-'))})
                 $scope.$apply()
            }   
        }
    }
    $scope.Stock=$('#stock').val();
    $scope.builderbyStock()
}
$scope.roundcornerfilter = function () {
if ($scope.roundcorners == "Round") {
    var macht = $scope.$eval("Coatingarray | filter:{product_description:'Round'}");
    if (macht.length==0) {
        $("#roundcorners option[value='Round']").remove() 
        $scope.Coatingarraylist = $scope.$eval("Coatingarray | filter:{product_description:'! Round'}");
    }else{
        $scope.Coatingarraylist = macht
        $scope.$apply()
    }  
}else {
    var macht=$scope.$eval("Coatingarray | filter:{product_description:'! Round'}");
    if (macht.length==0) {
        $("#roundcorners option[value='Standard']").remove() 
        $scope.Coatingarraylist = $scope.$eval("Coatingarray | filter:{product_description:'Round'}");
    }else{
        $scope.Coatingarraylist = macht
        $scope.$apply()
    }   
    $scope.$apply()
}
}

$scope.builderbyStock = function () {
    $scope.Coatingarray=[]
    var matches = $scope.$eval('stockarry | filter:{product_code:Stock}');
    if (matches.length == 0) {
        console.log("null")
    }else{
        for (let index = 0; index < matches.length; index++) {
            $scope.Coatingarray.push({product_option_groups:matches[index].product_option_groups,product_description:matches[index].product_description,product_code:matches[index].product_code,option:matches[index].product_description.toUpperCase().replace(prtdname.toUpperCase(),'').replace($scope.Stock.toUpperCase(),'').replace($scope.Dimensions.toUpperCase(),'').replace('ROUND','').replace('CORNER','').replace('RC','').replace('COVER','').replace('BUSINESS','').replace('CARD','').replace('CARDS','').replace('WITH','').replace('18PT C1S','').replace('UV','FULL GLOSS').replace('100LB','').replace('SPOT','').replace('UV','FULL GLOSS').replace('BC','').replace('14PT','').replace('LINEN','').replace('STIPPLE - WHITE','').replace('32PT','')})
              $scope.$apply()
        }
        $scope.Coatingarraylist = $scope.Coatingarray
        var matchescorner = $scope.$eval("Coatingarray | filter:{product_description:'Round'}");
        var matchesnocorner = $scope.$eval("Coatingarray | filter:{product_description:'! Round'}");
        if (matchescorner.length == 0) {
            $scope.showcorners=true
            $scope.cornersval=""
            $scope.$apply()
        }else{
            $scope.showcorners=false
            $scope.cornersval="round"
            $scope.$apply()
            $scope.roundcornerfilter()
        }
    }
    $scope.prdselect1=$('#coating').val();
    $scope.builderchangue()
}
$scope.optionbydimensions = function (endurl) {
    $http({
        method:'post',
        url:'/4overproducts',
        data: {endpoint:endurl},
    }).then(function mySuccess(response) {
        }, function myError(response) {
            console.log(response.statusText);
    });
}
$('#dimensions').change(function() {
    $scope.priceshow=false
    $scope.btndisigned=true
    $scope.Dimensions=$(this).val()
    $scope.roundcorners=""
    $scope.builderbydimencion()
});
$('#stock').change(function() {
    $scope.priceshow=false
    $scope.btndisigned=true
    $scope.Stock=$(this).val()
    $scope.roundcorners=""
    $scope.builderbyStock()
});
$('#coating').change(function() {
    $scope.priceshow=false
    $scope.btndisigned=true
    $scope.prdselect1=$(this).val()
    $scope.builderchangue()
});

$('#roundcorners').change(function() {
    $scope.priceshow=false
    $scope.btndisigned=true
    $scope.roundcorners=$(this).val()
    $scope.$apply()
    $scope.roundcornerfilter()
    $scope.builderprice()
});

$('#side').change(function() {
    $scope.priceshow=false
    $scope.btndisigned=true
    $scope.side=$(this).val()
    $scope.builderprice()
});

$('#quantyti').change(function() {
    $scope.priceshow=false
    $scope.btndisigned=true
    $scope.quantyti=$(this).val()
    $scope.builderprice()
});

$('#TurnAroundTime').change(function() { 
    $scope.priceshow=false
    $scope.btndisigned=true
    $scope.TurnAroundTime=$(this).val()
    $scope.builderTurnAround()
});

$scope.load4overproductsOptions = function (endurl) {
        $http({
            method:'post',
            url:'/4overproducts',
            data: {endpoint:endurl},
        }).then(function mySuccess(response) {
            $scope.arrayproductprices=response.data.success.entities
            var match=$scope.$eval("arrayproductprices | filter:{product_option_group_name:'Runsize'} ");
            var match2=$scope.$eval("arrayproductprices | filter:{product_option_group_name:'Colorspec'} ");
            var match3=$scope.$eval("arrayproductprices | filter:{product_option_group_name:'Turn Around Time'} ");
         
            $scope.productprices=match[0].options 
            $scope.productside=match2[0].options 
            $scope.productTurnAroundTime=match3[0].options
            setTimeout(function(){  $scope.quantyti=$('#quantyti').val();
            $scope.side=$('#side').val();
            $scope.builderprice()  }, 100);
       
            }, function myError(response) {
                console.log(response.statusText);
        });
}
$scope.builderprice = function (params) {
    
    var matches = $scope.$eval('productTurnAroundTime ');
    var matchesprice = $scope.$eval('productbaseprice | filter:quantyti | filter:side');
    $scope.productTurnAroundfilter=matches[0]
    $scope.firtprice=matchesprice[0].product_baseprice

  //  $scope.buildprice=parseFloat($scope.firtprice).toFixed(2); 
    $scope.$apply()
    $scope.TurnAroundTime=$('#TurnAroundTime').val();
    $scope.builderTurnAround()
}
$scope.builderTurnAround = function () {
    for (let index = 0; index < $scope.productTurnAroundTime.length; index++) {
       if ($scope.productTurnAroundTime[index].colorspec == $scope.side && $scope.productTurnAroundTime[index].runsize == $scope.quantyti && $scope.productTurnAroundTime[index].option_name == $scope.TurnAroundTime ) {
        $scope.TurnAroundTimeprice($scope.productTurnAroundTime[index].option_prices)
        $scope.option_uuid= $scope.productTurnAroundTime[index].option_uuid
        $scope.colorspec_uuid= $scope.productTurnAroundTime[index].colorspec_uuid
        $scope.runsize_uuid =$scope.productTurnAroundTime[index].runsize_uuid
       }
    }
    // $http({ 
    //     method:'post',
    //     url:'/4overproducts',
    //     data: {endpoint:endurl},
    // }).then(function mySuccess(response) {
    //      // console.log(response.data.success.entities);
    //     $scope.productbaseprice=response.data.success.entities;
    //     }, function myError(response) {
    //      //   console.log(response.statusText);
    // });
}
$scope.priceformat = function (format) {
    
   return "$"+$scope.pricetransform(format)
}
$scope.TurnAroundTimeprice = function (endurl) {
    $http({
        method:'post',
        url:'/4overproducts',
        data: {endpoint:endurl},
    }).then(function mySuccess(response) {
         if (response.data.success.entities[0].price== undefined) {
            $scope.buildprice =parseFloat($scope.firtprice).toFixed(2);
            $scope.priceperpiece = ($scope.pricetransform($scope.buildprice)/$scope.quantyti).toFixed(2);
            $scope.btndisigned=false
         }else{
            $scope.buildprice =parseFloat(parseFloat($scope.firtprice) + parseFloat(response.data.success.entities[0].price)).toFixed(2); 
            $scope.priceperpiece = ($scope.pricetransform($scope.buildprice)/$scope.quantyti).toFixed(2);
            $scope.btndisigned=false
         }
          $('#preloader').hide()
          $scope.priceshow=true
          $scope.moreoptions=false
        //$scope.productbaseprice=response.data.success.entities.price;
        }, function myError(response) {
         //console.log(response.statusText);
    });
}

$scope.computeshipping = function () {
    for (let index = 0; index < $scope.arrayproductprices.length; index++) {
        
        for (let index1 = 0; index1 < $scope.arrayproductprices[index].options.length; index1++) {

        }
        
    }
    $scope.option_uuid
    $scope.colorspec_uuid
    $scope.runsize_uuid 
    $scope.productuuid
    $scope.zip_code
    endurl="https://api.4over.com/shippingquote"
    $http({
        method:'post',
        url:'/computeshipping',
        data: {endpoint:endurl,pruuid:$scope.productuuid,opuuid:$scope.option_uuid,couuid:$scope.colorspec_uuid,ruuuid:$scope.runsize_uuid,zip:$scope.zip_code,type:1},
    }).then(function mySuccess(response) {
        if (response.data.success.status == 'error') {
            console.log("error");  
        }else{ 
           $scope.shipping_options=response.data.success.job.facilities[0].shipping_options 
           $scope.address=response.data.success.job.facilities[0].address
        }
        
        }, function myError(response) {
          console.log(response.statusText);
    });
   
}


})



// presentPrice($newTax)