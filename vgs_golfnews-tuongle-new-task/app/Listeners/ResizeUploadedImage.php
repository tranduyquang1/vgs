<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Intervention\Image\ImageManagerStatic as Image;
use UniSharp\LaravelFilemanager\Events\ImageWasUploaded;

class ResizeUploadedImage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ImageWasUploaded $event)
    {
        $path = $event->path();
        $image = Image::make($path);
        if($image->width() <= 720) {
            return;
        }
        // resize the image to a width of 1100 and constrain aspect ratio (auto height)
        $image->resize(720, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path);
    }
}
