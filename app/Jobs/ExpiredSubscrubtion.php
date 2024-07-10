<?php

namespace App\Jobs;

use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpiredSubscrubtion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $stores = Store::with('subscrubtion')->get();


        foreach ($stores as $store) {



            if (Carbon::now() > $store->subscrubtion->ends_at) {


                echo $store->update([

                    'active' => 0
                ]);
            }
        }
    }
}
