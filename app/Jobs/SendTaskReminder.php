<?php

namespace App\Jobs;

use App\Mail\EnviarCorreo;
use App\Models\Task;
use App\Mail\TaskReminder;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTaskReminder implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tasks = Task::where('due_date', Carbon::now()->toDateString())
                      ->where('due_time', Carbon::now()->format('H:i'))
                      ->get();

        foreach ($tasks as $task) {
            Mail::to('user@example.com')->send(new EnviarCorreo($task));
        }
    }
}
