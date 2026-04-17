<?php

namespace App\Console\Commands;

use App\Models\Location;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:delete-old-locations')]
#[Description('Command description')]
class DeleteOldLocations extends Command
{
    protected $signature = 'app:delete-old-locations';

    protected $description = 'Delete old locations with less than 2 upvotes';

    /**
     * Execute the console command.
     *
     * Delete all locations with less than 2 upvotes and created more than 14 days ago
     */
    public function handle()
    {
        $locations = Location::where('upvotes_count', '<', 2)->where('created_at', '<', now()->subDays(14))->get();
        $count = $locations->count();
        foreach ($locations as $location) {
            $location->delete();
            $this->info('Deleted '.$location->name);
        }
        $this->info('Deleted '.$count.' old locations');
    }
}
