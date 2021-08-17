@if(session('success'))
	<div class="bg-green-600 text-white px-3 py-2 rounded-md mb-2">
		{{ session('success') }}
	</div>
@endif
@if($errors->any())
	<div class="bg-red-600 text-white px-3 py-2 rounded-md mb-2">
		@foreach($errors->all() as $error)
			<p>{{ $error }}</p>
		@endforeach
	</div>
@endif
