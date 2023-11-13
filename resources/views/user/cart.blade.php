@extends('user/master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
	.cart-info--count {
  background-color: #6c757d;
  color: white;
  padding: 0.25em 0.75em;
  border-radius: 50px;
  float: right;
  font-weight: 700;
  font-size: 1.1em;
}
.product-checkbox {
    margin: 10px;
}
	</style>
    <!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="/" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Shoping Cart
			</span>
		</div>
	</div>
		

	<!-- Shoping Cart -->
	<form class="bg0 p-t-75 p-b-85">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<table class="table-shopping-cart">
								<tr class="table_head">
									<th><input class="product-checkbox" type="checkbox" name="all" value="all" id="toggleAll"></th>
									<th class="column-1">Product</th>
									<th class="column-2"></th>
									<th class="column-3">Price</th>
									<th class="column-4">Quantity</th>
									<th class="column-5">Total</th>
								</tr>
								@php
								$itemTotalPrice = 0;
								foreach ($cartItems as $item) {
									$itemTotalPrice += $item->quantity * $item->product->price;
								}
								$shippingCost = 5; // Example shipping cost
								$discount = 10; // Example discount
								$totalPrice = $itemTotalPrice + $shippingCost - $discount;
								@endphp
								@foreach ($cartItems as $item)
								@php
								$colors = explode('|', $item->product->color);//Blue|Red
								$sizes = explode('|', $item->product->size);//S,M,L|S,L
								$stocks = explode('|', $item->product->stock);//20,30,40|20,50

								$stockData = [];
								foreach ($colors as $colorIndex => $color) {
									$sizeList = explode(',', $sizes[$colorIndex]);
									$stockList = explode(',', $stocks[$colorIndex]);

									foreach ($sizeList as $sizeIndex => $size) {
										$stockData[$color][$size] = $stockList[$sizeIndex];
									}
								}

								$stockJson = json_encode($stockData);

								$subPrice = $item->quantity * $item->product->price;
								
								@endphp
								
								<tr class="table_row">
									<td><input type="checkbox" class="product-checkbox" name="1" value="1" id="1"></td>
									<td class="column-1">
										<div class="how-itemcart1">
											<img src="{{ asset('user/images/product/' . explode('|', $item->product->productImage)[0]) }}" alt="IMG">
										</div>
									</td>
									<td class="column-2">{{ $item->product->productName }} <br/> {{ $item->color }}, {{ $item->size}}</td>
									<td class="column-3">RM{{ number_format($item->product->price, 2) }}</td>
									<input type="hidden" class="selected-color" data-item-id="{{ $item->id }}" value="{{ $item->color }}">
    								<input type="hidden" class="selected-size" data-item-id="{{ $item->id }}" value="{{ $item->size }}">
									<td class="column-4">
										<div class="wrap-num-product flex-w m-l-auto m-r-0">
											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>
											
											<input class="mtext-104 cl3 txt-center num-product" id="quantityInput-{{ $item->id }}" type="number" name="num-product1" value="{{ $item->quantity }}" data-item-id="{{ $item->id }}" min="1">

											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>
									</td>
									<td class="column-5" id="subPrice-{{ $item->id }}">RM{{ number_format($subPrice, 2) }}</td>
								</tr>
								<script>
									window.stockData = window.stockData || {};
									window.stockData['{{ $item->id }}'] = @json($stockData);
									$(document).ready(function() {
										$('.num-product').each(function() {
											var $input = $(this); // Define $input here
											var itemId = $input.data('item-id');
											var stockDataForItem = window.stockData[itemId];
											var selectedColor = $('.selected-color[data-item-id="' + itemId + '"]').val();
											var selectedSize = $('.selected-size[data-item-id="' + itemId + '"]').val();

											if(stockDataForItem[selectedColor] && stockDataForItem[selectedColor][selectedSize]) {
												var maxStock = stockDataForItem[selectedColor][selectedSize];
												$input.attr('max', maxStock); // Use $input here
											} else {
												console.error("Stock data not found for", selectedColor, selectedSize);
											}
										});
										
									});

								</script>
								@endforeach
							</table>
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							<span style="font-size: 30px;">Cart Totals</span>
							<span class="cart-info--count">
								2
							</span>
						</h4>
						
						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2">
									Subtotal:
								</span>
							</div>

							<div class="size-209">
								<span class="mtext-110 cl2" id="subItemPrice">
									RM{{ number_format($itemTotalPrice, 2) }}
								</span>
							</div>
						</div>

						<div class="flex-w flex-t bor12 p-t-15 p-b-30">
							<div class="size-208 w-full-ssm">
								<span class="stext-110 cl2">
									Shipping:
								</span>
							</div>

							<div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
								<div class="size-209">
									<span class="mtext-110 cl2" id="shippingCost">
										RM{{ number_format($shippingCost, 2) }}
									</span>
								</div>
								
								<div class="p-t-15">
									<span class="stext-112 cl8">
										Delivery Address
									</span>
									<div class="bor8 bg0 m-b-12">
										<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Address">
									</div>
									
									<div class="bor8 bg0 m-b-12">
										<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Postcode / Zip">
									</div>

									<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
										<select class="js-select2" name="time">
											<option>Select a state...</option>
											<option>MYR</option>
										</select>
										<div class="dropDownSelect2"></div>
									</div>

									<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-22 m-t-9">
										<select class="js-select2" name="time">
											<option>Select a country...</option>
											<option>MYR</option>
										</select>
										<div class="dropDownSelect2"></div>
									</div>
									
										
								</div>
							</div>
						</div>
						<div class="flex-w flex-t bor12 p-t-15 p-b-30">
							<div class="size-208 w-full-ssm">
								<span class="stext-110 cl2" >
									Discount:
								</span>
							</div>

							<div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
								<div class="size-209">
									<span class="mtext-110 cl2" style="color: green;" id="discount"> 
										<b>RM{{ number_format($discount, 2) }}</b>
									</span>
								</div>
							</div>
						</div>

						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
							</div>

							<div class="size-209 p-t-1">
								<span class="mtext-110 cl2" id="finalTotalPrice">
									RM{{ number_format($totalPrice, 2) }}
								</span>
							</div>
						</div>

						<a href="payment.html" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
							Proceed to Checkout
						  </a>
						  
					</div>
				</div>
			</div>
		</div>
	</form>
	<script>
    var isCartPage = true;
	$(document).ready(function() {
    if (window.isCartPage) {
        $('.js-show-cart').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            // Forcefully hide the cart pop-up
            $('.show-header-cart').hide(); // Replace with the actual selector for your cart pop-up
        });
    }
	
	
});


document.querySelectorAll('.num-product').forEach(function(quantityInput) {
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

	$(document).on('change', '.num-product', function() {
    var itemId = $(this).data('item-id');
    var quantity = $(this).val();
    $.ajax({
        url: '/user/update-cart-item',
        type: 'POST',
        data: {
            itemId: itemId,
            quantity: quantity,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            document.querySelector(`#subPrice-${itemId}`).textContent = `RM${response.newSubPrice}`;
            document.querySelector('#subItemPrice').textContent = `RM${response.itemTotalPrice}`;
			document.querySelector('#shippingCost').textContent = `RM${response.shippingCost}`;
			document.querySelector('#finalTotalPrice').textContent = `RM${response.totalPrice}`;
			document.querySelector('#discount').textContent = `RM${response.discount}`;
        },
        error: function(xhr) {
            console.error('Error updating cart:', xhr.responseText);
        }
    });
});
});




</script>
@endsection