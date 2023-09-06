<?php

namespace App\Exports;
use App\Models\ArticlesModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ArticlesExport implements FromCollection,WithHeadings
{
    protected $articles;

    public function __construct($articles)
    {
        $this->articles = $articles;
    }

    public function collection()
    {
        return $this->articles;
    }
    public function headings(): array
    {
        return [
            'SKU',
            'Modelo',
            'Categoría',
            'Costo',
            'Ventas',
            'Inventario Inicial',
            'Inventario Final',
            'Devoluciones',
            'Entradas',
            'Ajustes',
            'ST',
            
        ];
    }
}
