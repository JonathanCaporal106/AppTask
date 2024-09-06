<?php

namespace App\Mail;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use resource\View\emails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarCorreo extends Mailable
{
    use Queueable, SerializesModels;
    public $Task;

    /**
     * Create a new message instance.
     */
    public function __construct( public Task  $task)
    {
        $this->task = $task;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendient Task',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view:'emails.content-mail'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        
        return [ ];
    }

    public function build()
    { 
        return $this->view('emails.content-mail')
        ->with([
            'title' => $this->task->title,
            'description' => $this->task->description,
            'due_date' => $this->task->due_date,
            'due_time' => $this->task->due_time,
        ]);    }
}
