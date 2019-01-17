$("input[name='phone']").keyup(function() {
    $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d)+$/, "$1-$2-$3"));
});

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

shopApp.controller('checkoutcontroller',function($scope,$http,$document){
    setTimeout(function(){
        $scope.shipingupdate()
        $scope.computeshipping()
    }, 200);
    $scope.processingpayment=true
    $scope.preloader=true
    $scope.dangermesagge=true
    $scope.PaymentDetails=true
    $scope.Continuebtn=true
    $scope.inputratio=true
$scope.computeshipping = function () {
   if ($scope.postalcode.length ==5) {
    $scope.shipping_options=[]
    $scope.shippinglist=[]
    $scope.preloader=false
    $scope.dangermesagge=true
    endurl="https://api.4over.com/shippingquote"
    $http({
        method:'post',
        url:'/computeshipping',
        data: {endpoint:endurl,address:$scope.address,city:$scope.city,province:$scope.province,postalcode:$scope.postalcode,type:2},
    }).then(function mySuccess(response) {
        console.log(response.data)
       $scope.taxpercent=response.data.taxpercent
        data = JSON.parse(response.data.success[0])
        if (data.status == 'error') {
            $scope.preloader=true
            $scope.danger=data.message
            $scope.dangermesagge=false
            $scope.Continuebtn=true
            console.log(data);  
            
        }else{
           if (data.ambiguos_address) {
            $scope.addresscandidates=data.candidates
            $scope.preloader=true
            $('#candidates').modal('show')
           }else{
               for (let index = 0; index < response.data.success.length; index++) {
                   const element = JSON.parse(response.data.success[index]);
                   console.log(element)
                   $scope.totaltax=element.job.facilities[0].total_tax
                   $scope.productionestimate=element.job.facilities[0].production_estimate 
                   $scope.addressoptions=element.job.facilities[0].address 
                   $scope.shippingoptions=element.job.facilities[0].shipping_options 
                   for (let i = 0; i < $scope.shippingoptions.length; i++) {
                       const elem = $scope.shippingoptions[i];
                       $scope.shippinglist.push({service_code:elem.service_code,service_name:elem.service_name,service_price:elem.service_price})      
                   }
                   $scope.facilitiesaddress=element.job.facilities[0].address  
               }
               var match=$scope.$eval("shippinglist | unique: 'service_name'");
               for (let index = 0; index < match.length; index++) {
                   $scope.item = match[index];
                var matches=$scope.$eval("shippinglist | filter:{service_code:item.service_code} ");
                $scope.shipping_options.push({service_code:matches[0].service_code,service_name:matches[0].service_name,service_price:$scope.sumarry(matches)}) 
               }
               $scope.preloader=true
               $scope.Continuebtn=false
           }
        }
        }, function myError(response) {
          alert(response.statusText);
    }); 
   }

}
$scope.sumarry = function (arr) {
    var sum = 0
  for (let index = 0; index < arr.length; index++) {
      const element = arr[index];
      sum = (parseFloat(sum) + parseFloat(element.service_price))
      
  }
  return sum.toFixed(2);
}

$scope.test = function () {
console.log("test")
}

$scope.Continueorder = function () {
    console.log($scope.checkoutform.$valid)
   if ($scope.checkoutform.$valid) {
      $scope.PaymentDetails=false
      $scope.Continuehide=true
      $scope.dangermesagge=true
  }else{
    $scope.danger="Please complete all requiered fields."
    $scope.dangermesagge=false
  }



    
}
$scope.inputraiocheck = function (i) {
    console.log(i)
    $scope.inputratio=i
}

$scope.shipingupdate = function (value,type) {
    $scope.ShippingMethodlist=type
    $scope.ShippingMethod=type
    $http({
        method:'post',
        url:'/shipingupdate',
        data: {shipingcost:value,shipingtype:type},
    }).then(function mySuccess(response) {
        result=response.data
    console.log(result)
    $scope.newTotal=result.Total.toFixed(2)
    $scope.shiping=result.shiping
    $scope.newTax=result.Tax.toFixed(2)
    $scope.NewSubtotal=result.NewSubtotal.toFixed(2)
    $scope.tax=result.tax.toFixed(2)
    
    })
}

$scope.processingpayment = function () {
    $scope.processingpayment=false
    }

$scope.presentPrice = function (value) {
return '$'+value
}
$scope.setaddres = function (a,c,s,z) {
    $scope.address=a
    $scope.city=c
    $scope.province=s
    $scope.postalcode=z
    $('#candidates').modal('hide')
    $scope.computeshipping()
}

})



// presentPrice($newTax)