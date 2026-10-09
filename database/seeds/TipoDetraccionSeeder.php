<?php

use Illuminate\Database\Seeder;

class TipoDetraccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_detraccions')->insert([
            'codigo' => "001",
            'descripcion' => "Azúcar",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "003",
            'descripcion' => "Alcohol etílico",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "004",
            'descripcion' => "Recursos hidrobiológicos",
            'tasa' => "4"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "005",
            'descripcion' => "Maíz amarillo duro",
            'tasa' => "4"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "006",
            'descripcion' => "Algodón",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "007",
            'descripcion' => "Caña de azúcar",
            'tasa' => "4"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "008",
            'descripcion' => "Madera",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "009",
            'descripcion' => "Arena y piedra",
            'tasa' => "15"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "010",
            'descripcion' => "Residuos, subproductos, desechos, recortes y desperdicios",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "011",
            'descripcion' => "Bienes del inciso A) del Apéndice de la Ley del IGV",
            'tasa' => "4"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "012",
            'descripcion' => "Intermediación laboral y tercerización",
            'tasa' => "4"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "013",
            'descripcion' => "Animales Vivo",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "014",
            'descripcion' => "Carnes y despojos comestibles",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "015",
            'descripcion' => "Abonos, cueros y pieles de origen animal",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "016",
            'descripcion' => "Aceite de pescado",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "017",
            'descripcion' => "Harina, polvo, 'pellets' de pescado, crustáceos, moluscos y demás invertebrados acuáticos",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "018",
            'descripcion' => "Embarcaciones Pesqueras",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "019",
            'descripcion' => "Arrendamiento de bienes muebles",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "020",
            'descripcion' => "Mantenimiento y reparción de bienes muebles",
            'tasa' => "4"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "021",
            'descripcion' => "Movimiento de carga",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "022",
            'descripcion' => "Otros servicios empresariales",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "023",
            'descripcion' => "Leche",
            'tasa' => "1.5"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "024",
            'descripcion' => "Comisión mercantil",
            'tasa' => "1.5"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "025",
            'descripcion' => "Fabricación de bienes por encargo",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "026",
            'descripcion' => "Servicio de transporte de personas",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "029",
            'descripcion' => "Algodón en rama sin desmontar",
            'tasa' => "4"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "030",
            'descripcion' => "Contratos de construcción",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "031",
            'descripcion' => "Oro gravado con el IGV",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "032",
            'descripcion' => "Páprika y otros frutos de los géneros capsicum o pimienta",
            'tasa' => "4"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "033",
            'descripcion' => "Espárragos",
            'tasa' => "4"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "034",
            'descripcion' => "Minerales metálicos no auriferos",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "035",
            'descripcion' => "Bienes exonerados del IGV",
            'tasa' => "4"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "036",
            'descripcion' => "Oro y demás minerales metálicos exonerados del IGV",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "037",
            'descripcion' => "Demás servicios gravados con el IGV",
            'tasa' => "15"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "039",
            'descripcion' => "Minerales no metálicos",
            'tasa' => "10"
        ]);
        DB::table('tipo_detraccions')->insert([
            'codigo' => "040",
            'descripcion' => "Bien inmueble gravado con IGV",
            'tasa' => "4"
        ]);
    }
}
