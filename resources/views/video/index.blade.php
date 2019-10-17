@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Videos</div>

                <div class="card-body">
                    @if($videos->count())
                        @foreach($videos as $video)
                            <div class="well mb-3">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <a href="{{url('/videos/'.$video->uid)}}">
                                            <img src="{{$video->getThumbnail()}}" class="img-fluid" alt="{{$video->title}}">
                                        </a>
                                    </div>
                                    <div class="col-sm-9">
                                        <a href="{{url('/videos/'.$video->uid)}}">{{$video->title}}</a>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="muted">
                                                @if(!$video->isProcessed())
                                                    Processing 
                                                    ({{$video->processedPercentage() ? $video->processedPercentage().'%' : 'Starting up' }})
                                                @else
                                                    <span>{{$video->created_at->toDateTimeString()}}</span>
                                                @endif
                                                </p>
                                                <form action="{{url('/videos/'.$video->uid)}}" method="post">
                                                    {{csrf_field()}}
                                                    {{method_field('DELETE')}}
                                                    <a href="{{url('/videos/'.$video->uid.'/edit')}}" class="btn btn-secondary btn-sm">Edit</a>
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                            <div class="col-sm-6">
                                                <p>{{ucfirst($video->visibility)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{$videos->links()}}
                    @else
                        <p>You have no videos</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
