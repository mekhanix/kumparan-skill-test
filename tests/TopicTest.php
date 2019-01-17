<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TopicTest extends TestCase
{
    public function testGetAllTopics()
    {
        $this->get('v1/topics')->seeJson();
    }

    public function testGetTopicById()
    {
        $response = $this->call('GET', 'v1/topics/1');
        $this->assertEquals(200, $response->status());
    }

    public function testCreateTopic()
    {
        $response = $this->call('POST', 'v1/topics', 
        [
            'topic_name' => 'Gadget',
            'description' => 'Semua yang berhubungan dengan gadget.',
        ]);
        $this->seeJson(['topic_name' => 'Gadget']);
    }

    public function testCreateTopicValidation()
    {
        $response = $this->call('POST', 'v1/topics', 
        [
            'topic_name' => 'Gadget',
            'description' => $this->generateRandomString(256),
        ]);

        $this->assertEquals(422, $response->status());
    }
    
    public function testUpdateTopic()
    {
        $response = $this->call('PATCH', 'v1/topics/2',[
            'topic_name' => 'Hobbies',
        ]);

        $this->assertEquals(200, $response->status());
        $this->seeJson(['topic_name' => 'Hobbies']);
    }

    public function testDeleteTopic()
    {
        $response = $this->call('DELETE', 'v1/topics/2');
        $this->assertEquals(202, $response->status());
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
