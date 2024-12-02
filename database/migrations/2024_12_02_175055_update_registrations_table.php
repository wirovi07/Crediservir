<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Cambiar el nombre de la columna "input_type" a "type_input" y modificar su tipo
            $table->dropColumn('input_type'); // Eliminar la columna actual
            $table->enum('type_input', ['Gratis', 'General', 'VIP'])->after('id'); // Agregar la columna con los valores deseados

            // Renombrar la columna "promotional code" a "code_promotional"
            $table->renameColumn('promotional code', 'code_promotional');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Revertir los cambios realizados en el método up()
            $table->dropColumn('type_input'); // Eliminar la columna "type_input"
            $table->date('input_type')->after('id'); // Restaurar la columna "input_type"

            $table->renameColumn('code_promotional', 'promotional code'); // Renombrar la columna de vuelta a su nombre original
        });
    }
};
