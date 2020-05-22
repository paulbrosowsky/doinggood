<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('needs', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('user_id');  
            $table->string('title');            
            $table->text('project_description')->nullable();
            $table->text('need_description')->nullable();
            $table->string('title_image')->nullable();
            $table->timestamp('deadline');
            $table->string('status')->default('offen');
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
        Schema::dropIfExists('needs');
    }
}
