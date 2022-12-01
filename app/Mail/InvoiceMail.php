<?php

namespace App\Mail;

use App\Models\Supplier;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The Invoice instance.
     *
     * @var Invoice
     */
    protected $invoice;
    protected $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, Supplier $customer)
    {
        $this->invoice = $invoice;
        $this->customer = $customer;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('support@shopify.com', 'Shopify CO LTD'),
            subject: "Order For Today's Shopping",
            tags: ['invoice'],
            metadata: [
                'invoice_no' => $this->invoice->invoice_no,
            ]
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.invoice-mail',
            with: [
                'invoice' => $this->invoice,
                'customer' => $this->customer,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
