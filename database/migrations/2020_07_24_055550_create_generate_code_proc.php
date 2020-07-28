<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateGenerateCodeProc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $mySp = 'CREATE OR REPLACE PROCEDURE generate_code(
          IN prefix VARCHAR(10),
          IN queue INT,
          OUT new_code VARCHAR(45)
        )
        BEGIN
          DECLARE x INT;
          SET x = 3 - LENGTH(queue);
          IF x = 2 THEN
            SET new_code = "00";
          ELSEIF x = 1 THEN
            SET new_code = "0";
          END IF;

          SET new_code = CONCAT(prefix,new_code,queue);
        END;';

        DB::unprepared($mySp);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS get_cust_code;');
    }
}
