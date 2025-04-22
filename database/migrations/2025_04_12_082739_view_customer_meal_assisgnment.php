<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW view_customer_meal_assignments AS
            SELECT
                cma.id AS assignment_id,
                cma.delivery_status,
                cma.created_at AS assigned_at,
                cma.updated_at AS last_updated,

                c.id AS customer_id,
                c.name AS customer_name,
                c.wa_number AS customer_whatsapp,
                c.email AS customer_email,
                c.subscription_status,

                mi.name AS meal_name,
                mi.description AS meal_description,
                mi.category AS meal_type,
                mi.dietary_type,
                mi.week_start_date,

                mp.type AS meal_plan_type,
                mp.breakfast AS includes_breakfast,
                mp.lunch AS includes_lunch,
                mp.dinner AS includes_dinner,
                mp.restrictions_note,
                mp.special_instruction
            FROM
                customer_meal_assignments cma
                JOIN customers c ON cma.customer_id= c.id
                JOIN menu_items mi ON cma.menu_item_id= mi.id
                JOIN meal_plans mp ON mp.customer_id= cma.id

            where c.subscription_status = 'active'
        ");
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        DB::statement("DROP VIEW IF EXISTS view_customer_meal_assignments");
    }
};
