<template>
    <div class="container">
        <videoThumbnail v-for="video in videos" :name="video.name" :link="getUrl(video)" :speaker="video.speaker" size="col-sm-6 col-md-4"></videoThumbnail>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                videos: []
            }
        },
        mounted() {
            axios.get('/api/videos/latest').then(response => this.videos = response.data);
        },
        methods: {
            getUrl(video) {
                return '/api/videos/' + video.id;
            }
        },
    }
</script>
