<p class="card-text small {{$loop->last ? '':'mb-1'}}">
    {{$activity->user->name}} incompleted "{{$activity->subject->body}}" task {{$activity->created_at->diffForHumans()}}
</p>
