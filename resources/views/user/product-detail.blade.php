@extends('user/master')
@section('content')
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.1.1/model-viewer.min.js"></script>
   <!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="/" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<a href="/product#{{ $mainProduct->productType }}" class="stext-109 cl8 hov-cl1 trans-04">
			{{ $mainProduct->productType->label() }}
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				{{ $mainProduct->productName }}
			</span>
		</div>
	</div>
		

	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-65 p-b-60">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
							@php
							$imageFiles = explode('|', $mainProduct->productImage);
							@endphp
							<div class="slick3 gallery-lb">
							@php
							$gltfWithImages = [];
							$imagesToShow = [];

							foreach ($imageFiles as $file) {
								$extension = pathinfo($file, PATHINFO_EXTENSION);
								$baseName = pathinfo($file, PATHINFO_FILENAME);
								
								// Check if the file is a GLTF file
								if ($extension === 'gltf') {
									// Look for a corresponding image file
									$imageFound = false;
									foreach ($imageFiles as $image) {
										if (pathinfo($image, PATHINFO_FILENAME) === $baseName && pathinfo($image, PATHINFO_EXTENSION) !== 'gltf') {
											$gltfWithImages[$file] = $image;
											$imageFound = true;
											break;
										}
									}
									// If no corresponding image file is found, map the GLTF file to null
									if (!$imageFound) {
										$gltfWithImages[$file] = null;
									}
								} else {
									// If it's not a GLTF file and no corresponding GLTF file exists, add it to the imagesToShow array
									if (!isset($gltfWithImages[$baseName . '.gltf'])) {
										$imagesToShow[] = $file;
									}
								}
							}
						@endphp

						@foreach($gltfWithImages as $gltfFile => $imageFile)
						<div class="item-slick3" data-thumb="{{ asset('user/images/product/' . ($imageFile ?? 'default-thumbnail.jpg')) }}">
							<div class="wrap-pic-w pos-relative">
								<model-viewer src="{{ asset('user/images/product/' . $gltfFile) }}"
											ar
											ar-modes="webxr scene-viewer quick-look"
											camera-controls
											poster="{{ asset('user/images/product/' . ($imageFile ?? 'default-poster.webp')) }}"
											shadow-intensity="1"
											style="height:700px;width:100%">
								</model-viewer>
							</div>
						</div>
					@endforeach

					{{-- Display standalone images --}}
					@foreach($imagesToShow as $imageFile)
						<div class="item-slick3" data-thumb="{{ asset('user/images/product/' . $imageFile) }}">
							<div class="wrap-pic-w pos-relative">
								<img src="{{ asset('user/images/product/' . $imageFile) }}" alt="IMG-PRODUCT">
								<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ asset('user/images/product/' . $imageFile) }}">
									<i class="fa fa-expand"></i>
								</a>
							</div>
						</div>
					@endforeach

							</div>
						</div>
					</div>
				</div>
					
				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 class="mtext-105 cl2 js-name-detail p-b-14">
						{{ $mainProduct->productName}}
						</h4>

						<span class="mtext-106 cl2">
						RM {{ $mainProduct->price}}
						</span>

						<p class="stext-102 cl3 p-t-23">
						{{ $mainProduct->productDesc}}
						</p>
						
						<!--  -->
						@php
							$colors = explode('|', $mainProduct->color); // 'Blue|Red'
							$sizePairs = explode('|', $mainProduct->size); // 'S,M,L|L'
							$quantityPairs = explode('|', $mainProduct->stock); // '30,50,20|20'

							$colorSizeMap = [];
							$maxQuantityMap = [];
							foreach ($colors as $index => $color) {
								$sizes = isset($sizePairs[$index]) ? explode(',', $sizePairs[$index]) : [];
								$quantities = isset($quantityPairs[$index]) ? explode(',', $quantityPairs[$index]) : [];

								$colorSizeMap[trim($color)] = $sizes;

								foreach ($sizes as $sizeIndex => $size) {
									$sizeTrimmed = trim($size);
									$maxQuantity = isset($quantities[$sizeIndex]) ? (int)$quantities[$sizeIndex] : 0;
									$maxQuantityMap[$sizeTrimmed] = $maxQuantity;
								}
							}
						@endphp
						<form action="/add-to-cart" method="POST">
    					@csrf
						<input type="hidden" name="productId" value="{{ $mainProduct->id }}">
						<input type="hidden" name="maxProductQuantity" type="num" id="maxProductQuantity" value="0"/>

						<div class="p-t-33">
							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6">
									Color
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select class="js-select2" name="color" id="colorSelect" onchange="updateSizes()">
											<option value="">Choose an option</option>
											@foreach ($colorSizeMap as $color => $sizes)
												<option value="{{ $color }}">{{ $color }}</option>
											@endforeach
										</select>
										<div class="dropDownSelect2" id="colorDropDownSelect"></div>
									</div>
								</div>
							</div>
							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6">
									Size
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select class="js-select2" name="size" id="sizeSelect" disabled onchange="updateQuantity()">
											<option value="">--Please Select a Color--</option>
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>
						</div>

							<div class="flex-w flex-r-m p-b-10">
								<div class="size-204 flex-w flex-m respon6-next">
									<div class="wrap-num-product flex-w m-r-20 m-tb-10">
										<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>

										<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" id="quantityInput" value="0" min="0" max="0" required>

										<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>

									<button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail" type="submit">
										Add to cart
									</button>
								</div>
							</div>	
						</div>
						</form>
						<!--  -->
						<div class="flex-w flex-m p-l-100 p-t-40 respon7">
							<div class="flex-m bor9 p-r-10 m-r-11">
								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
									<i class="zmdi zmdi-favorite"></i>
								</a>
							</div>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
								<i class="fa fa-facebook"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
								<i class="fa fa-twitter"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
								<i class="fa fa-google-plus"></i>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="bor10 m-t-50 p-t-43 p-b-40">
				<!-- Tab01 -->
				<div class="tab01">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item p-b-10">
							<a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
						</li>

						<li class="nav-item p-b-10">
							<a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional information</a>
						</li>

						<li class="nav-item p-b-10">
							<a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews (1)</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content p-t-43">
						<!-- - -->
						<div class="tab-pane fade show active" id="description" role="tabpanel">
							<div class="how-pos2 p-lr-15-md">
								<p class="stext-102 cl6">
								{{ $mainProduct->productDesc}}
								</p>
							</div>
						</div>

						<!-- - -->
						
						<div class="tab-pane fade" id="information" role="tabpanel">
							<div class="row">
								<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
									<ul class="p-lr-28 p-lr-15-sm">
										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Color
											</span>

											<span class="stext-102 cl6 size-206">
											{{ implode(', ', explode('|', $mainProduct->color)) }}
											</span>
										</li>

										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Size
											</span>

											<span class="stext-102 cl6 size-206">
											@php
												$sizeArray = explode(',', str_replace('|', ',', $mainProduct->size));
												$sizeArray = array_map('trim', $sizeArray);
												$uniqueSizes = array_unique($sizeArray);
											@endphp
											{{ implode(', ', $uniqueSizes) }}
											</span>
										</li>
									</ul>
								</div>
							</div>
						</div>
						
						<!-- - -->
						<div class="tab-pane fade" id="reviews" role="tabpanel">
							<div class="row">
								<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
									<div class="p-b-30 m-lr-15-sm">
										<!-- Review -->
										<div class="flex-w flex-t p-b-68">
											<div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
												<img src="images/avatar-01.jpg" alt="AVATAR">
											</div>

											<div class="size-207">
												<div class="flex-w flex-sb-m p-b-17">
													<span class="mtext-107 cl2 p-r-20">
														Ariana Grande
													</span>

													<span class="fs-18 cl11">
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star-half"></i>
													</span>
												</div>

												<p class="stext-102 cl6">
													Quod autem in homine praestantissimum atque optimum est, id deseruit. Apud ceteros autem philosophos
												</p>
											</div>
										</div>
										
										<!-- Add review -->
										<form class="w-full">
											<h5 class="mtext-108 cl2 p-b-7">
												Add a review
											</h5>

											<p class="stext-102 cl6">
												Your email address will not be published. Required fields are marked *
											</p>

											<div class="flex-w flex-m p-t-50 p-b-23">
												<span class="stext-102 cl3 m-r-16">
													Your Rating
												</span>

												<span class="wrap-rating fs-18 cl11 pointer">
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<input class="dis-none" type="number" name="rating">
												</span>
											</div>

											<div class="row p-b-25">
												<div class="col-12 p-b-5">
													<label class="stext-102 cl3" for="review">Your review</label>
													<textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="review"></textarea>
												</div>

												<div class="col-sm-6 p-b-5">
													<label class="stext-102 cl3" for="name">Name</label>
													<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text" name="name">
												</div>

												<div class="col-sm-6 p-b-5">
													<label class="stext-102 cl3" for="email">Email</label>
													<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email" type="text" name="email">
												</div>
											</div>

											<button class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
												Submit
											</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
			<span class="stext-107 cl6 p-lr-25">
				Type: 
				<a href="/product#{{ $mainProduct->productType }}"> {{ucwords($mainProduct->productType->value)}}</a>
			</span>

			<span class="stext-107 cl6 p-lr-25">
				Categories: 
				<a href="/product?category[]={{ $mainProduct->category }}"> {{ucwords($mainProduct->category->value)}}</a>
				
			</span>
		</div>
	</section>


	<!-- Related Products -->
	<section class="sec-relate-product bg0 p-t-45 p-b-105">
		<div class="container">
			<div class="p-b-45">
				<h3 class="ltext-106 cl5 txt-center">
					Related Products
				</h3>
			</div>

			<!-- Slide2 -->
			<div class="wrap-slick2">
				<div class="slick2">
				@foreach ($relatedProducts as $product)
					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						
						<div class="block2">
							<div class="block2-pic hov-img0">
							<img src="{{ asset('user/images/product/' . explode('|', $product->productImage)[0]) }}" alt="{{ $product->productImage }}">
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="{{ route('product.detail', $product->id) }}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										{{$product->productName}}
									</a>

									<span class="stext-105 cl3">
										RM {{$product->price}}
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="{{asset('user/images/icons/icon-heart-01.png')}}" alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{asset('user/images/icons/icon-heart-02.png')}}" alt="ICON">
									</a>
								</div>
							</div>
						</div>
						
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</section>
	<script>
    var colorSizeMap = @json($colorSizeMap); 
	var maxQuantityMap = @json($maxQuantityMap);
