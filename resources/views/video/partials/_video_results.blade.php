<div class="row">
	<div class="col-sm-3">
		<a href="{{url('/videos/'.$video->uid)}}">
			<img src="{{$video->getThumbnail()}}" alt="{{$video->title}}" class="img-fluid">
		</a>
	</div>
	<div class="col-sm-9">
		<a href="{{url('/videos/'.$video->uid)}}">{{$video->title}}</a>
		@if($video->description)
		<p>{{$video->description}}</p>
		@else
		<p class="muted"> No description</p>
		@endif
		<ul class="list-inline">
			<li class="list-inline-item"><a href="{{url('channel/'.$video->channel->slug)}}">{{$video->channel->name}}</a></li>
			<li class="list-inline-item">{{$video->created_at->diffForHumans()}}</li>
			<li class="list-inline-item">{{$video->viewCount()}} {{str_plural('view', $video->viewCount())}}</li>
		</ul>
	</div>
</div>