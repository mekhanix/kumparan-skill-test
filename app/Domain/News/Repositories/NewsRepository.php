<?php
namespace App\Domain\News\Repositories;
use App\Domain\News\News;
use App\Domain\News\Events\NewsDeleted;

class NewsRepository
{
    public function getNewsList()
    {
        $news = News::with(['topics'])->orderBy('created_at', 'DESC')->get();
        return $news;
    }

    public function insertOneNews(array $payload)
    {
        $news = new News;
        $news->title = $payload['title'];
        $news->header = $payload['header'];
        $news->content = $payload['content'];
        $news->status = $payload['status'];
        $news->save();
        $news->topics()->attach($payload['topics']);
        return $news;
    }

    public function removeOneNews($id)
    {
        $news = News::findOrFail($id);
        $news->delete();        
        event(new NewsDeleted($news));
        return $news;
    }
}
