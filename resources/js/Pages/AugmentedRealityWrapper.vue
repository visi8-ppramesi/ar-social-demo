<template>
    <div>
        <canvas id="arcanvas"></canvas>
    </div>
</template>

<script>
import cubeSceneModule from '../Scenes/CubeSceneModule.js'

export default {
    name:"augmented-reality-wrapper",
    created(){
        var xrExtraScriptTag = document.createElement('script')
        xrExtraScriptTag.src = "//cdn.8thwall.com/web/xrextras/xrextras.js"
        xrExtraScriptTag.id = "xrextras-script"
        document.getElementsByTagName('head')[0].appendChild(xrExtraScriptTag)
        var xr8ScriptTag = document.createElement('script')
        xr8ScriptTag.src = "//apps.8thwall.com/xrweb?appKey=g9A9qvEGISS1wWvaR2EkJLvtqzmMROhXmG3zXuXvkcWD5jhv2Uy7m0iHYUZjfmsIOsCLXP"
        xr8ScriptTag.id = "xr8-script"
        xr8ScriptTag.async = ''
        document.getElementsByTagName('head')[0].appendChild(xr8ScriptTag)
        window.onload = () => {
            this.initXR()
        }
    },
    methods:{
        initXR(){
            cubeSceneModule()
        }
    }
}
</script>
