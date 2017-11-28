<template>
    <div class="label-list">
        <router-link v-for="label in labels" :to="getLabelUrl(label)">
            <span class="label label-default">{{label.name}}</span>
        </router-link>
    </div>
</template>

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
