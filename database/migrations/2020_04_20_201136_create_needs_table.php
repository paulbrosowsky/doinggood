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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');            
            $table->text('project_description')->nullable();
            $table->text('need_description')->nullable();
            $table->string('title_image')->nullable();
            $table->timestamp('deadline');
            $table->string('state_id')->default(1);
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
