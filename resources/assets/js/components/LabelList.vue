<template>
    <div class="label-list">
        <router-link v-for="label in labels" :to="getLabelUrl(label)">
            <span class="label label-default">{{label.name}}</span>
        </router-link>
    </div>
</template>

<style scoped>
    .label {
        display: inline-block;
        margin-left: 2px;
        margin-right: 2px;
    }
</style>

<script>
    export default {
        props: ['labels'],
        methods: {
            getLabelUrl(label) {
                return '/labels/' + label.name;
            }
        }
    }
</script>
