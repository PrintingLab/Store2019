
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

shopApp.controller('cartcontroller',function($scope,$http,$document){
$scope.optionproduct = function () {
    endurl="https://api.4over.com/printproducts/products/"+$scope.itemID+"/optiongroups"
    $http({
        method:'post',
        url:'/4overproducts',
        data: {endpoint:endurl},
    }).then(function mySuccess(response) {
        var resutl = response.data.success.entities
         console.log(resutl)
         $scope.optionsproduct=resutl
 
         $('#editmodal').modal('show')
        }, function myError(response) {
            console.log(response.statusText);
    });
   
}
$scope.editmodal = function (item,id) {
    $scope.itemname= item
    $scope.itemID= id
 $scope.optionproduct()
}


})



// presentPrice($newTax)