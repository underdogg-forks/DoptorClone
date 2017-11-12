<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReportGeneratorsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_generators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('modules')->nullable();
            $table->string('author');
            $table->string('version');
            $table->string('website');
            $table->boolean('show_calendars')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('report_generators');
    }

}
