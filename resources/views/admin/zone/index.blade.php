@extends("admin/layouts.master")
@section('title','All Zones | ')
@section("body")

@section('data-field')
Brand
@endsection


<div class="box box-primary">

  <div class="box-header with-border">
    <h3 class="box-title">
      Zone
    </h3>
  </div>
  <!-- /.box-header -->
  <div class="panel-heading">
    <a href=" {{url('admin/zone/create')}} " class="btn btn-success owtbtn">+ Add New Zone</a>
  </div>
  <div class="box-body">
    <table style="width: 100%" id="full_detail_table" class="w-100 table table-bordered table-striped">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Country</th>
          <th>Zone Name</th>
          <th>Code</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($zones as $key => $zone)

        <tr>
          <td>{{$key+1}}</td>
          <td>{{$zone->title}}</td>
          <td>{{$zone->country->name}}</td>
          <td class="width30">

            @if(is_array($zone->name))

            @php
            $state = App\Allstate::whereIn('id',$zone->name)->get();
            @endphp
            <?php $zcount =  count($state); $i = 0;?>
            @foreach($state as $s)
            <?php $i++;?>

            @if($i<$zcount) {{ $s->name }}, @else {{ $s->name }} @endif @endforeach @endif </td> <td>{{$zone->code}}
          </td>
          <td>
            @if($zone->status=='1')
            {{'Yes'}}
            @else
            {{'No'}}
            @endif
          </td>
          <td>
            <div class="row">
              <div class="col-md-2">
                <a href="{{url('admin/zone/'.$zone->id.'/edit')}}" class="btn btn-sm btn-info">
                  <i class="fa fa-pencil"></i>
                </a>
              </div>
              <div class="col-md-offset-2 col-md-2">
                <form method="post" action="{{url('admin/zone/'.$zone->id)}}" class="pull-right">
                  {{csrf_field()}}
                  {{method_field("DELETE")}}
                  <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled=""
                    title="This action is disabled in demo !" @endif class="btn btn-sm btn-danger abc">
                    <i class="fa fa-trash"></i>
                  </button>
                </form>
              </div>
            </div>

          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
  <!-- /.box-body -->
</div>


@endsection