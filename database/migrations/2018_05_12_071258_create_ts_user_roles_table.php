<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('ts_user_role', function (Blueprint $table) {

            // Keys
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('role_id');

            // Attributes
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('ts_user_role', function (Blueprint $table) {

            $table->foreign('user_id')
                ->references('id')
                ->on('ts_users')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('ts_roles')
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
        Schema::table('ts_user_roles', function (Blueprint $table) {
            //
        });
    }
}
