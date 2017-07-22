@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="text-center mt">
                <img class="img-circle" src="{{ Auth::user()->avatar  }}" alt="{{ Auth::user()->name }}">
                <h4>{{ Auth::user()->name }} <br>
                <small>{{ Auth::user()->email  }}</small></h4>
                <p><span class="glyphicon glyphicon-calendar"></span> Joined {{ Auth::user()->created_at->toFormattedDateString() }}</p>
                <p><span class="glyphicon glyphicon-facetime-video"></span> {{ Auth::user()->videos()->count() . ' ' . str_plural('Video', Auth::user()->videos()->count()) }}</p>
                <p><span class="glyphicon glyphicon-comment"></span> {{ Auth::user()->comments()->count() . ' ' . str_plural('Comment', Auth::user()->videos()->count()) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
