@extends('layouts.app')

@section('content')

    <div class="container">

        <h3>Tags</h3>

        <a href="{{ route('admin.tags.create') }}" class="btn btn-default">Create Tag</a>

        <br><br>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td>{{ $tag->name }}</td>
                    <td>
                        <a href="{{ route('admin.tags.edit', ['id' => $tag->id]) }}"
                           class="btn btn-default">Edit</a>

                        <a href="{{ route('admin.tags.delete', ['id' => $tag->id]) }}"
                           class="btn btn-default">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@stop