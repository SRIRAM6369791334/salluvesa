<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_details', function (Blueprint $table) {
            $table->id();
            $table->string('account_holder_name');
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_type');
            $table->string('ifsc_code');
            $table->string('swift_code')->nullable();
            $table->string('bank_branch_name');
            $table->text('bank_branch_address');
            $table->string('bank_country')->default('India');
            $table->string('currency_accepted');
            $table->string('business_name');
            $table->text('business_address');
            $table->string('business_email');
            $table->string('business_contact_number');
            $table->string('gst_number')->nullable();
            $table->string('payment_confirmation_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_details');
    }
}
