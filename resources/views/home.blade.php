@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
               <p class="lead">Chat Users</p>
                @foreach($threads as $inbox)
                    {{--@if(!is_null($inbox->message))--}}
                        {{--<li class="list-group-item">--}}
                            {{--<a href="{{ route('chat' , [--}}
                                {{--'id' => $inbox->message->conversation->id--}}
                            {{--]) }}">--}}
                                {{--<div class="about">--}}
                                    {{--<div class="name">{{$inbox->user->name}}</div>--}}
                                    {{--<div class="status">--}}
                                        {{--@if(auth()->user()->id == $inbox->message->sender->id)--}}
                                            {{--<span class="fa fa-reply"></span>--}}
                                        {{--@endif--}}
                                        {{--<span>{{ substr($inbox->message->text, 0, 20)}}</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--@endif--}}

                        @if($inbox->message->conversation->is_accepted)
                            <a href="{{ route('chat' , [
                                'id' => $inbox->message->conversation->id
                            ]) }}">
                                <div class="about">
                                    <div class="name">{{$inbox->user->name}}</div>
                                    <div class="status">
                                        @if(auth()->user()->id == $inbox->message->sender->id)
                                            <span class="fa fa-reply"></span>
                                        @endif
                                        <span>{{ substr($inbox->message->text, 0, 20)}}</span>
                                    </div>
                                </div>
                            </a>
                        @else
                            <a href="#">
                                <div class="about">
                                    <div class="name">{{$inbox->user->name}}</div>
                                    <div class="status">
                                        @if(auth()->user()->id == $inbox->message->sender->id)
                                            <span class="fa fa-reply"></span>
                                        @endif
                                        <span>{{ substr($inbox->message->text, 0, 20)}}</span>
                                    </div>
                                    @if($inbox->message->conversation->second_user_id == auth()->user()->id)
                                        <div>
                                            <a href="{{ route('accept.message' , [
                                'id' => $inbox->message->conversation->id
                            ]) }}" class="btn btn-xs btn-success">Accept Message Request</a>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endif

                @endforeach

            </ul>
            <p class="lead">Send Chat Request</p>
            @foreach($users as $user)
            <p><a href="/start/{{$user->id}}">{{$user->name}}</a></p>
            @endforeach
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
