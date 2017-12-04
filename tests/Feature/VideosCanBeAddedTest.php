<?php

namespace Tests\Feature;

use App\User;
use App\Video;
use Faker\Factory;
use Laravel\Passport\Passport;
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
                    'speaker' => 'John Doe',
                    'link' => 'http://random.link',
                    201,
                    1,
                ],
            'Name is empty' =>
                [
                    'name' => '',
                    'description' => 'Some description',
                    'speaker' => 'John Doe',
                    'link' => 'http://random.link',
                    302,
                    0,
                ],
            'Description is empty' =>
                [
                    'name' => 'Some name',
                    'description' => '',
                    'speaker' => 'John Doe',
                    'link' => 'http://random.link',
                    302,
                    0,
                ],
            'Link is empty' =>
                [
                    'name' => 'Some name',
                    'description' => 'Some description',
                    'speaker' => 'John Doe',
                    'link' => '',
                    302,
                    0,
                ],
            'Link must be a valid URL' =>
                [
                    'name' => 'Some name',
                    'description' => 'Some descriptions',
                    'speaker' => 'John Doe',
                    'link' => 'Invalid URL here',
                    302,
                    0,
                ],
        ];
    }

    /**
     * @test
     * @dataProvider postProvider
     */
    public function videos_can_be_added_when_authenticated($name, $description, $speaker, $link, $expectedStatus, $videosCreated)
    {
        Passport::actingAs(factory(User::class)->create(), []);

        $this->post('/api/videos',
            [
                'name' => $name,
                'description' => $description,
                'speaker' => $speaker,
                'link' => $link,
            ]
        )->assertStatus($expectedStatus);

        $this->assertCount($videosCreated, Video::all());
    }
    
    /** @test */
    public function it_is_not_possible_to_add_videos_if_not_authenticated()
    {
        $this->post('/api/videos', [
            'name' => 'It does not matter',
            'description' => 'It does not matter',
            'speaker' => 'It does not matter',
            'link' => 'http://itdoesnot.matter',
        ])->assertStatus(302);

        $this->assertCount(0, Video::all());
    }
}
