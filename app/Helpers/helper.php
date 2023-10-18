<?php

use App\Cart;
use App\ProductAttributes;
use App\ProductValues;
use App\Shipping;
use App\ShippingWeight;
use App\Wishlist;

function getPlanStatus()
{

    if (auth()->user()->activeSubscription && date('Y-m-d h:i:s') <= auth()->user()->activeSubscription->end_date && auth()->user()->activeSubscription->status == 1) {

        return 1;

    } else {

        if (auth()->user()->activeSubscription) {

            auth()->user()->activeSubscription()->update([
                'status' => 0,
            ]);
        }

        return 0;
    }

}

function extended_license()
{

    if (!@file_get_contents(storage_path() . '/app/extended/extended.json')) {

        return false;
    }

    $code = json_decode(@file_get_contents(storage_path() . '/app/extended/extended.json'), true);

    if (!preg_match("/^(\w{8})-((\w{4})-){3}(\w{12})$/", $code)) {
        //throw new Exception("Invalid code");
        $logmessage = __("Invalid Purchase Code");
        return false;
    }

    return true;

}

function shippingprice($cart)
{

    $shipping = 0;

    if (isset($cart->simple_product)) {
        if ($cart->simple_product->free_shipping == '0') {

            $free_shipping = Shipping::where('default_status', '=', '1')->first();

            if (!empty($free_shipping)) {

                if ($free_shipping->name == "Shipping Price") {

                    $weight = ShippingWeight::first();
                    $pro_weight = $cart->simple_product->weight;
                    if ($weight->weight_to_0 >= $pro_weight) {
                        if ($weight->per_oq_0 == 'po') {
                            $shipping = $shipping + $weight->weight_price_0;
                        } else {
                            $shipping = $shipping + $weight->weight_price_0 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_1 >= $pro_weight) {
                        if ($weight->per_oq_1 == 'po') {
                            $shipping = $shipping + $weight->weight_price_1;
                        } else {
                            $shipping = $shipping + $weight->weight_price_1 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_2 >= $pro_weight) {
                        if ($weight->per_oq_2 == 'po') {
                            $shipping = $shipping + $weight->weight_price_2;
                        } else {
                            $shipping = $shipping + $weight->weight_price_2 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_3 >= $pro_weight) {
                        if ($weight->per_oq_3 == 'po') {
                            $shipping = $shipping + $weight->weight_price_3;
                        } else {
                            $shipping = $shipping + $weight->weight_price_3 * $cart->qty;
                        }
                    } else {
                        if ($weight->per_oq_4 == 'po') {
                            $shipping = $shipping + $weight->weight_price_4;
                        } else {
                            $shipping = $shipping + $weight->weight_price_4 * $cart->qty;
                        }

                    }

                } else {

                    $shipping = $shipping + $free_shipping->price;

                }
            }
        }
    }

    return $shipping;

}

function getcarttotal()
{

    $total = 0;

    foreach (auth()->user()->cart as $val) {

        if ($val->product && $val->variant) {
            if ($val->product->tax_r != null && $val->product->tax == 0) {

                if ($val->ori_offer_price != 0) {
                    //get per product tax amount
                    $p = 100;
                    $taxrate_db = $val->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $val->product->offer_price / $vp * $taxrate_db;
                    $taxAmnt = sprintf("%.2f", $taxAmnt);
                    $price = ($val->ori_offer_price - $taxAmnt) * $val->qty;

                } else {

                    $p = 100;
                    $taxrate_db = $val->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $val->product->price / $vp * $taxrate_db;

                    $taxAmnt = sprintf("%.2f", $taxAmnt);

                    $price = ($val->ori_price - $taxAmnt) * $val->qty;
                }

            } else {

                if ($val->semi_total != 0) {

                    $price = $val->semi_total;

                } else {

                    $price = $val->price_total;

                }
            }
        }

        if ($val->simple_product) {
            if ($val->semi_total != 0) {

                $price = $val->semi_total - $val->tax_amount;

            } else {

                $price = $val->price_total - $val->tax_amount;

            }
        }

        $total = $total + $price;

    }

    return $total;
}

function variantname($orivar){

    $i = 0 ;

    $varcount = count($orivar->main_attr_value);

    foreach($orivar->main_attr_value as $key=> $orivars){

            $i++; 
            $getvarvalue = ProductValues::where('id',$orivars)->first();
            

            if($i < $varcount){

                if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null){

                    if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour"){
                        echo  $getvarvalue->values.',';
                    }else{
                        echo $getvarvalue->values . $getvarvalue->unit_value.',';
                    }

                }else{
                    echo  $getvarvalue->values.',';
                }
                    
                
            }else{

                if(strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null){
                    
                    if($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour"){
                        echo  $getvarvalue->values;
                    }else{
                        echo $getvarvalue->values . $getvarvalue->unit_value;
                    }

                }else{
                    echo  $getvarvalue->values;
                }
                
            }
    }
}

function inwishlist($id){

    if(auth()->check()){

        $check = Wishlist::where('user_id',auth()->id())->where('simple_pro_id',$id)->first();

        if(isset($check)){
            return true;
        }else{
            return false;
        }

    }else{
        return false;
    }

}

function chekcincart($id){

    if(auth()->check()){

        $check = Cart::where('user_id',auth()->id())->where('simple_pro_id',$id)->first();

        if(isset($check)){
            return true;
        }else{
            return false;
        }

    }else{
        return false;
    }

}


