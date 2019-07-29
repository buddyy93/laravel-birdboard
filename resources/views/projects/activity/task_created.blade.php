<p class="card-text small {{$loop->last ? '':'mb-1'}}">
    {{$activity->user->name}} created "{{$activity->subject->body}}" task {{$activity->created_at->diffForHumans()}}
</p>
