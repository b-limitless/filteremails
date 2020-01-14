<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Emailaddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {           
            Schema::create('emailaddresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('email')->unique();
            $table->string('sendInvitation');
             $table->timestamps('created_at');
            $table->timestamps('update_at');
           
            
        });

        Schema::connection('wealthface2')->table('emailaddresses', function (Blueprint $collection) {
            $collection->index([ "is_valid" => "2dsphere" ]);
        });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('wealthface2')->table('emailaddresses', function (Blueprint $collection) {
            $collection->dropIndex(['loc_2dsphere']);
        });
    }
}
