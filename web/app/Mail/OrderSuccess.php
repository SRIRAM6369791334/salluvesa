<?php

namespace App\Mail;

use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;
    public $orderDetails;
    public $currencySymbol;
    public $exchangeRate;

    /**
     * Create a new message instance.
     */
    public function __construct(ProductOrder $order, User $user, $orderDetails)
    {
        $this->order = $order;
        $this->user = $user;
        $this->orderDetails = $orderDetails;

        // Get currency symbol from order's selected currency
        $selectedCurrency = $order->selected_currency ?? 'INR';
        $currencies = app(\App\Services\CurrencyService::class)->getSupportedCurrencies();
        $this->currencySymbol = $currencies[$selectedCurrency]['symbol'] ?? '₹';
        $this->exchangeRate = (float) ($order->exchange_rate ?? 1);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation - ' . $this->order->order_id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-success',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
