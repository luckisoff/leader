<div class="row">
	<div class="container-fluid">
		<div class="footer">
				<div class="pull-left">
					<p>&copy; 2017 - <a href="{{Setting::get('copyrights_url') ? Setting::get('copyrights_url') : url('/')}}">{{Setting::get('site_name' , 'StreamHash')}} </a></p>
				</div>
					
				<div class="pull-right">
					<?php $pages = pages();?>
					@if(count($pages) > 0)
						<ul>
							@foreach($pages as $page)
							<li><a href="{{route('page', $page->type)}}">{{$page->heading}}</a> | </li>
							@endforeach
						</ul>
						@endif
				</div>
		</div>
	</div>
</div>