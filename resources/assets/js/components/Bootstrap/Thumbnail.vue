<template>
    <div :class="size">
        <div class="thumbnail">
            <img :src="image">
            <div class="caption">
                <h3>{{title}}</h3>
                <h5>{{subtitle}}</h5>
                <p v-if="description">{{description}}</p>
                <p>
                    <router-link :to="link">
                        <a class="btn btn-primary" role="button">{{cta}}</a>
                    </router-link>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['size', 'image', 'title', 'subtitle', 'description', 'link', 'cta'],
    }
</script>
