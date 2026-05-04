@if($errors->any())
	<div class="w-full mx-auto">
		<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-4 rounded relative" role="alert">
			<strong class="font-bold">Validation Errors!</strong>
			<ul class="list-disc list-inside">
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	</div>
@endif
