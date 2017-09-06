<li id="deleted-{{ $deleted->id }}" draggable="true">
    <h5> 
        {{ $deleted->title }}
        <button class="btn btn-default btn-xs pull-right">+ 新增</button>
    </h5>
    {{ $deleted->updated_at }}
</li>