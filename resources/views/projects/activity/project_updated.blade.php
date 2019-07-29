<p class="card-text small {{$loop->last ? '':'mb-1'}}">
    @if(count($activity->changes['after']) === 1)
        {{$activity->user->name}} updated the {{key($activity->changes['after'])}} of the project
    @else
        {{$activity->user->name}} updated this project
    @endif
</p>
