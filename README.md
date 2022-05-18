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

Setelah terbuat model pegawai dan migrasinya maka langkah selanjutnya yaitu menambahkan kolom-kolom yang ingin dibuat pada tabel pegawai. Sebagai contoh disini menambahkan kolom id, nama dan alamat.
```
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->text('alamat');
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
}
```
Perhatikan pada file migration di atas, karena kita akan membuat tabel "pegawai", bukan "pegawais", jadi kitaa ubah menjadi "pegawai". 

Kemudian migrate dengan mengetikkan perintah `php artisan migrate`. Setelah itu maka akan muncul tabel pegawai pada database model_pbkke sesuai dengan yang dibuat pada file migration pegawai.

Dalam mengimplementasikan eloquent kita memerlukan data pada tabel di database, nah disini kita akan membuat data dummy dalam tabel pegawai dengan menggunakan factory dan seeder. Untuk membuat factory kita dapat menuliskan perintah `php artisan make:factory PegawaiFactory`. Lalu lengkapi seperti contoh berikut:
```
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->name(),
            'alamat' => $this->faker->address(),
        ];
    }
}
```
Langkah selanjutnya yaitu dengan menambahkan `\App\Models\Pegawai::factory(100)->create();` pada `public function run()` pada file DatabaseSeeder untuk menjalankan PegawaiFactorynya.
```
public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Pegawai::factory(100)->create();

    }
```

Setelah itu kita jalankan perintah `php artisan migrate:fresh --seed` untuk menjalankan seeder sekaligus factorynya. Lalu akan muncul data dummy pada tabel pegawai di database.

Setelah kita punya data untuk mencoba fitur Eloquent Laravel, sekarang buka lagi model Pegawai.php. Karena laravel menerapkan sistem plural atau jamak pada penamaan tabel maka kita set dulu nama tabelnya menjadi pegawai bukan pegawais yaitu dengan menambahkan `protected $tabel = "pegawai";` pada model Pegawai.php agar model tersebut dapat menghandle tabel pegawai bukan pegawais.

```
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = "pegawai";
}
```

Kemudian buat route untuk menampilkan data pegawai dengan eloquent.
```
<?php

use App\Http\Controllers\GiftController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pegawai', [PegawaiController::class, 'index']);
```

Disini kita membuat pengaturan saat route `/pegawai` diakses, maka akan dijalankan method index pada PegawaiController.php. Karena belum ada controller tersebut maka kita perlu membuatnya terlebih dahulu dengan mengetikkan perintah `php artisan make:controller PegawaiController`.

Setelah controllernya terbuat, isi controller tersebut seperti contoh berikut:
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pegawai;

class PegawaiController extends Controller
{
    public function index()
    {
    	// mengambil data pegawai
    	$pegawai = Pegawai::all();
 
    	// mengirim data pegawai ke view pegawai
    	return view('pegawai', ['pegawai' => $pegawai]);
    }
}
```

Perhatikan pada controller pegawai di atas, pertama pada bagian luar class kita panggil model Pegawai sesuai dengan letak model dalam folder app. Kemudian pada method atau function index kita menggunakan fitur eloquent dengan mengambil data dari tabel pegawai hanya dengan fungsi `all()` dan terakhir kita passing datanya ke view pegawai.

Buat sebuah view pegawai baru dengan nama pegawai.blade.php.
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Pegawai</title>
</head>
<body>
    <h1> Data Pegawai </h1>
    <ul>
        @foreach($pegawai as $p)
            <li>{{ "Nama : ". $p->nama . ' | Alamat : ' . $p->alamat }}</li>
        @endforeach
    </ul>
</body>
</html>
```

Pada view pegawai.blade.php, kita tangkap data yang dikirim dari controller dan kita tampilkan dengan menggunakan foreach. Untuk mengeceknya dengan `php artisan serve` dan akses `localhost:8000/pegawai` maka hasilnya akan seperti berikut:

