@if (session('errors'))
	<div class="alert alert-danger">
		<button class="close" type="button" data-dismiss="alert" aria-hidden="true">&#215;</button>
		{{ session('danger2') }}
	</div>
@endif