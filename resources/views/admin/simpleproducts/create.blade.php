@extends('admin.layouts.master')
@section('title','Create new product | ')
@section('body')
<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            {{__("Create new product")}}
        </div>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form action="{{ route("simple-products.store") }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product Type: <span class="text-red">*</span></label>
                                <select required data-placeholder="{{ __("Please select product type") }}" name="type" id="product_type" class="select2 product_type form-control">
                                    <option value="">{{ __("Please select product type") }}</option>
                                    <option value="simple_product">{{ __("Simple Product") }}</option>
                                    <option value="d_product">{{ __("Digital Product") }}</option>
                                    <option value="ex_product">{{ __("External Product") }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product Name: <span class="text-red">*</span></label>
                                <input placeholder="{{ __("Enter product name") }}" required type="text"
                                    value="{{ old('product_name') }}" class="form-control" name="product_name">
                            </div>
                        </div>

                        <div class="ex_pro_link display-none col-md-12">
                            <div class="form-group">
                                <label>Product Link: <span class="text-red">*</span></label>
                                <input placeholder="{{ __("Enter product link: https:// ") }}" type="text"
                                    value="{{ old('external_product_link') }}" class="form-control" name="external_product_link">
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
                                    <option value="{{$brand->id}}"
                                        {{ $brand->id == old('brand_id') ? 'selected="selected"' : '' }}>
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
                                        <option {{ old('store_id') == $store->id ? "selected" : "" }}
                                            value="{{ $store->id }}">
                                            {{ $store->name }}</option>
                                    </optgroup>
                                    @endforeach


                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label> Key Features :
                        </label>
                        <textarea class="form-control editor" name="key_features">{!! old('key_features') !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Product Description: <span class="text-red">*</span></label>
                        <textarea placeholder="{{ __("Enter product details") }}" class="editor" name="product_detail"
                            id="product_detail" cols="30" rows="10">{{ old('product_detail') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product Category: <span class="text-red">*</span></label>
                                <select data-placeholder="{{ __("Please select category") }}" name="category_id"
                                    id="category_id" class="form-control select2">
                                    <option value="">{{ __("Please select category") }}</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product Subategory: <span class="text-red">*</span></label>

                                <select data-placeholder="Please select subcategory" required="" name="subcategory_id"
                                    id="upload_id" class="form-control select2">
                                    <option value="">Please Select</option>

                                </select>
                            </div>


                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    Childcategory:
                                </label>
                                <select data-placeholder="Please select childcategory" name="child_id" id="grand"
                                    class="form-control select2">
                                    <option value="">Please choose</option>

                                </select>
                            </div>


                        </div>

                       

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Product Tags:</label>
                                <input placeholder="{{ __("Enter product tags by comma") }}" type="text"
                                    class="form-control" name="product_tags" value="{{ old('product_tags') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Model No:</label>
                                <input placeholder="{{ __("Enter product modal name or no.") }}" type="text"
                                    class="form-control" name="model_no" value="{{ old('model_no') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>HSIN : <span class="text-red">*</span></label>
                                <input required placeholder="{{ __("Enter product HSIN code") }}" type="text"
                                    class="form-control" name="hsin" value="{{ old('hsin') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SKU :</label>
                                <input required placeholder="{{ __("Enter product SKU code") }}" type="text"
                                    class="form-control" name="sku" value="{{ old('sku') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Price: <span class="text-red">*</span></label>
                                <input min="1" placeholder="{{ __("Enter product price") }}" required type="number"
                                    class="form-control" name="actual_selling_price" step="0.01" value="{{ old('actual_selling_price') }}">
                            </div>


                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Offer Price: </label>
                                <input min="1" placeholder="{{ __("Enter product offer price") }}" type="number"
                                    class="form-control" name="actual_offer_price" step="0.01"
                                    value="{{ old('actual_offer_price') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tax: <span class="text-red">*</span> <small>({{__("This tax % will add in given price.")}})</small> </label>
                                <input min="0" placeholder="{{ __("Enter product tax in %") }}" required type="number"
                                    class="form-control" name="tax" step="0.01" value="{{ old('tax') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tax name: <span class="text-red">*</span></label>
                                <input placeholder="{{ __("Enter product name") }}" required type="text"
                                    class="form-control" name="tax_name" value="{{ old('tax_name') }}">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product Thumbnail Image: <span class="text-red">*</span></label>
                                <input multiple required name="thumbnail" class="form-control" type="file">
                                <small class="text-muted">
                                    <i class="fa fa-question-circle"></i> {{__("Please select product thumbnail")}}
                                </small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product Hover Thumbnail Image: <span class="text-red">*</span></label>
                                <input multiple required name="hover_thumbnail" class="form-control" type="file">
                                <small class="text-muted">
                                    <i class="fa fa-question-circle"></i>
                                    {{__("Please select product hover thumbnail")}}
                                </small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Other Product Images: <span class="text-red">*</span></label>
                                <input multiple required name="images[]" class="form-control" type="file">
                                <small class="text-muted">
                                    <i class="fa fa-question-circle"></i> {{__("Multiple images can be choosen")}}
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="product_file display-none col-md-12">
                            <div class="form-group">
                                <label>Downloadable Product File: <span class="text-red">*</span></label>
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
                                    <input type="checkbox" name="status" {{ old('status') == '1' ? "checked" : "" }}>
                                    <span class="knob"></span>
                                </label>
                                <br>
                                <small class="text-muted"><i class="fa fa-question-circle"></i> Toggle the product
                                    status</b></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Free Shipping :</label>
                                <br>
                                <label class="switch">
                                    <input type="checkbox" name="free_shipping" {{ old('free_shipping') == '1' ? "checked" : "" }}>
                                    <span class="knob"></span>
                                </label>
                                <br>
                                <small class="text-muted"><i class="fa fa-question-circle"></i> Toggle to allow free
                                    shipping on product.</b></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Featured :</label>
                                <br>
                                <label class="switch">
                                    <input type="checkbox" name="featured" {{ old('featured') == '1' ? "checked" : "" }}>
                                    <span class="knob"></span>
                                </label>
                                <br>
                                <small class="text-muted"><i class="fa fa-question-circle"></i> Toggle to allow product
                                    is featured.</b></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cancel available :</label>
                                <br>
                                <label class="switch">
                                    <input type="checkbox" name="cancel_avbl" {{ old('cancel_avbl') == '1' ? "checked" : "" }}>
                                    <span class="knob"></span>
                                </label>
                                <br>
                                <small class="text-muted"><i class="fa fa-question-circle"></i> Toggle to allow product
                                    cancellation on order.</b></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cash on delivery available :</label>
                                <br>
                                <label class="switch">
                                    <input type="checkbox" name="cod_avbl" {{ old('cod_avbl') == '1' ? "checked" : "" }}>
                                    <span class="knob"></span>
                                </label>
                                <br>
                                <small class="text-muted"><i class="fa fa-question-circle"></i> Toggle to allow COD on
                                    product.</b></small>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-4">

                            <label for="">Return Available :</label>
                            <select data-placeholder="Please choose an option" required="" class="form-control select2" id="choose_policy" name="return_avbl">
                              <option value="">Please choose an option</option>
                              <option {{ old('return_avbl') =='1' ? "selected" : "" }} value="1">Return Available</option>
                              <option {{ old('return_avbl') =='0' ? "selected" : "" }} value="0">Return Not Available</option>
                            </select>
                            <br>
                            <small class="text-desc">(Please choose an option that return will be available for this product or not)</small>
                      
                      
                          </div>
                      
                          <div id="policy" class="{{ old('return_avbl') == 1 ? '' : 'display-none' }} form-group col-md-4">
                            <label>
                              Select Return Policy: <span class="required">*</span>
                            </label>
                            <select data-placeholder="Please select return policy" name="policy_id" class="form-control select2">
                              <option value="">Please select return policy</option>
                      
                              @foreach(App\admin_return_product::where('created_by',Auth::user()->id)->get() as $policy)
                                <option {{ old('policy_id') == $policy->id ? "selected" : "" }}
                                value="{{ $policy->id }}">{{ $policy->name }}</option>
                              @endforeach
                            </select>
                          </div>

                    </div>
            </div>

            <div class="col-md-offset-1 col-md-10 form-group">
                <button type="submit" class="btn btn-md btn-success">
                    <i class="fa fa-plus-circle"></i> {{__("Create product")}}
                </button>

                <a href="{{ route('simple-products.index') }}" role="button" class="btn btn-md btn-default">
                    <i class="fa fa-arrow-left"></i> {{__("Back")}}
                </a>
            </div>


            </form>
        </div>
    </div>
</div>
</div>
@endsection
@section('custom-script')
  <script>
      $('.product_type').on('change',function(){

        var type = $(this).val();

        if(type == 'd_product'){

            $('.ex_pro_link').addClass('display-none');
            $('.product_file').removeClass('display-none');
            $("input[product_file]").attr('required','required');
            $("input[external_product_link]").removeAttr('required','required');


        }else if(type == 'ex_product'){

            $('.ex_pro_link').removeClass('display-none');
            $('.product_file').addClass('display-none');
            $("input[product_file]").removeAttr('required','required');
            $("input[external_product_link]").attr('required','required');

        }else{

            $('.ex_pro_link').addClass('display-none');
            $('.product_file').addClass('display-none');
            $("input[product_file]").removeAttr('required','required');
            $("input[external_product_link]").removeAttr('required','required');
        }

      });
  </script>
@endsection