![image](https://user-images.githubusercontent.com/77374015/168723196-7370527e-b54f-41e2-95ec-cdf6558b325e.png)

## Eloquent Relationship Laravel
Salah satu fitur keren laravel yaitu ELoquent Relationship Laravel. Diantaranya sebagai berikut:
- One To One
- One To Many
- Many To Many

Biasanya untuk menghubungkan 2 tabel atau lebih, kita menggunakan fungsi join, atau langsung menggabungkannya menggunakan query sql, namun di laravel sudah ada fitur untuk menghubungkan 2 tabel atau lebih yaitu sudah diterapkan dalam Eloquent, jadi kita bisa menampilkan data dari 2 tabel atau lebih dengan laravel.

## Relasi One To One Eloquent
Relasi One To One maksudnya 1 record data dari tabel A memiliki relasi ke 1 record data di tabel B. Sebagai contoh misalnya satu orang pengguna memiliki satu nomor telepon, begitu juga kebalikannya, satu record data nomor telepon dimiliki oleh satu orang pengguna.

![image](https://user-images.githubusercontent.com/77374015/168944241-99a7fc7e-501d-47a7-b6e1-07effa8385e5.png)

Hal pertama yang dilakukan yaitu membuat kedua tabel tersebut dan juga mengisinya. Untuk mempermudah hal tersebut kita bisa mengimport langsung dengan file `OneToOne.sql` yang sudah disediakan. Jika proses import berhasil, maka akan muncul tabel pengguna dan telepon serta isinya.

Langkah selanjutnya yaitu membuat model untuk pengguna dengan menggunakan perintah `php artisan make:model Pengguna`. Kemudian buka model Pengguna yang sudah dibuat dan masukkan fungsi berikut:
```
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = "pengguna";

    public function telepon()
    {
    	return $this->hasOne('App\Telepon');
    }
    
}
```

Sama seperti sebelumnya, disini kita memberitahukan bahwa tabel yang digunakan yaitu tabel "pengguna' bukan "penggunas" (plural). Dan pada fungsi telepon() kita memberitahukan bahwa tabel pengguna memiliki relasi 1 ke model atau tabel telepon dengan menggunakan `hasOne`.

Langkah selanjutnya yaitu membuat model untuk telepon dengan menggunakan `php artisan make:model Telepon`. Setelah itu sesuaikan isinya dengan contoh berikut:
```
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telepon extends Model
{
    protected $table = "telepon";

    public function pengguna()
    {
    	return $this->belongsTo('App\Pengguna');
    }
}
```

Pada model telepon ini kita juga mendeklarasikan bahwa tabel yang kita gunakan yaitu tabel "telepon". Lalu untuk menghubungkannya dengan tabel pengguna kita menggunakan `belongsTo` yang berarti bahwa tabel telepon ini dimiliki oleh tabel pengguna sehingga kedua tabel sudah terhubung. Kedua tabel ini dihubungkan oleh kolom pengguna_id yang ada pada tabel telepon. 

Untuk pengecekan apakah relasi ini sudah berhasil atau belum, hal pertama yang dilakukan yakni membuat route "/pengguna" yang akan menampilkan data pengguna dan data nomor telepon masing-masing pengguna. 
```Route::get('/pengguna', [PenggunaController::class, 'index']);```

Selanjutnya buat controller PenggunaController.php menggunakan `php artisan make:controller PenggunaController`. Selanjutnya pada controller ini kita ambil data pengguna dan kita return ke view pengguna, caranya masih sama seperti contoh di pembahasan sebelumnya.
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// memanggil model Pengguna
use App\Pengguna;

class PenggunaController extends Controller
{
    public function index()
    {
    	// mengambil semua data pengguna
    	$pengguna = Pengguna::all();
    	// return data ke view
    	return view('pengguna', ['pengguna' => $pengguna]);
    }
}
```

Lalu buat sebuah view untuk menampilkan data pengguna yaitu view pengguna.blade.php
```
<!DOCTYPE html>
<html>
<head>
	<title>Relasi One To One Eloquent</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

	<div class="container">
		<div class="card mt-5">
			<div class="card-body">
				<h5 class="text-center my-4">Eloquent One To One Relationship</h5>
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Pengguna</th>
							<th>Nomor Telepon</th>
						</tr>
					</thead>
					<tbody>
						@foreach($pengguna as $p)
						<tr>
							<td>{{ $p->nama }}</td>
							<td>{{ $p->telepon->nomor_telepon }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

</body>
</html>
```

Pada view di atas kita bisa langsung mengakses data telepon dari data pengguna karena kita sudah mendeklarasikan relasi one to one antara kedua tabel ini. Dari variabel `$p` kita bisa langusng mengakses ke data telepon `$p->telepon` bahkan lebih spesifik lagi dengan memilih nama kolomnya `$p->telepon->nomor_telepon`

Terakhir untuk melihat hasilnya dengan menjalankan perintah `php artisan serve` pada terminal dan akses `localhost:8000/pengguna` maka akan muncul hasil relasi one to one relationship laravel

![image](https://user-images.githubusercontent.com/77374015/168948003-87dc9957-9d25-4412-8b9c-fb773248999c.png)

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


