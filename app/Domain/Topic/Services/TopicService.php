<?php
namespace App\Domain\Topic\Services;
use App\Domain\Topic\Repositories\TopicRepository;

class TopicService
{
    private $repository;

    public function __construct(TopicRepository $repository) 
    {
        $this->repository = $repository;
    }

    public function getTopics()
    {
        return $this->repository->getAllTopics();
    }

    public function getOneTopic($id)
    {
        return $this->repository->getTopicById($id);
    }

    public function updateTopic($request, $id)
    {
        $payload = $request->all();
        $result = $this->repository->updateTopicById($payload, $id);
        return $result;
    }

    public function insertOneTopic($request)
    {
        $payload = $request->all();
        $result = $this->repository->insertOneTopic($payload);
        return $result;
    }

    public function removeOneTopic($id)
    {
        $deleted = $this->repository->removeOneTopic($id);
        if ($deleted)
        {
            return [
                'id' => $deleted->id,
                'topic_name' => $deleted->topic_name,
                'deleted_at' => $deleted->deleted_at,
            ];
        }
        return $deleted;
    }
}
