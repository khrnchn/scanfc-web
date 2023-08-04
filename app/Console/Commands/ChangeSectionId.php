<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ChangeSectionId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:sectionId';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the section_id of all rows in the classrooms table to 1.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sectionId = 3;
        
        DB::table('classrooms')->update(['section_id' => $sectionId]);

        $this->info('All section_id values in the classrooms table have been changed to ' . $sectionId);
    }
}
