<template>
    <v-card>
        <v-img v-if="thread.image" :src="thread.image"></v-img>
        <!-- <v-img src="https://image.shutterstock.com/image-vector/example-red-square-grunge-stamp-260nw-327662909.jpg"></v-img> -->
        <!-- <v-card-subtitle>
            <v-avatar>
                <img
                    :src="thread.user.profile_photo_url"
                />
            </v-avatar>
        </v-card-subtitle>
        <v-card-text class="text--primary">
            <div>{{thread.message}}</div>
        </v-card-text> -->
        <v-container>
            <v-row>
                <v-col cols="1">
                    <v-avatar>
                        <img
                            :src="thread.user.profile_photo_url"
                        />
                    </v-avatar>
                </v-col>
                <v-col cols="11">
                    <div class="flex flex-col">
                        <div class="mt-1">
                            <span class="font-semibold">{{thread.user.name}}</span> · {{toDate}}
                        </div>
                        <div class="mt-1">
                            {{thread.message}}
                        </div>
                        <div class="mt-1">
                            <span>
                                <inertia-link :href="route('like', thread.id)">
                                    <v-icon
                                        small
                                    >
                                        mdi-heart
                                    </v-icon>
                                </inertia-link>
                                {{thread.likes}}
                            </span>
                            <span class="ml-3">
                                <v-icon
                                    small
                                >
                                    mdi-message-text
                                </v-icon>
                                {{totalLikes}}
                            </span>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</template>
<script>
import moment from 'moment'

export default {
    name: 'frontpage-item',
    computed: {
        toDate: function(){
            // let newDate = new Date(this.thread.created_at)
            // return newDate.toString()
            return moment(this.thread.created_at).fromNow()
        },
        totalLikes: function(){
            return this.thread.comments.length
        }
    },
    props: ['thread'],
}
</script>
