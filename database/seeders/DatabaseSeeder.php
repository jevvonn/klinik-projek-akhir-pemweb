<?php

namespace Database\Seeders;

use App\Models\ClinicRequest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Obat;
use App\Models\StokFarmasi;
use App\Models\Supplier;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = bcrypt('password');

        User::create([
            'name' => 'Admin Klinik',
            'email' => 'adminklinik@gmail.com',
            'password' => $password,
            'role' => 'ADMIN_KLINIK',
        ]);

        User::create([
            'name' => 'Admin Farmasi',
            'email' => 'adminfarmasi@gmail.com',
            'password' => $password,
            'role' => 'ADMIN_FARMASI',
        ]);

        User::create([
            'name' => 'Admin Gudang',
            'email' => 'admingudang@gmail.com',
            'password' => $password,
            'role' => 'ADMIN_GUDANG',
        ]);

        User::create([
            'name' => 'Admin Supplier',
            'email' => 'adminsupplier@gmail.com',
            'password' => $password,
            'role' => 'ADMIN_SUPPLIER',
        ]);

        ClinicRequest::create([
            'nama' => 'Han So Hee',
            'no_hp' => '081234567890',
            'umur' => '30',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Merdeka No. 1, Jakarta',
            'diagnosa' => 'Demam dan Batuk',
            'dokter' => 'Dr. Siti Aminah',
            'resep_obat' => 'Paracetamol 500mg, 3x sehari setelah makan',
            'status' => 'pending',
        ]);

        ClinicRequest::create([
            'nama' => 'Suzy Bae',
            'no_hp' => '089876543210',
            'umur' => '25',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Sudirman No. 10, Bandung',
            'diagnosa' => 'Sakit Kepala dan Mual',
            'dokter' => 'Dr. Budi Santoso',
            'resep_obat' => 'Ibuprofen 400mg, 2x sehari setelah makan',
            'status' => 'pending',
        ]);

        ClinicRequest::create([
            'nama' => 'Go Youn Jung',
            'no_hp' => '082112345678',
            'umur' => '40',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Thamrin No. 5, Surabaya',
            'diagnosa' => 'Nyeri Otot dan Kram',
            'dokter' => 'Dr. Andi Wijaya',
            'resep_obat' => 'Muscle Relaxant 50mg, 2x sehari setelah makan',
            'status' => 'pending',
        ]);

        // SEED SUPPLIERS
        $suppliers = [
            ['nama' => 'PT Kimia Farma', 'email' => 'contact@kimiafarma.com', 'telp' => '021-123456', 'alamat' => 'Jakarta Pusat'],
            ['nama' => 'PT Kalbe Farma', 'email' => 'info@kalbe.com', 'telp' => '021-789012', 'alamat' => 'Jakarta Timur'],
            ['nama' => 'PT Dexa Medica', 'email' => 'sales@dexa.com', 'telp' => '021-345678', 'alamat' => 'Palembang'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Get supplier IDs for seeding obat
        $supplierIds = Supplier::pluck('id')->toArray();

        Obat::insert([
            [
                'kode_obat' => 'MRX',
                'nama_obat' => 'Muscle Relaxant',
                'bentuk' => 'Kapsul',
                'jumlah' => 20000,
                'kategori' => 'Vitamin',
                'harga_jual' => 9000,
                'supplier_id' => $supplierIds[0], // PT Kimia Farma
                'stok_gudang' => 15000,
                'status_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_obat' => 'PRC',
                'nama_obat' => 'Paracetamol',
                'bentuk' => 'Kapsul',
                'jumlah' => 700,
                'kategori' => 'Analgesik',
                'harga_jual' => 5000,
                'supplier_id' => $supplierIds[1], // PT Kalbe Farma
                'stok_gudang' => 500,
                'status_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_obat' => 'IBP',
                'nama_obat' => 'Ibuprofen',
                'bentuk' => 'Kapsul',
                'jumlah' => 8000,
                'kategori' => 'NSAID',
                'harga_jual' => 7000,
                'supplier_id' => $supplierIds[2], // PT Dexa Medica
                'stok_gudang' => 6000,
                'status_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $obatList = Obat::all();

        foreach ($obatList as $obat) {
            StokFarmasi::create([
                'obat_id' => $obat->id,
                'jumlah' => $obat->jumlah ?? 0,
                'stok_minimum' => 100,
            ]);
        }
    }
}
