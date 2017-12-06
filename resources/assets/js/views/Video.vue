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
                <button v-on:click="like()">Like</button>
                <button v-on:click="dislike()">Dislike</button>
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
                labels: null,
                repositories: {
                    video: null
                }
            }
        },
        methods: {
            like() {
                this.repositories.video.vote(this.video.id, 'good');
            },
            dislike() {
                this.repositories.video.vote(this.video.id, 'bad');
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
            this.repositories.video = new VideoRepository(axios);
            let videoId = this.$route.params.id;
            this.repositories.video .get(videoId).then(response => {
                this.video = response.data;
                this.repositories.video .labels(videoId)
                    .then(response => this.labels = response.data);
            });
        }
    }
</script>
