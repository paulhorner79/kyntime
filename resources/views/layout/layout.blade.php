<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include("layout/favicon")
    <link href="/css/admin.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>@yield('title')</title>
</head>
<body data-basepath="{{config('app.url')}}">
<a name="top"></a>
<div id="app" class="app">
    <div id="page">
        <header id="header">
            <timecode
                :timer="timer"
                :show-time="showTime">
            </timecode>
        </header>
        <main class="page">
            <div id="content" class="page-content">
                <div class="container-fluid">
                    @if(\Auth::user())
                        @include("layout/messages")
                    @endif
                    @yield('content')
                </div>
            </div>
        </main>
        @include("layout/footer")
        <scene
            :scene-list="sceneList"
            :current-scene="currentScene"
            :timecode="getTimecode"
            :countdown="getCountdown"
            :copy-time="copyTime"
            :second-count="getSecondCount"
            :set-scene="setScene"
            :show-time="showTime">
        </scene>
    </div>
</div>
<script src="/js/admin.js"></script>
@yield('javascript')
@include("layout/analytics")
</body>
</html>
