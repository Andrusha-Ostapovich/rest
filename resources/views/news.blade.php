<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Новини') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                </div>
                <div class="container">


                    @foreach ($news as $item)
                    <div class="news-item">
                        <h2>{{ $item->title }}</h2>
                        <p>{{ $item->description }}</p>
                        <img src="{{ asset('images/' . $item->image_path) }}" alt="{{ $item->title }}">
                        <p>Час створення новини: {{ $item->created_at->format('d.m.Y H:i') }}</p>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                            <i class="fas fa-plus">Видалити</i>

                        </button>
                        <a href="{{ route('news.edit', $item->id) }}" class="btn btn-primary">
                            Редагувати
                        </a>
                        <br>
                    </div>
                    <div class="modal" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Новина</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <p>Ви впевнені, що хочете видалити цю новину?</p>
                                    <form action="{{ route('news.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Видалити</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Скасувати</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="fixed-bottom mb-4 mr-4 " style="left: 1150px; top: 570px;">
                    <a href="home" class="btn btn-lg btn-primary rounded-circle" data-bs-toggle="modal" data-bs-target="#myModal">
                        <i class="fas fa-plus">+</i>
                    </a>
                </div>
                <div class="modal" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Додайте новину</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="home" enctype="multipart/form-data">
                                    @csrf
                                    <label for="text-input">Введіть Назву:*</label>
                                    <input type="text" id="text-input" name="text-input">
                                    <br>
                                    <label for="text-input-tag">Введіть теги:*</label>
                                    <input type="text" id="text-input-tag" name="text-input-tag">
                                    <div class="form-group">
                                        <label for="image">Виберіть зображення для завантаження*</label>
                                        <input type="file" name="image" id="image">
                                    </div>
                                    <label for="textarea-input">Введіть текст статті:*</label>
                                    <textarea id="textarea-input" name="textarea-input" rows="4" cols="50" style="font-size: 16px; font-family: Arial;"></textarea>

                            </div>
                            <button type="submit" class="btn btn-primary">Готово</button>
                        </div>

                        </form>

                    </div>
                </div>
                @yield('news')