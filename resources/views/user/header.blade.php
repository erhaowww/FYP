<header class="header-v2">
    <!-- Header desktop -->
    <div class="container-menu-desktop trans-03">
        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop p-l-45">
                
                <!-- Logo desktop -->		
                <a href="#" class="logo">
                    <img src="{{asset('user/images/icons/signal.png')}}" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="active-menu">
                            <a href="index.html">Home</a>
                            <ul class="sub-menu">
                                <li><a href="index.html">Homepage 1</a></li>
                                <li><a href="home-02.html">Homepage 2</a></li>
                                <li><a href="home-03.html">Homepage 3</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="product.html">Shop</a>
                        </li>

                        <li class="label1" data-label1="hot">
                            <a href="shoping-cart.html">Features</a>
                        </li>

                        <li>
                            <a href="blog.html">Blog</a>
                        </li>

                        <li>
                            <a href="about.html">About</a>
                        </li>

                        <li>
                            <a href="contact.html">Contact</a>
                        </li>
                    </ul>
                </div>	

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m h-full">
                    @if(auth()->check())
                        <div class="flex-c-m h-full p-r-24">
                            <ul class="main-menu">
                                <li>
                                    <a>
                                        <img src="{{asset('user/images/gallery-01.jpg')}}" width="40" height="40" class="rounded-circle">
                                    </a>
                                    <ul class="sub-menu">
                                        <li><a href="index.html">Homepage 1</a></li>
                                        <li><a href="home-02.html">Homepage 2</a></li>
                                        <li><a href="/logout">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="flex-c-m h-full p-r-24">
                            <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 user-icon">
                                <i class="zmdi zmdi-account"></i>
                            </div>
                        </div>
                    @endif

                    <div class="flex-c-m h-full p-r-24">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11" id="notificationBell">
                            <i class="zmdi zmdi-notifications"></i>
                        </div>
                    </div>

                    <!-- Notifications Popup -->
                    <div class="notifications-popup" id="notificationsPopup">
                        <!-- Add notification content here -->
                        <!-- Row 1 -->
                        <div class="notification-item">
                            <img src="{{asset('user/images/gallery-02.jpg')}}" alt="Notification Image 1">
                            <div class="notification-content">
                            <h5 class="notification-title">Notification Title 1</h5>
                            <p class="notification-description">Description for Notification 1 goes here.</p>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="notification-item">
                            <img src="{{asset('user/images/gallery-03.jpg')}}" alt="Notification Image 2">
                            <div class="notification-content">
                            <h5 class="notification-title">Notification Title 2</h5>
                            <p class="notification-description">Description for Notification 2 goes here.</p>
                            </div>
                        </div>

                        <!-- Add more rows as needed -->
                    </div>

                    <div class="flex-c-m h-full p-r-24">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-search">
                            <i class="zmdi zmdi-search"></i>
                        </div>
                    </div>
                        
                    <div class="flex-c-m h-full p-r-24">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify="2">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                    </div>
                        
                    <div class="flex-c-m h-full p-l-24 p-r-25 bor5">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-sidebar">
                            <i class="zmdi zmdi-menu"></i>
                        </div>
                    </div>
                </div>
            </nav>
        </div>	
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->		
        <div class="logo-mobile">
            <a href="index.html"><img src="{{asset('user/images/icons/logo-01.png')}}" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">
            <div class="flex-c-m h-full p-r-10">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-search">
                    <i class="zmdi zmdi-search"></i>
                </div>
            </div>

            <div class="flex-c-m h-full p-lr-10 bor5">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify="2">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>
            </div>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="main-menu-m">
            <li>
                <a href="index.html">Home</a>
                <ul class="sub-menu-m">
                    <li><a href="index.html">Homepage 1</a></li>
                    <li><a href="home-02.html">Homepage 2</a></li>
                    <li><a href="home-03.html">Homepage 3</a></li>
                </ul>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>

            <li>
                <a href="product.html">Shop</a>
            </li>

            <li>
                <a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
            </li>

            <li>
                <a href="blog.html">Blog</a>
            </li>

            <li>
                <a href="about.html">About</a>
            </li>

            <li>
                <a href="contact.html">Contact</a>
            </li>
        </ul>
    </div>

    <!-- ====== Login and Signup Form ====== -->
    <div class="user-form">
        <div class="close-form d-flex"><i class="zmdi zmdi-close" style="font-size: 16px;font-weight: 600;"></i></div>
        <div class="form-wrapper container">
          <div class="user login">
            <div class="img-box">
              <img src="{{asset('user/images/login.svg')}}" alt="" />
            </div>
            <div class="form-box">
              <div class="top">
                <p>
                  Not a member?
                  <span data-id="#ff0066" id="register_now">Register now</span>
                </p>
              </div>
              
              <form action="/login" method="POST" id="loginForm">
                <div class="form-control">
                  @csrf
                  <h2>Hello Again!</h2>
                  <p>Welcome back you've been missed.</p>
                  <input type="text" placeholder="Email" name="email"/>
                  <div>
                    <input type="password" placeholder="Password" name="password"/>
                    <div class="icon form-icon">
                      <img src="{{asset('user/images/eye.svg')}}" alt="" />
                    </div>
                  </div>
                  <span>Recovery Password</span>
                  <input type="Submit" value="Login" />
                </div>
                <div class="form-control">
                  <p>Or continue with</p>
                  <div class="icons">
                    <div class="icon">
                        <a href="/auth/google"><img src="{{asset('user/images/search.svg')}}" alt="" /></a>
                    </div>
                    <div class="icon">
                        <a href=""><img src="{{asset('user/images/facebook.svg')}}" alt="" /></a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
  
          <!-- Register -->
          <div class="user signup">
            <div class="form-box">
              <div class="top">
                <p>
                  Already a member?
                  <span data-id="#1a1aff" id="login_now">Login now</span>
                </p>
              </div>
              <form action="/register" method="POST" id="registrationForm">
                <div class="form-control">
                  @csrf
                  <h2>Welcome to Signal!</h2>
                  <p>It's good to have you.</p>
                  <input type="text" placeholder="Enter Name" name="name"/>
                  <input type="email" placeholder="Enter Email" name="email"/>
                  <div>
                    <input type="password" placeholder="Password" name="password" id="password"/>
                    <div class="icon form-icon">
                        <img src="{{asset('user/images/eye.svg')}}" alt="" />
                    </div>
                  </div>
                  <div>
                    <input type="password" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation"/>
                    <div class="icon form-icon">
                      <img src="{{asset('user/images/eye.svg')}}" alt="" />
                    </div>
                  </div>
                  <input type="Submit" value="Register" />
                </div>
                <div class="form-control">
                  <p>Or continue with</p>
                  <div class="icons">
                    <div class="icon">
                        <a href="/auth/google"><img src="{{asset('user/images/search.svg')}}" alt="" /></a>
                    </div>
                    <div class="icon">
                      <a href=""><img src="{{asset('user/images/facebook.svg')}}" alt="" /></a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="img-box">
              <img src="{{asset('user/images/trial.svg')}}" alt="" />
            </div>
          </div>
        </div>
    </div>
    
    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="{{asset('user/images/icons/icon-close2.png')}}" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>

