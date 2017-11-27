<?php

use App\Label;
use App\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class SomeExampleVideosSeeder extends Seeder
{
    protected $labels;
    protected $videos;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->labels = factory(Label::class, 10)->create([]);

        $this->videos = factory(Video::class, 20)->create([]);

        $this->assignLabelsToVideos();
    }

    /**
     * @param $video
     */
    protected function addRandomLabelsToVideo(Video $video)
    {
        $randomLabels = $this->getRandomLabels();

        foreach ($randomLabels as $label) {
            $video->addLabel($label);
        }
    }

    protected function assignLabelsToVideos()
    {
        foreach ($this->videos as $video) {
            $this->addRandomLabelsToVideo($video);
        }
    }

    /**
     * @return Collection
     */
    protected function getRandomLabels(): Collection
    {
        $availableLabels = count($this->labels);

        return $this->labels->random(rand(1, $availableLabels));
    }
}
