<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddRequiresToBuiltModulesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('built_modules', function (Blueprint $table) {
            $table->text('requires')->nullable()->after('models');
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
            $table->dropColumn('requires');
        });
    }

}
