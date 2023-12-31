<?php
namespace App\Http\Controllers;

use App\Hotdeal;
use App\Product;
use Image;
use Illuminate\Http\Request;


class HotdealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('hotdeals.view'),403,'User does not have the right permissions.');
        $products = Hotdeal::with('pro')->get();
        return view('admin.hotdeal.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('hotdeals.create'),403,'User does not have the right permissions.');
        $products = Product::all();
        return view("admin.hotdeal.add", compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('hotdeals.create'),403,'User does not have the right permissions.');

         $input = $request->all();

        if(isset($request->status)){
            $input['status'] = '1';
        }else{
            $input['status'] = '0';
        }

        Hotdeal::create($input);


        return back()
            ->with("added", "Deal Has Been Created");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hotdeal  $hotdeal
     * @return \Illuminate\Http\Response
     */
    public function show(Hotdeal $hotdeal)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hotdeal  $hotdeal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   

        abort_if(!auth()->user()->can('hotdeals.edit'),403,'User does not have the right permissions.');

        $products = Hotdeal::find($id);
        return view("admin.hotdeal.edit", compact("products"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hotdeal  $hotdeal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        abort_if(!auth()->user()->can('hotdeals.edit'),403,'User does not have the right permissions.');

        $datas = new Hotdeal;
        $obj = $datas->find($id);
        $obj->start = $request->start;
        $obj->end = $request->end;
        $obj->pro_id = $request->pro_id;
        $obj->status = $request->status;
        $value = $obj->save();

        return redirect('admin/hotdeal')
            ->with('updated', 'Deal has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hotdeal  $hotdeal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('hotdeals.delete'),403,'User does not have the right permissions.');

        $product = Hotdeal::find($id);
        $value = $product->delete();
        if ($value)
        {
            $pro = $product->pro_id;
            $daa = new Product;
            $obj = $daa->findorFail($pro);
            $obj->offer_price = '';
            $obj->save();
            session()
                ->flash("deleted", "Deal Has Been Deleted");
            return redirect("admin/hotdeal");
        }
    }
}

