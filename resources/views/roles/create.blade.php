@extends('admin.layouts.master')
@section('title','Create a new role')

@section('body')
	

@component('components.box',['border' => 'with-border'])
@slot('header')

<div class="box-title">
    {{ __('Create a new role') }}
</div>
@endslot

@slot('boxBody')
<form action="{{ route('roles.store') }}" method="POST" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
          <label for="name"  class="text-dark">Role name <span class="text-red">*</span></label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter role name" value="{{ old('name') }}" required autofocus>

        <input type="hidden" name="guard" value="web">

        @error('name')
            <span class="text-red" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        

        <p class="text-dark"> <b>{{ __('Assign Permissions to role') }}</b> </p>
       
        <table class="permissionTable table table-bordered">
            <th>
                Section
            </th>

            <th>
                <label>
                    <input class="grand_selectall" type="checkbox">
                    {{__('Select All') }}
                </label>
            </th>

            <th>
                {{__("Available permissions")}}
            </th>


           
            <tbody>
               @foreach($custom_permission as $key => $group)
                <tr>
                    <td>
                        <b>{{ ucfirst($key) }}</b>
                    </td>
                    <td width="30%">
                        <label>
                            <input class="selectall" type="checkbox">
                            {{__('Select All') }}
                        </label>
                    </td>
                    <td>
                        
                        @forelse($group as $permission)

                           <label>
                               <input name="permissions[]" class="permissioncheckbox" type="checkbox" value="{{ $permission->id }}">
                               {{$permission->name}} &nbsp;&nbsp;
                           </label>

                        @empty
                            {{ __("No permission in this group !") }}
                        @endforelse

                    </td>

                </tr>
               @endforeach
            </tbody>
        </table>

     </div>

    <div class="form-group">
        <button type="submit" class="btn btn-md btn-primary">
         {{ __("+ Create")}}
        </button>
        <a role="button" href="{{ route('roles.index') }}" class="btn btn-md btn-default">
            <i class="fa fa-arrow-left"></i> {{__("Back")}}
        </a>
    </div>
</form>
@endslot

@endcomponent

       
@endsection
@section('custom-script')
    <script src="{{ url('/js/checkbox.js') }}"></script>
@endsection