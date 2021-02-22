<template>
    <div>
        <v-card>
            <v-img v-if="thread.image" :src="thread.image"></v-img>
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
                                <span class="font-semibold">{{thread.user.name}}</span> · {{toDate(thread.created_at)}}
                            </div>
                            <div class="mt-1">
                                {{thread.message}}
                            </div>
                            <div class="mt-1">
                                <span>
                                    <v-icon
                                        small
                                        @click="likeSubmit"
                                    >
                                        mdi-heart
                                    </v-icon>
                                    {{thread.likes}}
                                </span>
                                <span v-if="!showComments" class="ml-3">
                                    <inertia-link :href="'/thread/' + thread.id">
                                        <v-icon
                                            small
                                        >
                                            mdi-message-text
                                        </v-icon>
                                        {{totalComments}}
                                    </inertia-link>
                                </span>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
        <v-divider v-if="showComments" class="my-5"></v-divider>
        <div v-if="showComments" class="h2">
            Comments
        </div>
        <div v-if="showComments">
            <v-card class="px-2 pb-2">
                <v-form
                    v-model="commentForm"
                >
                    <v-textarea
                        auto-grow
                        rows="2"
                        label="Leave a comment"
                        v-model="commentPost"
                    ></v-textarea>
                    <v-spacer></v-spacer>
                    <div class="new-comment-actions">
                        <div>
                            <v-btn @click="commentSubmit">Submit</v-btn>
                        </div>
                    </div>
                </v-form>
            </v-card>
            <v-container v-for="(comment, idx) in thread.comments" v-bind:key="idx">
                <v-row>
                    <v-col cols="1">
                        <v-avatar>
                            <img
                                :src="comment.user.profile_photo_url"
                            />
                        </v-avatar>
                    </v-col>
                    <v-col cols="11">
                        <v-card class="px-2 pb-2">
                            <div class="flex flex-col">
                                <div class="mt-1">
                                    <span class="font-semibold">{{comment.user.name}}</span> · {{toDate(comment.created_at)}}
                                </div>
                                <div class="mt-1">
                                    {{comment.message}}
                                </div>
                                <div class="mt-1">
                                    <span>
                                        <v-icon
                                            small
                                            @click="likeCommentSubmit(comment.id)"
                                        >
                                            mdi-heart
                                        </v-icon>
                                        {{comment.likes}}
                                    </span>
                                </div>
                            </div>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </div>
    </div>
</template>

<script>
import moment from 'moment'

export default {
    name: 'post-item',
    data: function(){
        return {
            commentForm: '',
            commentPost: '',
        }
    },
    computed: {
        // toDate: function(){
        //     // let newDate = new Date(this.thread.created_at)
        //     // return newDate.toString()
        //     return moment(this.thread.created_at).fromNow()
        // },
        totalComments: function(){
            return this.thread.comments.length
        }
    },
    // props: ['thread'],
    props: {
        thread: Object,
        showComments: {
            type: Boolean,
            default: false
        }
    },
    methods:{
        toDate(date){
            return moment(date).fromNow()
        },
        commentSubmit(){
            let commentData = new FormData()
            commentData.append('message', this.commentPost)
            commentData.append('thread_id', this.thread.id)
            this.$inertia.post(
                '/comment/submit',
                commentData,
                {
                    preserveState: false,
                    preserveScroll: true,
                }
            )
        },
        likeCommentSubmit(commentId){
            let data = {}
            this.$inertia.get(
                '/like/comment/' + commentId,
                data,
                {
                    only: ['threads', 'thread'],
                    preserveScroll: true,
                    preserveState: true
                }
            )
        },
        likeSubmit(){
            let data = {}
            this.$inertia.get(
                '/like/thread/' + this.thread.id,
                data,
                {
                    only: ['threads', 'thread'],
                    preserveScroll: true,
                    preserveState: true
                }
            )
        }
    }
}
</script>

<style scoped>
.new-comment-actions{
    display:flex;
    justify-content: flex-end;
}
</style>
