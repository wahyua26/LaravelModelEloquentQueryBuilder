# Laravel model, eloquent and query builder

## Model
Laravel adalah kerangka kerja aplikasi web berbasis PHP yang sumber terbuka, menggunakan konsep Model-View-Controller

Model, Model mewakili struktur data. Biasanya model berisi fungsi-fungsi yang membantu seseorang dalam pengelolaan basis data seperti memasukkan data ke basis data, pembaruan data dan lain-lain.

Dalam membuat suatu model kita bisa menggunakan perintah `php artisan make:model 'nama model'` sebagai contoh bila ingin membuat model `Car` maka yang dapat dituliskan pada terminal yaitu `php artisan make:model Car`. Dalam pembuatan model juga dapat dibuat migration, factory, seeder, serta controllernya yaitu dengan menambahkan `-m` untuk membuat migration, `-f` untuk membuat factory, `-s` untuk membuat seeder, `-c` untuk membuat controller, dan `-mfsc` atau `--all` untuk membuat keempatnya secara sekaligus serta `--pivot` untuk membuat model tersebut sebagai model pivot hal ini berhubungan dengan relasi many to many eloquent yang akan dijelaskan di pembahasan selanjutnya.
```
# Generate a model and a Migration class...
php artisan make:model Car --migration
php artisan make:model Car -m

# Generate a model and a CarFactory class...
php artisan make:model Car --factory
php artisan make:model Car -f

# Generate a model and a CarSeeder class...
php artisan make:model Car --seed
php artisan make:model Car -s

# Generate a model and a CarController class...
php artisan make:model Car --controller
php artisan make:model Car -c

# Generate a model and a migration, factory, seeder, and controller...
php artisan make:model Car -mfsc

# Shortcut to generate a model, migration, factory, seeder, and controller...
php artisan make:model Car --all

# Generate a pivot model...
php artisan make:model CarProduct --pivot
```

## Eloquent
Seperti yang dijelaskan pada dokumentasi laravel, Eloquent adalah sebuah fitur untuk mengelola data yang ada pada database dengan sangat mudah. Eloquent ORM menyediakan fungsi-fungsi active record, atau fungsi-fungsi query sql untuk mengelola data pada database. Dan fungsi query nya semua sudah dibuat dan disediakan secara default dalam laravel. Jadi kita tidak perlu lagi mengetik query sql yang panjang-panjang. Simpel nya gini, jadi dengan Eloquent, kita bisa mengelola data yang ada pada database dari hanya satu buah model. Misalnya kita punya tabel siswa, maka kita juga akan mempunyai sebuah model dengan nama siswa, nah dengan model siswa ini kita bisa mengelola data-data yang ada pada tabel siswa dengan mudah dan cepat.

Pertama - tama, kita perlu seting `.env` terlebih dahulu. File ini terletak pada bagian luar projek laravel yang dibuat, dan pastikan pada bagian mysql sudah terkonfigurasi seperti pada gambar dibawah:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=model_pbkke
DB_USERNAME=root
DB_PASSWORD=
```

Selanjutnya kita perlu membuat sebuah model, pada contoh kali ini, kita namakan model tersebut "Pegawai". Model tersebut dapat dibuat dengan cara : 

```
php artisan make:model Pegawai -m
```
agar pembuatan model sekaligus dibuat dengan migrationnya.

## Query Builder
Pertama - tama, kita perlu seting `.env` terlebih dahulu. File ini terletak pada bagian luar projek laravel yang dibuat, dan pastikan pada bagian mysql sudah terkonfigurasi seperti pada gambar dibawah:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=model_pbkke
DB_USERNAME=root
DB_PASSWORD=
```

pertama - tama, kita perlu membuat sebuah model, pada contoh kali ini, kita namakan model tersebut "Movies". Model tersebut dapat dibuat dengan cara : 

```
php artisan make:model Movies -mfsc
```

agar pembuatan model sekaligus dibuat dengan migration, factories, seeder, dan controllernya.

Lalu, kita ubah kodingan yang ada pada model Movies menjadi sebagai berikut :

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    use HasFactory;
    protected $table="movies";
    protected $fillable =[
        'title',
        'description',
        'genre',
        'year',
    ];
}
```

lalu kita ubah migration untuk movies menjadi seperti berikut:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Movies', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description');
            $table->text('genre');
            $table->integer('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
};
```

lalu kita ubah MoviesFactory menjadi sebagai berikut:

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MoviesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'genre' => $this->faker->word(),
            'year' => $this->faker->year(),
        ];
    }
}
```

lalu kita lakukan migrate fresh dengan memasukan kode berikut ke dalam terminal:
```
php artisan migrate:fresh --seed
```

setelah melakukan hal tersebut, sekarang kita ke MoviesController.

Pada MoviesController kita akan ubah sebagai berikut:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

```

Setelah itu kita sudah bisa melakukan query. 


