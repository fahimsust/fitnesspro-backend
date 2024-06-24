<?php

namespace Database\Seeders;

use Domain\Locales\Models\Region;

class CountryRegionSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->bulkCreate(
            Region::class,
            ['id', 'country_id', 'name', 'rank'],
            [
                [1, 517, 'Negril (MBJ)', 1],
                [2, 517, 'Ocho Rios (MBJ)', 2],
                [3, 517, 'Montego Bay (MBJ)', 3],
                [4, 517, 'Rose Hall (MBJ)', 4],
                [5, 517, 'South Shore (MBJ)', 5],
                [6, 517, 'Runaway Bay (MBJ)', 6],
                [7, 517, 'Falmouth (MBJ)', 7],
                [8, 592, 'Cancun (CUN)', 1],
                [9, 592, 'Riviera Maya (CUN)', 2],
                [11, 596, 'Punta Cana (PUJ)', 1],
                [12, 592, 'Tulum (CUN)', 3],
                [13, 592, 'Puerto Morelos (CUN)', 4],
                [14, 592, 'Cozumel  (CUN or CZM)', 5],
                [15, 592, 'Puerto Vallarta (PVR)', 0],
                [16, 592, 'Xtapa (ZIH)', 0],
                [17, 592, 'Hualtulco (HUX)', 0],
                [18, 592, 'Los Cabos', 0],
                [19, 596, 'Cap Cana (PUJ)', 0],
                [20, 596, 'LaRomana (LRM or PUJ)', 0],
                [21, 477, 'Nassau (NAS)', 0],
                [22, 477, 'Exuma (GGT)', 0],
                [23, 495, 'Cayo (BZE)', 0],
                [24, 636, 'Willemstad', 0],
                [25, 516, 'BVI', 0],
                [26, 637, 'Sint Maarten', 0],
                [27, 584, 'Providenciales', 0],
                [28, 536, 'Nevis', 0],
                [29, 573, 'Guanacaste', 0],
                [30, 453, 'British West Indies', 0],
                [31, 605, 'El Cuco', 0],
                [32, 539, 'Gros Islet', 0],
                [33, 458, 'Arraijan District', 0],
                [34, 477, 'Western Great Bahama Bank', 0],
                [35, 1, 'Las Vegas, Nevada', 0],
                [36, 463, "St. George's", 0],
                [38, 495, 'Placencia (BZE-PLJ)', 0],
                [39, 487, 'Tela', 0],
                [40, 486, 'Saint Lawrence Gap', 0],
                [41, 596, 'Puerto Plata (POP)', 0],
                [42, 1, 'Port St. Lucie, Florida', 0],
            ]
        );
    }
}
