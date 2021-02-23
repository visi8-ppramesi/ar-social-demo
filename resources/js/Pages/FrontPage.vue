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
                        <v-row class="mb-0">
                            <v-col class="pb-0 pt-0">
                                <v-tabs v-model="tabSelector">
                                    <v-tab @click="showLatest" key="1">
                                        Latest
                                    </v-tab>
                                    <v-tab @click="showWeek" key="2">
                                        Week
                                    </v-tab>
                                    <v-tab @click="showMonth" key="3">
                                        Month
                                    </v-tab>
                                    <v-tab @click="showYear" key="4">
                                        Year
                                    </v-tab>
                                </v-tabs>
                            </v-col>
                        </v-row>
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
                                            <v-icon @click="augmentedReality">
                                                mdi-augmented-reality
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
                    <v-container class="pl-0">
                        <v-row v-for="(banner, idx) in banners" class="pb-4" :key="idx">
                            <v-col cols="12" class="pa-0">
                                <banner :banner="banner"></banner>
                            </v-col>
                        </v-row>
                    </v-container>
                </template>
            </three-column-layout>
        </v-main>
    </div>
</template>

<script>
import PostItem from './Components/Post/PostItem'
import ThreeColumnLayout from './Components/Shared/ThreeColumnLayout'
import FrontpageNavbar from './Components/Frontpage/FrontpageNavbar'
import Banner from './Components/Banner/Banner'

export default {
    name: 'front-page',
    created(){
        switch(this.tab){
            case 'latest':
                this.tabSelector = 0
                break
            case 'week':
                this.tabSelector = 1
                break
            case 'month':
                this.tabSelector = 2
                break
            case 'year':
                this.tabSelector = 3
                break
        }
    },
    components:{
        FrontpageNavbar,
        PostItem,
        ThreeColumnLayout,
        Banner
    },
    data: () => ({
        drawer: false,
        group: null,
        form: null,
        image:null,
        previewUrl:'',
        post:'',
        tabSelector: 0,
    }),
    props: [
        'tags',
        'threads',
        'tab',
        'banners'
    ],
    watch: {
      group () {
        this.drawer = false
      },
    },
    methods: {
        augmentedReality(){
            console.log('asdfasdfasdf')
        },
        showLatest(){
            this.$inertia.get(
                '/',
                {
                    tab: 'latest'
                },
                {
                    preserveState: false
                }
            )
        },
        showWeek(){
            this.$inertia.get(
                '/',
                {
                    tab: 'week'
                },
                {
                    preserveState: false
                }
            )
        },
        showMonth(){
            this.$inertia.get(
                '/',
                {
                    tab: 'month'
                },
                {
                    preserveState: false
                }
            )
        },
        showYear(){
            this.$inertia.get(
                '/',
                {
                    tab: 'year'
                },
                {
                    preserveState: false
                }
            )
        },
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
