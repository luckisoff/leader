@extends('layouts.admin')

@section('title', 'Live Quiz Winners')

@section('content-header', 'Live Quiz Winners')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"><i class="fa fa-shopping-basket"></i> Live Quiz Winners</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-body">

                    @if(count($winners) > 0)

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Name</th>
                                <th>Quiz Set</th>
                                <th>Prize Earned</th>
                                <th>Point Earned</th>
                                <th>Total Time</th>
                                <th>Date</th>

                            </tr>
                            </thead>

                            <tbody>
                                @foreach($winners as $key =>  $value)

                                <tr>
                                    <td>{{$key + 1 }}</td>
                                    <td>{{$value->user->name }}</td>
                                    <td>{{$value->question_set}}</td>
                                    <td>{{$value->prize}}</td>
                                    <td>{{$value->point}}</td>
                                    <td>
                                        {{gmdate('H:i:s',$value->user->liveQuizCorrectUsers->first()['total_time'])}}
                                    </td>
                                    <td>{{$value->created_at->format("d M Y")}}
                                    <span class="btn btn-xs btn-danger pull-right"><a href="/live-quiz-winners/del/{{$value->id}}">Del</a></span></td>
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