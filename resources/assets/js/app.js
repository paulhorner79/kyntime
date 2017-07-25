/* global require, Vue, axios, moment, localStorage, window, setTimeout, console */
/* exported app */
/* eslint no-console: ["error", { allow: ["error"] }] */

require('./bootstrap');

window.Vue = require('vue');

Vue.component('scene', require('./components/Scene.vue'));
Vue.component('timecode', require('./components/Timecode.vue'));
Vue.component('sections', require('./components/Sections.vue'));
Vue.component('events', require('./components/Events.vue'));
Vue.component('scenes', require('./components/Scenes.vue'));

const app = new Vue({
    el   : '#app',
    data : {
        tcodeId      : 0,
        tcodeEnd     : null,
        eventList    : [],
        sceneList    : [],
        sectionId    : 0,
        sectionList  : [],
        currentScene : 0,
        showApp      : false,
        zeroHour     : null,
        now          : moment()
    },
    beforeMount : function () {
        this.loadSection();
        this.loadFromApi();
    },
    mounted : function () {
        this.showApp = true;
    },
    computed : {
        showTime : function () {
            if (this.zeroHour) {
                return true;
            }
            return false;
        },
        displayApp : function () {
            if (this.showApp) {
                return {
                    visible : true
                };
            }
            return {
                visible : false
            };
        },
        showScenes : function () {
            if (this.sectionId === 999999) {
                return true;
            }
            return false;
        },
        timer : function () {
            var midnight = this.getMidnight();
            if (this.zeroHour) {
                var seconds = this.now.diff(this.zeroHour, 'seconds');
                if (this.tcodeEnd && seconds > this.tcodeEnd) {
                    this.setZeroHour(null);
                    return midnight;
                }
                if (seconds > 0) {
                    return midnight.add(seconds, 'seconds');
                }
                seconds = seconds * -1;
                return midnight.subtract(seconds, 'seconds');
            }
            return midnight;
        }
    },
    methods : {
        loadFromApi : function () {
            this.loadTimecode();
            this.loadSections();
            this.loadScenes();
            this.loadEvents();
        },
        setScene : function (s) {
            if (this.currentScene !== s) {
                this.currentScene = s;
            }
        },
        setZeroHour : function (h) {
            this.zeroHour = h;
        },
        clearTimecode : function () {
            this.setTimecodeId(0);
            this.setTimecodeEnd(null);
            this.setZeroHour(null);
        },
        setTimecodeId : function (id) {
            this.tcodeId = id;
        },
        setTimecodeEnd : function (end) {
            this.tcodeEnd = end;
        },
        loadTimeData : function (d) {
            if (!this.zeroHour || d.id !== this.tcodeId) {
                var h        = d.timecode.hour,
                    m        = d.timecode.minute,
                    s        = d.timecode.second,
                    time     = this.getMoment(h, m, s),
                    midnight = this.getMidnight(),
                    now      = moment(),
                    seconds  = time.diff(midnight, 'seconds'),
                    z        = now.subtract(seconds, 'seconds');
                if (d.end) {
                    this.setTimecodeEnd(d.end);
                }
                this.setTimecodeId(d.id);
                this.setZeroHour(z);
                this.setTime();
            }
        },
        loadTimecode : function () {
            var self = this;
            axios.get('/api/timecode')
                .then(function (response) {
                    var d = response.data;
                    if (d.id) {
                        self.loadTimeData(d);
                    }
                    else {
                        self.clearTimecode();
                    }
                })
                .catch(function(error){
                    console.error(error);
                });
            setTimeout(function(){
                self.loadTimecode();
            }, 15000);
        },
        loadScenes : function () {
            var self = this,
                url  = '/api/scenes';
            axios.get(url)
                .then(function (response) {
                    var d = response.data;
                    self.sceneList = d;
                })
                .catch(function(error){
                    console.error(error);
                });
        },
        loadEvents : function () {
            var self = this,
                url  = '/api/events';
            axios.get(url)
                .then(function (response) {
                    var d = response.data;
                    self.eventList = d;
                })
                .catch(function(error){
                    console.error(error);
                });
        },
        loadSections : function () {
            var self = this;
            axios.get('/api/sections')
                .then(function (response) {
                    var d = response.data;
                    self.sectionList = d;
                })
                .catch(function(error){
                    console.error(error);
                });
        },
        setSectionId : function (s) {
            this.sectionId = s;
            localStorage.setItem('kyntime-section-id', this.sectionId);
        },
        loadSection : function () {
            this.sectionId = parseInt(localStorage.getItem('kyntime-section-id')) || 0;
        },
        getTimecode : function (tc) {
            var time = moment().set({
                hour   : tc.hour,
                minute : tc.minute,
                second : tc.second
            });
            return time;
        },
        getCountdown : function (tc) {
            var time = this.getTimecode(tc);
            if (this.zeroHour) {
                // if it's less than 60 seconds show second count
                var d = time.diff(this.timer, 'seconds');
                if (d < 0) {
                    d = 0;
                }
                if (d === 1) {
                    return 'in 1 second';
                }
                else if (d < 61) {
                    return 'in ' + d + ' seconds';
                }
                return this.timer.to(time);
            }
            return '';
        },
        getTimeDisplay : function (tc) {
            var time = this.timecode(tc);
            return time.format('HH:mm:ss');
        },
        getSecondCount : function (tc) {
            var hours = parseInt(tc.format('H')),
                minutes = parseInt(tc.format('m')),
                seconds = parseInt(tc.format('s'));
            return (hours * 60 * 60) + (minutes * 60) + seconds;
        },
        copyTime : function () {
            if (this.zeroHour) {
                return moment().set({
                    hour   : this.timer.format('H'),
                    minute : this.timer.format('m'),
                    second : this.timer.format('s')
                });
            }
            return this.getMidnight();
        },
        getMoment : function (h, m, s) {
            return moment().set({
                hour   : h,
                minute : m,
                second : s
            });
        },
        getMidnight : function () {
            return this.getMoment(0, 0, 0);
        },
        setTime : function () {
            var self = this;
            if (this.zeroHour) {
                this.now = moment();
                setTimeout(function(){
                    self.setTime();
                }, 1000);
            }
        }
    }
});