<!-- Sidebar -->
<aside class="wrap-sidebar js-sidebar">
    <div class="s-full js-hide-sidebar"></div>

    <div class="sidebar flex-col-l p-t-22 p-b-25">
        <div class="flex-r w-full p-b-30 p-r-27">
            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-sidebar">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="sidebar-content flex-w w-full p-lr-65 js-pscroll">
            <ul class="sidebar-link w-full">
                <li class="p-b-13">
                    <a href="index.html" class="stext-102 cl2 hov-cl1 trans-04">
                        Home
                    </a>
                </li>

                <li class="p-b-13">
                    <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                        My Wishlist
                    </a>
                </li>

                <li class="p-b-13">
                    <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                        My Account
                    </a>
                </li>

                <li class="p-b-13">
                    <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                        Track Oder
                    </a>
                </li>

                <li class="p-b-13">
                    <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                        Refunds
                    </a>
                </li>

                <li class="p-b-13">
                    <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                        Help & FAQs
                    </a>
                </li>
            </ul>

            <div class="sidebar-gallery w-full p-tb-30">
                <span class="mtext-101 cl5">
                    @ CozaStore
                </span>

                <div class="flex-w flex-sb p-t-36 gallery-lb">
                    <!-- item gallery sidebar -->
                    <div class="wrap-item-gallery m-b-10">
                        <a class="item-gallery bg-img1" href="{{asset('user/images/gallery-01.jpg')}}" data-lightbox="gallery" 
                        style="background-image: url('{{asset('user/images/gallery-01.jpg')}}');"></a>
                    </div>

                    <!-- item gallery sidebar -->
                    <div class="wrap-item-gallery m-b-10">
                        <a class="item-gallery bg-img1" href="{{asset('user/images/gallery-02.jpg')}}" data-lightbox="gallery" 
                        style="background-image: url('{{asset('user/images/gallery-02.jpg')}}');"></a>
                    </div>

                    <!-- item gallery sidebar -->
                    <div class="wrap-item-gallery m-b-10">
                        <a class="item-gallery bg-img1" href="{{asset('user/images/gallery-03.jpg')}}" data-lightbox="gallery" 
                        style="background-image: url('{{asset('user/images/gallery-03.jpg')}}');"></a>
                    </div>

                    <!-- item gallery sidebar -->
                    <div class="wrap-item-gallery m-b-10">
                        <a class="item-gallery bg-img1" href="{{asset('user/images/gallery-04.jpg')}}" data-lightbox="gallery" 
                        style="background-image: url('{{asset('user/images/gallery-04.jpg')}}');"></a>
                    </div>

                    <!-- item gallery sidebar -->
                    <div class="wrap-item-gallery m-b-10">
                        <a class="item-gallery bg-img1" href="{{asset('user/images/gallery-05.jpg')}}" data-lightbox="gallery" 
                        style="background-image: url('{{asset('user/images/gallery-05.jpg')}}');"></a>
                    </div>

                    <!-- item gallery sidebar -->
                    <div class="wrap-item-gallery m-b-10">
                        <a class="item-gallery bg-img1" href="{{asset('user/images/gallery-06.jpg')}}" data-lightbox="gallery" 
                        style="background-image: url('{{asset('user/images/gallery-06.jpg')}}');"></a>
                    </div>

                    <!-- item gallery sidebar -->
                    <div class="wrap-item-gallery m-b-10">
                        <a class="item-gallery bg-img1" href="{{asset('user/images/gallery-07.jpg')}}" data-lightbox="gallery" 
                        style="background-image: url('{{asset('user/images/gallery-07.jpg')}}');"></a>
                    </div>

                    <!-- item gallery sidebar -->
                    <div class="wrap-item-gallery m-b-10">
                        <a class="item-gallery bg-img1" href="{{asset('user/images/gallery-08.jpg')}}" data-lightbox="gallery" 
                        style="background-image: url('{{asset('user/images/gallery-08.jpg')}}');"></a>
                    </div>

                    <!-- item gallery sidebar -->
                    <div class="wrap-item-gallery m-b-10">
                        <a class="item-gallery bg-img1" href="{{asset('user/images/gallery-09.jpg')}}" data-lightbox="gallery" 
                        style="background-image: url('{{asset('user/images/gallery-09.jpg')}}');"></a>
                    </div>
                </div>
            </div>

            <div class="sidebar-gallery w-full">
                <span class="mtext-101 cl5">
                    About Us
                </span>

                <p class="stext-108 cl6 p-t-27">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur maximus vulputate hendrerit. Praesent faucibus erat vitae rutrum gravida. Vestibulum tempus mi enim, in molestie sem fermentum quis. 
                </p>
            </div>
        </div>
    </div>
