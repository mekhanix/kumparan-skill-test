<?php

namespace App\Domain\News\Listeners;

use App\Domain\News\Events\NewsDeleted;

class ChangeNewsStatus
{
    /**
     * Handle the event.
     *
     * @param  NewsDeleted  $event
     * @return void
     */
    public function handle(NewsDeleted $event)
    {
        $event->news->status = 'deleted';
        $event->news->save();
    }
}
