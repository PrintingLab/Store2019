  <?php

  use Carbon\Carbon;
  use App\Product;

function getAllProducts(){
    $allproducts = Product::all()->where('type', false);
   
    return $allproducts;
  }


function presentPrice($price)
{
    return '$'.number_format($price, 2);
}

function GetTotalAmout()
{
    return number_format(getNumbers()->get('newTotal'),2, '.', '');
}


function printingPrice($price)
{
    $url = public_path()."/storage/jsonconfig/priceprintinglab.json";
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
      foreach ($json_data as $value) {
          if ($price >=$value['Pinicial'] && $price <=$value['Pfinal']) {
              $newprice =($price*$value['porcentaje'])/100;
             return  $newprice;
          }

     }

}


function printingtax($postalcode)
{
    $url = public_path()."/storage/jsonconfig/zips.json";
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
      foreach ($json_data as $value) {
         if ($postalcode == $value) {
            $taxval  = 6.32;
            break;
         }else {
            $taxval  = 0;
         }
     }
return  $taxval;
}
function Changeoptioname($iname)
{
    $outname="";
    $url = public_path()."/storage/jsonconfig/optionsname.json";
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
      foreach ($json_data as $value) {
          if ($iname ==$value['Name']) {
              $outname =$value['value'];
          }

     }
     if ($outname) {
        return $outname;
    }else{
        return $iname;
    }
}



function OrderStatus($Status){
    switch ($Status) {
        case 0:
            return 'Processing';
            break;
        case 1:
            return 'Shipped';
            break;
       case 2:
            return 'Completed';
            break;
       case 3:
            return 'Canceled';
            break; 
    default:
            'N/A';
            break;
    }
    return($result);
  }


function setActiveCategory($category, $output = 'active')
{
    return request()->category == $category ? $output : '';
}


function getshipingNumbers()
{
    foreach (Cart::content() as $item){
        $price =  $item->options->shiping;
    }
    if (isset($price)) {
       return $price;
    }
} 


function getdesignemode($mode)
{
   switch ($mode) {
       case 'op1':
           return 'UPLOAD YOUR FILE & ORDER NOW';
           break;
       case 'op2':
           return 'Online DESIGN';
           break;
        case 'op3':
           return 'WE DESIGN IT FOR YOU';
           break;
       default:
           'N/A';
           break;
   }
}



