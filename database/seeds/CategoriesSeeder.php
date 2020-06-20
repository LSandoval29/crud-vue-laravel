<?php

use Illuminate\Database\Seeder;
use App\Categoria;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = new Categoria();
        $categoria->nombre = "Computadoras";
        $categoria->descripcion = "Laptops, de escritorio";
        $categoria->save();

        $categoria = new Categoria();
        $categoria->nombre = "Periféricos";
        $categoria->descripcion = "Mouse, teclados";
        $categoria->save();
    }
}
