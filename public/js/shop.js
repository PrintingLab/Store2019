shopApp.controller('shopcontroller', function ($scope, $http, $document) {
    $scope.getjsonconfig = function () {
        $http({
            method: 'get',
            url: '/jsonconfig',
        }).then(function mySuccess(response) {
            $scope.stoknames = response.data.stokname
            $scope.optioname = response.data.optionsname
            $scope.rangeofprices = response.data.priceprintinglab
        }, function myError(response) {
            console.log(response.statusText);
        });
    }
    $scope.specs=prtdCoatings
    $scope.buildpricewedesing = 0
    $scope.btndisigned = true
    $scope.priceshow = false
    $scope.moreoptions = true
    $scope.showcorners = true
    $scope.prdselect1 = $('#coating').val();
    $scope.Dimensions = $('#dimensions').val();
    $scope.Coatingarraylist = []
    $scope.roundcorners = $('#roundcorners').val();
    $scope.selectedGenres = ","; 

    $scope.load4overproducts = function () {
        $scope.getjsonconfig()
        $scope.prtdarray = prtd
        endurl = 'https://api.4over.com/printproducts/categories/' + apiID + '/products'
        $http({
            method: 'post',
            url: '/4overproducts',
            data: {endpoint: endurl},
        }).then(function mySuccess(response) {
            $scope.products = response.data.success.entities;
            //$scope.builderchangue()
            console.log($scope.products)
            setTimeout(function () {
                $scope.builderbydimencion()
            }, 500);

        }, function myError(response) {
            console.log(response.statusText);
        });
    }();

    $scope.pricetransform = function (inprice) {
        for (let index = 0; index < $scope.rangeofprices.length; index++) {
            if (inprice >= $scope.rangeofprices[index].Pinicial && inprice <= $scope.rangeofprices[index].Pfinal) {
                return ((parseFloat(inprice) * parseFloat($scope.rangeofprices[index].porcentaje)) / 100).toFixed(2);
            }
        }

    }
    $scope.stockname = function (name) {
        var newname
        var stocknames
        if (prtdStock) {
            stocknames = JSON.parse(prtdStock)
            for (let index = 0; index < stocknames.length; index++) {
                const element = stocknames[index];
                if (name==element) { 
                   $("#stock option[value='" + name + "']").remove();
                }
            }
        }else{

        }
        for (let index = 0; index < $scope.stoknames.length; index++) {
            if ($scope.stoknames[index].Name == name) {
                newname = $scope.stoknames[index].value
            }
        }

        if (newname) {
            return newname
        } else {
            return name
        }
    }

    $scope.CoatingsName = function(expected,code){
        var newname
        var CoatingName
        for (let index = 0; index < $scope.optioname.length; index++) {
            if ($scope.optioname[index].Name.replace(/ /g, "") == expected.replace(/ /g, "")) {
                
                newname = $scope.optioname[index].value
            }
        }
        if (prtdCoatings) {
            CoatingName = JSON.parse(prtdCoatings)
             for (let index = 0; index < CoatingName.length; index++) {
                 const element = CoatingName[index];
                 //$("#coating option[value='"+element+"']").remove()
                 if (expected.replace(/ /g, "")==element.replace(/ /g, "")) {
                    $("#coating option[value='"+code+"']").remove() 
                 }
             }
            
        }

        
        if (newname) {
            return newname
        } else {
            return expected
        }
       // $("#coating option[value='" + code + "']").remove();
      }; 
    $scope.changeoptioname = function (name) {
        var newname
        for (let index = 0; index < $scope.optioname.length; index++) {
            if ($scope.optioname[index].Name == name) {
                newname = $scope.optioname[index].value
            }
        }
        if (newname) {
            return newname
        } else {
            return name
        }

    }

    $scope.baseprice = function (endurl) {
        $http({
            method: 'post',
            url: '/4overproducts',
            data: {
                endpoint: endurl
            },
        }).then(function mySuccess(response) {
            $scope.productbaseprice = response.data.success.entities;
        }, function myError(response) {
            console.log(response.statusText);
        });
    }
    $scope.builderchangue = function () {

        var matches = $scope.$eval('products | filter:prdselect1 ');
        if (matches.length == 0) {
            console.log("null")
        } else {
            $scope.productuuid = matches[0].product_uuid
            $scope.productcode = matches[0].product_code
            $scope.productdesc = matches[0].product_description
            $scope.baseprice(matches[0].product_base_prices)
            $scope.load4overproductsOptions(matches[0].product_option_groups)
        }
        
    }
    $scope.builderbydimencion = function () {
        $scope.stockarry = []
        $scope.Dimensions = $("#dimensions").val()
        var matches = $scope.$eval('products | filter:Dimensions');
        if (matches.length == 0) {
            console.log("null")
        } else {
            for (let index = 0; index < matches.length; index++) {
                if (matches[index].product_description.slice(0, 3) == 'LOW' || matches[index].product_description.slice(0, 3) == 'ALL') {} else {
                    $scope.stockarry.push({
                        product_option_groups: matches[index].product_option_groups,
                        product_description: matches[index].product_description,
                        product_code: matches[index].product_code,
                        option: matches[index].product_code.substr(0, matches[index].product_code.indexOf('-')),
                        value: matches[index].product_code.substr(0, matches[index].product_code.indexOf('-'))
                    })
                    $scope.$apply()
                }
            }
        }
        $scope.Stock = $('#stock').val();
        $scope.builderbyStock()
    }
    $scope.roundcornerfilter = function () {
        if ($scope.roundcorners == "Round") {
            var macht = $scope.$eval("Coatingarray | filter:{product_description:'Round'}");
            if (macht.length == 0) {
                $("#roundcorners option[value='Round']").remove()
                $scope.Coatingarraylist = $scope.$eval("Coatingarray | filter:{product_description:'! Round'}");
            } else {
                $scope.Coatingarraylist = macht
                $scope.$apply()
            }
        } else {
            var macht = $scope.$eval("Coatingarray | filter:{product_description:'! Round'}");
            if (macht.length == 0) {
                $("#roundcorners option[value='Standard']").remove()
                $scope.Coatingarraylist = $scope.$eval("Coatingarray | filter:{product_description:'Round'}");
            } else {
                $scope.Coatingarraylist = macht
                $scope.$apply()
            }
            $scope.$apply()
        }
    }

    $scope.builderbyStock = function () {
        $scope.Coatingarray = []
        var matches = $scope.$eval('stockarry | filter:{product_code:Stock}');
        if (matches.length == 0) {
            console.log("null")
        } else {
            for (let index = 0; index < matches.length; index++) {
                $scope.Coatingarray.push({
                    product_option_groups: matches[index].product_option_groups,
                    product_description: matches[index].product_description,
                    product_code: matches[index].product_code,
                    option: matches[index].product_description.toUpperCase().replace($scope.Stock.toUpperCase(), '').replace($scope.Dimensions.toUpperCase(), '').replace('ROUND', '').replace('CORNER', '').replace('RC', '').replace('COVER', '').replace('BUSINESS', '').replace('CARDS', '').replace('CARD', '').replace('WITH', '').replace('18PT C1S', '').replace('UV', 'FULL GLOSS').replace('100LB', '').replace('SPOT', '').replace('UV', 'FULL GLOSS').replace('BC', '').replace('14PT', '').replace('LINEN', '').replace('32PT', '').replace('SADDLE STITCH CALENDAR ON', '').replace('CALENDAR ON', '').replace('-', '').replace('#', '').replace('FLYERS', '').replace('FLYER', '').replace('AQ', 'AKUAFOIL').replace('SOCIAL', '').replace('POST', '')
                })
                $scope.$apply()
            }
            
            $scope.Coatingarraylist = $scope.Coatingarray

            var matchescorner = $scope.$eval("Coatingarray | filter:{product_description:'Round'}");
            var matchesnocorner = $scope.$eval("Coatingarray | filter:{product_description:'! Round'}");
            if (matchescorner.length == 0) {
                $scope.showcorners = true
                $scope.cornersval = ""
                $scope.$apply()
            } else {
                $scope.showcorners = false
                $scope.cornersval = "round"
                $scope.$apply()
                $scope.roundcornerfilter()
            }
        }
        
        $scope.prdselect1 = $('#coating').val();
        $scope.builderchangue()
     
    }
    $scope.optionbydimensions = function (endurl) {
        $http({
            method: 'post',
            url: '/4overproducts',
            data: {
                endpoint: endurl
            },
        }).then(function mySuccess(response) {}, function myError(response) {
            console.log(response.statusText);
        });
    }
    $('#dimensions').change(function () {
        $scope.priceshow = false
        $scope.btndisigned = true
        $scope.Dimensions = $(this).val()
        $scope.roundcorners = ""
        $scope.builderbydimencion()
    });
    $('#stock').change(function () {
        $scope.priceshow = false
        $scope.btndisigned = true
        $scope.Stock = $(this).val()
        $scope.roundcorners = ""
        $scope.builderbyStock()
    });
    $('#coating').change(function () {
        $scope.priceshow = false
        $scope.btndisigned = true
        $scope.prdselect1 = $(this).val()
        $scope.builderchangue()
    });

    $('#roundcorners').change(function () {
        $scope.priceshow = false
        $scope.btndisigned = true
        $scope.roundcorners = $(this).val()
        $scope.$apply()
        $scope.builderbyStock()
        $scope.roundcornerfilter()
       // $scope.builderprice()
    });

    $('#38d33954-5a42-4112-a905-215eb827e62c').change(function () {
         $scope.priceshow = false
        $scope.btndisigned = true
        $scope.Colorspec = $(this).val()
         $scope.builderprice()
       // alert($(this).val())
    });

    $('#87e09691-ef33-4cf4-8f17-48af06ce84f4').change(function () {
        $scope.Runsize = $(this).val()
        $scope.priceshow = false
        $scope.btndisigned = true
        $scope.builderprice()
    });

    $('#f80e8179-b264-42ce-9f80-bb258a09a1fe').change(function () {
        $scope.TurnAroundTime = $(this).val()
        $scope.priceshow = false
        $scope.btndisigned = true
        $scope.builderprice()
    });

    $scope.load4overproductsOptions = function (endurl) {
        $http({
            method: 'post',
            url: '/4overproducts',
            data: {
                endpoint: endurl
            },
        }).then(function mySuccess(response) {
            $scope.arrayproductprices = response.data.success.entities
            var Optionprices = $scope.$eval("arrayproductprices | filter:{product_option_group_name:'Turn Around Time'}");
            $scope.arrayProductprice = Optionprices[0].options
            setTimeout(function () {
                $scope.optionschange()
            }, 500);
        }, function myError(response) {
            console.log(response.statusText);
        });
    }

    $scope.optionschange = function () {
     //   $("#38d33954-5a42-4112-a905-215eb827e62c").val("13abbda7-1d64-4f25-8bb2-c179b224825d");
        $scope.priceshow = false
      
        var TurnAroundTimes = $scope.$eval("arrayproductprices | filter:'Turn Around Time'");
        $scope.productTurnAroundTime = TurnAroundTimes[0].options
       
        $scope.builderprice()
       
    }



    $scope.builderprice = function (params) {
            $scope.Colorspec = $("#38d33954-5a42-4112-a905-215eb827e62c").val()
            $scope.Runsize = $("#87e09691-ef33-4cf4-8f17-48af06ce84f4").val()
            $scope.TurnAroundTime = $("#f80e8179-b264-42ce-9f80-bb258a09a1fe").val()
            $scope.$apply()
           
        for (let index = 0; index < $scope.productbaseprice.length; index++) {
            const priceloop = $scope.productbaseprice[index];
            if (priceloop.colorspec_uuid == $scope.Colorspec && priceloop.runsize_uuid == $scope.Runsize) {
                $scope.firtprice = priceloop.product_baseprice
            }
        }
        $scope.builderTurnAround()
    }
    $scope.builderTurnAround = function () {
        $scope.Colorspec = $("#38d33954-5a42-4112-a905-215eb827e62c").val()
            $scope.Runsize = $("#87e09691-ef33-4cf4-8f17-48af06ce84f4").val()
            $scope.TurnAroundTime = $("#f80e8179-b264-42ce-9f80-bb258a09a1fe").val()
 
        for (let index = 0; index < $scope.productTurnAroundTime.length; index++) {
            if ($scope.productTurnAroundTime[index].colorspec_uuid == $scope.Colorspec && $scope.productTurnAroundTime[index].runsize_uuid == $scope.Runsize && $scope.productTurnAroundTime[index].option_uuid == $scope.TurnAroundTime) {
                $scope.TurnAroundTimeprice($scope.productTurnAroundTime[index].option_prices)
                $scope.option_uuid = $scope.productTurnAroundTime[index].option_uuid
                $scope.colorspec_uuid = $scope.productTurnAroundTime[index].colorspec_uuid
                $scope.runsize_uuid = $scope.productTurnAroundTime[index].runsize_uuid
                $scope.quantyti = $scope.productTurnAroundTime[index].runsize
                $scope.side = $scope.productTurnAroundTime[index].colorspec
                $scope.TurnAroundval = $scope.productTurnAroundTime[index].option_name
                //console.log($scope.productTurnAroundTime[index].option_prices)
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

        var price = (parseFloat($scope.pricetransform(format)) + $scope.buildpricewedesing).toFixed(2);
        return "$" + price
    }
    $scope.TurnAroundTimeprice = function (endurl) {
        $http({
            method: 'post',
            url: '/4overproducts',
            data: {
                endpoint: endurl
            },
        }).then(function mySuccess(response) {
            if (response.data.success.entities[0].price == undefined) {
                $scope.buildprice = parseFloat($scope.firtprice).toFixed(2);
                $scope.priceperpiece = ($scope.pricetransform($scope.buildprice) / $scope.quantyti).toFixed(2);
                $scope.btndisigned = false
            } else {
                $scope.buildprice = parseFloat(parseFloat($scope.firtprice) + parseFloat(response.data.success.entities[0].price)).toFixed(2);
                $scope.priceperpiece = ($scope.pricetransform($scope.buildprice) / $scope.quantyti).toFixed(2);
                $scope.btndisigned = false
            }
            $('#preloader').hide()
            $scope.priceshow = true
            $scope.moreoptions = false
            //$scope.productbaseprice=response.data.success.entities.price;
            $scope.productbuiloption = []
            for (let index = 0; index < $scope.arrayproductprices.length; index++) {
                const element = $scope.arrayproductprices[index];
                $scope.productbuiloption.push({
                    option: element.product_option_group_name,
                    id: $("#" + element.product_option_group_uuid + "").val(),
                    name: $("#" + $("#" + element.product_option_group_uuid + "").val() + "").attr("name")
                })
            }
            $scope.optionstring = JSON.stringify($scope.productbuiloption, null, "")
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
        endurl = "https://api.4over.com/shippingquote"
        $http({
            method: 'post',
            url: '/computeshipping',
            data: {
                endpoint: endurl,
                pruuid: $scope.productuuid,
                opuuid: $scope.option_uuid,
                couuid: $scope.colorspec_uuid,
                ruuuid: $scope.runsize_uuid,
                zip: $scope.zip_code,
                type: 1
            },
        }).then(function mySuccess(response) {
            if (response.data.success.status == 'error') {
                console.log("error");
            } else {
                $scope.shipping_options = response.data.success.job.facilities[0].shipping_options
                $scope.address = response.data.success.job.facilities[0].address
            }

        }, function myError(response) {
            console.log(response.statusText);
        });

    }

    $scope.actionoptsend = function (key) {
        switch (key) {
            case "op1":
                $scope.optsend = key
                $scope.buildpricewedesing = 0
                setTimeout(function () {
                    $('#fromBtn').submit();
                }, 100);
                break;
            case "op2":
                $scope.optsend = key
                $scope.buildpricewedesing = 0
                setTimeout(function () {
                    $('#fromBtn').submit();
                }, 100);
                break;
            case "op3":
                $scope.optsend = key
                $scope.buildpricewedesing = 50
                $.confirm({
                    title: 'We design it for you.',
                    content: 'If you take this service will cost $50 additional.',
                    draggable: false,
                    buttons: {
                        confirm: function () {
                            $('#fromBtn').submit();
                        },
                        cancel: function () {
                            $scope.buildpricewedesing = 0
                            $scope.$apply()
                        },
                    }
                })
                break;
            default:
                break;
        }

    }

    $scope.categorias = function () {
        endurl = "https://api.4over.com/printproducts/categories"
        $http({
            method: 'post',
            url: '/4overproducts',
            data: {
                endpoint: endurl
            },
        }).then(function mySuccess(response) {
            $scope.categoriaslist = response.data.success.entities
        }, function myError(response) {
            //console.log(response.statusText);
        });
    }





})



// presentPrice($newTax)

//products validar