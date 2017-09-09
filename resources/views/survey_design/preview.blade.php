<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>[调查问题预览] {{ $survey->survey }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="{{ url('/') }}/css/app.css">
    <link type="text/css" rel="stylesheet" href="{{ url('/') }}/css/font-awesome.min.css">
    <script type="text/javascript" src="{{ url('/') }}/js/app.js"></script>
</head>
<body>
@foreach ($subpages as $surveypage)
	 @include('survey_design.page')
@endforeach
</body>
</html>