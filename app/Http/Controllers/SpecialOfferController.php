<?php

namespace App\Http\Controllers;

use App\SpecialOffer;
use Illuminate\Http\Request;
use App\Product;
use DB;


class SpecialOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('specialoffer.view'),403,'User does not have the right permissions.');

        $products = SpecialOffer::with('pro')->get();
        return view('admin.special.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('specialoffer.create'),403,'User does not have the right permissions.');
        $products = Product::all();
        return view("admin.special.add",compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('specialoffer.create'),403,'User does not have the right permissions.');

         $input = $request->all();

          $data = SpecialOffer::create($input);
        
          $data->save();
       

        return back()->with("added","Special Offer Has Been Created !");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function show(SpecialOffer $specialOffer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
        abort_if(!auth()->user()->can('specialoffer.edit'),403,'User does not have the right permissions.');

        $products_pro = Product::all();
        $products = SpecialOffer::find($id);
        return view("admin.special.edit",compact("products","products_pro"));
      
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('specialoffer.edit'),403,'User does not have the right permissions.');

        $brand = SpecialOffer::findOrFail($id);

        $input = $request->all();  
        
        $brand->update($input);

        return redirect('admin/special')->with('updated', 'Special Offer has been updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        abort_if(!auth()->user()->can('specialoffer.delete'),403,'User does not have the right permissions.');

         $daa = new SpecialOffer;
          $obj = $daa->findorFail($id);
          $value = $obj->delete();
         if($value){
            session()->flash("deleted","Special Offer Has Been deleted");
             return redirect("admin/special");
        }
    }

    public function show_widget()
    {
        $slide = DB::table('special_offer_widget')->first();
        return view('admin.special.widget.index',compact('slide'));
    }

    public function update_widget(Request $request)
    {   
        $slider_wid = DB::table('special_offer_widget')->first();
        if(!empty($slider_wid)){
            $slider = DB::table('special_offer_widget')->update(['slide_count'=>$request->slider]);   
        }
        else{
               DB::table('special_offer_widget')->insert(
                    array(
                            
                            'slide_count'   =>   $request->slider
                    )
                );    
        }
         
            
            return back();
        }

}
