@extends('user/master')
@section('content')
    <title>Virtual Showroom</title>
    <style>
        body { margin: 0; }
        body, #showroom-container {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        #showroom-container {
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        #chatbot__container{
            display:none;
        }
        #instructions {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            padding: 20px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black background */
            color: white;
            font-size: 24px;
            cursor: pointer; /* Change cursor to indicate it's clickable */
            z-index: 100;
        }
        canvas { display: block; } 
    </style>
<body>
    <div id="instructions">
        <span style="font-size: 24px; color:white">Click to play</span><br>
        Move: WASD<br>
        Look: Mouse Move
    </div>
    <div id="showroom-container"></div>
    <div id="fullscreen-btn" style="position: fixed; top: 110px; right: 10px; z-index: 1000; cursor: pointer; padding: 10px; background-color: #f1f1f1; border-radius: 5px;">
        Fullscreen
    </div>
    <script src="https://cdn.jsdelivr.net/npm/three/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/PointerLockControls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/GLTFLoader.js"></script>

    <script>
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.getElementById('showroom-container').appendChild(renderer.domElement);

        scene.background = new THREE.Color(0x000000);
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
        scene.add(ambientLight);
        const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        scene.add(directionalLight);

        const controls = new THREE.PointerLockControls(camera, renderer.domElement);
        document.getElementById('showroom-container').addEventListener('click', () => {
            controls.lock();
        });

        // WASD movement
        let moveForward = false;
        let moveBackward = false;
        let moveLeft = false;
        let moveRight = false;
        const velocity = new THREE.Vector3();
        const direction = new THREE.Vector3();
        const onKeyDown = function (event) {
            switch (event.code) {
                case 'KeyW':
                    moveForward = true;
                    break;
                case 'KeyA':
                    moveLeft = true;
                    break;
                case 'KeyS':
                    moveBackward = true;
                    break;
                case 'KeyD':
                    moveRight = true;
                    break;
            }
        };
        const onKeyUp = function (event) {
            switch (event.code) {
                case 'KeyW':
                    moveForward = false;
                    break;
                case 'KeyA':
                    moveLeft = false;
                    break;
                case 'KeyS':
                    moveBackward = false;
                    break;
                case 'KeyD':
                    moveRight = false;
                    break;
            }
        };
        document.addEventListener('keydown', onKeyDown);
        document.addEventListener('keyup', onKeyUp);

        // Load GLB model
        const loader = new THREE.GLTFLoader();
        loader.load('user/images/virtual-showroom.glb', function (gltf) {
            scene.add(gltf.scene);
        }, undefined, function (error) {
            console.error('An error happened while loading the GLB file:', error);
        });

        camera.position.z = 5;

        function animate() {
            requestAnimationFrame(animate);

            if (controls.isLocked === true) {
                const delta = 0.1; // Adjust for speed

                velocity.x -= velocity.x * 10.0 * delta;
                velocity.z -= velocity.z * 10.0 * delta;

                direction.z = Number(moveForward) - Number(moveBackward);
                direction.x = Number(moveRight) - Number(moveLeft);
                direction.normalize(); // this ensures consistent movements in all directions

                if (moveForward || moveBackward) velocity.z -= direction.z * 400.0 * delta;
                if (moveLeft || moveRight) velocity.x -= direction.x * 400.0 * delta;

                controls.moveRight(-velocity.x * delta);
                controls.moveForward(-velocity.z * delta);
            }

            renderer.render(scene, camera);
        }

        function onWindowResize() {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        }
        window.addEventListener('resize', onWindowResize, false);

        animate();

        document.getElementById('showroom-container').addEventListener('click', () => {
            controls.lock();
        });

        document.getElementById('instructions').addEventListener('click', () => {
            controls.lock();
        });

        // Add event listeners for the Pointer Lock API
        controls.addEventListener('lock', function () {
            instructions.style.display = 'none';
        });

        controls.addEventListener('unlock', function () {
            instructions.style.display = 'block';
        });

        // Initially, the instructions should be visible
        const instructions = document.getElementById('instructions');
        instructions.style.display = 'block';


        function toggleFullscreenElements() {
            const header = document.querySelector('header');
            const footer = document.querySelector('footer');
            const fullscreenBtn = document.getElementById('fullscreen-btn');
            const isFullscreen = !!document.fullscreenElement;

            if (header) header.style.display = isFullscreen ? 'none' : '';
            if (footer) footer.style.display = isFullscreen ? 'none' : '';

            if (isFullscreen) {
                fullscreenBtn.textContent = 'Exit Fullscreen';
                fullscreenBtn.style.top = '30px';
            } else {
                fullscreenBtn.textContent = 'Fullscreen';
                fullscreenBtn.style.top = '110px';
            }

        }
        toggleFullscreenElements();
        document.getElementById('fullscreen-btn').addEventListener('click', () => {
            if (!document.fullscreenElement) {
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();

                } else if (document.documentElement.mozRequestFullScreen) { /* Firefox */
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
                    document.documentElement.webkitRequestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) { /* IE/Edge */
                    document.documentElement.msRequestFullscreen();
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) { /* Firefox */
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) { /* Chrome, Safari & Opera */
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) { /* IE/Edge */
                    document.msExitFullscreen();
                }
            }
        });
        document.addEventListener('fullscreenchange', toggleFullscreenElements);

    </script>
</body>
@endsection