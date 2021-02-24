<template>
    <div id="ar-container">
        <!-- <canvas id="arcanvas"></canvas> -->
        <v-icon @click="takeScreenshot" id="camera-icon">mdi-camera</v-icon>
    </div>
</template>

<script>
import scenePipelineModule from '../Scenes/ScenePipelineModule.js'

export default {
    name:"augmented-reality-wrapper",
    mounted(){
        var canvas = document.createElement('canvas')
        canvas.id = "arcanvas"
        document.getElementById('ar-container').prepend(canvas)
        var xrExtraScriptTag = document.createElement('script')
        xrExtraScriptTag.src = "//cdn.8thwall.com/web/xrextras/xrextras.js"
        xrExtraScriptTag.id = "xrextras-script"
        document.getElementsByTagName('head')[0].appendChild(xrExtraScriptTag)
        var xr8ScriptTag = document.createElement('script')
        xr8ScriptTag.src = "//apps.8thwall.com/xrweb?appKey=g9A9qvEGISS1wWvaR2EkJLvtqzmMROhXmG3zXuXvkcWD5jhv2Uy7m0iHYUZjfmsIOsCLXP"
        xr8ScriptTag.id = "xr8-script"
        xr8ScriptTag.setAttribute('async', '')
        document.getElementsByTagName('head')[0].appendChild(xr8ScriptTag)
        window.onload = () => {
            this.onxrloaded()
        }
    },
    methods:{
        generateRandomString(length){
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        },
        takeScreenshot(){
            let canvas = document.getElementById('arcanvas')
            let strId = this.generateRandomString(6)
            localStorage.setItem(strId, canvas.toDataURL('image/jpeg'))
            canvas.parentNode.removeChild(canvas);
            this.$inertia.get('/', {imguri: strId})
        },
        onxrloaded(){
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

            // Open the camera and start running the camera run loop.
            XR8.run({canvas: document.getElementById('arcanvas')})
        }
    }
}
</script>

<style scoped>
#camera-icon{
    position:absolute;
    z-index:2;
    left: 50%;
    top:75%;
    -webkit-transform: translate(-50%, -75%);
    transform: translate(-50%, -75%);
}
#arcanvas{
    z-index:1;
}
</style>
