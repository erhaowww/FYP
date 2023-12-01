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
        #crosshair {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 5px;
            height: 5px;
            background-color: red;
            border-radius: 50%;
        }
        canvas { display: block; } 
    </style>
<body>
    <div id="instructions">
        <span style="font-size: 24px; color:white">Click to play</span><br>
        Move: WASD<br>
        Look: Mouse Move<br>
        Click Button: Show Details <br>(click anywhere to close it)<br>
    </div>
    <div id="showroom-container"></div>
    <div id="fullscreen-btn" style="position: fixed; top: 110px; right: 10px; z-index: 1000; cursor: pointer; padding: 10px; background-color: #f1f1f1; border-radius: 5px;">
        Fullscreen
    </div>
    <div id="data-dialog" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 300px; padding: 20px; text-align: center; background-color: white; border-radius: 10px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); z-index: 1001;">
        <div id="data-content">
        </div>
        <button onclick="closeDataDialog()">Close</button>
    </div>
    <div id="crosshair"></div>
    <script src="https://cdn.jsdelivr.net/npm/three/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/PointerLockControls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/GLTFLoader.js"></script>

    <script type="text/javascript">
    var products = @json($products);
    </script>
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
                const delta = 0.03; // Adjust for speed

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
            const headerHeight = document.querySelector('header').offsetHeight;
            const newHeight = window.innerHeight - headerHeight;
            renderer.setSize(window.innerWidth, newHeight);
            camera.aspect = window.innerWidth / newHeight;
            camera.updateProjectionMatrix();
            renderer.render(scene, camera);
        }

        window.addEventListener('resize', onWindowResize);
        document.addEventListener('fullscreenchange', onWindowResize);
        onWindowResize();
        window.addEventListener('resize', onWindowResize, false);
        animate();

        document.getElementById('showroom-container').addEventListener('click', () => {
            controls.lock();
        });
        document.getElementById('instructions').addEventListener('click', () => {
            controls.lock();
        });
        controls.addEventListener('lock', function () {
            instructions.style.display = 'none';
        });
        controls.addEventListener('unlock', function () {
            instructions.style.display = 'block';
        });
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
                onWindowResize();
            } else {
                fullscreenBtn.textContent = 'Fullscreen';
                fullscreenBtn.style.top = '110px';
                onWindowResize();
            }

        }
        toggleFullscreenElements();
        document.getElementById('fullscreen-btn').addEventListener('click', () => {
            if (!document.fullscreenElement) {
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();

                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        });
        document.addEventListener('fullscreenchange', toggleFullscreenElements);

        
        let buttonMeshes = [];
        const buttonMesh1 = createButtonForProduct(1, new THREE.Vector3(-2,-1, 5));
        scene.add(buttonMesh1);
        buttonMeshes.push(buttonMesh1);
        const buttonMesh3 = createButtonForProduct(3, new THREE.Vector3(2, -1, 5));
        scene.add(buttonMesh3);
        buttonMeshes.push(buttonMesh3);

        function createButtonForProduct(productId, position) {
            const buttonGeometry = new THREE.BoxGeometry(1, 0.5, 0.1);
            const buttonMaterial = new THREE.MeshBasicMaterial({ color: 0xff0000 });
            const buttonMesh = new THREE.Mesh(buttonGeometry, buttonMaterial);
            buttonMesh.position.copy(position);
            buttonMesh.userData = { productId: productId };
            return buttonMesh;
        }
            

        const raycaster = new THREE.Raycaster();
        const mouse = new THREE.Vector2();
        function getCanvasRelativePosition(event) {
            const rect = renderer.domElement.getBoundingClientRect();
            return {
                x: ((event.clientX - rect.left) / rect.width) * 2 - 1,
                y: -((event.clientY - rect.top) / rect.height) * 2 + 1
            };
        }

        function onMouseMove(event) {
            const rect = renderer.domElement.getBoundingClientRect();
            mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
            mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
        }
        window.addEventListener('mousemove', onMouseMove, false);


        function onDocumentMouseDown(event) {
            if (controls.isLocked === true) {
                console.log("Mouse down event triggered");
                event.preventDefault();
                const centerX = (window.innerWidth / 2 - renderer.domElement.offsetLeft) / renderer.domElement.clientWidth * 2 - 1;
                const centerY = -(window.innerHeight / 2 - renderer.domElement.offsetTop) / renderer.domElement.clientHeight * 2 + 1;

                // Set the raycaster to the calculated center position
                raycaster.setFromCamera({ x: centerX, y: centerY }, camera);
                const intersects = raycaster.intersectObjects(scene.children);

                console.log("Intersections found:", intersects.length);
                if (intersects.length > 0 && intersects[0].object.userData.productId) {
                    console.log("Product button clicked, ID:", intersects[0].object.userData.productId);
                    const productId = intersects[0].object.userData.productId;
                    const buttonPosition = intersects[0].object.position;
                    openDataDialog(productId, buttonPosition);
                } else {
                    console.log("No product button clicked");
                    close3DDialog();
                }
            }
        }
    document.addEventListener('mousedown', onDocumentMouseDown, false);

let currentDialog = null;
function createTextTexture(product, width = 512, height = 256) {
    const canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;

    const context = canvas.getContext('2d');
    context.fillStyle = '#FFFFFF'; // Background color
    context.fillRect(0, 0, width, height);
    context.font = '20px Arial';
    context.fillStyle = '#000000';
    context.textAlign = 'left';
    context.padding = '40px';
    context.textBaseline = 'top';
    const lineHeight = 24;
    let yPosition = 10;
    context.fillText('Name: ' + product.productName, 10, yPosition);
    yPosition += lineHeight;
    context.fillText('Description: ' + product.productDesc, 10, yPosition);
    yPosition += lineHeight;
    context.fillText('Price: RM ' + product.price, 10, yPosition);
    yPosition += lineHeight;
    context.fillText('Color: ' + product.colors, 10, yPosition);
    yPosition += lineHeight;
    context.fillText('Size: ' + product.sizes, 10, yPosition);
    yPosition += lineHeight * 2;
    const img = new Image();
    img.onload = function() {
        context.drawImage(img, 10, yPosition, 100, 100); // Adjust size as needed
        const texture = new THREE.Texture(canvas);
        texture.needsUpdate = true;
    };
    img.src = '{{ asset("user/images/product/") }}'+'/' + product.productTryOnQR;

    context.strokeStyle = 'red'; 
    context.strokeRect(0, 0, width, height);
    
    const texture = new THREE.Texture(canvas);
    texture.needsUpdate = true;
    return texture;
}
function create3DDialog(product, position) {
    console.log("Creating 3D dialog for product:", product);
    const dialogGroup = new THREE.Group();

    const dialogGeometry = new THREE.PlaneGeometry(2, 3);
    const textTexture = createTextTexture(product);
    const dialogMaterial = new THREE.MeshBasicMaterial({ map: textTexture, transparent: true });
    const dialogMesh = new THREE.Mesh(dialogGeometry, dialogMaterial);
    dialogGroup.add(dialogMesh);

    // Positioning the dialog
    dialogGroup.position.set(position.x, position.y + 1, position.z);
    dialogGroup.scale.set(1, 1, 1);
    dialogGroup.lookAt(camera.position);
    console.log("Created dialog group:", dialogGroup);
    return dialogGroup;
}


function openDataDialog(productId, buttonPosition) {
    console.log("Opening data dialog for product:", productId);
    var product = products.find(p => p.id === productId);
    const buttonMesh = scene.children.find(child => child.userData.productId === productId);
    if (!product) {
        console.error('Product not found!');
        return;
    }
    close3DDialog(); // Close any existing dialog
    const offset = new THREE.Vector3(0, 0, -1); // Adjust the z-value as needed
    const dialogPosition = buttonPosition.clone().add(offset.applyQuaternion(buttonMesh.quaternion));
    currentDialog = create3DDialog(product, dialogPosition);
    currentDialog.scale.set(2, 2, 2);
    scene.add(currentDialog);
    console.log("Dialog added. Scene children:", scene.children);
}

function close3DDialog() {
    console.log("Closing data dialog");
    if (currentDialog) {
        scene.remove(currentDialog);
        currentDialog = null;
    }
}
    </script>
</body>
@endsection