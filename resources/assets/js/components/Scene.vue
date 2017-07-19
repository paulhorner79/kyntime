<template>
    <div class="scene" v-if="showTime">
        <div class="current" v-if="visible.scene">
            <div class="icon"></div>
            <div class="scene-info">
                {{visible.scene.name}}
            </div>
        </div>
        <div class="next" v-if="visible.next">
            <div class="icon"></div>
            <div class="scene-info">
                {{visible.next.name}} {{visible.next.countdown}}
            </div>
        </div>
        <div class="next" v-else-if="visible.scene">
            <div v-if="visible.scene.end">
                <div class="icon"></div>
                <div class="scene-info">
                    Ending {{visible.scene.countdown}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : {
            sceneList    : Array,
            currentScene : Number,
            topHeight    : Function,
            timecode     : Function,
            countdown    : Function,
            copyTime     : Function,
            secondCount  : Function,
            setScene     : Function,
            showTime     : Boolean
        },
        computed : {
            visible : function () {
                var scene   = null,
                    next    = null,
                    self    = this,
                    t       = this.copyTime(),
                    current = this.secondCount(t);
                this.sceneList.forEach(function (e) {
                    var start     = null,
                        startTime = null,
                        end       = null,
                        endTime   = null,
                        countdown = null;

                    if (e.start) {
                        startTime = self.timecode(e.start.time);
                        start     = self.secondCount(startTime);
                    }
                    if (e.end) {
                        endTime   = self.timecode(e.end.time);
                        end       = self.secondCount(endTime);
                        countdown = self.countdown(e.end.time);
                    }
                    // It has a start date
                    if (start) {
                        // it has started - the start time is before the current time
                        if (start < current) {
                            // it either doesn't have an end, or the end is after the current time
                            if (!end || end > current) {
                                if (!scene || start > scene.seconds) {
                                    scene = {
                                        id        : e.id,
                                        name      : e.name,
                                        start     : startTime,
                                        end       : endTime,
                                        countdown : countdown,
                                        seconds   : start
                                    };
                                }
                            }
                            else if (end && end < current) {
                                scene = null;
                            }
                        }
                        else {
                            // it has not started yet
                            // check that the start date of this one is earlier than the current "next" time
                            if (!next || start < next.seconds) {
                                next = {
                                    id        : e.id,
                                    name      : e.name,
                                    countdown : self.countdown(e.start.time),
                                    start     : startTime,
                                    end       : endTime,
                                    seconds   : start
                                };
                            }
                        }
                    }
                });
                if (scene) {
                    this.setScene(scene.id);
                }
                else {
                    this.setScene(0);
                }
                if (next) {
                    if (next.end && self.secondCount(next.end) < current) {
                        next = null;
                    }
                }
                return {
                    scene : scene,
                    next  : next
                };
            }
        }
    };
</script>
