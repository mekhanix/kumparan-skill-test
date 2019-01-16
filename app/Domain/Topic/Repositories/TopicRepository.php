<?php
namespace App\Domain\Topic\Repositories;
use App\Domain\Topic\Topic;

class TopicRepository
{
    public function getAllTopics()
    {
        $topics = Topic::orderBy('created_at', 'DESC')->get();
        return $topics;
    }

    public function getTopicById($id)
    {
        $topic = Topic::findOrFail($id);
        return $topic;
    }

    public function insertOneTopic($payload)
    {
        $topic = new Topic;
        $topic->topic_name = $payload['topic_name'];
        $topic->description = $payload['description'];
        $topic->save();
        return $topic;
    }

    public function removeOneTopic($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();        
        // event(new NewsDeleted($news));
        return $topic;
    }

}
