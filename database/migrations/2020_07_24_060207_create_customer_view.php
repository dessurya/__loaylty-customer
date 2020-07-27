<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_customer AS (
                SELECT 
                    cstmr.id as id,
                    cstmr.code as customer_code,
                    username,
                    cstmr.name as name,
                    alamat,
                    no_hp,
                    no_rekening,
                    atas_nama_rekening,
                    mw.code as website_code,
                    mw.name as website,
                    mb.code as bank_code,
                    mb.name as bank,
                    mt.name as tier,
                    icon,
                    cstmr.created_at as created_at
                FROM customer cstmr
                LEFT JOIN master_website mw on cstmr.website_id = mw.id
                LEFT JOIN master_bank mb on cstmr.bank_id = mb.id
                LEFT JOIN master_tier mt on cstmr.tier_id = mt.id
            )
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS view_customer");
    }
}
