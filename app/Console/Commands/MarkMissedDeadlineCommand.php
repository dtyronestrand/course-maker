<?php

namespace App\Console\Commands;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkMissedDeadlineCommand extends Command
{
    protected $signature = 'courses:mark-missed-deadline';

    protected $description ='Checks for active courses that have missed their deadline and sets their status accordingly';

    public function handle()
    {
        $now = Carbon::now();
      
        $coursesToActivate = Course::where('status', 'pending')
            ->whereHas('developmentCycle', function($query){
                $query->where('start_date', '<=', now());
            })
            ->get();

            $count = $coursesToActivate->count();
            if ($count >0){
                $this->info("Activating {$count} courses...");
                Course::whereIn('id', $coursesToActivate->pluck('id'))->update(['status' => 'design']);
                $this->info("Activated {$count} courses.");
            }else{
                $this->info("No courses to activate.");
            }
            return Command::SUCCESS;
    }
}