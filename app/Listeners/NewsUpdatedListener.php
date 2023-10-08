<?php

namespace App\Listeners;

use App\Models\LogsNews;
use App\Events\NewsUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsUpdatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewsUpdated $event): void
    {
        $news = $event->news;

        // Create a log entry
        LogsNews::create([
            'user_id' => $news->user_id,
            'news_id' => $news->id,
            'action' => 'updated',
            'details' => 'News item updated: ' . $news->title,
        ]);
    }
}
