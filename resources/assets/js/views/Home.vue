<template>
    <div class="container">
        <div class="label-list">
            <router-link v-for="label in labels" :to="getLabelUrl(label)">
                <span class="label label-default">{{label.name}}</span>
            </router-link>
        </div>
        <div class="page-header">
            <h1>Latest ones</h1>
        </div>
        <videoThumbnail v-for="video in videos" :name="video.name" :link="getVideoUrl(video)" :speaker="video.speaker"
                        size="col-sm-6 col-md-4"></videoThumbnail>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                videos: [],
                labels: [],
            }
        },
        mounted() {
            axios.get('/api/videos/latest').then(response => this.videos = response.data);
            axios.get('/api/labels').then(response => this.labels = response.data);
        },
        methods: {
            getVideoUrl(video) {
                return '/videos/' + video.id;
            },
            getLabelUrl(label) {
                return '/labels/' + label.name;
            },
        },
    }
</script>
