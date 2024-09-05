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
    // Obtener las tareas que tienen recordatorio 2 minutos antes de la hora de vencimiento
    $tasks = Task::where('due_date', Carbon::now()->toDateString())
                 ->where('due_time', Carbon::now()->addMinutes(5)->format('H:i'))
                 ->get();

    // Enviar recordatorio a los usuarios solo si hay tareas
    if ($tasks->isNotEmpty()) {
        foreach ($tasks as $task) {
            Mail::to('UserExample@gmai.com')->send(new EnviarCorreo($task));
        }

        // Mostrar mensaje de éxito
        $this->info('Task reminders sent successfully!');
    } else {
        $this->info('No tasks due at the current time.');
    }
})->purpose('Send mail')->everyMinute();

