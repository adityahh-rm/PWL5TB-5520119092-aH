<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIncomeReportsTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Illuminate\Support\Facades\DB::unprepared('CREATE TRIGGER addreportfrominsert AFTER INSERT ON products FOR EACH ROW INSERT INTO income_reports SET name = new.name, qty= new.qty, created_at = new.created_at');
        Illuminate\Support\Facades\DB::unprepared('CREATE TRIGGER addreportfromupdate AFTER UPDATE ON products FOR EACH ROW INSERT INTO income_reports SET name = new.name, qty= new.qty, created_at = new.updated_at');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
