const cubeSceneModule = () => {
    const tapPosition = new THREE.Vector2
    const modelContainer = new THREE.Object3D()
    const raycaster = new THREE.Raycaster()
    let light, surface, objectsContainer, deltaTime, mixer, loaded = false, plane, circle, canvas
    const clock = new THREE.Clock()
    const actions = []

    const placeObjectTouchHandler = (e) => {
        if (e.touches.length === 2) {
            XR8.XrController.recenter()
        }
        if (e.touches.length > 2) {
            return
        }
        // If the canvas is tapped with one finger and hits the "surface", spawn an object.
        const {scene, camera} = XR8.Threejs.xrScene()
        // calculate tap position in normalized device coordinates (-1 to +1) for both components.
        tapPosition.x = (e.touches[0].clientX / window.innerWidth) * 2 - 1
        tapPosition.y = -(e.touches[0].clientY / window.innerHeight) * 2 + 1
        // Update the picking ray with the camera and tap position.
        raycaster.setFromCamera(tapPosition, camera)
        // Raycast against the "surface" object.
        const intersects = raycaster.intersectObject(surface)
        if (intersects.length === 1 && intersects[0].object === surface) {
            // placeObject(intersects[0].point.x, intersects[0].point.z)
            objectsContainer.position.x = intersects[0].point.x
            objectsContainer.position.z = intersects[0].point.z
            objectsContainer.visible = true
        }
    }

    const preventDefault = (event) => {
        event.preventDefault()
    }

    const setupScene = ({scene, camera, renderer, myCanvas}) => {
        canvas = myCanvas
        renderer.shadowMap.enabled = true
        renderer.shadowMap.type = THREE.PCFSoftShadowMap

        canvas.addEventListener('touchstart', placeObjectTouchHandler, true)  // Add touch listener.
        // // prevent scroll/pinch gestures on canvas
        canvas.addEventListener('touchmove', preventDefault)

        objectsContainer = new THREE.Object3D()
        objectsContainer.name = 'objects-container'
        objectsContainer.visible = false
        scene.add(objectsContainer)

        let cube = new THREE.Mesh( new THREE.BoxGeometry( 2, 2, 2 ), new THREE.MeshBasicMaterial({color: 0x00ff00}) );
        objectsContainer.add(cube)

        light = new THREE.DirectionalLight(0xffffff, 1)
        light.name = 'light'
        light.position.set(0, 4.5, 0)
        scene.add(light)  // Add soft white light to the scene.

        scene.add(new THREE.AmbientLight(0x404040, 5))  // Add soft white light to the scene.
        light.shadow.mapSize.width = 1024  // default
        light.shadow.mapSize.height = 1024  // default
        light.shadow.camera.near = 0.5  // default
        light.shadow.camera.far = 500  // default
        light.castShadow = true

        surface = new THREE.Mesh(
          new THREE.PlaneGeometry(100, 100, 1, 1),
          new THREE.ShadowMaterial({
            opacity: 0.5,
          })
        )

        surface.rotateX(-Math.PI / 2)
        surface.position.set(0, 0, 0)
        surface.receiveShadow = true
        scene.add(surface)
        camera.position.set(0, 3, 0)
    }

    const showTarget = () => {

    }

    const animate = () => {

    }

    const resetState = () => {

    }

    return {
        setupScene,
        showTarget,
        animate,
        resetState,
        onStart: () => {},
    }
}

export default cubeSceneModule
