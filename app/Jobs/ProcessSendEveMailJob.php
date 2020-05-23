<?php

namespace App\Jobs;

/**
 * This is just an example of how to create a job and send eve mails with said job.
 */

//Internal Library
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;

//Seat stuff
use Seat\Eseye\Configuration;
use Seat\Eseye\Containers\EsiAuthentication;
use Seat\Eseye\Eseye;
use Seat\Eseye\Exceptions\RequestFailedException;
use App\Library\Esi\Esi;

//Models
use App\Models\Esi\EsiScope;
use App\Models\Esi\EsiToken;

class ProcessSendEveMailJob implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Timeout in seconds
     * 
     * @var int
     */
    public $timeout = 3600;
    
    /**
     * Retries
     * 
     * @var int
     */
    public $retries = 3;
    private $body;
    private $recipient;
    private $recipient_type;
    private $subject;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EveMail $mail) {

        $this->body = $mail->body;
        $this->recipient = $mail->recipient;
        $this->recipient_type = $mail->recipient_type;
        $this->subject = $mail->subject;

        $this->connection = 'redis';
    }
    
    /**
     * Execute the job.
     * Utilized by using ProcessSendEveMailJob::dispatch($mail);
     * The model is passed into the dispatch function, then added to the queue
     * for processing.
     *
     * @return void
     */
    public function handle()
    {
        //Get the esi configuration
        $config = config('esi');

        //Declare the esi helper
        $esiHelper = new Esi;

        //Get the refresh  token
        $token = $esiHelper->GetRefreshToken($config['primary']);
        //Setup the authentication container
        $esi = $esiHelper->SetupEsiAuthentication($token);

        //Attemp to send the mail
        try {
            $esi->setBody([
                'approved_cost' => 100,
                'body' => $this->body,
                'recipients' => [[
                    'recipient_id' => $this->recipient,
                    'recipient_type' => $this->recipient_type,
                ]],
                'subject' => $this->subject,
            ])->invoke('post', '/characters/{character_id}/mail/', [
                'character_id'=> $config['primary'],
            ]);
        } catch(RequestFailedException $e) {
            Log::warning($e);
            return null;
        }
        
        $this->delete();
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed($exception)
    {
        Log::critical($exception);
    }
}

?>
