<template>
    <div class="scenes">
        <table>
            <tbody>
                <tr v-for="scene in sceneList" v-bind:class="{'current' : checkCurrent(scene.id)}">
                    <td>{{scene.name}}</td>
                    <td>{{timecode(scene.start.time).format('HH:mm:ss')}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props : {
            sceneList    : Array,
            currentScene : Number,
            timecode     : Function
        },
        methods : {
            checkCurrent : function (i) {
                if (i === this.currentScene) {
                    return true;
                }
                return false;
            }
        }
    };
</script>
