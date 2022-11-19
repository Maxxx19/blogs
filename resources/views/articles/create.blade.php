@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Article') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form action="/article" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="">Article Title</label>
                            <input type="text" name="title" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Article Body</label>
                            <textarea name="body" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="published_at">Publish At</label>
                            <input type="date" name="published_at" class="form-control">
                        </div>
                        <div>
                            <label for="blog_id">Select Blog</label>
                            </br>
                            <select class="mb-3" name="blog_id">
                                @foreach ($blogs as $blog)
                                <option value="{{$blog->id}}">{{ $blog->title }} </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection