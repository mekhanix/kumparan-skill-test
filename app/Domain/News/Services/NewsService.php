<?php
namespace App\Domain\News\Services;
use App\Domain\News\Repositories\NewsRepository;

class NewsService
{
    private $repository;

    public function __construct(NewsRepository $repository) 
    {
        $this->repository = $repository;
    }

    public function getNewsList($request)
    {
        $payload = $request->all();
        return $this->repository->getNewsList($payload);
    }
    
    public function getOneNews($id)
    {
        return $this->repository->getNewsById($id);
    }

    public function updateNews($request, $id)
    {
        $payload = $request->all();
        return $this->repository->updateNewsById($payload, $id);
    }

    public function insertOneNews($request)
    {
        $payload = $request->all();
        $result = $this->repository->insertOneNews($payload);
        return $result;
    }

    public function removeOneNews($id)
    {
        $deleted = $this->repository->removeOneNews($id);
        if ($deleted)
        {
            return [
                'id' => $deleted->id,
                'status' => $deleted->status,
            ];
        }
        return $deleted;
    }
}
