<template>
    <div class="container">
        <div v-if="video">
            <div class="page-header">
                <h1>{{video.name}} <small>by @{{video.speaker}}</small></h1>
            </div>
            <p>
                {{video.description}}
            </p>
            <p>
                <div>Like</div>
                <div>Dislike</div>
            </p>
            <label-list :labels="labels"></label-list>
        </div>
    </div>
</template>

<script>
    import VideoRepository from '../app/repository/Video.js';

    export default {
        data() {
            return {
                video: null,
                labels: null
            }
        },
        computed: {
            randomLabelStyle()
            {
                var labelColors = ["default", "primary", "success", "info", "warning", "danger"];
                var labelColorToPick =  Math.floor(Math.random() * (labelColors.length));
                var randomLabel = 'label-' + labelColors[labelColorToPick];
                return 'label ' + randomLabel;
            }
        },
        mounted() {
            let videoRepository = new VideoRepository(axios);
            let videoId = this.$route.params.id;
            videoRepository.get(videoId).then(response => {
                this.video = response.data;
                videoRepository.labels(videoId)
                    .then(response => this.labels = response.data);
            });
        }
    }
</script>
