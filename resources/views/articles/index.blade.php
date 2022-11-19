@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
                <a href="blog/create" class="btn btn-primary mb-2">Create Article</a> 
                <br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Text</th>
                            <th>Published At</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->body }}</td>
                            <td>{{ date('Y-m-d H-m', strtotime($article->published_at)) }}</td>
                            <td>
                            <a href="article/{{$article->id}}" class="btn btn-primary">Show</a>
                            @if (auth()->user()->user_type == "admin")
                            <a href="article/{{$article->id}}/edit" class="btn btn-primary">Edit</a>
                            <form action="article/{{$article->id}}" method="post" class="d-inline">
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
    </div>
</div>
@endsection