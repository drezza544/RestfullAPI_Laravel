<?php

use App\User;
use App\Profile;
use App\Pitstop;
use App\Review;
use App\Fasilitas;
use App\Pitstop_Fasilitas;
use App\Order;
use App\OrderDetail;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/**User Class */
$factory->define(User::class, function (Faker $faker) {
    return [
        'nama' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('secret'),
        'no_handphone' => $faker->phoneNumber,
        'remember_token' => Str::random(10),
    ];
});
/**Profile Class */
$factory->define(Profile::class, function (Faker $faker) {

    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'alamat' => $faker->address,
        'tgl_lahir' => $faker->date,
        'path' => $faker->imageUrl(640, 480, 'people'),
    ];
});
/**Pitstop Class */
$factory->define(Pitstop::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return User::all()->random()->id;
        },
        'nama' => $faker->text($faker->numberBetween(10, 15)),
        'deskripsi' => $faker->text($faker->numberBetween(20,250)),
        'latitude' => $faker->latitude(-90, 90),
        'longitude' => $faker->longitude(-180, 180),
        'slot' => $faker->numberBetween(5, 20),
        'harga' => $faker->numberBetween(5000, 20000),
    ];
});
/**Review Class */
$factory->define(Review::class, function (Faker $faker) {
    return [
        'pitstop_id' => function() {
            return Pitstop::all()->random()->id;
        },
        'user_id' => function() {
            return User::all()->random()->id;
        },
        'message' => $faker->text($faker->numberBetween(20, 250)),
        'rate' => $faker->numberBetween(1, 5),
        'created_at' => date_create()->format('Y-m-d H:i:s'),
        'updated_at' => date_create()->format('Y-m-d H:i:s'),
    ];
});
/**Pitsto__Fasilitas Class */
$factory->define(Pitstop_Fasilitas::class, function (Faker $faker) {
    return [
        'pitstop_id' => function() {
            return Pitstop::all()->random()->id;
        },
        'fasilitas_id' => function() {
            return Fasilitas::all()->random()->id;
        },
        'created_at' => date_create()->format('Y-m-d H:i:s'),
        'updated_at' => date_create()->format('Y-m-d H:i:s'),
    ];
});
/**Fasilitas Class */
$factory->define(Fasilitas::class, function (Faker $faker) {
    return [
        'nama' => $faker->text($faker->numberBetween(10, 15)),
        'harga' => $faker->numberBetween(3000, 10000),
        'created_at' => date_create()->format('Y-m-d H:i:s'),
        'updated_at' => date_create()->format('Y-m-d H:i:s'),
    ];
});
/**Order */
$factory->define(Order::class, function(Faker $faker) {
    return [
        'kode_order' => 'PS' . $faker->numberBetween(10000, 100000),
        'user_id' => function() {
            return User::all()->random()->id;
        },
        'pitstop_id' => function() {
            return Pitstop::all()->random()->id;
        },
        'tanggal' => $faker->date('Y-m-d'),
        'waktu_boking' => $faker->time('H:i:s'),
        'harga' => $faker->numberBetween(1000, 4000),
        'created_at' => date_create()->format('Y-m-d H:i:s'),
        'updated_at' => date_create()->format('Y-m-d H:i:s'),
    ];
});
/**OrderDetail */
$factory->define(OrderDetail::class, function(Faker $faker) {
    return [
        'order_id' => function() {
            return Order::all()->random()->id;
        },
        'fasilitas_id' => function() {
            return Fasilitas::all()->random()->id;
        },
        'created_at' => date_create()->format('Y-m-d H:i:s'),
        'updated_at' => date_create()->format('Y-m-d H:i:s'),
    ];
});