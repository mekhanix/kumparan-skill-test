<?php

namespace App\Domain\Topic\Controllers;
use App\Http\Controllers\Controller;
use App\Domain\Topic\Services\TopicService;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function __construct(TopicService $service) 
    {
        $this->service = $service;
    }

    public function list()
    {
        $topics = $this->service->getTopics();
        return response()->json($topics);
    }

    public function show($id)
    {
        $topic = $this->service->getOneTopic($id);
        return response()->json($topic);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'topic_name' => 'required|min:5|max:255',
            'description' => 'required|min:5|max:255'
        ]);
        
        $topic = $this->service->insertOneTopic($request);
        return response()->json($topic, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'topic_name' => 'min:5|max:255',
            'description' => 'min:5|max:255'
        ]);
        
        $topic = $this->service->updateTopic($request, $id);
        return response()->json($topic);
    }

    public function remove($id)
    {
        $deleted = $this->service->removeOneTopic($id);
        return response()->json($deleted, 202);
    }

}
