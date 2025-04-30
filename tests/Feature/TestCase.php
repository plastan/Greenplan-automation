<?php

namespace Tests\Feature\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class GenerateReportScheduleTest extends  TestCase
{
    public function test_report_generation_runs_every_twelve_hours_for_a_week()
    {
        // Mock the current time
        $startDate = Carbon::create(2025, 4, 24, 0, 0, 0);
        Carbon::setTestNow($startDate);

        // Keep track of executions
        $executionCount = 0;

        // Get the schedule instance
        $schedule = app()->make(Schedule::class);

        // Simulate a week (7 days), advancing 12 hours at a time
        for ($i = 0; $i < 14; $i++) {
            // Check if the command should run at the current time
            $schedule->dueEvents(app())
                ->filter(function ($event) {
                    return $event->command === 'artisan app:assign-daily-meals';
                })
                ->each(function ($event) use (&$executionCount) {
                    // Mock the command execution or spy on it
                    Artisan::call('app:assign-daily-meals');
                    $executionCount++;
                });

            // Advance time by 12 hours
            Carbon::setTestNow($startDate->copy()->addHours(12 * ($i + 1)));
        }

        // Assert the command ran the expected number of times (14 times in a week)
        $this->assertEquals(14, $executionCount);

        // Reset the mocked time
        Carbon::setTestNow();
    }
}
