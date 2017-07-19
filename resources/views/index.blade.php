<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-title" content="Kynren Timecode">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-transluscent">
    @include("layout/favicon")
    <link href="/css/app.css" rel="stylesheet">
    <title>Timecodes</title>
</head>
<body data-basepath="{{config('app.url')}}">
<a name="top"></a>
<div id="app" class="app">
    <div v-bind:style="displayApp" id="page">
        <header id="header">
            <timecode
                :timer="timer"
                :show-time="showTime">
            </timecode>
        </header>
        <main class="page">
            <div id="content" class="page-content">
                <sections
                    :section-id="sectionId"
                    :section-list="sectionList"
                    :set-section-id="setSectionId">
                </sections>
                <div v-if="showScenes">
                    <scenes
                        :scene-list="sceneList"
                        :current-scene="currentScene"
                        :timecode="getTimecode">
                    </scenes>
                </div>
                <div v-else>
                    <events
                        :event-list="eventList"
                        :section-id="sectionId"
                        :timecode="getTimecode"
                        :countdown="getCountdown"
                        :second-count="getSecondCount"
                        :copy-time="copyTime">
                    </events>
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
<script src="/js/app.js"></script>
@include("layout/analytics")
</body>
</html>
