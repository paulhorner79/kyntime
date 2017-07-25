<template>
    <div class="timecode" id="timecode">
        <div v-bind:class="{'active': showTime}">
            {{timer.format('HH:mm:ss')}}
            <a href="/timecode"><i class="fa fa-cog"></i></a>
        </div>
    </div>
</template>

<script>
    export default {
        props : {
            timer    : Object,
            showTime : Boolean
        }
    };
</script>
