<template>
    <div>
        <div v-if="video">
            <div class="page-header">
                <h1>{{video.name}} <small>by @{{video.speaker}}</small></h1>
            </div>
            <p>
                {{video.description}}
            </p>
            <p>
                <span v-for="label in labels" :class="randomLabelStyle">{{label.name}}</span>
            </p>
        </div>
    </div>
</template>

<script>
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
            axios.get('/videos/' + this.$route.params.id).then(response => {
                this.video = response.data;
                axios.get('/videos/' + this.video.id + '/labels')
                    .then(response => this.labels = response.data);
            });
        }
    }
</script>
