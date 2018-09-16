<?php

namespace App\Console\Commands;

use App\Services\DataUpdater;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GoodsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'goods:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Скачать товары';

    private $dataUpdater;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DataUpdater $dataUpdater)
    {
        parent::__construct();

        $this->dataUpdater = $dataUpdater;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->dataUpdater->update();
        } catch (\Throwable $e) {
            Log::emergency("Failed update goods data: {$e->getMessage()}");
        }
    }
}
