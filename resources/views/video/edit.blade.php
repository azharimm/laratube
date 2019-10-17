@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Video "{{$video->title}}"</div>

                <div class="card-body">
                    <form action="{{url('/videos/'.$video->uid)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('PUT')}}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ? old('title') : $video->title }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="description">{{ old('title') ? old('title') : $video->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="visibility" class="col-md-4 col-form-label text-md-right">{{ __('Visibility') }}</label>

                            <div class="col-md-6">
                                <select name="visibility" id="visibility" class="form-control">
                                    @foreach(['public','private','unlisted'] as $visibility)
                                        <option value="{{$visibility}}" {{$video->visibility === $visibility ? 'selected="selected' : ''}}>{{ucfirst($visibility)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="allow_votes" class="col-md-4 col-form-label text-md-right">{{ __('Allow Vote') }}</label>

                            <div class="col-md-6">
                                <input type="checkbox" name="allow_votes" id="allow_votes" {{$video->votesAllowed() ? 'checked="checked"' : ''}}> Allow Votes
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="allow_comments" class="col-md-4 col-form-label text-md-right">{{ __('Allow Comments') }}</label>

                            <div class="col-md-6">
                                <input type="checkbox" name="allow_comments" id="allow_comments" {{$video->commentsAllowed() ? 'checked="checked"' : ''}}> Allow Comments
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-6 offset-md-4">
                                <button class="btn btn-primary"> Update</button>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