</aside>


<!-- Cart -->
<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">
                Your Cart
            </span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>
        
        <div class="header-cart-content flex-w js-pscroll">
            <ul class="header-cart-wrapitem w-full">
                <li class="header-cart-item flex-w flex-t m-b-12">
                    <div class="header-cart-item-img">
                        <img src="{{asset('user/images/item-cart-01.jpg')}}" alt="IMG">
                    </div>

                    <div class="header-cart-item-txt p-t-8">
                        <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                            White Shirt Pleat
                        </a>

                        <span class="header-cart-item-info">
                            1 x $19.00
                        </span>
                    </div>
                </li>

                <li class="header-cart-item flex-w flex-t m-b-12">
                    <div class="header-cart-item-img">
                        <img src="{{asset('user/images/item-cart-02.jpg')}}" alt="IMG">
                    </div>

                    <div class="header-cart-item-txt p-t-8">
                        <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                            Converse All Star
                        </a>

                        <span class="header-cart-item-info">
                            1 x $39.00
                        </span>
                    </div>
                </li>

                <li class="header-cart-item flex-w flex-t m-b-12">
                    <div class="header-cart-item-img">
                        <img src="{{asset('user/images/item-cart-03.jpg')}}" alt="IMG">
                    </div>

                    <div class="header-cart-item-txt p-t-8">
                        <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                            Nixon Porter Leather
                        </a>

                        <span class="header-cart-item-info">
                            1 x $17.00
                        </span>
                    </div>
                </li>
            </ul>
            
            <div class="w-full">
                <div class="header-cart-total w-full p-tb-40">
                    Total: $75.00
                </div>

                <div class="header-cart-buttons flex-w w-full">
                    <a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                        View Cart
                    </a>

                    <a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                        Check Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#registrationForm').submit(function(event) {
            event.preventDefault(); // Prevent the default form submit
            var url = $(this).attr("action");
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#login_now').click();
                    swal({
                        title: "Success!",
                        text: response.register_success,
                        icon: "success",
                        button: "OK"
                    });
                },
                error: function(xhr) {
                    // Handle errors
                    var errorMessageElement = document.createElement("ul");
                    errorMessageElement.style.listStyleType = "none";
                    errorMessageElement.style.padding = "0";
                    errorMessageElement.style.margin = "0";

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, values) { // The value could be an array of messages
                            values.forEach(function(value) { // Iterate through each message
                                var li = document.createElement("li");
                                li.style.margin = "5px 0";
                                li.style.paddingLeft = "20px";
                                li.style.position = "relative";

                                var span = document.createElement("span");
                                span.style.width = "6px";
                                span.style.height = "6px";
                                span.style.backgroundColor = "black";
                                span.style.borderRadius = "50%";
                                span.style.display = "inline-block";
                                span.style.position = "absolute";
                                span.style.left = "5px";
                                span.style.top = "50%";
                                span.style.transform = "translateY(-50%)";

                                li.appendChild(span);
                                li.appendChild(document.createTextNode(value)); // Append the text node to the li
                                errorMessageElement.appendChild(li); // Append the li to the ul
                            });
                        });
                    } else {
                        var li = document.createElement("li");
                        li.style.margin = "5px 0";
                        li.style.paddingLeft = "20px";
                        li.style.position = "relative";

                        var span = document.createElement("span");
                        span.style.width = "6px";
                        span.style.height = "6px";
                        span.style.backgroundColor = "black";
                        span.style.borderRadius = "50%";
                        span.style.display = "inline-block";
                        span.style.position = "absolute";
                        span.style.left = "5px";
                        span.style.top = "50%";
                        span.style.transform = "translateY(-50%)";

                        li.appendChild(span);
                        li.appendChild(document.createTextNode(xhr.statusText));
                        errorMessageElement.appendChild(li);
                    }

                    swal({
                        title: "Error!",
                        content: errorMessageElement, // Pass the DOM element, not the string
                        icon: "error",
                        button: "OK"
                    });
                }
            });
        });

        $('#loginForm').submit(function(event) {
            event.preventDefault(); // Prevent the default form submit
            var url = $(this).attr("action");
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    window.location.href = '/'
                },
                error: function(xhr) {
                    var errorMessage = xhr.responseJSON.error
                    swal({
                        title: "Error!",
                        text: errorMessage, // Pass the DOM element, not the string
                        icon: "error",
                        button: "OK"
                    });
                }
            });
        });
    });
</script>

    