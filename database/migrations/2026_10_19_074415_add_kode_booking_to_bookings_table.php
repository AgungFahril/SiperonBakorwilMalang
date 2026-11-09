use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

public function up(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->string('kode_booking')->nullable()->unique();
    });
}

public function down(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropUnique(['kode_booking']);
        $table->dropColumn('kode_booking');
    });
}