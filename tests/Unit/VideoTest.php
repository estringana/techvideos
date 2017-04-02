<?php

namespace Tests\Unit;

use App\Label;
use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function existing_labels_can_be_added_to_a_video()
    {
        /** @var Label $label */
        $label = factory(Label::class)->create();
        /** @var Video $video */
        $video = factory(Video::class)->create();

        $video->addLabel($label);

        $this->assertCount(1, $video->labels);
    }

    /** @test */
    public function videos_are_returneded_by_created_last_first()
    {
        $video01 = factory(Video::class)->create([
            'created_at' => '2017-01-01',
        ]);
        $video02 = factory(Video::class)->create([
            'created_at' => '2017-01-02',
        ]);
        $video03 = factory(Video::class)->create([
            'created_at' => '2017-01-03',
        ]);

        $videos = Video::latest();

        $this->assertCount(3, $videos);
        $this->assertEquals($video03->id, $videos->get(0)->id);
        $this->assertEquals($video02->id, $videos->get(1)->id);
        $this->assertEquals($video01->id, $videos->get(2)->id);
    }
}
