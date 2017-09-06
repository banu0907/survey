@extends('layouts.default')
@section('title','建立调查问卷')
@section('content')
<div class="container">
<form action="{{ route('surveys.store') }}" method="post">
{{ csrf_field() }}
<div class="form-group">
	<label for="survey">输入问卷名称</label>
	<input type="text" class="form-control" name="survey" id="survey" value="{{ old('survey') }}">
</div>
<button type="submit" class="btn btn-primary">建立调查问卷</button>
</form>
</div>
@endsection