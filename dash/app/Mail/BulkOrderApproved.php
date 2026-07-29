<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BulkOrderApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $bulkOrder;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bulkOrder)
    {
        $this->bulkOrder = $bulkOrder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Approval: Your Bulk Order Request #' . $this->bulkOrder->id)
                    ->view('emails.bulk_order_approved');
    }
}
