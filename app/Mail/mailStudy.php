<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailStudy extends Mailable
{
    use Queueable, SerializesModels;
    public $file,$study,$link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($file,$study,$link)
    {
        //
        $this->file = $file;
        $this->study = $study;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject("DDU :: ¡Estudios realizados!")
        ->view('mail.sendStudy')
        ->from('no-reply@ddu.mx', 'Radiología - DDU');
        foreach($this->file as $single){
            $email->attach($single->getRealPath(), [
                'as' => $single->getClientOriginalName(),
                'mime' => $single->getMimeType(),
            ]);
        }
        
        
    }
}
