<?php

namespace App\Console\Commands;

use App\Mail\EnviarCorreo;
use Illuminate\Console\Command;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;

class SendTaskNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:send-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send task notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Obtener las tareas que necesitan recordatorio
        $tasks = Task::where('due_date', '<=', now()->addDay())->get();

        // Enviar recordatorio a los usuarios
        foreach ($tasks as $task) {
            Mail::to($task->user->email)->send(new EnviarCorreo($task));
        }

        // Mostrar mensaje de éxito
        $this->info('Task reminders sent successfully!');
    }
}