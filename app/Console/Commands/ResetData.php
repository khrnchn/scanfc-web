<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ResetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for resetting data.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Clear all records from the Attendance table
        Attendance::truncate();
        $this->info('Successfully cleared Attendance table.');

        // Update hasRecordedAttendance field in Classroom table for today's classrooms
        $today = Carbon::today();
        $todayClassrooms = Classroom::whereDate('start_at', $today)->update(['hasRecordedAttendance' => false]);
        $this->info('Successfully updated Classroom table.');

        // Clear the nfc_tag field for the student with user_id of 2
        $student = Student::where('user_id', 2)->first();
        if ($student) {
            $student->update(['nfc_tag' => '']);
            $this->info('Successfully cleared ' . $student->user->name . "'s NFC tag.");
        } else {
            $this->error('Student with user_id 2 not found.');
        }

        // Clear the nfc_tag field for the student Ilwani
        $user = User::where('email', 'alwani@student.uitm.com')->first();
        $student = $user->student;
        if ($student) {
            $student->update(['nfc_tag' => '']);
            $this->info('Successfully cleared ' . $student->user->name . "'s NFC tag.");
        } else {
            $this->error('Student with email => ilwani@student.uitm.com not found.');
        }

        return Command::SUCCESS;
    }
}
