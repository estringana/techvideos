<?php

namespace Tests\Feature;

use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideosCanBeAddedTest extends TestCase
{
    use DatabaseMigrations;

    public function postProvider()
    {
        return [
            'All inputs are properly provided' =>
                [
                    'name' => 'Some name',
                    'description' => 'Some description',
                    'author' => 'John Doe',
                    'link' => 'http://random.link',
                    201,
                    1
                ],
            'Name is empty' =>
                [
                    'name' => '',
                    'description' => 'Some description',
                    'author' => 'John Doe',
                    'link' => 'http://random.link',
                    302,
                    0
                ],
            'Description is empty' =>
                [
                    'name' => 'Some name',
                    'description' => '',
                    'author' => 'John Doe',
                    'link' => 'http://random.link',
                    302,
                    0
                ],
            'Link is empty' =>
                [
                    'name' => 'Some name',
                    'description' => 'Some description',
                    'author' => 'John Doe',
                    'link' => '',
                    302,
                    0
                ],
            'Link must be a valid URL' =>
                [
                    'name' => 'Some name',
                    'description' => 'Some descriptions',
                    'author' => 'John Doe',
                    'link' => 'Invalid URL here',
                    302,
                    0
                ],
        ];
    }

    /**
     * @test
     * @dataProvider postProvider
     **/
    public function videos_can_be_added($name, $description, $author, $link, $expectedStatus, $videosCreated)
    {
        $this->post('/videos',
            [
                'name' => $name,
                'description' => $description,
                'author' => $author,
                'link' => $link,
            ]
        )->assertStatus($expectedStatus);

        $this->assertCount($videosCreated, Video::all());
    }
}
