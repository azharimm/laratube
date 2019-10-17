@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Channel Setting</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/channel/'.$channel->slug.'/edit') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : $channel->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="slug" class="col-md-4 col-form-label text-md-right">{{ __('Slug') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">{{config('app.url')}}/channel/</span>
                                    </div>
                                    <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') ? old('slug') : $channel->slug }}" required autocomplete="slug" autofocus>
                                </div>

                                @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="description" autocomplete="description" autofocus>{!! old('description') ? old('name') : $channel->description !!}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Channel Image') }}</label>

                            <div class="col-md-6">
                                <input type="file" name="image" id="image">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10 col-form-label text-md-right">
                                <button class="btn btn-default" type="submit">Update</button>
                            </div>
                        </div>


                        {{method_field('PUT')}}

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
