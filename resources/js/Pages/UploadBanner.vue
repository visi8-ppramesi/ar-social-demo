<template>
    <div>
        <v-text-field v-model="title"></v-text-field>
        <v-textarea v-model="message"></v-textarea>
        <v-text-field v-model="linkUrl"></v-text-field>
        <v-file-input v-model="bannerImg"></v-file-input>
        <v-btn @click="submitBanner">Submit</v-btn>
    </div>
</template>

<script>
export default {
    name:'upload-banner',
    data: function(){
        return {
            title:'',
            message:'',
            linkUrl: '',
            bannerImg: null
        }
    },
    methods:{
        submitBanner(){
            let data = new FormData()
            data.append('title', this.title)
            data.append('message', this.message)
            data.append('link_url', this.linkUrl)
            data.append('image_url', this.bannerImg)
            this.$inertia.post(
                '/banner/submit',
                data
            )
        }
    }
}
</script>
