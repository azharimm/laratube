@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Search for {{Request::get('q')}} :</div>
                <div class="card-body">
                    @if($channels->count())
                    <h4>Channels</h4>
                    <div class="card-body bg-light mb-2">
                        @foreach($channels as $channel)
                        <div class="media">
                            <div class="media-left">
                                <a href="{{url('/channel/'.$channel->slug)}}">
                                    <img src="{{$channel->getImage()}}" alt="{{$channel->name}}" width="40px" class="media-object">
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="{{url('/channel/'.$channel->slug)}}" class="media-heading">{{$channel->name}}</a>
                                <ul class="list-inline">
                                    <li class="list-inline-item">{{$channel->subscriptionCount()}} {{str_plural('subscriber', $channel->subscriptionCount())}}</li>
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if($videos->count())
                        @foreach($videos as $video)
                            <div class="card-body bg-light mb-2">
                                @include('video.partials._video_results', ['video'=>$video])
                            </div>
                        @endforeach
                    @else
                        <h4>Videos</h4>
                        <div class="card-body bg-light mb-2">
                            <p>No videos found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
