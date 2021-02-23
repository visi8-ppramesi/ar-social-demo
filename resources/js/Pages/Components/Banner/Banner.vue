<template>
    <v-card @click="goToLink">
        <v-img v-if="banner.image_url" :src="banner.image_url"></v-img>
        <v-card-title>{{banner.title}}</v-card-title>
        <v-card-text>{{banner.message}}</v-card-text>
    </v-card>
</template>

<script>
export default {
    name:'banner',
    props: {
        banner: Object
    },
    methods: {
        goToLink(){
            this.$inertia.visit('/banner/redirect/' + this.banner.id)
        }
    }
}
</script>
