<?php

namespace App\Console\Commands;

use App\Events\CreateCurrentForecastEvent;
use App\Models\User;
use App\Services\ForecastInterface;
use Illuminate\Console\Command;

class SyncForecastCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ForecastInterface $forecastService): void
    {
        $this->info('START: Sync forecast');

        $progress = $this->output->createProgressBar(User::count());

        User::query()->chunkById(100, function ($users) use ($forecastService, $progress) {
            /** @var User $user */
            foreach ($users as $user) {
                $progress->advance();
                event(new CreateCurrentForecastEvent($user));
            }
        });

        $progress->finish();
        echo "\n";

        $this->info('END: Sync forecast');
    }
}
