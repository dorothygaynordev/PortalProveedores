<?php

namespace App\Exports;
use App\Models\ArticlesModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArticlesExport implements FromCollection
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
}
