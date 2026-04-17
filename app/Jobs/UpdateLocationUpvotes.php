<?php

namespace App\Jobs;

use App\Models\Location;
use App\Models\Upvote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateLocationUpvotes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Location $location) {}

    public function handle(): void
    {
        $count = Upvote::where('location_id', $this->location->id)->count();
        $this->location->update(['upvotes_count' => $count]);
    }
}
