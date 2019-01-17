<?php

namespace App\Domain\News\Controllers;
use App\Http\Controllers\Controller;
use App\Domain\News\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(NewsService $service) 
    {
        $this->service = $service;
    }

    public function list(Request $request)
    {
        $news = $this->service->getNewsList($request);
        return response()->json($news);
    }

    public function show($id)
    {
        $news = $this->service->getOneNews($id);
        return response()->json($news);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'in:draft,deleted,publish',
            'topics' => 'array|min:1',
            'topics.*' => 'int'
        ]);
        
        $news = $this->service->updateNews($request, $id);
        return response()->json($news);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5|max:255',
            'header' => 'required|min:5|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,deleted,publish',
            'topics' => 'required|array|min:1',
            'topics.*' => 'int'
        ]);

        $news = $this->service->insertOneNews($request);
        return response()->json($news, 201);
    }

    public function remove($id)
    {
        $deleted = $this->service->removeOneNews($id);
        return response()->json($deleted, 202);
    }
}
