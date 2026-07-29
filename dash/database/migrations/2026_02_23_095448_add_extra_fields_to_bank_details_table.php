<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_details', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('account_type');
            $table->string('routing_number')->nullable()->after('payment_method');
            $table->text('beneficiary_address')->nullable()->after('bank_branch_address');
            
            // Adjust existing fields to be nullable if they weren't
            $table->string('ifsc_code')->nullable()->change();
            $table->string('bank_branch_name')->nullable()->change();
            $table->text('bank_branch_address')->nullable()->change();
            $table->string('business_name')->nullable()->change();
            $table->text('business_address')->nullable()->change();
            $table->string('business_email')->nullable()->change();
            $table->string('business_contact_number')->nullable()->change();
            $table->string('payment_confirmation_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_details', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'routing_number', 'beneficiary_address']);
        });
    }
}
