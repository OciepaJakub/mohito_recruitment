<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RecipeService;
use Illuminate\Support\Facades\Log;

class FetchAndSyncRecipes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-and-sync-recipes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch, update or create the recipies in a database.';

    protected string $startTime, $endTime;

    public function __construct(protected readonly RecipeService $recipeService){
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            $this->startTime = microtime(true);
            
            $this->recipeService->syncData();

            $this->endTime = microtime(true);

            $resultTime = (($this->startTime - $this->endTime) / 60);
            
            $this->info("Execution time: $resultTime");
        }catch(\Exception $e){
            Log::error($e->getMessage(), [
                'context' => 'Scheduled sync recipes data',
                'error_class' => get_class($e),
                'base_class' => debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0]['class'] ?? ''
            ]);
        }
    }
}
