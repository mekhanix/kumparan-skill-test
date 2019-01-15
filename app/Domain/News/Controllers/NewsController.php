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

    public function list()
    {
        $list = $this->service->getNewsList();
        return response()->json($list);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5|max:255',
            'header' => 'required|min:5|max:255',
            'content' => 'required',
            'status' => 'required|in:draft, deleted, publish',
            'topics' => 'required|array',
        ]);

        $news = $this->service->insertOneNews($request);
        return response()->json($news);
    }

    public function remove($id)
    {
        $deleted = $this->service->removeOneNews($id);
        return response()->json($deleted, 202);
    }
}
