<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('pulang'); // Menambahkan kolom foto
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->dropColumn('foto'); // Menghapus kolom jika rollback
        });
    }
};
