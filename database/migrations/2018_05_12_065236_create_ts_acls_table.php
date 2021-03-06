<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTsAclsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('ts_acls', function (Blueprint $table) {
            
            // Keys
            $table->bigIncrements('id');            
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('creator_id');            
            $table->unsignedInteger('resource_id');
            $table->unsignedInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            // Attributes
            $table->string('name');
            $table->json('meta')
                ->nullable(); 
            $table->softDeletes();
            $table->timestamps();            
        });
        
        Schema::table('ts_acls', function (Blueprint $table) {
            $table->foreign('client_id')
                ->references('id')
                ->on('ts_clients')
                ->onDelete('cascade');

            $table->foreign('creator_id')
                ->references('id')
                ->on('ts_users');

            $table->foreign('role_id')
                ->references('id')
                ->on('ts_roles')
                ->onDelete('cascade');

            $table->foreign('resource_id')
                ->references('id')
                ->on('ts_resources')
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on('ts_permissions')
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
        Schema::table('ts_acls', function (Blueprint $table) {
            //
        });
    }
}
