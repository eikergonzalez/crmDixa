<?php
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use app\Models\inmueble;

class InformeExport implements FromCollection, WithHeadings
{
    protected $filtro;

    public function __construct($filtro)
    {
        $this->filtro = $filtro;
    }

    public function collection()
    {
        $datos = inmueble::query();
        if ($this->filtro) {
            $datos->where('campo', $this->filtro);
        }
        return $datos->get();
    }

    public function headings(): array
    {
        return [
            'Campo 1',
            'Campo 2',
        ];
    }
}