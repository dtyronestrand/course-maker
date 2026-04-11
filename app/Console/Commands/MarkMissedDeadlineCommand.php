<?php

namespace App\Console\Commands;

use App\Models\CourseDeliverable;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkMissedDeadlineCommand extends Command
{
    protected $signature = 'courses:mark-missed-deadlines';

    protected $description = 'Checks for active courses whose deadline has passed and marks them as missed.';

    public function handle()
    {
        $count = CourseDeliverable::where('is_done', false)
            ->where('due_date', '<', now())
            ->where('missed_due_date_count', 0)
            ->update(['missed_due_date_count' => 1]);

        if ($count > 0) {
            $this->info("Marked {$count} deliverables as missed.");
        } else {
            $this->info('No deliverables to mark.');
        }

        return Command::SUCCESS;
    }
}