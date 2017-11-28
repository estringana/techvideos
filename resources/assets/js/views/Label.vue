<template>
    <div class="container">
        <div class="page-header">
            <h1>Videos on label {{label}}</h1>
        </div>
        <video-list :videos="videos"></video-list>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                label: this.$route.params.id,
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
