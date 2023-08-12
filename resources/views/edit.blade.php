@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('news.update', $news->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Заголовок:</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $news->title }}">
            </div>
            <div class="form-group">
                <label for="tag">Теги:</label>
                <input type="text" name="tag" id="tag" class="form-control" value="{{ $news->tag }}">
            </div>
            <div class="form-group">
                <label for="description">Опис:</label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ $news->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Зображення:</label>
                <input type="file" name="image" id="image" class="form-control-file">
            </div>
            
            <button type="submit" class="btn btn-primary">Зберегти</button>
        </form>
    </div>
@endsection
