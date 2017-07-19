<template>
    <div class="sections">
        <select v-on:change="updateSection()" v-model="s" name="section">
            <option v-bind:value="0">All Cues</option>
            <option v-for="option in sectionList" v-bind:value="option.id">
                {{ option.name }}
            </option>
            <option v-bind:value="999999">Scenes</option>
        </select>
    </div>
</template>

<script>
    export default {
        data : function () {
            return {
                s : this.sectionId
            };
        },
        updated : function () {
            this.s = this.sectionId;
        },
        props : {
            sectionId    : Number,
            sectionList  : Array,
            setSectionId : Function
        },
        methods : {
            updateSection : function () {
                this.setSectionId(this.s);
            }
        }
    };
</script>
