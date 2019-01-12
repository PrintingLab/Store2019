<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';

    protected $fillable = ['order_id', 'product_id','product_decription', 'quantity','colorspecuuid', 'imgF','imgB', 'optionuuid','produtcode', 'produtid','runsizeuuid', 'side','tat', 'Proofing','comment','Optionstring'];
}
