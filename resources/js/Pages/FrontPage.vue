<template>
    <div class="front-page">
        <v-navigation-drawer
            clipped
            app
            v-if="$vuetify.breakpoint.smAndDown"
        >
            <frontpage-navbar :tags="tags"/>
        </v-navigation-drawer>
        <v-main>
            <three-column-layout>
                <template v-slot:column-one>
                    <frontpage-navbar :tags="tags"/>
                </template>
                <template v-slot:column-two>
                    <v-container fluid>
                        <v-row class="mb-3" v-if="$page.props.user">
                            <v-col>
                                <v-card class="px-2 pb-2">
                                    <v-img :src="previewUrl"></v-img>
                                    <v-form
                                        v-model="form"
                                    >
                                        <v-textarea
                                            auto-grow
                                            rows="2"
                                            label="What's happening?"
                                            v-model="post"
                                        ></v-textarea>
                                        <v-file-input type="file" ref="file" style="display: none" v-model="image" @change="previewImage"/>
                                    </v-form>
                                    <v-spacer></v-spacer>
                                    <div class="new-post-actions">
                                        <div>
                                            <v-icon @click="$refs.file.$refs.input.click()">
                                                mdi-file-image
                                            </v-icon>
                                        </div>
                                        <div>
                                            <v-btn @click="submit">Submit</v-btn>
                                        </div>
                                    </div>
                                </v-card>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <div v-for="(thread, idx) in threads" v-bind:key="idx" class="mb-2">
                                    <post-item :thread="thread" />
                                </div>
                            </v-col>
                        </v-row>
                    </v-container>
                </template>
                <template v-slot:column-three>

                </template>
            </three-column-layout>
        </v-main>
    </div>
</template>

<script>
import PostItem from './Components/Post/PostItem'
import ThreeColumnLayout from './Components/Shared/ThreeColumnLayout'
import FrontpageNavbar from './Components/Frontpage/FrontpageNavbar'

export default {
    name: 'front-page',
    components:{
        FrontpageNavbar,
        PostItem,
        ThreeColumnLayout
    },
    data: () => ({
        drawer: false,
        group: null,
        form: null,
        image:null,
        previewUrl:'',
        post:'',
    }),
    props: [
        'tags',
        'threads',
    ],
    watch: {
      group () {
        this.drawer = false
      },
    },
    methods: {
        previewImage(){
            this.previewUrl = URL.createObjectURL(this.image)
        },
        submit(){
            var data = new FormData()
            data.append('post', this.post)
            data.append('image', this.image)
            this.$inertia.post(
                '/thread/submit',
                data,
                { preserveState: false }
            )
        }
    }
}
</script>

<style scoped>
.new-post-actions{
    display:flex;
    justify-content: space-between;
}
</style>
