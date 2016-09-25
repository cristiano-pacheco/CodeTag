@extends('layouts.app')

@section('content')

    <div class="container">

        <h3>Edit Tag</h3>

        {!! Form::open(['method'=>'post','route' => [ 'admin.tags.update', 'id' => $tag->id ]]) !!}

        {{--@include('codecategory::errors')--}}

        <div class="form-group">
            {!! Form::label('Name',"Name:") !!}
            {!! Form::text('name',  $tag->name, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Submit',['class'=> 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>

@stop