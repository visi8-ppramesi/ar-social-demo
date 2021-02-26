<template>
    <div id="ar-container">
        <canvas id="arcanvas" v-if="shownar"></canvas>
        <v-icon
            @click="closeAR"
            id="close-icon"
            color="white"
            large
        >
            mdi-close-circle
        </v-icon>
        <div id="icons-container">
            <v-icon
                @click="stopRecording"
                v-if="currentlyRecording"
                id="camera-icon"
                color="red"
                large
            >
                mdi-stop-circle-outline
            </v-icon>
            <v-icon
                @click="takeScreenshot"
                v-if="!currentlyRecording"
                id="camera-icon"
                color="red"
                large
            >
                mdi-camera-outline
            </v-icon>
            <v-icon
                @click="startRecording"
                v-if="!currentlyRecording"
                id="video-icon"
                color="red"
                large
            >
                mdi-video-outline
            </v-icon>
        </div>
    </div>
</template>

<script>
import scenePipelineModule from '../Scenes/ScenePipelineModule.js'
import store, {increment, decrement} from '../Helpers/Count.js'

export default {
    name:"augmented-reality-wrapper",
    data(){
        return {
            shownar:false,
            onLoadCalled: false,
            mediaRecorder: null,
            chunks: [],
            audioStream: null,
            currentlyRecording: false
        }
    },
    mounted(){
        try{
            this.onxrloaded()
        }catch(error){
            if(error.message === "XR8 is not defined"){
                console.log('xr8 shit')
            }else{
                console.log('other shit')
            }
        }
    },
    created(){
        window.onload = () => {
            this.onxrloaded()
            this.onLoadCalled = true
        }
        this.shownar = true
    },
    methods:{
        closeAR(){
            this.shownar = false
            XR8.stop()
            this.$inertia.get('/')

        },
        generateRandomString(length){
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        },
        stopRecording(){
            this.mediaRecorder.stop()
        },
        startRecording(){
            var self = this
            let canvas = document.getElementById('arcanvas')
            var videoStream = canvas.captureStream(30)
            var device = navigator.mediaDevices.getUserMedia({audio: true})
            this.currentlyRecording = true
            device.then((stream) => {
                videoStream.addTrack(stream.getTracks()[0])
                self.mediaRecorder = new MediaRecorder(videoStream)
                self.mediaRecorder.onstop = function(e){
                    var blob = new Blob(self.chunks, {type: 'video/mp4'})
                    self.chunks = []
                    // let strId = self.generateRandomString(6)
                    // localStorage.setItem(strId, URL.createObjectURL(blob))
                    self.shownar = false
                    var reader = new FileReader()
                    reader.onload = function(event){
                        let strId = self.generateRandomString(6)
                        localStorage.setItem(strId, event.target.result)
                        self.$inertia.get('/', {viduri: strId})
                    }
                    reader.readAsDataURL(blob)
                    XR8.stop()
                    // self.$inertia.get('/', {viduri: strId})
                }
                self.mediaRecorder.ondataavailable = function(e){
                    self.chunks.push(e.data)
                }
                self.mediaRecorder.start();
            })
        },
        takeScreenshot(){
            console.log('take screenshot')
            let canvas = document.getElementById('arcanvas')
            let strId = this.generateRandomString(6)
            localStorage.setItem(strId, canvas.toDataURL('image/jpeg'))
            // canvas.parentNode.removeChild(canvas);
            this.shownar = false
            XR8.stop()
            this.$inertia.get('/', {imguri: strId})
        },
        onxrloaded(){
            console.log('onxrloaded')
            if(store.counter < 1){
                XR8.addCameraPipelineModules([  // Add camera pipeline modules.
                    // Existing pipeline modules.
                    XR8.GlTextureRenderer.pipelineModule(),      // Draws the camera feed.
                    XR8.Threejs.pipelineModule(),                // Creates a ThreeJS AR Scene.
                    XR8.XrController.pipelineModule(),           // Enables SLAM tracking.
                    XRExtras.AlmostThere.pipelineModule(),       // Detects unsupported browsers and gives hints.
                    XRExtras.FullWindowCanvas.pipelineModule(),  // Modifies the canvas to fill the window.
                    XRExtras.Loading.pipelineModule(),           // Manages the loading screen on startup.
                    XRExtras.RuntimeError.pipelineModule(),      // Shows an error image on runtime error.
                    // XRExtras.PwaInstaller.pipelineModule(),      // PWA installer ???
                    scenePipelineModule(),
                    // uiComponents(),
                ])
            }
            increment()
            // Open the camera and start running the camera run loop.
            XR8.run({canvas: document.getElementById('arcanvas')})
        }
    }
}
</script>

<style scoped>
#icons-container{
    position:absolute;
    z-index:2;
    left: 50%;
    top:75%;
    -webkit-transform: translate(-50%, -75%);
    transform: translate(-50%, -75%);
    display: flex;
    flex-direction: row;
    justify-content: space-around;
}
#close-icon{
    position: absolute;
    z-index: 3;
    left:10%;
    top:5%;
    -webkit-transform: translate(-10%, -5%);
    transform: translate(-10%, -5%);
}
#arcanvas{
    z-index:1;
}
</style>
