<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFormFieldsToBuiltModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('built_modules', function (Blueprint $table) {
            $table->text('form_fields')->nullable()->after('form_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('built_modules', function (Blueprint $table) {
            $table->dropColumn('form_fields');
        });
    }
}
