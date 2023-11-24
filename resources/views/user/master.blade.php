<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signal</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('user/css/chatbot/chat.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/chatbot/chatbot.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/chatbot/typing.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
<!--===============================================================================================-->

    <style>
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

        .emoji-picker-container {
            position: relative;
        }

        emoji-picker {
            position: absolute;
            bottom: 100%; /* This will make it pop out above the chatbox footer */
            right: 0; /* Adjust this as needed to align with the emoji icon */
            z-index: 1000; /* Ensure it's above other elements */
        }

        .chatbox__microphone-icon.listening {
            /* style change when listening */
            opacity: 0.5;
        }

        .chatbox__send--footer {
            cursor: pointer;
        }

        .chatbox__microphone-icon {
            cursor: pointer;
        }

        .chatbox__emoji-icon {
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
                        <div class="messages__item--operator">
                            <!-- Frequently Asked Question buttons -->
                            <div class="faq-buttons">
                                <button type="button" class="faq-button">How can I contact support?</button>
                                <button type="button" class="faq-button">What are your business hours?</button>
                                <button type="button" class="faq-button">Do you offer refunds?</button>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
                <div class="chatbox__footer">
                    <div class="emoji-picker-container" style="position: relative;">
                        <emoji-picker style="display: none; position: absolute; bottom: 100%;"></emoji-picker>
                    </div>
                    <img src="{{asset('user/images/icons/emojis.svg')}}" class="chatbox__emoji-icon" alt="">
                    <img src="{{asset('user/images/icons/microphone.svg')}}" class="chatbox__microphone-icon" alt="">
                    <input type="text" class="chatbox__userQuery" placeholder="Write a message..." name="chatbox__userQuery">
                    <p class="chatbox__send--footer">Send</p>
                </div>
            </div>
            <div class="chatbox__button">
                <button>button</button>
            </div>
        </div>
    </div>
    {{-- end chatbot --}}

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
                    url: '../user/add-to-cart',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                    if ($('.header-cart-wrapitem').length === 0) {
                        // If the cart was initially empty, create the structure
                        var cartContentHtml = '<ul class="header-cart-wrapitem w-full">' + 
                                            response.cartItemsHtml + 
                                            '</ul><div class="w-full">' +
                                            '<div class="header-cart-total w-full p-tb-40" id="totalPrice">' +
                                            'Total: RM' + response.newTotalPrice + '</div>' +
                                            '<div class="header-cart-buttons flex-w w-full">' +
                                            '<a href="/cart" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">View Cart</a>' +
                                            '<a href="#" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">Check Out</a>' +
                                            '</div></div>';
                        $('.header-cart-content').html(cartContentHtml);
                    } else {
                        // If the cart already has items, just update the list and total
                        $('.header-cart-wrapitem').html(response.cartItemsHtml);
                        $('#totalPrice').text('Total: RM' + response.newTotalPrice);
                    }

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

    <script>
        // Check for browser support
        var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;

        if (SpeechRecognition) {
            let recognition = new SpeechRecognition();
            let isListening = false;
            const microphoneButton = document.querySelector('.chatbox__microphone-icon');
            const chatInput = document.querySelector('.chatbox__userQuery');

            microphoneButton.addEventListener('click', () => {
                if (isListening) {
                    recognition.stop();
                    return;
                }

                recognition.lang = 'en-US'; // Set the language of the recognition
                recognition.start(); // Start the recognition
                isListening = true;
                microphoneButton.classList.add('listening'); // Optional: change the icon style when listening
            });

            recognition.onresult = (event) => {
                const transcript = Array.from(event.results)
                    .map(result => result[0])
                    .map(result => result.transcript)
                    .join('');

                chatInput.value += transcript; // Append the transcript to the input field
            };

            recognition.onend = () => {
                isListening = false;
                microphoneButton.classList.remove('listening'); // Optional: revert the icon style when not listening
            };

            recognition.onerror = (event) => {
                console.error('Speech recognition error', event.error);
                isListening = false;
                microphoneButton.classList.remove('listening'); // Optional: revert the icon style when not listening
            };
        } else {
            console.log('Speech Recognition Not Available');
            // Hide or disable the microphone button as speech recognition is not supported in the browser
        }
    </script>

    <script type="module">
        import 'https://cdn.jsdelivr.net/npm/emoji-picker-element@latest/index.js'
    </script>
      
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const emojiPicker = document.querySelector('.emoji-picker-container emoji-picker');
            const emojiButton = document.querySelector('.chatbox__emoji-icon');
            const chatInput = document.querySelector('.chatbox__userQuery');

            emojiButton.addEventListener('click', () => {
                const isDisplayed = window.getComputedStyle(emojiPicker).display !== 'none';
                emojiPicker.style.display = isDisplayed ? 'none' : 'block';
                emojiButton.style.opacity = isDisplayed ? '1' : '0.5';
            });

            emojiPicker.addEventListener('emoji-click', event => {
                chatInput.value += event.detail.unicode;
                chatInput.focus(); // Brings focus back to the input after selecting an emoji
            });
        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function sendMessage() {
            $value = $('.chatbox__userQuery').val();
            var $messages = $(".chatbox__messages");

            //avoid sending empty messages
            if ($value.trim() === '') {
                swal({
                    title: "Error!",
                    text: "Please don't send empty query messages",
                    icon: "error",
                    buttons: false,
                    timer: 3000
                });
                return;
            }

            // Create a new message element
            var $newMessage = $('<div class="messages__item messages__item--visitor">' + $value + '</div>');

            // Append the new message at the beginning of the container, which appears at the bottom due to flex-reverse
            $messages.append($newMessage);

            // Scroll to the new message
            $messages.scrollTop($messages.prop("scrollHeight"));

            // Clear the input field
            $('.chatbox__userQuery').val('');

            // Show a loading message
            var $loadingMessage = $('<div class="messages__item messages__item--typing"><span class="messages__dot"></span><span class="messages__dot"></span><span class="messages__dot"></span></div>');
            $messages.append($loadingMessage);
            $messages.scrollTop($messages.prop("scrollHeight"));

            $.ajax({
                type: 'POST',
                url: "{{ route('sendChat') }}",
                data: {
                    'input': $value
                },
                success: function(response) {
                    // Remove the loading message
                    $loadingMessage.remove();
                    $responseMessage = $('<div class="messages__item messages__item--operator">' + response.choices[0].message.content + '</div>');
                    $messages.append($responseMessage);
                    $messages.scrollTop($messages.prop("scrollHeight"));
                },
                error: function(xhr) {
                    // Remove the loading message
                    $loadingMessage.remove();

                    // Check if the response is in JSON format
                    var errorResponse = xhr.responseJSON;
                    
                    // Check if an error message is provided
                    var errorMessage = errorResponse && errorResponse.error ? errorResponse.error : "An unknown error occurred.";

                    // Display the error message
                    var $errorMessage = $('<div class="messages__item messages__item--operator">' + errorMessage + '</div>');
                    $messages.append($errorMessage);
                    $messages.scrollTop($messages.prop("scrollHeight"));
                }
            })
        }
            
        // Send button click event
        $(".chatbox__send--footer").on('click', sendMessage);

        // Keypress event for Enter key on the input field
        $('.chatbox__userQuery').on('keypress', function (e) {
            if (e.which == 13) { // 13 is the Enter key's keycode
                sendMessage();
                return false; // Prevents the default action of the Enter key
            }
        });
    </script>
</body>

</html>