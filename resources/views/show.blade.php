@extends('layouts/app')

@section('content')

<div class="container">
<h1>{{ $newsItem->title }}</h1>
<img src="{{ asset('images/' . $newsItem->image_path) }}" alt="{{ $newsItem->title }}">
<p>{!! $newsItem->description !!}</p>


<p>Час створення новини: {{ $newsItem->created_at->format('d.m.Y H:i') }}</p>

<a href="/public/" class="btn btn-primary">Назад</a>
<br>
<br>
<div class="container">@if ($previousNewsItem)
    <a href="{{ route('news.show', ['id' => $previousNewsItem->id]) }}" class="btn btn-primary">Попередня новина</a> 
@endif
@if ($nextNewsItem)
    <a href="{{ route('news.show', ['id' => $nextNewsItem->id]) }}" class="btn btn-primary">Наступна новина</a> 
@endif
</div>

</div>
@endsection