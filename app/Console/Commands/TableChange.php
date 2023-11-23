<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Artisan;


class TableChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:change {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->argument('table');
        DB::statement("DROP TABLE IF EXISTS $table");
        DB::table("migrations")
            ->where('migration', 'like', '%' . $table . '%')
            ->delete();
        $exitCode = Artisan::call('migrate');

        $this->info("Table $table has been dropped.");
        if ($exitCode === 0) {
            $this->info("Table $table has been generated.");
        } else {
            $this->info("Table $table has been generated stop.");
        }
    }
}
