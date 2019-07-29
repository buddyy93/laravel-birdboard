@if (isset($activity->changes['after']['body']))
    <p class="card-text small {{$loop->last ? '':'mb-1'}}">
        {{$activity->user->name}} updated task's title {{$activity->created_at->diffForHumans()}}
    </p>
@endif
