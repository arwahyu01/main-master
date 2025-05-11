<p style="text-align: center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p style="text-align: center">
Framework PHP untuk Para Pengrajin Web
</p>

<h2 style="text-align: center"> Main Master </h2>
<h3 style="text-align: center">( Generator CRUD )</h3>
<p style="text-align: center">
Main Master adalah generator CRUD untuk proyek Laravel. Proyek ini dibuat untuk mempermudah para pengembang dalam membangun proyek Laravel. Dibuat menggunakan Laravel 12 dan Bootstrap 5.
</p>
<p style="text-align: center">
Dibuat dengan ❤️ oleh <a href="https://www.linkedin.com/in/arwahyupradana/" target="_blank">arwp</a>
</p>

## Persyaratan

* Laravel 12 atau lebih baru
* PHP 8.2 atau lebih baru
* MySQL 5.7 atau database lainnya
* Composer 2.2.\* atau lebih baru

## Fitur Utama

- [x] Login with authentication (email and password)
- [x] Login API with Sanctum
- [x] CRUD with ajax request
- [x] role and permission management
- [x] Sidebar notification
- [x] Header notification
- [x] Dark Mode
- [x] Create a menu seeder and access the menu using the php artisan `app:convert-menu command`.
- [x] Morph File
- [x] Default Menu
    - [x] Dashboard
    - [x] Menu with sub menu (multi level)
    - [x] Role Management
      - [x] Access Group
      - [x] Level Access
      - [x] Access Menu
    - [x] Faq
    - [x] user management
    - [x] Announcement

## Cara Instalasi

```bash
# Dari Packagist
$ composer create-project arwp/main-master {nama-proyek-anda}
# ---- ATAU -----
# Clone repositori
$ git clone https://github.com/arwahyu01/main-master.git {nama-proyek-anda}
$ cd main-master
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate --seed
$ php artisan serve # atau gunakan valet
```

## Fitur untuk Pengembang (MVC Builder):

Install paket ini ke proyek Laravel Anda

```bash
composer require arwp/mvc
```

#### Jangan lupa untuk mengatur konfigurasi, baca selengkapnya di [sini](https://github.com/arwahyu01/mvc-builder)

## Skrip Khusus

#### Untuk Datatables

* Gunakan skrip ini untuk mengirim banyak data ke 'datatable.blade.js'

- Hapus skrip lama dan ganti dengan skrip berikut:
- script lama : `<script src="{{ asset('js/'.$backend.'/'.$page->code.'/datatable.js') }}"></script>`
- script baru:

```html

<script type="application/javascript">
    fetch("{{ url('/js/'.$backend.'/'.$page->code.'/datatable.js') }}", {
        method: 'POST',
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({id: "{{ $id }}"})
    })
        .then(e => e.text())
        .then(r => {
            Function('"use strict";\n' + r)();
        }).catch(e => console.log(e));
</script>
```

* Gunakan `JSON.stringify({'id': "{{ $id }}",'id2': "{{ $id2 }}"})` untuk mengirim beberapa arguemen ke `datatable.blade.js`
* Gunakan `JSON.stringify({id: "{{ $id }}"})` untuk satu permintaan
* Tambahkan `$id` di file `datatable.blade.js` seperti ini:

```javascript
$('#datatable').DataTable({
    ajax: `{{ url(config('master.app.url.backend').'/'.$url.'/data?id='${id}') }}`,
});
```

Berikut contoh penjelasan yang bisa kamu gunakan dalam file `README.md` untuk menjelaskan mekanisme **sub-sub menu dinamis dengan ID induk** di Laravel:

---

## 📚 Sub-Sub Menu Dinamis (Dengan ID Induk)

Dalam implementasi sub-menu atau sub-sub menu yang membutuhkan hubungan dengan data induk (misalnya kategori, parent item, dsb), mekanisme berikut digunakan agar proses penambahan data (`create`) tetap mengetahui ID dari entitas induknya.

### 🔗 Alur Umum:

1. **Controller induk** meneruskan `id` data induk ke halaman sub-menu.
2. **View sub-menu (`index.blade.php`)** menampilkan tombol "Tambah" yang menyisipkan `id` ke URL.
3. **Controller sub-menu** mengambil `id` dari `Request` dan menggunakannya untuk menyiapkan halaman `create`.

### 🧩 Implementasi

#### 1. Kirimkan ID dari controller induk:

```php
return view('sub_menu.index', compact('id', 'page', 'user'));
```

#### 2. Sesuaikan tombol Tambah di `index.blade.php` pada sub-menu:

```blade
@if($user->create)
<button
    type="button"
    class="btn-action pull-right btn btn-success btn-sm"
    data-title="Tambah"
    data-id="{{ $id }}"
    data-url="{{ $page->url.'/create?id='.$id }}">
    <span class="fa fa-plus-circle"></span> Tambah
</button>
@endif
```

> ⚠️ **Catatan:** Atribut `data-action="create"` tidak lagi digunakan, jadi hapus jika masih ada.

#### 3. Tangani ID di controller sub-menu:

```php
public function create(Request $request)
{
    $id = $request->input('id');
    $page = Page::where('id', $id)->first();
    $user = Auth::user();
    return view($page->url.'.create', compact('page', 'user'));
}
```

#### 4. Sertakan `id` di form `create.blade.php`:

```blade
<input type="hidden" name="parent_id" value="{{ request('id') }}">
```

---

Dengan pendekatan ini, halaman sub-menu tetap mengetahui data induknya dan hubungan antar data dapat terjaga secara dinamis.

---


## Lisensi

* Paket MVC Builder: Paket ini tidak memiliki lisensi, dan bebas digunakan untuk proyek pribadi.
* Template Eduadmin: Template Eduadmin yang digunakan untuk tampilan dalam paket ini tidak gratis. Anda perlu membeli lisensinya untuk penggunaan komersial dari [sini](https://themeforest.net/item/eduadmin-responsive-bootstrap-admin-template-dashboard/29365133).
* Hak Cipta dan Atribusi: Mohon hormati hak cipta dari paket dan kontributornya. Jangan menghapus kredit yang ada di dalam file.

#### Semoga Main Master ini mempercepat dan mempermudah proses pengembangan proyek Anda. Jika Anda memiliki pertanyaan atau saran, jangan ragu untuk menghubungi saya di [Insta](https://www.instagram.com/arwahyupradana/) atau [LinkedIn](https://www.linkedin.com/in/arwahyupradana/).

```
