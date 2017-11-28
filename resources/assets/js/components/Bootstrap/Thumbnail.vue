<template>
    <div :class="size">
        <div class="thumbnail">
            <router-link :to="link">
                <img :src="image">
            </router-link>
            <div class="caption">
                <router-link :to="link">
                    <h3>{{title}}</h3>
                </router-link>
                <h5>{{subtitle}}</h5>
                <p v-if="description">{{description}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['size', 'image', 'title', 'subtitle', 'description', 'link'],
    }
</script>
