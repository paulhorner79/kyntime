<template>
    <div class="events">
        <div v-if="computedEvents.showC" class="current-events">
            <div v-for="event in computedEvents.current" v-bind:class="['event', event.status]">
                <div class="event-title">{{event.name}}</div>
                <div v-if="event.notes" class="event-notes">
                    {{event.notes}}
                </div>
                <div class="event-time">
                    <div class="icon"></div>
                    <div class="content">{{event.time.format('HH:mm:ss')}}</div>
                </div>
                <div v-if="event.section" class="event-section">
                    <div class="icon"></div>
                    <div class="content">{{event.section.name}}</div>
                </div>
            </div>
        </div>
        <div v-if="computedEvents.showE" class="future-events">
            <div v-for="event in computedEvents.events" v-bind:class="['event', event.status]">
                <div class="event-title">{{event.name}}</div>
                <div v-if="event.notes" class="event-notes">
                    {{event.notes}}
                </div>
                <div v-if="event.countdown" class="event-countdown">
                    <div class="icon"></div>
                    <div class="content">
                        {{event.time.format('HH:mm:ss')}} | {{event.countdown}}
                    </div>
                </div>
                <div v-else class="event-time">
                    <div class="icon"></div>
                    <div class="content">{{event.time.format('HH:mm:ss')}}</div>
                </div>
                <div v-if="event.section" class="event-section">
                    <div class="icon"></div>
                    <div class="content">{{event.section.name}}</div>
                </div>
            </div>
        </div>
        <div v-if="computedEvents.showD" class="deferred-events">
            <h5>Completed Events</h5>
            <div v-for="event in computedEvents.deferred" v-bind:class="['event', event.status]">
                <div class="event-title">{{event.name}}</div>
                <div class="event-time">
                    <div class="icon"></div>
                    <div class="content">{{event.time.format('HH:mm:ss')}}</div>
                </div>
                <div v-if="event.section" class="event-section">
                    <div class="icon"></div>
                    <div class="content">{{event.section.name}}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : {
            eventList   : Array,
            sectionId   : Number,
            timecode    : Function,
            countdown   : Function,
            secondCount : Function,
            copyTime    : Function
        },
        computed : {
            computedEvents : function () {
                var events    = [],
                    deferred  = [],
                    cevents   = [],
                    self      = this,
                    current   = this.secondCount(this.copyTime()),
                    grace     = current - 30,
                    pending   = current + 180,
                    sectionId = this.sectionId,
                    showC     = false,
                    showD     = false,
                    showE     = false;

                this.eventList.forEach(function (e) {
                    if (!sectionId || sectionId === e.section.id) {
                        var time      = self.timecode(e.calculated),
                            thisTime  = self.secondCount(time),
                            status    = 'future',
                            section   = null,
                            countdown = null,
                            notes     = null;

                        if (thisTime <= current) {
                            if (thisTime >= grace) {
                                status = 'current';
                                if (e.notes) {
                                    notes = e.notes;
                                }
                            }
                            else {
                                notes = null;
                                status = 'past';
                            }
                        }
                        else if (thisTime <= pending) {
                            status = 'pending';
                            countdown = self.countdown(e.calculated);
                            if (e.notes) {
                                notes = e.notes;
                            }
                        }

                        if (!sectionId) {
                            section = e.section;
                        }

                        var event = {
                            id        : e.id,
                            name      : e.name,
                            section   : section,
                            countdown : countdown,
                            status    : status,
                            time      : time,
                            current   : current,
                            pending   : pending,
                            grace     : grace,
                            thisTime  : thisTime,
                            notes     : notes
                        };
                        if (status === 'current') {
                            cevents.push(event);
                            showC = true;
                        }
                        else if (status === 'past' ){
                            deferred.push(event);
                            showD = true;
                        }
                        else {
                            events.push(event);
                            showE = true;
                        }
                    }
                });
                var ev = {
                    events   : events,
                    current  : cevents,
                    deferred : deferred,
                    showC    : showC,
                    showD    : showD,
                    showE    : showE
                };
                return ev;
            }
        }
    };
</script>
