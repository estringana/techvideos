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

    /** @test **/
    public function existing_labels_can_be_added_to_a_video()
    {
        /** @var Label $label */
        $label = factory(Label::class)->create();
        /** @var Video $video */
        $video = factory(Video::class)->create();

        $video->addLabel($label);

        $this->assertCount(1, $video->labels);
    }
}
