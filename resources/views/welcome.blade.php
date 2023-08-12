@extends('layouts/app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Новини') }}</div>
                <div class="card-body">
                </div>
                <div class="container">
                    @foreach ($news as $item)
                    <div class="news-item">
                        
                        <a href="{{ route('news.show', ['id' => $item->id]) }}">{{ $item->title }}</a>
                        <br>
                        <img src="{{ asset('images/' . $item->image_path) }}" alt="{{ $item->title }}">

                        <p>Час створення новини: {{ $item->created_at->format('d.m.Y H:i') }}</p>
                        
                    </div>
                    @endforeach
                </div>

                {{ $news->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
</div>
@endsection

