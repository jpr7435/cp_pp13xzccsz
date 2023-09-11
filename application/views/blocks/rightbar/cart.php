<div class="cart">
	<div class="subtitle">Shopping Cart</div>

	<div class="row p-l-15 p-r-15 m-b-20">
		<div class="col-md-12">
			<button class="btn btn-block btn-warning text-semibold">Continue to Checkout</button>
		</div>
	</div>

	<div class="row p-l-15 p-r-15 p-b-20">
		<div class="col-md-3 col-sm-3 col-xs-3">
			<!--<img src="http://via.placeholder.com/80x80" alt="" class="img-responsive"/>-->
			<span class="notif-bubble left-top primary">2</span>
		</div>
		<div class="col-md-9 col-sm-9 col-xs-9 no-padding-l">
			<div>
				<span class="text-semibold">Product Name</span>
				<span class="x2 text-light pull-right">$51.98</span>
			</div>
			<div><a href="#" class="delete-item text-semibold text-danger"><i class="icon-bin position-left text-sm"></i>Delete</a></div>
		</div>
	</div>

	<div class="row p-l-15 p-r-15 p-b-20">
		<div class="col-md-3 col-sm-3 col-xs-3">
			<!--<img src="http://via.placeholder.com/80x80" alt="" class="img-responsive"/>-->
			<span class="notif-bubble left-top primary">1</span>
		</div>
		<div class="col-md-9 col-sm-9 col-xs-9 no-padding-l">
			<div>
				<span class="text-semibold">Product Name</span>
				<span class="x2 text-light pull-right">$25.99</span>
			</div>
			<div><a href="#" class="delete-item text-semibold text-danger"><i class="icon-bin position-left text-sm"></i>Delete</a></div>
		</div>
	</div>

	<div class="row p-l-15 p-r-15 p-b-20">
		<div class="col-md-3 col-sm-3 col-xs-3">
			<!--<img src="http://via.placeholder.com/80x80" alt="" class="img-responsive"/>-->
			<span class="notif-bubble left-top primary">1</span>
		</div>
		<div class="col-md-9 col-sm-9 col-xs-9 no-padding-l">
			<div>
				<span class="text-semibold">Product Name</span>
				<span class="x2 text-light pull-right">$25.99</span>
			</div>
			<div><a href="#" class="delete-item text-semibold text-danger"><i class="icon-bin position-left text-sm"></i>Delete</a></div>
		</div>
	</div>

	<div class="row p-l-15 p-r-15 p-b-20">
		<div class="col-md-3 col-sm-3 col-xs-3">
			<!--<img src="http://via.placeholder.com/80x80" alt="" class="img-responsive"/>-->
			<span class="notif-bubble left-top primary">1</span>
		</div>
		<div class="col-md-9 col-sm-9 col-xs-9 no-padding-l">
			<div>
				<span class="text-semibold">Product Name</span>
				<span class="x2 text-light pull-right">$25.99</span>
			</div>
			<div><a href="#" class="delete-item text-semibold text-danger"><i class="icon-bin position-left text-sm"></i>Delete</a></div>
		</div>
	</div>

</div>

<script>
var topMargin = $('.sidebar_header li a').outerHeight();
$('.cart').slimscroll({
	height: $(window).outerHeight() - topMargin + 2,
	width: "100%"
}).mouseover(function() {
	$(this).next('.slimScrollBar');
});
</script>
