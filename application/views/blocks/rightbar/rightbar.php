<div class="tabbable">
	<ul class="nav nav-tabs sidebar_header">
		<li class="active"><a href="#chat" data-toggle="tab"><i class="icon-comment-discussion"></i></a></li>
		<!--<li><a href="#notifications" data-toggle="tab"><i class="icon-bell2"></i></a></li>
		<li><a href="#activities" data-toggle="tab"><i class="icon-align-center-horizontal"></i></a></li>
		<li><a href="#cart" data-toggle="tab"><i class="icon-cart4"></i></a></li>

		<li class="pull-right"><a onclick="close_rightbar()"><i class="icon-cross2"></i></a></li>
		<li class="pull-right"><a href="#settings" data-toggle="tab"><i class="icon-cog2"></i></a></li>-->
	</ul>

	<div class="tab-content">
		<div class="tab-pane active fadeIn" id="chat">
		</div>

		<!--<div class="tab-pane fade" id="notifications">
		</div>

		<div class="tab-pane fade" id="activities">
		</div>

		<div class="tab-pane fade" id="cart">
		</div>

		<div class="tab-pane fade" id="settings">
		</div>-->
	</div>
</div>
<script>
$("#chat").load("blocks/rightbar/chat.html");
$("#notifications").load("blocks/rightbar/notifications.html");
$("#activities").load("blocks/rightbar/activities.html");
$("#cart").load("blocks/rightbar/cart.html");
$("#settings").load("blocks/rightbar/settings.html");
</script>
