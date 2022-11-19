@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{$error}}</div>
                    @endforeach
                @endif
                @if (auth()->user()->user_type == "admin")
                <a href="#" class="btn btn-primary mb-2 create-blog-modal">Create Blog</a> 
                @endif
                <br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Text</th>
                            <th>Articles</th>
                            <th>Published At</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                        <tr>
                            <td>{{ $blog->id }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->body }}</td>
                            <td>
                                @foreach ($blog->articles as $article)
                                <a href="article/{{$article->id}}" class="btn btn-success">{{ $article->title }}</a>
                                @endforeach
                            </td>
                            <td>{{ date('Y-m-d H-m', strtotime($blog->published_at)) }}</td>
                            <td>
                            <a href="blog/{{$blog->id}}" class="btn btn-primary">Show</a>
                            @if (auth()->user()->user_type == "admin")
                            <a href="blog/{{$blog->id}}/edit" class="btn btn-primary">Edit</a>
                            <a href="#" class="btn btn-primary show-modal" data-id="{{$blog->id}}" data-title="{{$blog->title}}" data-body="{{$blog->body}}" data-published="{{$blog->published_at}}">Edit modal</a>
                            <form action="blog/{{$blog->id}}" method="post" class="d-inline">
                                {{ csrf_field() }}
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> 
        <!-- The Modal -->
        <div class="modal" id="edit-blog-modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Edit blog</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form data-action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data" id="add-project-form">
                        <!-- Modal body -->
                        <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Blog Title</label>
                            <input type="text" id="title-modal" name="title" class="form-control" value="{{$blog->title}}">
                        </div>

                        <div class="form-group">
                            <label for="">Blog Body</label>
                            <textarea name="body" id="body-modal" cols="30" rows="10" class="form-control">{{$blog->body}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Publish At</label>
                            <input type="date" id="published-modal" name="published_at" class="form-control" value="{{ date('Y-m-d', strtotime($blog->published_at)) }}">
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
        <div class="modal" id="add-blog-modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Edit article</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form data-action="blog/" method="POST" enctype="multipart/form-data" id="add-blog-form">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                            <label for="">Blog Title</label>
                                <input type="text" name="title" class="form-control" value="">
                            </div>

                            <div class="form-group">
                                <label for="">Blog Body</label>
                                <textarea name="body" id="" cols="30" rows="10" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="">Publish At</label>
                                <input type="date" name="published_at" class="form-control" value="{{ date('Y-m-d')}}">
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
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
<script type="text/javascript">

$(document).ready(function(){

    var table = '#projects-table';
    var modal_edit = '#edit-blog-modal';
    var modal_add_blog = '#add-blog-modal';
    var form = '#add-project-form';
    var form_add_blog = '#add-blog-form';
    var id = null;
    var title = null;
    var body = null;
    var published = null;

    $('.show-modal').on('click', function(event){
        id = $(this).attr('data-id');
        title = $(this).attr('data-title');
        body = $(this).attr('data-body');
        published = $(this).attr('data-published');
        $("#add-project-form").attr('data-action', '/blog/'+ id);
        var date = new Date(published);
        var day = ("0" + date.getDate()).slice(-2);
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var date_formated = date.getFullYear()+"-"+(month)+"-"+(day);

        $(this).attr('data-id', id);
        $("#edit-blog-modal #title-modal").val(title);
        $("#edit-blog-modal #body-modal").val(body);
        $("#edit-blog-modal #date-modal").val(title);
        $("#edit-blog-modal #published-modal").val(date_formated);

        $(modal_edit).modal('toggle');
    });

    $(form).on('submit', function(event){
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
            success:function(response)
            {
                $(modal_edit).modal('toggle');
                //location.reload();
            },
            error: function(response) {
                //alert(response.error);
            }
        });
    });

    $('.create-blog-modal').on('click', function(event){
       $(modal_add_blog).modal('toggle');
    });

    $(form_add_blog).on('submit', function(event){

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
            success:function(response)
            {
                $(modal_add_blog).modal('toggle');
                //location.reload();
            },
            error: function(response) {
                //alert(response.error);
               
            }
        });
    });

    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }

});
</script>