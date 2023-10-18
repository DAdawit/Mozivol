@extends('admin.layouts.master')
@section('title','Edit Product: '. $product->product_name.' | ')
@section('body')



<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            {{__("Edit Product")}} {{ $product->product_name }}
        </div>
    </div>

    <div class="box-body">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">{{ __("Product Details") }}</a></li>
                <li><a href="#tab_2" data-toggle="tab">{{ __("Manage Inventory") }}</a></li>
                <li><a href="#tab_3" data-toggle="tab">{{ __("Product Specifications") }}</a></li>
                <li><a href="#tab_4" data-toggle="tab">{{ __("Product FAQ's") }}</a></li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">

                    <div class="row">
                        <form action="{{ route("simple-products.update",$product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            <div class="col-md-9">

                                @csrf
                                @method('PUT')



                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label>Product Name: <span class="text-red">*</span></label>
                                            <input placeholder="{{ __("Enter product name") }}" required type="text"
                                                value="{{ $product->product_name }}" class="form-control"
                                                name="product_name">
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                Product Brand: <span class="required">*</span>
                                            </label>
                                            <select data-placeholder="Please select brand" required="" name="brand_id"
                                                class="select2 form-control">
                                                <option value="">Please Select</option>
                                                @if(!empty($brands_all))
                                                @foreach($brands_all as $brand)
                                                <option {{$product['brand_id'] == $brand['id'] ? "selected" : "" }}
                                                    value="{{$brand->id}}">
                                                    {{$brand->name}} </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                Product Store: <span class="text-red">*</span>
                                            </label>
                                            <select data-placeholder="Please select store" required="" name="store_id"
                                                class="form-control select2">

                                                <option value="">Please select store</option>

                                                @foreach($stores as $store)
                                                <optgroup label="Store Owner • {{ $store->user->name }}">
                                                    <option {{$product['store_id'] == $store['id'] ? "selected" : "" }}
                                                        value="{{ $store->id }}">
                                                        {{ $store->name }}</option>
                                                </optgroup>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Product Description: <span class="text-red">*</span></label>
                                            <textarea placeholder="{{ __("Enter product details") }}" class="editor"
                                                name="product_detail" id="product_detail" cols="30"
                                                rows="10">{{ $product->product_detail }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Product Category: <span class="text-red">*</span></label>
                                            <select data-placeholder="{{ __("Please select category") }}"
                                                name="category_id" id="category_id" class="form-control select2">
                                                <option value="">{{ __("Please select category") }}</option>
                                                @foreach($categories as $category)
                                                <option {{ $product->category_id == $category->id ? "selected" : "" }}
                                                    value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Product Subategory: <span class="text-red">*</span></label>

                                            <select data-placeholder="Please select subcategory" required=""
                                                name="subcategory_id" id="upload_id" class="form-control select2">
                                                <option value="">Please Select</option>
                                                @foreach($product->category->subcategory as $item)
                                                <option {{ $item->id == $product->subcategory_id ? "selected" : "" }}
                                                    value="{{ $item->id }}">{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                Childcategory:
                                            </label>
                                            <select data-placeholder="Please select childcategory" name="child_id"
                                                id="grand" class="form-control select2">
                                                <option value="">Please choose</option>
                                                @foreach($product->subcategory->childcategory as $item)
                                                <option {{ $item->id == $product->child_id ? "selected" : "" }}
                                                    value="{{ $item->id }}">{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Product Tags:</label>
                                            <input placeholder="{{ __("Enter product tags by comma") }}" type="text"
                                                class="form-control" name="product_tags"
                                                value="{{ $product->product_tags }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Model No:</label>
                                            <input placeholder="{{ __("Enter product modal name or no.") }}" type="text"
                                                class="form-control" name="model_no" value="{{ $product->model_no }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>HSIN : <span class="text-red">*</span></label>
                                            <input required placeholder="{{ __("Enter product HSIN code") }}"
                                                type="text" class="form-control" name="hsin"
                                                value="{{ $product->hsin }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>SKU :</label>
                                            <input required placeholder="{{ __("Enter product SKU code") }}" type="text"
                                                class="form-control" name="sku" value="{{ $product->sku }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Price: <span class="text-red">*</span></label>
                                            <input min="1" placeholder="{{ __("Enter product price") }}" required
                                                type="number" class="form-control" name="actual_selling_price"
                                                step="0.01" value="{{ $product->actual_selling_price }}">
                                        </div>


                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Offer Price: </label>
                                            <input min="1" placeholder="{{ __("Enter product offer price") }}"
                                                type="number" class="form-control" name="actual_offer_price" step="0.01"
                                                value="{{ $product->actual_offer_price }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tax: <span class="text-red">*</span> <small>({{__("This tax % will add in given price.")}})</small></label>
                                            <input placeholder="{{ __("Enter product tax in %") }}" required
                                                type="number" class="form-control" name="tax" step="1"
                                                value="{{ $product->tax }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tax name: <span class="text-red">*</span></label>
                                            <input placeholder="{{ __("Enter product name") }}" required type="text"
                                                class="form-control" name="tax_name" value="{{ $product->tax_name }}">
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Product Thumbnail Image: </label>
                                            <input name="thumbnail" class="form-control" type="file">
                                            <small class="text-muted">
                                                <i class="fa fa-question-circle"></i>
                                                {{__("Please select product thumbnail")}}
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Product Hover Thumbnail Image:</label>
                                            <input name="hover_thumbnail" class="form-control" type="file">
                                            <small class="text-muted">
                                                <i class="fa fa-question-circle"></i>
                                                {{__("Please select product hover thumbnail")}}
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Product Gallery Images:</label>
                                            <input multiple name="images[]" class="form-control" type="file">
                                            <small class="text-muted">
                                                <i class="fa fa-question-circle"></i>
                                                {{__("Multiple images can be choosen")}}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div
                                        class="{{ $product->product_file !='' ? "" : "display-none" }} product_file col-md-12">
                                        <div class="form-group">
                                            <label>Update Downloadable Product File: <span
                                                    class="text-red">*</span></label>
                                            <input name="product_file" class="form-control" type="file">
                                            <small class="text-muted">
                                                <i class="fa fa-question-circle"></i> {{__("Max file size is 50 MB")}}
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label>Status :</label>
                                            <br>
                                            <label class="switch">
                                                <input type="checkbox" name="status"
                                                    {{ $product->status == '1' ? "checked" : "" }}>
                                                <span class="knob"></span>
                                            </label>
                                            <br>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Toggle the
                                                product status</b>.</small>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Free Shipping :</label>
                                            <br>
                                            <label class="switch">
                                                <input type="checkbox" name="free_shipping"
                                                    {{ $product->free_shipping == '1' ? "checked" : "" }}>
                                                <span class="knob"></span>
                                            </label>
                                            <br>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Toggle to
                                                allow free
                                                shipping on product.</b></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Featured :</label>
                                            <br>
                                            <label class="switch">
                                                <input type="checkbox" name="featured"
                                                    {{ $product->featured == '1' ? "checked" : "" }}>
                                                <span class="knob"></span>
                                            </label>
                                            <br>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Toggle to
                                                allow product
                                                is featured.</b></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Cancel available :</label>
                                            <br>
                                            <label class="switch">
                                                <input type="checkbox" name="cancel_avbl"
                                                    {{ $product->cancel_avbl == '1' ? "checked" : "" }}>
                                                <span class="knob"></span>
                                            </label>
                                            <br>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Toggle to
                                                allow product
                                                cancellation on order.</b></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Cash on delivery available :</label>
                                            <br>
                                            <label class="switch">
                                                <input type="checkbox" name="cod_avbl"
                                                    {{ $product->cod_avbl == '1' ? "checked" : "" }}>
                                                <span class="knob"></span>
                                            </label>
                                            <br>
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Toggle to
                                                allow COD on
                                                product.</b></small>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="">Return Available :</label>
                                        <select data-placeholder="Please choose an option" required=""
                                            class="form-control select2" id="choose_policy" name="return_avbl">
                                            <option value="">Please choose an option</option>
                                            <option {{ $product['return_avbl'] =='1' ? "selected" : "" }} value="1">
                                                Return Available</option>
                                            <option {{ $product['return_avbl'] =='0' ? "selected" : "" }} value="0">
                                                Return Not Available</option>
                                        </select>
                                        <br>
                                        <small class="text-desc">(Please choose an option that return will be available
                                            for this product or not)</small>


                                    </div>

                                    <div id="policy"
                                        class="{{ $product['return_avbl'] == 1 ? '' : 'display-none' }} form-group col-md-4">
                                        <label>
                                            Select Return Policy: <span class="required">*</span>
                                        </label>
                                        <select data-placeholder="Please select return policy" name="policy_id"
                                            class="form-control select2">
                                            <option value="">Please select return policy</option>

                                            @foreach(App\admin_return_product::where('created_by',Auth::user()->id)->get()
                                            as $policy)
                                            <option {{ $product['policy_id'] == $policy->id ? "selected" : "" }}
                                                value="{{ $policy->id }}">{{ $policy->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-success">
                                        <i class="fa fa-save"></i> {{__("Update product")}}
                                    </button>

                                    <a href="{{ route('simple-products.index') }}" role="button"
                                        class="btn btn-md btn-default">
                                        <i class="fa fa-arrow-left"></i> {{__("Back")}}
                                    </a>
                                </div>



                            </div>

                            <div class="col-md-3">
                                <div class="well">
                                    <label>{{ __("Current product thumbnail:") }}</label>
                                    <a href="{{ url('images/simple_products/'.$product->thumbnail) }}"
                                        data-lightbox="image-1" data-title="{{ $product->thumbnail }}">
                                        <img src="{{ url('images/simple_products/'.$product->thumbnail) }}"
                                            alt="{{ $product->thumbnail }}" class="img-fluid img-thumbnail">
                                    </a>
                                </div>
                                <p></p>
                                <div class="well">
                                    <label>{{ __("Current product hover-thumbnail:") }}</label>
                                    <a href="{{ url('images/simple_products/'.$product->hover_thumbnail) }}"
                                        data-lightbox="image-1" data-title="{{ $product->hover_thumbnail }}">
                                        <img src="{{ url('images/simple_products/'.$product->hover_thumbnail) }}"
                                            alt="{{ $product->hover_thumbnail }}" class="img-fluid img-thumbnail">
                                    </a>
                                </div>
                                <div class="well">

                                    <label>{{ __("Product Gallery Images:") }}</label>
                                    <br>
                                    @forelse($product->productGallery as $gallery)
                                    <a href="{{ url('images/simple_products/gallery/'.$gallery->image) }}"
                                        data-lightbox="image-1" data-title="{{ $gallery->image }}">
                                        <img src="{{ url('images/simple_products/gallery/'.$gallery->image) }}"
                                            alt="{{ $gallery->image }}" class="img-fluid pro-img img-thumbnail">
                                    </a>
                                    @empty
                                    {{__("No images in product gallery.")}}
                                    @endforelse

                                </div>

                                <div class="{{ $product->product_file !='' ? "" : "display-none" }} well">

                                    <label>{{ __("Current downloadable Product File:") }}</label>

                                    <p>
                                        <a href="{{ storage_path('digitalproducts/files/'.$product->product_file) }}"><i
                                                class="fa fa-download"></i> {{ $product->product_file }}</a>
                                    </p>

                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <h4>{{ __("Manage Inventory") }}</h4>
                    <hr>
                    <form action="{{ route("manage.inventory",$product->id) }}" method="POST">
                        @csrf

                       

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __("Stock") }} <span class="text-red">*</span></label>
                                    <input class="form-control" type="number" min="0" value="{{ $product->stock ?? old('stock') }}" name="stock">
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __("Minimum Order Qty.") }} <span class="text-red">*</span></label>
                                    <input class="form-control" type="number" min="1" value="{{ $product->min_order_qty ?? old('min_order_qty') }}" name="min_order_qty">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __("Maxium Order Qty.") }}</label>
                                    <input class="form-control" type="number" min="1" value="{{ $product->max_order_qty ?? old('max_order_qty') }}" name="max_order_qty">
                                </div>
                            </div>
                        </div>

                       

                       

                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-success">
                                 <i class="fa fa-save"></i> {{__("Update")}}
                            </button>
                        </div>
                        
                    </form>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <h3>Edit Product Specification</h3>
                    <hr>
                    <a type="button" class="btn btn-danger btn-md z-depth-0" data-toggle="modal"
                        data-target="#bulk_delete"><i class="fa fa-trash"></i> Delete Selected</a>
                    <hr>
                    <form action="{{ route('pro.specs.store',$product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" value="yes" name="simple_product">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <th>
                                    <div class="inline">
                                        <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                            value="all" />
                                        <label for="checkboxAll" class="material-checkbox"></label>
                                    </div>

                                </th>
                                <th>Key</th>
                                <th>Value</th>
                                <th>#</th>
                            </thead>

                            <tbody>
                                @if(isset($product->specs))
                                @foreach($product->specs as $spec)
                                <tr>
                                    <td>
                                        <div class="inline">
                                            <input type="checkbox" form="bulk_delete_form"
                                                class="filled-in material-checkbox-input" name="checked[]"
                                                value="{{$spec->id}}" id="checkbox{{$spec->id}}">
                                            <label for="checkbox{{$spec->id}}" class="material-checkbox"></label>
                                        </div>
                                    </td>
                                    <td>{{ $spec->prokeys }}</td>
                                    <td>{{ $spec->provalues }}</td>
                                    <td>

                                        <a data-toggle="modal" title="Edit" data-target="#edit{{ $spec->id }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fa fa-pencil"></i>
                                        </a>




                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <table class="table table-striped table-bordered" id="dynamic_field">

                            <tbody>
                                <tr>
                                    <td>
                                        <input required="" name="prokeys[]" type="text" class="form-control" value=""
                                            placeholder="Product Attribute">
                                    </td>

                                    <td>
                                        <input required="" name="provalues[]" type="text" class="form-control" value=""
                                            placeholder="Attribute Value">
                                    </td>
                                    <td>
                                        <button type="button" name="add" id="add" class="btn btn-xs btn-success">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <div class="container-fluid">
                            <button class="btn btn-primary btn-md"><i class="fa fa-plus"></i> Add</button>
                        </div>
                    </form>


                    @if(isset($product->specs))
                    @foreach($product->specs as $spec)
                    <div id="edit{{ $spec->id }}" class="delete-modal modal fade" role="dialog">
                        <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="modal-title">Edit : <b>{{ $spec->prokeys }}</b></div>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('pro.specs.update',$spec->id) }}" method="POST">
                                        @csrf
                                        

                                        <div class="form-group">
                                            <label>Attribute Key:</label>
                                            <input required="" type="text" name="pro_key" value="{{ $spec->prokeys }}"
                                                class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Attribute Value:</label>
                                            <input required="" type="text" name="pro_val" value="{{ $spec->provalues }}"
                                                class="form-control">
                                        </div>


                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                            Save</button>
                                        <button type="reset" class="btn btn-danger translate-y-3"
                                            data-dismiss="modal">Cancel</button>



                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif






                </div>
                <!-- /.tab-pane -->
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_4">
                    <div class="panel-heading">
                        <a data-toggle="modal" data-target="#addFAQ" class="btn btn-success owtbtn"><i
                                class="fa fa-plus-circle"></i> Add FAQ</a>
                        <br>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($product->faq as $key => $f)

                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$f->simpleproduct->product_name}}</td>
                                <td>{{ $f->question }}</td>
                                <td>{!!$f->answer!!}</td>
                                <td>
                                    <a title="Edit FAQ" data-toggle="modal" data-target="#editfaq{{ $f->id }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a title="Delete this FAQ?" data-toggle="modal" data-target="#{{ $f->id }}faqdel"
                                        class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    @foreach($product->faq as $key => $f)
                    <div id="{{ $f->id }}faqdel" class="delete-modal modal fade" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <div class="delete-icon"></div>
                                </div>
                                <div class="modal-body text-center">
                                    <h4 class="modal-heading">Are You Sure ?</h4>
                                    <p>Do you really want to delete this faq? This process cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form method="post" action="{{url('admin/product_faq/'.$f->id)}}"
                                        class="pull-right">
                                        {{csrf_field()}}
                                        {{method_field("DELETE")}}
                                        <button type="reset" class="btn btn-gray translate-y-3"
                                            data-dismiss="modal">No</button>
                                        <button type="submit" class="btn btn-danger">Yes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach($product->faq as $key => $f)
                    <!-- EDIT FAQ Modal -->
                    <div class="modal fade" id="editfaq{{ $f->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Edit FAQ: {{ $f->question }}</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="demo-form2" method="post" action="{{route('product_faq.update',$f->id)}}">
                                        {{ method_field("PUT") }}
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Question: <span class="required">*</span></label>
                                            <input required="" type="text" name="question" value="{{ $f->question }}"
                                                class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Answer: <span class="required">*</span></label>
                                            <textarea required="" cols="10" id="answerarea" name="answer" rows="5"
                                                class="form-control editor">{{ $f->answer }}</textarea>
                                            <input type="hidden" readonly name="pro_id" value="{{ $product->id }}">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Please enter
                                                answer for above question ! </small>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-plus-save"></i> Save
                                        </button>


                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Create FAQ Modal -->
                    <div class="modal fade" id="addFAQ" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Add new FAQ</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="demo-form2" method="post" action="{{url('admin/product_faq')}}">
                                        @csrf
                                        <input type="hidden" value="yes" name="simple_product">
                                        <div class="form-group">
                                            <label for="">Question: <span class="required">*</span></label>
                                            <input type="text" name="question" value="{{old('question')}}"
                                                class="form-control">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Please write
                                                question !</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Answer: <span class="required">*</span></label>
                                            <textarea cols="10" id="editor1" name="answer" rows="5"
                                                class="form-control">{{old('answer')}}</textarea>
                                            <input type="hidden" readonly name="pro_id" value="{{ $product->id }}">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> Please enter
                                                answer for above question ! </small>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-plus-circle"></i> Create
                                        </button>


                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>


    </div>
</div>
@endsection
@section('custom-script')

@endsection