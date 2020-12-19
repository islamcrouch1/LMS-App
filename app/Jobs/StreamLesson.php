<?php

namespace App\Jobs;

use Carbon\Carbon;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Lesson;



class StreamLesson implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $lesson ;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

            $lowBitrate = (new X264('aac'))->setKiloBitrate(100);
            $midBitrate = (new X264('aac'))->setKiloBitrate(250);
            $highBitrate = (new X264('aac'))->setKiloBitrate(500);

            FFMpeg::fromDisk('public')
                ->open($this->lesson->path)
                ->exportForHLS()
                ->onProgress(function ($percent) {
                    $this->lesson->update([
                        'percent' => $percent
                    ]);
                })
                ->setSegmentLength(10)// optional
                ->addFormat($lowBitrate)
                ->addFormat($midBitrate)
                ->addFormat($highBitrate)
                ->save("lessons/videos/{$this->lesson->id}/{$this->lesson->id}.m3u8");
    }
}
