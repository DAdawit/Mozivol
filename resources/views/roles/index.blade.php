@extends('admin.layouts.master')
@section('title','Roles | ')
@section('body')


    @component('components.box',['border' => 'with-border'])
        @slot('header')
            <div class="box-title">
                {{ __("Roles")}}
            </div>
            @can('roles.create')
                <a href="{{ route('roles.create') }}" class="pull-right btn btn-md btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ __("Create a new role") }}
                </a>
            @endcan
        @endslot

        @slot('boxBody')

        
       

        <table id="roletable" class="table table-borderd responsive no-wrap" style="width: 100%">

            <thead>
                <th>
                    #
                </th>
                <th>
                    Role Name
                </th>
                <th>
                    Action
                </th>
            </thead>
        
            <tbody>
        
            </tbody>
        
        
        </table>

            

        @endslot

    @endcomponent  
@endsection
@section('custom-script')
    <script>
       $(document).ready(function () {
        var table = $('#roletable').DataTable({
            lengthChange: false,
            responsive: true,
            serverSide: true,
            autoWidth: true,
            ajax: '{{ route('roles.index') }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'name',
                    name: 'roles.name'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable : false
                }
            ],
            dom: 'lBfrtip',
            buttons: [
                'copy',
                'excel',
                'csv',
                'pdf',
                'print',
                'colvis'
            ],
            order: [
                [1, 'ASC']
            ]
        });

    });
    </script>
@endsection