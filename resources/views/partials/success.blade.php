@if (session('success2'))
	<div class="alert alert-success">
		<button class="close" type="button" data-dismiss="alert" aria-hidden="true">&#215;</button>
		{{ session('success2') }}
	</div>
@endif