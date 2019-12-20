@extends('layouts.user.focused')

@section('content')
<!-- Sing in  Form -->
<section class="sign-in">
  <div class="page-content">

		<div class="video-full-box">

			<h4>{{$model->heading}}</h4>


			<?= $model->description; ?>

		</div>
	</div>
</section>

@endsection