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

    public function getNewsList()
    {
        return $this->repository->getNewsList();
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
