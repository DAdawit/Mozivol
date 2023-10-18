@if(!in_array($id,['1','2','3','4']))
  <a href="{{ route('roles.edit',$id) }}" class="text-white btn btn-sm btn-round btn-success" rol="button"><i class="fa fa-pencil"></i></a>
@else 
  <p class="text-red">
    <b>{{__("System reserved role")}}</b>
  </p>
@endif

@if(!in_array($id,['1','2','3','4','5']))
  <a title="Delete Role" @if(env('DEMO_LOCK')==0) data-toggle="modal" data-target="#delete{{ $id }}" @else
    disabled="disabled" title="This operation is disabled in Demo !" @endif class="btn btn-sm btn-danger">
    <i class="fa fa-trash"></i>
  </a>

  <div id="delete{{ $id }}" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">Are You Sure ?</h4>
          <p>Do you really want to delete this role <b>{{ $name }}</b> ? <b> By Clicking YES IF any user attach to this role will be unroled !</b> This process cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <form method="post" action="{{ route('roles.destroy',$id) }}" class="pull-right">
            {{csrf_field()}}
            {{method_field("DELETE")}}

            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
            <button type="submit" class="btn btn-danger">Yes</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif
	
