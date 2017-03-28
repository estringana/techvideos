<?php

namespace Tests\Feature;

use App\Label;
use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LabelsCanBeAddedToVideosTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function existing_label_can_be_added_to_an_existing_video()
    {
        $this->disableExceptionHandling();
        /** @var Label $label */
        $label = factory(Label::class)->create([]);
        /** @var Video $video */
        $video = factory(Video::class)->create([]);

        $this->post(
            sprintf('/videos/%s/labels', $video->id),
            ['name' => $label->name]
        )->assertStatus(201);

        $this->assertCount(1, $video->labels);
    }

    /** @test */
    public function new_label_can_be_added_to_an_existing_video()
    {
        /** @var Video $video */
        $video = factory(Video::class)->create([]);

        $this->post(
            sprintf('/videos/%s/labels', $video->id),
            ['name' => 'NonExistingLabelYet']
        )->assertStatus(201);

        $this->assertCount(1, $video->labels);
    }
}
