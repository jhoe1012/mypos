<?php

namespace App\Console\Commands;

use App\Services\ReportService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Carbon;

class Endofday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "endofday {inv_date}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform End of day for inventory';
    public function __construct(protected ReportService $reportService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $inv_date =  $this->argument('inv_date');

        if (isset($inv_date)) {
            // $this->info($inv_date);
            $this->reportService->endOfDay($inv_date);
            echo "\n";
            $this->info("Done...");
            return Command::SUCCESS;
        }
       
        return Command::FAILURE;
    }
}
