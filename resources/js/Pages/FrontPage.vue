<template>
    <div class="front-page">
        <!-- <v-navigation-drawer
            clipped
            app
            v-if="$vuetify.breakpoint.smAndDown"
        >
            <frontpage-navbar :tags="tags"/>
        </v-navigation-drawer> -->
        <v-main>
            <three-column-layout>
                <template v-slot:column-one>
                    <frontpage-navbar :tags="tags"/>
                </template>
                <template v-slot:column-two>
                    <v-container fluid>
                        <v-row class="mb-0">
                            <v-col class="pb-0 pt-0">
                                <v-tabs v-model="tabSelector" :show-arrows="false" id="tab-tabs">
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
                                            <v-icon @click="augmentedRealityLink">
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
        let url = new URL(window.location.href)
        let sPar = new URLSearchParams(url.search)
        if(sPar.has('imguri')){
            this.arimg = localStorage.getItem(sPar.get('imguri'))
            this.previewUrl = this.arimg
            this.armode = true
            localStorage.removeItem(sPar.get('imguri'))
        }

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
        armode: false,
        arimg: ''
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
        dataURItoBlob(dataURI) {
            var byteString = atob(dataURI.split(',')[1]);

            // separate out the mime component
            var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]

            // write the bytes of the string to an ArrayBuffer
            var ab = new ArrayBuffer(byteString.length);

            // create a view into the buffer
            var ia = new Uint8Array(ab);

            // set the bytes of the buffer to the correct values
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }

            // write the ArrayBuffer to a blob, and you're done
            var blob = new Blob([ab], {type: mimeString});
            return blob;
        },
        augmentedRealityLink(){
            if(this.isMobile()){
                var data = {}
                this.$inertia.get('/ar', data, {preserveState: false})
            }else{
                alert("To view AR content, please use a smartphone")
            }
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
            if(this.armode){
                data.append('image', this.dataURItoBlob(this.arimg))
            }else{
                data.append('image', this.image)
            }
            this.$inertia.post(
                '/thread/submit',
                data,
                { preserveState: false }
            )
        },
        isMobile(){
            var check = false;
            (function(a){
                if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))
                check = true;
            })(navigator.userAgent||navigator.vendor||window.opera);
            return check;
        }
    }
}
</script>

<style scoped>
.new-post-actions{
    display:flex;
    justify-content: space-between;
}
#tab-tabs >>> .v-slide-group__prev{
    display:none;
}
</style>
