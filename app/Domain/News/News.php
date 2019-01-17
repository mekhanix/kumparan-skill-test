<?php

namespace App\Domain\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domain\Topic\Topic;
use App\Domain\News\Events\NewsDeleted;

class News extends Model 
{
    use SoftDeletes;
    
    protected $table = 'news';
    protected $dates = ['deleted_at'];
    protected $dispatchesEvents = [
        'deleted' => NewsDeleted::class,
    ];
    protected $hidden = ['pivot'];

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'news_topic');
    }
}