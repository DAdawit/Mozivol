@extends('admin.layouts.master')
@section('title','All Products | ')
@section('body')
<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            {{__("Create new product")}}
        </div>
        @can('digital-products.create')
        <a href="{{ route("simple-products.create") }}" class="pull-right btn btn-md btn-success">
            <i class="fa fa-plus"></i> {{__("Add new product") }}
        </a>
        @endcan
    </div>

    <div class="box-body">
        <table style="width: 100%" id="d_products" class="table table-bordered table-striped">
            <thead>
                <th>#</th>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Offer Price</th>
                <th>Product Status</th>
                <th>Action</th>
            </thead>
        </table>
    </div>
</div>
@endsection
@section('custom-script')
<script>
    $(function () {
        "use strict";
        var table = $('#d_products').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("simple-products.index") }}',
            language: {
                searchPlaceholder: "Search Products..."
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'image',
                    name: 'image',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'product_name',
                    name: 'simple_products.product_name'
                },
                {
                    data: 'price',
                    name: 'simple_products.actual_selling_price'
                },
                {
                    data: 'offer_price',
                    name: 'simple_products.actual_offer_price'
                },
                {
                    data: 'status',
                    name: 'simple_products.status'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable : false
                },
            ],
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print', 'colvis'
            ],
            order: [
                [0, 'DESC']
            ]
        });

    });
</script>
@endsection