function updateSizes() {
	// Get the selected color value
	var colorSelect = document.getElementById('colorSelect');
	var selectedColor = colorSelect.value; // This gets the selected color value from the dropdown
	var sizeSelect = document.getElementById('sizeSelect');
	var selectedSize = sizeSelect.value;
	var quantityInput = document.getElementById('quantityInput');
	var maxProductQuantity = document.getElementById('maxProductQuantity');
	if (selectedColor!== "") {
        sizeSelect.disabled = false;
        sizeSelect.innerHTML = '<option value="">Choose a size</option>';
        $(sizeSelect).trigger('change'); // If using Select2
    } else {
        sizeSelect.innerHTML = '<option value="">--Please Select a Color--</option>';
        sizeSelect.disabled = true;
        $(sizeSelect).trigger('change');
		quantityInput.max = 0;
        quantityInput.value = 0;
		maxProductQuantity.value = 0;
    }

	// Check if the selected color is in the colorSizeMap
	if (selectedColor in colorSizeMap) {
		// Iterate over the sizes for the selected color
		colorSizeMap[selectedColor].forEach(function(size) {
			var option = document.createElement('option');
			option.value = size.trim(); // Ensure we don't have leading/trailing whitespace
			option.text = 'Size ' + size.trim();
			sizeSelect.appendChild(option);
		});

		// If using Select2, trigger the update for the size select dropdown
		$('#sizeSelect').trigger('change'); // Notify Select2 to update the sizeSelect dropdown
	}
}

function updateQuantity() {
        var sizeSelect = document.getElementById('sizeSelect');
        var selectedSize = sizeSelect.options[sizeSelect.selectedIndex].value; // Get the selected size value
        var quantityInput = document.getElementById('quantityInput'); // Get the quantity input element

        if (maxQuantityMap.hasOwnProperty(selectedSize)) {
            var maxQuantity = maxQuantityMap[selectedSize];
            quantityInput.max = maxQuantity; // Set the max attribute
			maxProductQuantity.value = maxQuantity;
            quantityInput.value = maxQuantity > 0 ? 1 : 0; // Reset the quantity input to 1 or 0 depending on availability
        } else {
            quantityInput.max = 0; // No size selected, or no quantity available
            quantityInput.value = 0;
			maxProductQuantity.value = 0;
        }
    }

	var quantityInput = document.getElementById('quantityInput');

    quantityInput.addEventListener('input', function() {
        var value = parseInt(this.value);
        var min = parseInt(this.getAttribute('min'));
        var max = parseInt(this.getAttribute('max'));

		if (!isFinite(value)) {
            this.value = min;
            return;
        }
        if (value < min) {
            this.value = min;
        } else if (value > max) {
            this.value = max;
        }
    });
		</script>
@endsection