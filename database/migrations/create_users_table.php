public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('surname');
        $table->string('email')->unique();
        $table->string('password');
        $table->enum('role', ['admin', 'customer']);
        $table->boolean('dark_mode')->default(false);
        $table->timestamps();
    });
}
