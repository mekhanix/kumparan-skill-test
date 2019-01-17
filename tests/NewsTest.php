<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Domain\Topic\Topic;
use App\Domain\News\News;

class NewsTest extends TestCase
{
    public function testDatabase()
    {
        $topics = factory(Topic::class, 10)->create();
        $news = factory(News::class, 20)->create();
        foreach(News::all() as $news)
        {
            foreach(Topic::all() as $topic)
            {
                $news->topics()->attach($topic->id);
            }
            $news->save();
        }
        //supress warning
        $this->assertEquals(true, true);
    }

    public function testGetNews()
    {
        $this->get('v1/news')->seeJson();
    }

    public function testGetNewsByStatus()
    {
        $this->get('v1/news?status=deleted')
        ->seeJson([
            'status' => 'deleted',
        ]);
    }

    public function testGetAllNewsByTopics()
    {
        $this->get('v1/news?topics=3,2')
        ->seeJson(['topic_id' => 2])
        ->seeJson(['topic_id' => 3]);
    }

    public function testGetNewsByFiltered()
    {
        $this->get('v1/news?status=draft&topics=4')
        ->seeJson(['status' => 'draft'])
        ->seeJson(['topic_id' => 3]);
    }

    public function testGetNewsById()
    {
        $response = $this->call('GET', 'v1/news/1');
        $this->assertEquals(200, $response->status());
    }

    public function testNotFound()
    {
        $response = $this->get('v1/news/abcd')->response->getData();
        $this->assertEquals(404, $response->statusCode);
    }

    public function testCreateNews()
    {
        $response = $this->call('POST', 'v1/news', 
            [
                'title' => 'Testing',
                'header' => 'Tested Test',
                'content' => $this->generateRandomString(1024),
                'status' => 'publish',
                'topics' => [1,2,3]
            ]);
        $this->seeJson(['title' => 'Testing']);
    }

    public function testCreateNewsValidation()
    {
        $response = $this->call('POST', 'v1/news', [
                'title' => 'Testing',
                'header' => 'Tested Test',
                'content' => $this->generateRandomString(1024),
                'status' => 'publishjhdfg',
                'topics' => []
            ]);
        $this->assertEquals(422, $response->status());
    }

    public function testDeleteNews()
    {
        $response = $this->call('DELETE', 'v1/news/1');
        $this->assertEquals(202, $response->status());
    }

    public function testUpdateNews()
    {
        $response = $this->call('PATCH', 'v1/news/5',[
            'title' => 'PHPTest',
            'header' => 'for testing purpose',
            'topics' => [2,3]
        ]);

        $this->assertEquals(200, $response->status());
        $this->seeJson(['topic_id' => 2, 'topic_id' => 3]);
        $this->seeJson(['title' => 'PHPTest']);
    }

    private function generateRandomString($length) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
