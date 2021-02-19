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
                            <v-row class="mb-3" v-if="$page.props.user">
                                <v-col>
                                    <v-card class="px-2 pb-2">
                                        <v-form
                                            v-model="form"
                                        >
                                            <v-textarea
                                                auto-grow
                                                rows="2"
                                                label="What's happening?"
                                            ></v-textarea>
                                        </v-form>
                                        <v-spacer></v-spacer>
                                        <div class="new-post-actions">
                                            <div>
                                                <v-icon>
                                                    mdi-file-image
                                                </v-icon>
                                            </div>
                                            <div>
                                                <v-btn click="submit">Submit</v-btn>
                                            </div>
                                        </div>
                                    </v-card>
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
        group: null,
        form: null
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

<style scoped>
.new-post-actions{
    display:flex;
    justify-content: space-between;
}
</style>
