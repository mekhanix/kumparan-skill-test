<?php
namespace App\Domain\News\Repositories;
use App\Domain\News\News;
use App\Domain\News\Events\NewsDeleted;

class NewsRepository
{
    private function newsWithTopics()
    {
        return News::with(['topics:topic_id,topic_name,description']);
    }

    public function getNewsList(array $payload)
    {
        $status = !empty($payload['status']) ? $payload['status'] : null;
        $topics = null;
        if (!empty($payload['topics'])) 
        {
            $topics = explode(',', $payload['topics']);
        }

        $news = $this->newsWithTopics()
            ->withTrashed()
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($topics, function ($query, $topics) {
                return $query->whereHas('topics', function($q) use($topics) {
                    $q->whereIn('topic_id', $topics);
                });
            })
            ->orderBy('created_at', 'DESC')
            ->get();
        return $news;
    }

    public function getNewsById($id)
    {
        $news = $this->newsWithTopics()->findOrFail($id);
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
