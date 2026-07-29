<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_details', function (Blueprint $table) {
            $table->id();

            // Bank / Account info
            $table->string('account_holder_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_type')->nullable();          // savings / current
            $table->string('ifsc_code')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('bank_branch_name')->nullable();
            $table->text('bank_branch_address')->nullable();
            $table->string('bank_country')->nullable();
            $table->string('currency_accepted')->nullable();     // INR, USD …

            // Business info
            $table->string('business_name')->nullable();
            $table->text('business_address')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_contact_number')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('payment_confirmation_time')->nullable(); // e.g. "2-3 business days"

            $table->timestamps();
        });

        // Seed one default row so BankDetails::first() never returns null
        DB::table('bank_details')->insert([
            'account_holder_name'      => 'Saaluvesa Enterprises Private Limited',
            'bank_name'                => '',
            'account_number'           => '',
            'account_type'             => 'current',
            'ifsc_code'                => '',
            'swift_code'               => '',
            'bank_branch_name'         => '',
            'bank_branch_address'      => '',
            'bank_country'             => 'India',
            'currency_accepted'        => 'INR',
            'business_name'            => 'Saaluvesa Enterprises Private Limited',
            'business_address'         => '',
            'business_email'           => '',
            'business_contact_number'  => '',
            'gst_number'               => '',
            'payment_confirmation_time'=> '2-3 business days',
            'created_at'               => now(),
            'updated_at'               => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_details');
    }
};
