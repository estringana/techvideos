<?php

namespace Tests\Unit\Commands;

use App\Commands\AddLabelToVideoCommand;
use App\Label;
use App\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddLabelToVideoCommandTest extends TestCase
{
    use DatabaseMigrations;

    /** @test * */
    public function it_adds_an_existing_label_to_an_existing_video()
    {
        /** @var Label $label */
        $label = factory(Label::class)->create();
        /** @var Video $video */
        $video = factory(Video::class)->create();

        $command = new AddLabelToVideoCommand($video->id, $label->label);
        $command->execute();

        $this->assertCount(1, $video->labels);
    }

    /** @test */
    public function it_adds_an_non_existing_label_to_an_existing_video_an_create_label()
    {
        $labelToCreate = 'LabelNonExistingYet';

        /** @var Video $video */
        $video = factory(Video::class)->create();

        $command = new AddLabelToVideoCommand($video->id, $labelToCreate);
        $command->execute();

        $this->assertCount(1, $video->labels);
        $this->assertCount(1, Label::where('label', $labelToCreate)->get());
    }

    /** @test */
    public function it_throws_exception_if_video_does_not_existis()
    {
        $nonExistingVideo = 12345;
        $command = new AddLabelToVideoCommand($nonExistingVideo, 'SomethingHere');

        $this->expectException(ModelNotFoundException::class);

        $command->execute();
    }
}
