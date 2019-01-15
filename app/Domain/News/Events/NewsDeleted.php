<?php
namespace App\Domain\News\Events;
use App\Events\Event;
use App\Domain\News\News;

class NewsDeleted extends Event
{
    public $news;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(News $news)
    {
        $this->news = $news;
    }
}