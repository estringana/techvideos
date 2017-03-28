<?php

namespace Tests\Feature;

use App\Label;
use App\Video;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetLabelsOfAGivenVideoTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_the_assigned_labels_to_that_video()
    {
        /** @var Video $video */
        $video = factory(Video::class)->create([]);
        /** @var Collection $labels */
        $labels = factory(Label::class, 2)->create([]);
        $labels->each(function ($label) use ($video) {
            $video->addLabel($label);
        });

        $this->get('/videos/' . $video->id . '/labels')
            ->assertStatus(200)
            ->assertJson($labels->toArray());
    }

    public function it_returns_empty_if_video_has_no_labels()
    {
        /** @var Video $video */
        $video = factory(Video::class)->create([]);
        $this->get('/videos/' . $video->id . '/labels')
            ->assertStatus(200)
            ->assertJson([]);
    }

    public function it_returns_404_if_video_does_not_exists()
    {
        $nonExistingVideoId = 12345;
        $this->get('/videos/' . $nonExistingVideoId . '/labels')
            ->assertStatus(404);
    }
}
