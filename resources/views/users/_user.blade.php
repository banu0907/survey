		<li>
			<img src="{{ $user->gravatar() }}" alt="{{ $user->name }}">
			<a href="{{ route('users.show',$user->id) }}" class="username">{{ $user->name }}</a>

			@can('destroy', $user)
			<form action="{{ route('users.destroy',$user->id) }}" method="post">
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
				<button type="submit" class="btn btn-sm btn-danger">删除</button>
			</form>
			@endcan
		</li>