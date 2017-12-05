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
    import VideoRepository from '../app/repository/Video.js';
    import LabelRepository from '../app/repository/Label.js';

    export default {
        data() {
            return {
                videos: [],
                labels: [],
            }
        },
        mounted() {
            let videoRepository = new VideoRepository(axios);
            let labelRepository = new LabelRepository(axios);
            videoRepository.latest().then(response => this.videos = response.data)
            labelRepository.all().then(response => this.labels = response.data);
        }
    }
</script>
