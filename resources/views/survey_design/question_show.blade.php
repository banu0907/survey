<div class="question-row clearfix" draggable="true" id="{{ $question->id }}" data-question-class="{{ $question->question_type }}">
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
</div>