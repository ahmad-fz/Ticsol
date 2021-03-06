<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_comments', function (Blueprint $table) {
            // Keys
            $table->bigIncrements('id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('creator_id');
            $table->unsignedBigInteger('job_id')
                ->nullable();
            $table->unsignedBigInteger('parent_id')
                ->nullable();
            $table->unsignedBigInteger('request_id')
                ->nullable();
            
            // Attributes
            $table->mediumText('body');   
            $table->softDeletes();         
            $table->timestamps();
        });

        Schema::table('ts_comments', function (Blueprint $table) {            
            
            $table->foreign('client_id')
                ->references('id')
                ->on('ts_clients')
                ->onDelete('cascade');

            $table->foreign('creator_id')
                ->references('id')
                ->on('ts_users');
            
            $table->foreign('job_id')
                ->references('id')
                ->on('ts_jobs')
                ->onDelete('cascade');  

            $table->foreign('parent_id')
                ->references('id')
                ->on('ts_comments')
                ->onDelete('cascade');  

            $table->foreign('request_id')
                ->references('id')
                ->on('ts_requests')
                ->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ts_comments', function (Blueprint $table) {
            //
        });
    }
}
