<?php
namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;



class CategoryController extends Controller
{

    public function index()
    {
        abort_if(!auth()->user()->can('category.view'),403,'User does not have the right permissions.');
        $category = Category::orderBy('position', 'asc')->get();
        return view("admin.category.index", compact("category"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        abort_if(!auth()->user()->can('category.create'),403,'User does not have the right permissions.');
        return view("admin.category.add_category");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('category.create'),403,'User does not have the right permissions.');

        $request->validate(["title" => "required"], [
            "title.required" => "Category Name is required"
        ]);

        $input = $request->all();

        $input['description'] = clean($request->description);

        $cat = new Category();

        if ($file = $request->file('image')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/category/';
            $image = time() . $file->getClientOriginalExtension();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image, 90);

            $input['image'] = $image;

        }

        $input['position'] = (Category::count() + 1);

        $cat->create($input);

        return back()->with("added", "Category Has Been Added !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function reposition(Request $request)
    {
        abort_if(!auth()->user()->can('category.edit'),403,'User does not have the right permissions.');

        if ($request->ajax()) {

            $posts = Category::all();
            foreach ($posts as $post) {
                foreach ($request->order as $order) {
                    if ($order['id'] == $post->id) {
                        \DB::table('categories')->where('id', $post->id)->update(['position' => $order['position']]);
                    }
                }
            }
            return response()->json('Update Successfully.', 200);

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('category.edit'),403,'User does not have the right permissions.');

        $cat = Category::findOrFail($id);

        return view("admin.category.edit", compact("cat"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        abort_if(!auth()->user()->can('category.edit'),403,'User does not have the right permissions.');

        $request->validate( 
            [
                "title" => "required"
            ],[
                "title.required" => "Name is needed"
            ]
        );

        $cat = Category::findOrFail($id);

        $category = Category::findOrFail($id);
        $input = $request->all();

        $input['description'] = clean($request->description);

        if ($file = $request->file('image')) {

            if ($category->image != '' && file_exists(public_path() . '/images/category/' . $category->image)) {
                unlink(public_path() . '/images/category/' . $category->image);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/category/';
            $name = time() . $file->getClientOriginalExtension();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $name, 90);

            $input['image'] = $name;

        }

        $category->update($input);

        return redirect('admin/category')->with('updated', 'Category has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('category.delete'),403,'User does not have the right permissions.');

        $category = Category::find($id);

        if (count($category->products) > 0) {
            return back()
                ->with('warning', 'Category cant be deleted as its linked to products !');
        }

        if ($category->image != '' && file_exists(public_path() . '/images/category/' . $category->image)) {
            unlink(public_path() . '/images/category/' . $category->image);
        }

        $value = $category->delete();
        if ($value) {
            session()->flash("deleted", "Category Has Been Deleted");
            return redirect("admin/category");
        }
    }

}
