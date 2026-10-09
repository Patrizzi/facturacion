<?php

use Illuminate\Database\Seeder;

class MedioPagoDetraccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "001",
            'descripcion' => "Depósito en cuenta",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "002",
            'descripcion' => "Giro",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "003",
            'descripcion' => "Transferenca de fondos",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "004",
            'descripcion' => "Orden de pago",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "005",
            'descripcion' => "Tarjeta de débito",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "006",
            'descripcion' => "Tarjeta de crédito emitida en el país por una empresa del sistema financiero",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "007",
            'descripcion' => "Cheques con la cláusula de  'no negociable', 'intransferibles', 'no a la orden', u otra equivalente, a que se refiere el inciso g) del artículo 5' de la ley",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "008",
            'descripcion' => "Efectivo, por operaciones en las que no existe obligación de utilizar medio de pago",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "009",
            'descripcion' => "Efectivo, en los demás casos",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "010",
            'descripcion' => "Medios de pago usados en comerci exterior",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "011",
            'descripcion' => "Documentos emitridos por la adpymes y las cooperativas de ahorro y crédito no autorizadas a captar depósitos del público ",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "012",
            'descripcion' => "Tarjeta de crédito emitida en el país o en el exterior por una empresa no perteneciente al sistema financiera, cuyo objeto principal sea la emisión y administración de tarjetas de crédito",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "013",
            'descripcion' => "Tarjetas de crédito emitidas en el exterior por empresas financieras no domiciladas",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "101",
            'descripcion' => "Transferencias - comercio exterior",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "102",
            'descripcion' => "Cheques bancarios - comercio exterior",
        ]);DB::table('medio_pago_detraccions')->insert([
            'codigo' => "103",
            'descripcion' => "Orden de pago simple - comercio simple",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "104",
            'descripcion' => "Orden de pago documentario - comercio exterior",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "105",
            'descripcion' => "Remesa simple - comercio exterior",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "106",
            'descripcion' => "Remesa documentaria - comercio exterior",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "107",
            'descripcion' => "Carta de crédito simple - comercio exterior",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "108",
            'descripcion' => "Carta de crédito documentario - comercio exterior",
        ]);
        DB::table('medio_pago_detraccions')->insert([
            'codigo' => "999",
            'descripcion' => "Otros medios de pago",
        ]);
    }
}
