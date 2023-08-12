<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Nette\Utils\Image;

class NewsController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'text-input' => 'required|max:255',
            'text-input-tag' => 'required|max:15',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'textarea-input' => 'required'
        ]);

        $news = new News;
        $news->title = htmlspecialchars($validatedData['text-input']);
        $news->description = htmlspecialchars($validatedData['textarea-input']);

        $tags = explode(',', $validatedData['text-input-tag']);
        $existingTags = News::distinct()->pluck('tag')->toArray();

        foreach ($tags as $tag) {
            $tag = trim($tag);

            if (in_array($tag, $existingTags)) {
                return redirect('home')->with('error', 'Такий тег уже існує!');
            }

            $existingTags[] = $tag;
        }

        $news->tag = implode(',', $tags);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $news->image_path = $imageName;
        $news->save();

        return redirect('home')->with('success', 'Стаття успішно додана!');
    }

    public function showNews()
    {
        $news = News::all();
        $news = News::orderBy('created_at', 'desc')->get();
        return view('home', ['news' => $news]);
    }
    public function show()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(3);
        return view('welcome', ['news' => $news]);
    }
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return back(); // або return refresh();
    }
    public function edit($id)
    {
        $news = News::find($id);
        return view('edit', compact('news'));
    }
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news->title = $request->input('title');
        $news->tag  = $request->input('tag');
        $news->description = $request->input('description');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('images/' . $filename);
            Image::make($image->getRealPath())->save($path);
            $news->image_path = $filename;
        }

        $news->save();
        return redirect('/home')->with('success', 'Дія успішно виконана.');
    }

    public function shows($id)
    {
        // Знаходимо новину за ID
        $newsItem = News::findOrFail($id);

        $tags = explode(',', $newsItem->tag);

        $foundTags = News::where('id', '<>', $id)->get()->flatMap(function ($news) {
            $tags = explode(',', $news->tag);
            return collect($tags)->map(function ($tag) use ($news) {
                $tag = trim($tag);
                return ['tag' => $tag, 'news_id' => $news->id];
            });
        })->filter(function ($tag) use ($newsItem) {
            return preg_match('/\b' . preg_quote($tag['tag'], '/') . '\b/ui', $newsItem->description);
        })->toArray();

        // Заміна тегів на посилання
        foreach ($foundTags as $tag) {
            $url = route('news.show', ['id' => $tag['news_id'], 'tag' => $tag['tag']]);
            $newsItem->description = preg_replace('/\b' . preg_quote($tag['tag'], '/') . '\b/u', "<a href=\"$url\">{$tag['tag']}</a>", $newsItem->description);
        }

        $previousNewsItemId = News::where('id', '<', $id)->max('id');
        $nextNewsItemId = News::where('id', '>', $id)->min('id');
        $previousNewsItem = ($previousNewsItemId) ? News::findOrFail($previousNewsItemId) : null;
        $nextNewsItem = ($nextNewsItemId) ? News::findOrFail($nextNewsItemId) : null;

        return view('show', compact('newsItem', 'previousNewsItem', 'nextNewsItem'));
    }
}
