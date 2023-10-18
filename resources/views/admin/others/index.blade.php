@extends('admin.layouts.master')
@section('title','Remove Public & FORCE HTTPS Seting | ')
@section('body')

    

    @component('components.box',['border' => 'with-border'])
        @slot('header')
            <div class="box-title">
                {{ __("Remove Public & FORCE HTTPS Seting")}}
            </div>
        @endslot

        @slot('boxBody')

            
            <form action="{{ route('do.forcehttps') }}" method="POST">
                @csrf

                <div class="callout callout-success">
                    <i class="fa fa-info"></i> {{__("Enable FORCE https only if VALID SSL already configured else you can set serious errors !")}}
                </div>

                <button type="submit" class="btn btn-md btn-success">
                   @if(env('FORCE_HTTPS') == '1') {{__("REMOVE FORCE HTTPS REQUESTS")}} @else  {{__("FORCE HTTPS REQUESTS")}}  @endif
                </button>

            </form>
            <hr>    
            <form action="{{ route("do.removepublic") }}" method="POST">
                @csrf

                <div class="callout callout-success">
                    <i class="fa fa-info"></i> {{__("Important note:")}}
                    <ul>
                        <li>
                            {{__("Remove public only works if script is on valid subdomain and on main domain !")}}
                        </li>
                        <li>
                            {{__("If above requirment is satisfied and you're getting 500 Internal server error then your a2nMod headers are not enabled or root have 2 htaccess files !")}}
                        </li>
                        <li>
                            {{__("IN Case of a2nmod headers not enabled on your server kindly contact your hosting provider only !")}}
                        </li>
                    </ul>
                </div>

                <button type="submit" class="btn btn-md btn-success">
                    {{__("REMOVE Public")}}
                </button>

            </form>
       

        @endslot

    @endcomponent  
@endsection