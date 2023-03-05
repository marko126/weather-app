<?php

namespace App\Console\Commands;

use App\Http\Resources\ForecastResource;
use App\Models\Forecast;
use App\Models\User;
use App\Services\ForecastInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

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
                $forecast = $user->forecast;

                if (!$forecast) {
                    $forecast = new Forecast(['user_id' => $user->id]);
                }

                $forecast->data = json_encode($forecastService->todayWeather($user));

                Cache::put("forecast_user_{$user->id}", new ForecastResource($forecast->load('user')));
            }
        });

        $progress->finish();
        echo "\n";

        $this->info('END: Sync forecast');
    }
}
