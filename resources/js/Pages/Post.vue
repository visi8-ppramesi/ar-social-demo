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
            <v-container>
                <v-row>
                    <v-col cols="2" v-if="$vuetify.breakpoint.mdAndUp">
                        <frontpage-navbar :tags="tags"/>
                    </v-col>
                    <v-col cols="7" md="7" xs="12">
                        <v-container fluid>
                            <v-row>
                                <v-col>
                                    put create new post here
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <div v-for="(thread, idx) in threads" v-bind:key="idx" class="mb-2">
                                        <frontpage-item :thread="thread" />
                                    </div>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-col>
                    <v-col cols="3" v-if="$vuetify.breakpoint.mdAndUp">

                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </div>
</template>

<script>
import FrontpageItem from './Components/Frontpage/FrontpageItem.vue'
import FrontpageNavbar from './Components/Frontpage/FrontpageNavbar'

export default {
    name: 'front-page',
    components:{
        FrontpageNavbar,
        FrontpageItem
    },
    data: () => ({
        drawer: false,
        group: null
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
}
</script>
