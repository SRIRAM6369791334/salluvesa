<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\CurrencyService;

class UpdateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update-rates {base=INR}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and update current exchange rates from API';

    /**
     * Execute the console command.
     */
    public function handle(CurrencyService $currencyService): int
    {
        $base = $this->argument('base');
        $this->info("Updating exchange rates for base: {$base}...");

        try {
            $currencyService->updateRates($base);
            $this->info('Exchange rates updated successfully.');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to update exchange rates: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
