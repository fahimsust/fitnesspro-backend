<?php
namespace Support\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class DataExport implements FromCollection
{
    protected $header;
    protected $totalData;
    protected $data;
    protected $total;

    public function __construct($header, $totalData, $data, $total)
    {
        $this->header = $header;
        $this->totalData = $totalData;
        $this->data = $data;
        $this->total = $total;
    }

    public function collection()
    {
        $collection = new Collection();

        $collection->push($this->header);
        $collection->push(['']); // blank row
        $collection->push($this->totalData);
        $collection->push(['']); // blank row

        foreach ($this->data as $row) {
            $collection->push($row);
        }

        $collection->push($this->total);

        return $collection;
    }
}
