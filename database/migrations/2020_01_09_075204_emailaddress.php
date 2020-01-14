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
            $table->string('email');
            $table->string('email')->unique();
            $table->string('sendInvitation');
            $table->timestamps('update_at');
            $table->timestamps('create_at');
            $table->index([ "email" => "2dsphere" ]);
            
        });

        
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
