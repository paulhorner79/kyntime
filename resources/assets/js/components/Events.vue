<template>
    <div class="events" v-bind:class="{ started : started, running : running }">
        <div v-for="event in displayEvents" v-bind:class="['event', event.status]">
            <div class="event-title">
                {{event.name}}
            </div>
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
                <div class="content" v-if="event.status === 'pre'">Before Show</div>
                <div class="content" v-else>{{event.time.format('HH:mm:ss')}}</div>
            </div>
            <div v-if="showSection" class="event-section">
                <div class="icon"></div>
                <div class="content">{{event.section.name}}</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data : function () {
            return {
                first : 0
            };
        },
        props : {
            eventList   : Array,
            sectionId   : Number,
            timecode    : Function,
            countdown   : Function,
            secondCount : Function,
            copyTime    : Function
        },
        methods : {
            /**
             * Return the status of an event.
             *
             * @param  {Object} e An event
             * @return {String}   "Current", "Pre", "Pending", "Future", "Past"
             */
            getStatus : function (e) {
                var time = this.secondCount(this.timecode(e.calculated));
                if (time === 0) {
                    return 'pre';
                }
                else if (time <= this.current) {
                    if (time >= this.grace) {
                        return 'current';
                    }
                    else if (this.current === 0) {
                        return 'future';
                    }
                    else {
                        return 'past';
                    }
                }
                else if (time <= this.pending) {
                    return 'pending';
                }
                return 'future';
            },
            /**
             * Setter for the first record.  Takes the timecode from an event,
             * and if it's the first event, will reset the property "first".
             *
             * @param  {Object}  a  A momentjs object
             * @return {Void}
             */
            setFirst : function (a) {
                var val = this.makeFirst(a);
                if (this.first === 0 && val > 0) {
                    this.first = val;
                }
                else if (this.first !== 0 && val < this.first) {
                    this.first = val;
                }
                return;
            },
            /**
             * Translates a moment JS object into an integer outlining the
             * number of seconds since midnight.
             *
             * @param  {Object}  a  A momentjs object
             * @return {Integer}
             */
            makeFirst : function (a) {
                var val = (a.hour * (60 * 60)) + (a.minute * 60) + a.second;
                return val;
            }
        },
        computed : {
            /**
             * Are we looking at a section or not?
             *
             * @return {Boolean}
             */
            showSection : function () {
                if (this.sectionId) {
                    return false;
                }
                return true;
            },
            /**
             * Tells us whether the show has started - the timecode is after
             * the first event.
             *
             * @return {Boolean}
             */
            started : function () {
                if (this.current === 0 || this.first === 0) {
                    return false;
                }
                if (this.current > this.first || this.current > 3600) {
                    return true;
                }
                return false;
            },
            /**
             * Tells us whether the timecode is running.  If it's 00:00:00 it
             * will return false.
             *
             * @return {Boolean}
             */
            running : function () {
                if (this.current === 0) {
                    return false;
                }
                return true;
            },
            /**
             * The current time in seconds.
             *
             * @return {Integer}
             */
            current : function () {
                return this.secondCount(this.copyTime());
            },
            /**
             * The time at which we label something as "pending", in seconds
             *
             * @return {Integer}
             */
            pending : function () {
                return this.current + 180;
            },
            /**
             * The time at which an event is no longer in the grace period, in
             * seconds.
             *
             * @return {Integer}
             */
            grace : function () {
                return this.current - 30;
            },
            /**
             * A computed list of the events that should be displayed within
             * the current section.  This adds details of the current time,
             * status, and in some cases a calculated "countdown".  These are
             * returned in a specific order based on whether the show has
             * started or not.
             *
             * @return {Array}
             */
            displayEvents : function () {
                var self           = this,
                    current_events = [],
                    pending_events = [],
                    future_events  = [],
                    past_events    = [],
                    pre_events     = [],
                    events         = [],
                    sectionId      = this.sectionId;

                this.eventList.forEach(function (e) {
                    self.setFirst(e.calculated);
                    if (sectionId === 0 || e.section.id === sectionId) {
                        e.time      = self.timecode(e.calculated);
                        e.thisTime  = self.secondCount(e.time);
                        e.status    = self.getStatus(e);
                        e.countdown = null;

                        if (e.status === 'current') {
                            current_events.push(e);
                        }
                        else if (e.status === 'pending') {
                            e.countdown = self.countdown(e.calculated);
                            pending_events.push(e);
                        }
                        else if (e.status === 'future') {
                            e.notes = null;
                            future_events.push(e);
                        }
                        else if (e.status === 'past') {
                            e.notes = null;
                            past_events.push(e);
                        }
                        else if (e.status === 'pre')  {
                            pre_events.push(e);
                        }
                    }
                });
                // if it's started, put the pre_events at the start.
                // otherwise, put it at the end
                if (this.started) {
                    return current_events.concat(pending_events)
                        .concat(future_events)
                        .concat(pre_events)
                        .concat(past_events);
                }
                return pre_events.concat(current_events)
                    .concat(pending_events)
                    .concat(future_events)
                    .concat(past_events);
            }
        }
    };
</script>
