<footer class="footer">
  <div class="container">
  	<div class="pull-left col-sm-6 text-left">
		&copy; 2019 - <a href="{{Setting::get('copyrights_url') ? Setting::get('copyrights_url') : url('/')}}">{{Setting::get('site_name' , 'StreamHash')}} </a>
  	</div>
  	<div class="pull-right col-sm-6 text-right">
		<?php $pages = pages();?>
		@if(count($pages) > 0)
			<ul>
				@foreach($pages as $page)
				<li><a href="{{route('page', $page->type)}}">{{$page->heading}}</a></li>
				@endforeach
			</ul>
		@endif
	</div>
  </div>
</footer>