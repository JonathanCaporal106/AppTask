<?php

use App\Jobs\SendTaskReminder;
use Illuminate\Support\Facades\Mail;
use App\Models\Task;
use App\Mail\EnviarCorreo;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

Artisan::command('LogTimeCommand', function () {
    $now = Carbon::now();

    $destinatarios = ['diurnovampiro6@gmail.com'];


    // Obtener las tareas que necesitan recordatorio (2 minutos antes de la hora de vencimiento)
    $tasks = Task::where('due_date', $now->toDateString())
                 ->where('due_time', $now->copy()->addMinutes(2)->format('H:i'))
                 ->get();

    // Enviar recordatorio a los usuarios solo si hay tareas
    if ($tasks->isNotEmpty()) {
        foreach ($tasks as $task) {
            Mail::bcc($destinatarios)->send(new EnviarCorreo($task));
        }

        $this->info('Task reminders sent successfully!');
    } else {
        $this->info('No tasks due at the current time.');
    }
})->purpose('Send mail 2 minutes before task due')->everyMinute();

