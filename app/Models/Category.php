<?php

// File Model Category: representasi tabel "categories" di database (M pada MVC).
// Satu kategori mengelompokkan banyak bahan (item).

// namespace: "alamat" class ini, sesuai folder app/Models. Dipakai Composer (autoload) untuk menemukan file ini.

namespace App\Models;

use Database\Factories\CategoryFactory; // import class CategoryFactory: pembuat data dummy kategori
use Illuminate\Database\Eloquent\Factories\HasFactory; // import trait HasFactory: agar model bisa memakai factory
use Illuminate\Database\Eloquent\Model; // import class Model: induk semua model Eloquent (ORM Laravel)
use Illuminate\Database\Eloquent\Relations\HasMany; // import class HasMany: tipe relasi one-to-many

// Attribute #[Fillable]: daftar kolom yang boleh diisi massal lewat create()/update() (mass assignment)
// class Category extends Model: deklarasi class Category yang mewarisi (extends) semua fitur Eloquent dari Model.
// Nama tabel otomatis ditebak Laravel: Category -> "categories" (jamak)
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    // trait HasFactory: membuat model ini bisa dipakai dengan factory (data dummy), contoh Category::factory()->create()
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Relasi one-to-many: satu kategori punya banyak bahan.
     *
     * @return HasMany<Item, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
