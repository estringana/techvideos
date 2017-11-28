<template>
    <div>
        <video-thumbnail v-for="video in videos" :name="video.name" :link="getVideoUrl(video)" :speaker="video.speaker"
                     size="col-sm-6 col-md-4"></video-thumbnail>
    </div>
</template>

<script>
    export default {
        props: ['videos'],
        methods: {
            getVideoUrl(video) {
                return '/videos/' + video.id;
            }
        }
    }
</script>
