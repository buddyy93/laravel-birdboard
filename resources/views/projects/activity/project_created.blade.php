<p class="card-text small {{$loop->last ? '':'mb-1'}}">
    {{$activity->user->name}} created this project {{$activity->created_at->diffForHumans()}}
</p>
