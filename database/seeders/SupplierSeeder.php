<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::factory()->create([
            'name' => "PT. SOLO MURNI (KIKY CREATIVE PRODUCT)",
            'address' => 'Jl. A. Yani No. 378. Solo 57143 Central Java, Indonesia',
            'contact' => "+62 (271) 714505",
        ]);
        Supplier::factory()->create([
            'name' => "PT. Sinar Mas Agro Resources and Technology Tbk",
            'address' => 'Jl. M.H. Thamrin No. 51, Jakarta 10350 Indonesia',
            'contact' => "+62 21 5033 8899",
        ]);
        Supplier::factory()->create([
            'name' => "PT Standardpen Industries",
            'address' => 'Jl.Cideng Timur No.50, Kel. Petojo Selatan, Kec. Gambir, Kota Adm. Jakarta Pusat, Prov. DKI Jakarta',
            'contact' => "linktr.ee/standardfriend",
        ]);
        Supplier::factory()->create([
            'name' => "UMKM Kerupuk Enak",
            'address' => 'Jl.SM Raja, Kec. Kebayoran Baru , Kota Jakarta Selatan, Prov. DKI Jakarta',
            'contact' => "+62 123 456789",
        ]);
    }
}
