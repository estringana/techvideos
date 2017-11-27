<template>
    <div class="container">
        <div v-for="row in groupedVideos" class="row">
            <thumbnail v-for="video in row" :name="video.name" :description="video.description" :link="getUrl(video)" :speaker="video.speaker" size="col-sm-6 col-md-4"></thumbnail>
        </div>
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
            axios.get('/videos/latest').then(response => this.videos = response.data);
        },
        methods: {
            getUrl(video) {
                return '/videos/' + video.id;
            }
        },
        computed: {
            groupedVideos() {
                return _.chunk(this.videos,3);
            }
        }
    }
</script>
