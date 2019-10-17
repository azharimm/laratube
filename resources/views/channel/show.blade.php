@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                  <div class="media">
                      <div class="media-left" style="margin-right: 10px; ">
                          <img src="{{$channel->getImage()}}" alt="{{$channel->name}} image" class="media-object" width="40px">
                      </div>
                      <div class="media-body">
                          {{$channel->name}}
                          <ul class="list-inline">
                              <li>
                                  <subscribe-button channel-slug="{{$channel->slug}}"></subscribe-button>
                              </li>
                              <li class="list-inline-item">
                                <small>
                                {{$channel->totalVideoViews()}} video {{str_plural('view', $channel->totalVideoViews())}}
                                </small>
                              </li>
                          </ul>
                          @if($channel->description)
                            <hr>
                            <p>{{$channel->description}}</p>
                          @endif
                      </div>
                  </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">Videos</div>

                <div class="card-body bg-light">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($videos->count())
                        @foreach($videos as $video)
                            @include('video.partials._video_results', ['video'=>$video])
                        @endforeach
                        {{$videos->links()}}
                    @else
                        <p>{{$channel->name}} has no videos</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
