@extends("admin/layouts.master")
@section('title','All Users | ')
@section("body")

  @component('components.box',['border' => 'with-border'])
      @slot('header')
        <div class="box-title">
            
          {{__("All users")}}
            
        </div>

        

       
        @slot('rightbar')

            @can('users.create')
              <a href="{{ route('users.create',['type' => app('request')->input('filter')]) }}" class="pull-right btn btn-md btn-success">
                <i class="fa fa-plus-circle"></i> {{__("Add New")}}
              </a>
            @endcan

            <br><br>
          
            <select data-placeholder="Filter by role" name="roles" id="roles" class="pull-right form-control select2">
              <option value="">{{ __("Filter by role") }}</option>
              <option value="all">{{ __("All") }}</option>
              @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
              @endforeach
            </select>
          
          
         
        @endslot
       
      @endslot

      @slot('boxBody')
        <table style="width: 100%;" id="userstable" class="table table-bordered table-striped">
              <thead>
                <th>
                  #
                </th>
                <th>
                  {{__("Image")}}
                 </th>
                <th>
                 {{__("Name")}}
                </th>
                <th>
                  {{ __("Email") }}
                 </th>
                 <th>
                  {{ __("Contact NO.") }}
                 </th>
                 <th>
                  {{ __("Role") }}
                 </th>
                 <th>
                  {{ __("Login as user") }}
                 </th>
                 <th>
                  {{ __("Registerd at") }}
                 </th>
                 <th>
                  {{ __("Action") }}
                 </th>
              </thead>
        </table>
      @endslot
  @endcomponent

@endsection
@section('custom-script')
  <script>
      $(function() {
           var table = $('#userstable').DataTable({
                lengthChange: true,
                responsive: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                url: "{{ route("users.index") }}",
                    data: function (d) {
                        d.roles = $('#roles').val();
                    }
                },
                language: {
                  searchPlaceholder: "Search users"
                },
                columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable : false, searchable : false},
                  {data: 'image', name: 'image', orderable : false, searchable : false},
                  {data : 'name', name : 'users.name'},
                  {data : 'email', name : 'users.email'},
                  {data : 'mobile', name : 'mobile'},
                  {data : 'role', name : 'role'},
                  {data: 'loginas', name: 'loginas', orderable : false, searchable : false},
                  {data : 'created_at', name : 'users.created_at'},
                  {data : 'action', name : 'action',searchable : false}
                ],
                dom : 'lBfrtip',
                buttons : [
                    'csv','excel','pdf','print','colvis'
                ]
            });

            table.buttons().container().appendTo('#userstable .col-md-3:eq(0)');

            $('#roles').on('change',function(){
                table.draw();
            });
        });
  </script>
@endsection