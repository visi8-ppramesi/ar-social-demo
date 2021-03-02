<template>
    <div></div>
</template>

<script>
export default {
    name:'tester',
    created(){
        // var xhr = new XMLHttpRequest()
        // xhr.open('GET', '/storage/3dmodels/citylots.json')
        // xhr.seenBytes = 0
        // xhr.onload = function(){
        //     console.log('asdfasdasdf')
        // }
        // // xhr.onreadystatechange = function(){
        // //     var newData = xhr.responseText.substr(xhr.seenBytes);

        // //     xhr.seenBytes = xhr.responseText.length;
        // //     console.log(newData)
        // // }
        // xhr.send();
        var script = document.createElement('script')
        script.type = 'text/javascript'
        script.src = "https://cdnjs.cloudflare.com/ajax/libs/oboe.js/1.14.4/oboe-browser.min.js"
        document.head.appendChild(script)
        window.onload = function(){
            oboe("/storage/3dmodels/citylots.json").node("features.*", function(e){
                console.log(e)
            })
        }
    }
}
</script>