function getPrintingTime($prttime)
{
    $method = 'GET';
    $separator ='?';
    $json = '';
    $uri='https://api.4over.com/printproducts/optiongroups/f80e8179-b264-42ce-9f80-bb258a09a1fe/options';
    $result = json_decode(call4overcurl($uri,$method,$separator,$json), true);
    foreach ($result['entities'] as $value) {
        if ($value['option_name'] == $prttime) {
           return $value['option_description'];
          }
       }

  }


  function extensioImg($imagen){
    $result=  ltrim(strstr($imagen, '.'), '.');
    return($result);
  }

  function productsTempleteEps($url){
  $directory = array_diff(scandir($url), array('..', '.'));
  $array_eps=array_diff(scandir($url.$directory[2]), array('..', '.'));
  return($array_eps);
  }

  function productsTempleteJpg($url){
  $directory = array_diff(scandir($url), array('..', '.'));
  $array_jpg=array_diff(scandir($url.$directory[3]), array('..', '.'));
  return($array_jpg);
  }

  function typeFile($url){
    $directory = array_diff(scandir($url), array('..', '.'));
    $imagen=$directory[3];
    return($imagen);
  }

  function presentDate($date)
  {
      return Carbon::parse($date)->format('M d, Y');
  }



  function productImage($path)
  {
      return $path && file_exists('storage/'.$path) ? asset('storage/'.$path) : asset('img/not-found.jpg');
  }



  function getPrintingsides($prttime)
  {
     switch ($prttime) {
         case '4/0':
             return 'Front Only';
             break;
         case '4/4':
             return 'Front and Back';
             break;
         default:
             'N/A';
             break;
     }
  }


  function getNumbers()
  {
      //tax for zip funtion
      $cookie_name="Zipcode";
      if(!isset($_COOKIE[$cookie_name])) {
          $tax = 0 / 100;
     } else {
      $tax = printingtax($_COOKIE[$cookie_name]) / 100;
     }
      $discount = session()->get('coupon')['discount'] ?? 0;
      $code = session()->get('coupon')['name'] ?? null;
      $newSubtotal = (Cart::subtotal() - $discount);
      $shiping = getshipingNumbers();
      if ($newSubtotal < 0) {
          $newSubtotal = 0;
      }
      $newTax = $newSubtotal * $tax;
      $newTotal = ($newSubtotal * (1 + $tax)) + getshipingNumbers();

      return collect([
          'tax' => $tax,
          'discount' => $discount,
          'code' => $code,
          'newSubtotal' => $newSubtotal,
          'newTax' => $newTax,
          'newTotal' => $newTotal,
          'shiping' => $shiping,
      ]);
  }
  function get4overprices($UUID,$runsize,$colorspec,$TurnAroundTime)
  {
        $method = 'GET';
        $separator ='?';
        $json = '';
        $enponit='https://api.4over.com/printproducts/products/'.$UUID.'/baseprices';
        $enponitoption='https://api.4over.com/printproducts/products/'.$UUID.'/optiongroups';
        $result2 = json_decode(call4overcurl($enponitoption,$method,$separator,$json), true);

        foreach ($result2['entities'] as $value) {
          if ($value['product_option_group_name'] == 'Turn Around Time') {
             $TurnAroundTimeoptions = $value['options'];
            }
         }
        $result = json_decode(call4overcurl($enponit,$method,$separator,$json), true);
        foreach ($result['entities'] as $value) {
           if ($runsize ==$value['runsize'] && $colorspec ==$value['colorspec']) {
            $firtprice = $value['product_baseprice'];
           }
     }
     foreach ($TurnAroundTimeoptions as $value) {
      if ($runsize ==$value['runsize'] && $colorspec == $value['colorspec'] && $TurnAroundTime == $value['option_name']) {
          $result3= json_decode(call4overcurl($value['option_prices'],$method,$separator,$json), true)['entities'];
          if (isset($result3[0]['price'])) {
              $secondprice = $result3[0]['price'];
          }
      }
      if (isset($secondprice)) {
          $sumprice = $firtprice+$secondprice;
            return  number_format($sumprice, 2);
      }else {
             return number_format($firtprice, 2);
      }

      }

  }
  function getStockLevel($quantity)
  {
      if ($quantity > setting('site.stock_threshold', 5)) {
          $stockLevel = '<div class="badge badge-success">In Stock</div>';
      } elseif ($quantity <= setting('site.stock_threshold', 5) && $quantity > 0) {
          $stockLevel = '<div class="badge badge-warning">Low Stock</div>';
      } else {
          $stockLevel = '<div class="badge badge-danger">Not available</div>';
      }
      return $stockLevel;
  }

  function call4overcurl($uri,$method,$separator,$json) {
      $public_key = 'printinglab';
      $private_key = '4HT62RVQ';
      if ($method == 'GET' || $method == 'DELETE') {
      $apiPath=$uri.$separator.'apikey='.$public_key.'&signature='.hash_hmac('sha256', $method, hash('sha256', $private_key)).'&max=1000';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$apiPath);
      $args = array(
        'method' => $method,
        'timeout' => 20
      );
      curl_setopt($ch, CURLOPT_HTTPHEADER, $args);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
      }
      if ($method == 'POST'){
    $apiPath=$uri.$separator.'apikey='.$public_key.'&signature='.hash_hmac('sha256', $method, hash('sha256', $private_key)).'&max=500';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$apiPath);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
      }
    }
