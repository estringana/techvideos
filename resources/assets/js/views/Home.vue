<template>
    <div class="container">
        <label-list :labels="labels"></label-list>
        <div class="page-header">
            <h1>Latest ones</h1>
        </div>
        <video-list :videos="videos"></video-list>
    </div>
</template>

<script>
    import Video from '../app/repository/Video.js';

    export default {
        data() {
            return {
                videos: [],
                labels: [],
            }
        },
        mounted() {
            let videoRepository = new Video();
            videoRepository.latest().then(response => this.videos = response.data)
            axios.get('/api/labels').then(response => this.labels = response.data);
        }
    }
</script>
