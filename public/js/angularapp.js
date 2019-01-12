var pricesarry
var stoknamearray
var optionamearray
$.getJSON("../storage/jsonconfig/priceprintinglab.json", function(result){
    pricesarry=result
    })
$.getJSON("../storage/jsonconfig/stokname.json", function(result){
    stoknamearray=result
    })
$.getJSON("../storage/jsonconfig/optionsname.json", function(result){
            optionamearray=result
    })
var shopApp = angular.module('shop-v1', []);
