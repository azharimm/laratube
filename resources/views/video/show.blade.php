@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if($video->isPrivate() && Auth::check() && $video->ownedByUser(Auth::user()))
            <div class="alert alert-info">
              Your video is currently private. Only you can see it.
            </div>
            @endif

            @if($video->isProcessed() && $video->canBeAccessed(Auth::user()))
              <video-player video-uid="{{$video->uid}}" video-url="{{$video->getStreamUrl()}}" thumbnail-url="{{$video->getThumbnail()}}"></video-player>
            @endif

            @if(!$video->isProcessed())
            <div class="video-placeholder">
              <div class="video-placeholder__header">
                This video is processing. Come back later
              </div>
            </div>
            @elseif(!$video->canBeAccessed(Auth::user()))
            <div class="video-placeholder">
              <div class="video-placeholder__header">
                This video is private.
              </div>
            </div>
            @endif

            <div class="card mb-2">
                <div class="card-body">
                   <h4>{{$video->title}}</h4>
                   <div class="float-right">
                       <div class="video__views">
                         {{$video->viewCount()}} {{str_plural('view',$video->viewCount())}}
                       </div>
                       @if($video->votesAllowed())
                       <video-vote video-uid ="{{$video->uid}}"></video-vote>
                       @endif
                   </div>
                   <div class="media">
                       <div class="media-left" style="margin-right: 10px;">
                        <a href="{{url('/channel/'.$video->channel->slug)}}">
                            <img width="40px" src="{{$video->channel->getImage()}}" alt="{{$video->channel->name}}">
                        </a>
                       </div>
                       <div class="media-body">
                           <a href="{{url('/channel/'.$video->channel->slug)}}" class="media-heading">{{$video->channel->name}}</a>
                           <subscribe-button channel-slug="{{$video->channel->slug}}"></subscribe-button>
                       </div>
                   </div>
                </div>
            </div>
            @if($video->description)
            <div class="card mb-2">
                <div class="card-body">
                   {!!nl2br(e($video->description))!!}
                </div>
            </div>
            @endif

            <div class="card mb-2">
            @if($video->commentsAllowed())
                <div class="card-body">
                   <video-comment video-uid="{{$video->uid}}"></video-comment>
                </div>
            @else
                <p>Comments are disabled</p>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection
