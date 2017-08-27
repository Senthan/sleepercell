<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('what');
            $table->dateTimeTz('start');
            $table->dateTimeTz('end');
            $table->enum('all_day', ['Yes', 'No'])->default('Yes');
            $table->enum('repeat', ['No', 'Daily', 'Weekdays', 'Weekly', 'Monthly', 'Yearly'])->nullable();
            $table->unsignedInteger('repeat_every')->nullable();
            $table->dateTimeTz('repeat_end')->nullable();
            $table->string('where')->nullable();
            $table->string('related_url')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('event_type_id')->index();
            $table->foreign('event_type_id')->references('id')->on('event_types')->onDelete('cascade');
            $table->enum('visibility', ['Public', 'Participants'])->default('Public');
            $table->string('timezone')->nullable();
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
        Schema::drop('events');
    }
}
