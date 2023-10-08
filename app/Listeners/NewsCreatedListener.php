<?php

namespace App\Listeners;

use App\Models\LogsNews;
use App\Events\NewsCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsCreatedListener
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
    public function handle(NewsCreated $event): void
    {
        $news = $event->news;

        LogsNews::create([
            'user_id' => auth()->user()->id,
            'news_id' => $news->id,
            'action' => 'created',
            'details' => 'News item created: ' . $news->title,
        ]);
    }
}
