<?php

namespace Tests\Feature;

use App\Label;
use App\Video;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GettingVideosAssociatedToALabelTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_the_videos_associated_with_the_given_label()
    {
        /** @var Collection $videos */
        $videos = factory(Video::class, 2)->create([]);
        /** @var Label $label */
        $label = factory(Label::class)->create();
        $videos->each(function ($video) use ($label) {
            $video->addLabel($label);
        });

        $this->get('/labels/' . $label->name . '/videos')
            ->assertStatus(200)
            ->assertJson($videos->toArray());
    }

    /** @test */
    public function it_returns_empty_array_if_no_videos_associated()
    {
        /** @var Label $label */
        $label = factory(Label::class)->create();

        $this->get('/labels/' . $label->name . '/videos')
            ->assertStatus(200)
            ->assertJson([]);
    }

    /** @test */
    public function it_should_throw_exception_if_label_do_not_exists()
    {
        $investedLabelName = 'Something here';
        $this->get('/labels/' . $investedLabelName . '/videos')
            ->assertStatus(404);
    }
}
