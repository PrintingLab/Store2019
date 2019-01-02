

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
    $scope.preloader=true
    $scope.dangermesagge=true
    $scope.PaymentDetails=true
$scope.computeshipping = function () {
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
        console.log(response.data.success)
        data = JSON.parse(response.data.success[0])
        if (data.status == 'error') {
            $scope.preloader=true
            $scope.danger=data.message
            $scope.dangermesagge=false
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
           }
        }
        }, function myError(response) {
          console.log(response.statusText);
    }); 
}
$scope.sumarry = function (arr) {
    var sum = 0
  for (let index = 0; index < arr.length; index++) {
      const element = arr[index];
      sum = (parseFloat(sum) + parseFloat(element.service_price))
      
  }
  return sum.toFixed(2);
}
$scope.Continueorder = function (a,c,s,z) {
   
    $scope.PaymentDetails=false


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