@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('View Article') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (auth()->user()->user_type == "admin")
                    <a href="#" class="btn btn-primary mt-0 show-add-modal">Create Article</a>
                    <a href="{{ url('/blog/restoreArticles') }}" class="btn btn-primary mt-0">Restore deleted Articles</a>
                    <a href="#" class="btn btn-primary mt-0 show-edit-modal">Edit Article</a>
                    <form href="{{ url('/article/'.$article->id) }}" method="post" class="d-inline">
                        {{ csrf_field() }}
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                    @endif
                    <h2>{{$article->title}}</h2>

                    <p>Published At: {{date('Y-m-d', strtotime($article->published_at))}}</p>
                    <br>
                    <div>
                        {{$article->body}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="edit-article-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit article</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form data-action="/article/{{$article->id}}" method="POST" enctype="multipart/form-data" id="edit-modal-form">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Article Title</label>
                            <input type="text" name="title" class="form-control" value="{{$article->title}}">
                        </div>

                        <div class="form-group">
                            <label for="">Article Body</label>
                            <textarea name="body" id="" cols="30" rows="10" class="form-control">{{$article->body}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Publish At</label>
                            <input type="date" name="published_at" class="form-control" value="{{ date('Y-m-d', strtotime($article->published_at)) }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="add-article-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit article</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form data-action="/article" method="POST" enctype="multipart/form-data" id="add-modal-form">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="">Article Title</label>
                            <input type="text" name="title" class="form-control" value="">
                        </div>

                        <div class="form-group">
                            <label for="">Article Body</label>
                            <textarea name="body" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Publish At</label>
                            <input type="date" name="published_at" class="form-control" value="{{ date('Y-m-d')}}">
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
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = '#projects-table';
        var modal_edit = '#edit-article-modal';
        var form_edit = '#edit-modal-form';
        var modal_add = '#add-article-modal';
        var form_add = '#add-modal-form';

        $('.show-edit-modal').on('click', function(event) {
            $(modal_edit).modal('toggle');
        });

        $(form_edit).on('submit', function(event) {

            event.preventDefault();
            var url = $(this).attr('data-action');

            $.ajax({
                url: url,
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $(modal_edit).modal('toggle');
                    location.reload();
                },
                error: function(response) {
                    //console.log('error');
                    $(modal_edit).modal('toggle');
                    location.reload();
                }
            });
        });

        $('.show-add-modal').on('click', function(event) {
            $(modal_add).modal('toggle');
        });
        $(form_add).on('submit', function(event) {

            event.preventDefault();
            var url = $(this).attr('data-action');

            $.ajax({
                url: url,
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $(modal_add).modal('toggle');
                    location.reload();
                },
                error: function(response) {
                    //console.log('error');
                    $(modal_add).modal('toggle');

                }
            });
        });

    });
</script>