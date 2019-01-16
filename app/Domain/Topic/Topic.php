<?php

namespace App\Domain\Topic;

use Illuminate\Database\Eloquent\Model;
use App\Domain\News\News;

class Topic extends Model 
{
    protected $table = 'topics';
    protected $hidden = ['pivot'];
    public function news()
    {
        return $this->belongsToMany(News::class, 'news_topic');
    }
}