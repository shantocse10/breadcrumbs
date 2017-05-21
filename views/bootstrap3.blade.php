@if($breadcrumbs)
	<ol class="breadcrumb">
		@foreach($breadcrumbs as $item)
			@if ($loop->last)
				<li class="active">
					@if ($item['icon'])
						@if($icon_set == 'Glyphicons')
							<span class="{{ $item['icon'] }}" aria-hidden="true"></span> 
						@endif
					@endif
					{{ $item['title'] }}
				</li>
			@else
				<li>
					<a href="{{ $item['url'] }}">
						@if ($item['icon'])
							@if($icon_set == 'Glyphicons')
								<span class="{{ $item['icon'] }}" aria-hidden="true"></span> 
							@endif
						@endif
						{{ $item['title'] }}
					</a>
				</li>
			@endif
		@endforeach
	</ol>
@endif