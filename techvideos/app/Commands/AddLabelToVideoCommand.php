<?php
namespace App\Commands;

use App\Label;
use App\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddLabelToVideoCommand
{
    protected $videoId;
    protected $labelName;

    /**
     * AddLabelToVideo constructor.
     */
    public function __construct(int $videoId, string $labelName)
    {
        $this->videoId = $videoId;
        $this->labelName = $labelName;
    }

    public function execute()
    {
        /** @var Label $label */
        $label = null;
        /** @var Video $video */
        $video = Video::findOrFail($this->videoId);
        try {
            $label = Label::where('label', $this->labelName)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            $label = new Label();
            $label->label = $this->labelName;
            $label->save();
        }
        $video->addLabel($label);
    }
}
