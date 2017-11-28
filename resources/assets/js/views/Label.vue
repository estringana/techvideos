<template>
    <div class="container">
        <div class="page-header">
            <h1>Videos on label {{label}}</h1>
        </div>
        <videoThumbnail v-for="video in videos" :name="video.name" :link="getUrl(video)" :speaker="video.speaker"
                        size="col-sm-6 col-md-4"></videoThumbnail>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                label: this.$route.params.id ,
                videos: [],
            }
        },
        mounted() {
            axios.get('/api/labels/' + this.label + '/videos')
                .then(response => this.videos = response.data);
        },
        methods: {
            getUrl(video) {
                return '/api/videos/' + video.id;
            }
        },
    }
</script>
