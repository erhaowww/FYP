<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signal</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('user/css/chatbot/chat.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/chatbot/chatbot.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/chatbot/typing.css')}}">

<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{asset('user/images/icons/signal.png')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user/fonts/iconic/css/material-design-iconic-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user/fonts/linearicons-v1.0.0/icon-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user/vendor/animate/animate.css')}}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('user/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('user/vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user/vendor/slick/slick.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user/vendor/MagnificPopup/magnific-popup.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user/vendor/perfect-scrollbar/perfect-scrollbar.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('user/css/main.css')}}">
<!--===============================================================================================-->

<!--===============================================================================================-->	
<script src="{{asset('user/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('user/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('user/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('user/vendor/bootstrap/js/bootstrap.min.js')}}"></script>

    <style>
        .swal2-container {
            z-index: 10500 !important; /* Adjust the value as needed, higher than the form's z-index */
        }

        /* Style for the notifications popup container */
        .notifications-popup {
        position: absolute;
        top: 100%;
        right: 10px;
        width: 300px;
        background-color: #ffffff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        padding: 10px;
        z-index: 9999;
        display: none; /* Hide the popup by default */
        }

        /* Style for each notification row */
        .notification-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #e0e0e0;
        }

        .notification-item:last-child {
        border-bottom: none; /* Remove border for the last notification item */
        }

        /* Style for notification image */
        .notification-item img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
        }

        /* Style for notification title */
        .notification-title {
        margin: 0;
        font-size: 16px;
        font-weight: bold;
        }

        /* Style for notification description */
        .notification-description {
        margin: 5px 0 0;
        font-size: 14px;
        color: #888888;
        }

        /* Hover effect for notification items */
        .notification-item:hover {
        background-color: #f5f5f5;
        cursor: pointer;
        }
    </style>
</head>
<body class="animsition">
    {{View::make('user/header')}}
    @yield('content')
    {{View::make('user/footer')}}

    {{-- chatbot --}}
    <div class="container" id="chatbot__container">
        <div class="chatbox">
            <div class="chatbox__support">
                <div class="chatbox__header">
                    <div class="chatbox__image--header">
                        <img src="{{asset('user/images/image.png')}}" alt="image">
                    </div>
                    <div class="chatbox__content--header">
                        <h4 class="chatbox__heading--header">Chat support</h4>
                        <p class="chatbox__description--header">There are many variations of passages of Lorem Ipsum available</p>
                    </div>
                </div>
                <div class="chatbox__messages">
                    <div>
                        <div class="messages__item--visitor">
                            <!-- Frequently Asked Question buttons -->
                            <div class="faq-buttons">
                                <button type="button" class="faq-button">How can I contact support?</button>
                                <button type="button" class="faq-button">What are your business hours?</button>
                                <button type="button" class="faq-button">Do you offer refunds?</button>
                            </div>
                        </div>
                        <div class="messages__item messages__item--visitor">
                            Can you let me talk to the support?
                        </div>
                        <div class="messages__item messages__item--operator">
                            Sure!
                        </div>
                        <div class="messages__item messages__item--visitor">
                            Need your help, I need a developer in my site.
                        </div>
                        <div class="messages__item messages__item--operator">
                            Hi... What is it? I'm a front-end developer, yay!
                        </div>
                        <div class="messages__item messages__item--typing">
                            <span class="messages__dot"></span>
                            <span class="messages__dot"></span>
                            <span class="messages__dot"></span>
                        </div>
                    </div>
                </div>
                <div class="chatbox__footer">
                    <img src="{{asset('user/images/icons/emojis.svg')}}" alt="">
                    <img src="{{asset('user/images/icons/microphone.svg')}}" alt="">
                    <input type="text" placeholder="Write a message...">
                    <p class="chatbox__send--footer">Send</p>
                    <img src="{{asset('user/images/icons/attachment.svg')}}" alt="">
                </div>
            </div>
            <div class="chatbox__button">
                <button>button</button>
            </div>
        </div>
    </div>

    <script src="{{asset('user/js/chatbot/Chat.js')}}"></script>
    <script type="text/javascript">
        var chatboxIconUrl = "{{ asset('user/images/icons/chatbox-icon.svg') }}";
    </script>
    <script src="{{asset('user/js/chatbot/chatbot.js')}}"></script>

<!--===============================================================================================-->
<script src="{{asset('user/vendor/select2/select2.min.js')}}"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
            $(this).on('select2:selecting', function (e) {
                $(this).select2('close');
            });
		})
	</script>
<!--===============================================================================================-->
	<script src="{{asset('user/vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{asset('user/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('user/vendor/slick/slick.min.js')}}"></script>
	<script src="{{asset('user/js/slick-custom.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('user/vendor/parallax100/parallax100.js')}}"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="{{asset('user/vendor/MagnificPopup/jquery.magnific-popup.min.js')}}"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="{{asset('user/vendor/isotope/isotope.pkgd.min.js')}}"></script>
<!--===============================================================================================-->
	{{-- <script src="{{asset('user/vendor/sweetalert/sweetalert.min.js')}}"></script> --}}
    <!-- Include SweetAlert2 CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> --}}
    <!-- Include SweetAlert2 JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @if ($message = Session::get('success'))
        <script>
                swal({
                    title: "Success!",
                    text: "{{ $message }}",
                    icon: "success",
                    button: "OK",
                });
        </script>
    @endif

	<script>
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

            $('.js-addcart-detail').on('click', function(e) {
                e.preventDefault(); // Prevent the default form submission
                var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();

                // Collect form data
                var color = $('#colorSelect').val();
                var size = $('#sizeSelect').val();
                var quantity = $('#quantityInput').val();
                var errors = [];

                // Validation checks
                if (!color) {
                    errors.push("Please select a color.");
                }
                if (!size) {
                    errors.push("Please select a size.");
                }
                if (quantity <= 0 || isNaN(quantity)) {
                    errors.push("Please enter a valid quantity.");
                }

                // Display errors using SweetAlert, if any
                if (errors.length > 0) {
                    var errorMessage = errors.join("\n");
                    swal("Error", errorMessage, "error");
                    return; // Stop further execution
                }

                // If validation passes, proceed with AJAX request
                var formData = {
                    '_token': $('input[name="_token"]').val(),
                    'productId': $('input[name="productId"]').val(),
                    'color': color,
                    'size': size,
                    'num-product': quantity,
                    'maxProductQuantity': $('input[name="maxProductQuantity"]').val(),
                };

                $.ajax({
                    url: '/add-to-cart',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        swal(nameProduct, "is added to cart!", "success");
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            swal("Error", xhr.responseJSON.error, "error");
                        } else {
                            swal("Error", "An error occurred while adding the product to the cart.", "error");
                        }
                    }
                });
            });


	</script>
<!--===============================================================================================-->
	<script src="{{asset('user/vendor/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>

	<script>
		$(document).ready(function() {
			// Show/hide notifications popup on bell icon click
			$("#notificationBell").click(function() {
				$("#notificationsPopup").toggle();
			});

			// Hide notifications popup when clicking outside the popup
			$(document).click(function(event) {
				if (!$(event.target).closest("#notificationBell, #notificationsPopup").length) {
				$("#notificationsPopup").hide();
				}
			});
		});
	</script>
<!--===============================================================================================-->
	<script src="{{asset('user/js/main.js')}}"></script>
</body>

</html>