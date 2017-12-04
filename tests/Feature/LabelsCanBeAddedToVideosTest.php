<?php

namespace Tests\Feature;

use App\Label;
use App\User;
use App\Video;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LabelsCanBeAddedToVideosTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function existing_label_can_be_added_to_an_existing_video_when_authenticated()
    {
        /** @var Label $label */
        $label = factory(Label::class)->create([]);
        /** @var Video $video */
        $video = factory(Video::class)->create([]);

        Passport::actingAs(factory(User::class)->create(), []);

        $this->post(
            sprintf('/api/videos/%s/labels', $video->id),
            ['name' => $label->name]
        )->assertStatus(201);

        $this->assertCount(1, $video->labels);
    }

    /** @test */
    public function new_label_can_be_added_to_an_existing_video_when_authenticated()
    {
        /** @var Video $video */
        $video = factory(Video::class)->create([]);

        Passport::actingAs(factory(User::class)->create(), []);

        $this->post(
            sprintf('/api/videos/%s/labels', $video->id),
            ['name' => 'NonExistingLabelYet']
        )->assertStatus(201);

        $this->assertCount(1, $video->labels);
    }
    
    /** @test */
    public function it_is_not_possible_to_add_labels_to_videos_if_not_authenticated()
    {
        /** @var Label $label */
        $label = factory(Label::class)->create([]);
        /** @var Video $video */
        $video = factory(Video::class)->create([]);

        $this->post(
            sprintf('/api/videos/%s/labels', $video->id),
            ['name' => $label->name]
        )->assertStatus(302);

        $this->assertCount(0, $video->labels);
    }
}
