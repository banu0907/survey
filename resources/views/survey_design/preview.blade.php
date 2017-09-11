<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>[调查问题预览] {{ $survey->survey }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="{{ url('/') }}/css/app.css">
    <link type="text/css" rel="stylesheet" href="{{ url('/') }}/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="{{ url('/') }}/css/survey_preview.css">
    <script type="text/javascript" src="{{ url('/') }}/js/app.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/js/survey_preview.js"></script>
</head>
<body>

		<div class="container" id="survey_box">

			<header class="question-header">
				<h1{!! $survey->survey_alignment=="center"  ? " class=\"text-center\"" : "" !!}>
				{{ $survey->survey }}
				</h1>
				@if (isset( $survey->survey_logo ))
				<img src="{{ $survey->survey_logo }}" alt="">
				@endif
			</header>	

			<div id="question-pages">
@foreach ($subpages as $surveypage)
				<article class="survey-page" id="pageid-{{ $surveypage->id }}">
					<header>
						<h2>{{ $surveypage->page_title or '' }}</h2>
						<h3>{!! $surveypage->page_description !!}</h3>
					</header>
		@foreach ($surveypage->questions as $question)
					<section class="question-row clearfix" id="{{ $question->id }}" data-question-class="{{ $question->question_type }}">
						<fieldset>
						    <h4>
						    @if ($question->required_question)
						        <span class="required-asterisk">*</span>
						    @endif
						        <span class="question-number">{{ $question->question_num }}</span>
						        <span>{!! $question->title !!}</span>
						    </h4>
						    <div class="question-body">
						        {!! $question->content_show !!}
						    </div>
						</fieldset>
					</section>
		@endforeach
					<footer>
						<button class="btn btn-lg prev-button">上一页</button>
						<button class="btn btn-lg done-button">完成</button>
						<button class="btn btn-lg next-button">下一页</button>
					</footer>
				</article>
@endforeach
			</div>
		</div>

		<div class="container" id="endPreview">

			<h1>预览结束!</h1>
			<button class="btn btn-lg" id="resetSurvey">再次预览调查问题</button>
			<button class="btn btn-success btn-lg" id="closePreview">回到调查问卷编辑器</button>
		</div>


</body>
</html>