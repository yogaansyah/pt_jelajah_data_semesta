<?php

namespace App\Listeners;

use App\Models\LogsNews;
use App\Events\NewsDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsDeletedListener
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
    public function handle(NewsDeleted $event): void
    {
        $news = $event->news;

        LogsNews::create([
            'user_id' => auth()->user()->id,
            'news_id' => $news->id,
            'action' => 'deleted',
            'details' => 'News item deleted:'. $news->title,
        ]);
    }
}
