<div class="question-row clearfix" draggable="true" id="{{ $question->id }}" data-question-class="{{ $question->question_type }}">
<fieldset>
    <h4>
        <span class="required-asterisk">
    @if ($question->required_question)
        <i class="fa fa-asterisk"></i>
    @endif
        </span>
        <span class="question-number">{{ $question->question_num }}</span>
        <span>{!! $question->title !!}</span>
    </h4>
    <div class="question-body">
        {!! $question->content_show !!}
    </div>
</fieldset>
</div>