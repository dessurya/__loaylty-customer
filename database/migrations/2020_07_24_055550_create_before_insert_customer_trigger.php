<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBeforeInsertCustomerTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $myTrg = 'CREATE OR REPLACE TRIGGER before_insert_customer BEFORE INSERT ON customer FOR EACH ROW BEGIN
          DECLARE web_count INT;
          DECLARE web_code VARCHAR(175);
          DECLARE web_name VARCHAR(175);
          DECLARE bank_name VARCHAR(175);
          DECLARE tier_name VARCHAR(175);
          DECLARE gen_code VARCHAR(175);

            IF NEW.code IS NULL THEN
              SELECT code, name INTO web_code, web_name FROM master_website WHERE id = NEW.website_id LIMIT 1;
              SELECT count(website_id)+1 INTO web_count FROM customer WHERE website_id = NEW.website_id;
              SELECT name INTO bank_name FROM master_bank WHERE id = NEW.bank_id LIMIT 1;
              SELECT name INTO tier_name FROM master_tier WHERE id = NEW.tier_id LIMIT 1;
              CALL generate_code(web_code, web_count, gen_code);
              SET NEW.code = gen_code, NEW.website = web_name, NEW.bank = bank_name, NEW.tier = tier_name;
            END IF;
        END;';
        DB::unprepared($myTrg);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS before_insert_customer;');
    }
}
