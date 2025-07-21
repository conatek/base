<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateIsValidDateFunction extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            DROP FUNCTION IF EXISTS is_valid_date;
            CREATE FUNCTION is_valid_date(date_str VARCHAR(10))
            RETURNS TINYINT(1) DETERMINISTIC
            BEGIN
                DECLARE y INT;
                DECLARE m INT;
                DECLARE d INT;

                -- Verifica el formato básico YYYY-MM-DD
                IF date_str NOT REGEXP '^[0-9]{4}-(0[1-9]|1[0-2])-([0][1-9]|[12][0-9]|3[01])$' THEN
                    RETURN 0;
                END IF;

                -- Extrae año, mes y día
                SET y = CAST(SUBSTRING(date_str, 1, 4) AS UNSIGNED);
                SET m = CAST(SUBSTRING(date_str, 6, 2) AS UNSIGNED);
                SET d = CAST(SUBSTRING(date_str, 9, 2) AS UNSIGNED);

                -- Verifica meses con 31 días
                IF m IN (1,3,5,7,8,10,12) THEN
                    RETURN d <= 31;

                -- Verifica meses con 30 días
                ELSEIF m IN (4,6,9,11) THEN
                    RETURN d <= 30;

                -- Verifica febrero y años bisiestos
                ELSEIF m = 2 THEN
                    IF (y % 4 = 0 AND y % 100 != 0) OR (y % 400 = 0) THEN
                        RETURN d <= 29; -- Año bisiesto
                    ELSE
                        RETURN d <= 28; -- Año no bisiesto
                    END IF;

                -- Mes inválido
                ELSE
                    RETURN 0;
                END IF;
            END;
        ");
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS is_valid_date');
    }
}
