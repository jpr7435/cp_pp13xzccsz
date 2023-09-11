<div class="activities">
	<div class="subtitle">Recent Activities</div>
	<ol class="activity-feed">
		<li class="feed-item" data-content="&#xeb35" data-color="info">
			<section>
				<input type="checkbox" id="expand_1" name="expand_1" />
				<label for="expand_1">
					<cite>2 minutes ago</cite>
					<span><b>Jane Elliott</b> added 2 new friends</span>
				</label>
				<main class="content">
					<b>Jane Elliott</b> added:<br />
					<!--<img src="http://via.placeholder.com/80x80" alt="image" class="img-circle img-20 m-t-10 m-r-10"/>
					<img src="http://via.placeholder.com/80x80" alt="image" class="img-circle img-20 m-t-10"/>-->
				</main>
			</section>
		</li>
		<li class="feed-item" data-content="&#xe914" data-color="success">
			<section>
				<input type="checkbox" id="expand_2" name="expand_2" />
				<label for="expand_2">
					<cite>Yesterday at 12:15 pm</cite>
					<span><b>Florence Douglas</b> posted on your timeline.</span>
				</label>
				<main class="content">
					Duis iaculis commodo condimentum. Donec quis felis libero. Nunc feugiat nisi ut ullamcorper congue.
				</main>
			</section>
		</li>
		<li class="feed-item" data-content="&#xeb35" data-color="warning">
			<section>
				<input type="checkbox" id="expand_3" name="expand_3" />
				<label for="expand_3">
					<cite>2 Days ago</cite>
					<span>You have a new friend request</span>
				</label>
				<main class="content">
					<b>Jane Elliott</b> wants to be your friend<br />
					<!--<img src="http://via.placeholder.com/80x80" alt="image" class="img-circle img-20 m-t-10 m-r-10"/>-->
				</main>
			</section>
		</li>
		<li class="feed-item" data-content="&#xeab6" data-color="success">
			<section>
				<label for="expand_4">
					<cite>2 days ago</cite>
					<span><b>Florence Douglas</b> invited you for <a href="#">New event</a>.</span>
				</label>
			</section>
		</li>
		<li class="feed-item" data-content="&#xea49">
			<section>
				<input type="checkbox" id="expand_5" name="expand_5" />
				<label for="expand_5">
					<cite>3 days ago</cite>
					<span>You have 5 documents pending</span>
				</label>
				<main class="content">
					<i class="icon-file-presentation x4 position-left m-b-10"></i>
					<i class="icon-file-picture x4 position-left m-b-10"></i>
					<i class="icon-file-locked x4 position-left m-b-10"></i>
					<i class="icon-file-xml x4 position-left m-b-10"></i>
					<i class="icon-file-play x4 position-left m-b-10"></i>
				</main>
			</section>
		</li>
	</ol>
</div>

<script>
var topMargin = $('.sidebar_header li a').outerHeight();
$('.activities').slimscroll({
	height: $(window).outerHeight() - topMargin + 2,
	width: '100%'
}).mouseover(function() {
	$(this).next('.slimScrollBar');
});
</script>
