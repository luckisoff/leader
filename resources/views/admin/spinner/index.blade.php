@extends('layouts.admin')

@section('title', 'Spinner Landmark')

@section('content-header', 'Spinner Landmark')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"><i class="fa fa-shopping-basket"></i> Spinner Landmark</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-body">
                    @if(count($spinners) > 0)

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Point</th>
                                <th>Price</th>
                                <th>Action</th>

                            </tr>
                            </thead>

                            <tbody>
                                @foreach($spinners as $key =>  $value)

                                <tr>
                                    <td> {{ $key + 1 }}.</td>

                                    <td> {{$value->point }}</td>

                                    <td>
                                        {{$value->price}}
                                    </td>
                                    <td>
                                        <ul class="admin-action btn btn-default">
                                            <li class="dropdown">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                    Action <span class="caret"></span>
                                                </a>

                                                <ul class="dropdown-menu">  

                                                    <li role="presentation">
                                                        @if(Setting::get('admin_delete_control'))
                                                            <a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>
                                                        @else
                                                    <a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?');" href="{{route('landmarkdelete',$value->id)}}">
                                                                <i class="fa fa-trash"></i>Delete
                                                            </a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h3 class="no-result">No results found</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection