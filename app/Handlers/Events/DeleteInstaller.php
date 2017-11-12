<?php namespace App\Handlers\Events;

use App;
use App\Events\InstallationWasCompleted;
use File;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Queue\InteractsWithQueue;

class DeleteInstaller
{

    /**
     * Create the event handler.
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
     * @param  InstallationWasCompleted $event
     * @return void
     */
    public function handle(InstallationWasCompleted $event)
    {
        // delete installation files after install
        if (App::environment() != 'local') {
            File::deleteDirectory(base_path('resources/views/install'));
            File::deleteDirectory(base_path('public/assets/shared/install'));
            File::delete(app_path('Http/controllers/InstallController.php'));
        }
    }

}
