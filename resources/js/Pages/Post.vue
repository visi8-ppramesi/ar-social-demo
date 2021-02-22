<template>
    <app-layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto md:px-4 sm:px-0 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- <welcome /> -->
                    <div class="thread-page">
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
                                        <v-row>
                                            <v-col>
                                                <div class="mb-2">
                                                    <post-item :thread="thread" :showComments="true" />
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
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import PostItem from './Components/Post/PostItem.vue'
import FrontpageNavbar from './Components/Frontpage/FrontpageNavbar'
import ThreeColumnLayout from './Components/Shared/ThreeColumnLayout'

export default {
    name: 'post',
    components:{
        AppLayout,
        FrontpageNavbar,
        PostItem,
        ThreeColumnLayout
    },
    data: () => ({
        drawer: false,
        group: null
    }),
    props: [
        'thread',
        'tags',
    ],
    watch: {
      group () {
        this.drawer = false
      },
    },
}
</script>
