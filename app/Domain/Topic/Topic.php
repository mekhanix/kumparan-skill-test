<?php

namespace App\Domain\Topic;

use Illuminate\Database\Eloquent\Model;
use App\Domain\News\News;
use Illuminate\Database\Eloquent\SoftDeletes;
class Topic extends Model 
{
    use SoftDeletes;

    protected $table = 'topics';
    protected $hidden = ['pivot'];
    protected $dates = ['deleted_at'];
    
    public function news()
    {
        return $this->belongsToMany(News::class, 'news_topic');
    }
}