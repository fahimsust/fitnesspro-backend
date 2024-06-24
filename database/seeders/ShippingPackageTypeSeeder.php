<?php

namespace Database\Seeders;

use Domain\Orders\Models\Shipping\ShippingPackageType;
use Illuminate\Database\Seeder;

class ShippingPackageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'Your Packaging',1,'YOUR_PACKAGING',1,2],
            [2,'FedEx Box',1,'FEDEX_BOX',0,2],
            [3,'FedEx Envelope',1,'FEDEX_ENVELOPE',0,2],
            [4,'FedEx Pak',1,'FEDEX_PAK',0,2],
            [5,'FedEx Tube',1,'FEDEX_TUBE',0,2],
            [6,'Individual Packages',1,'INDIVIDUAL_PACKAGES',0,2],
            [7,'Parcel',6,'Parcel',1,2],
            [8,'Large Parcel',6,'LargeParcel',0,2],
            [9,'Card',6,'Card',0,2],
            [10,'Letter',6,'Letter',0,2],
            [11,'Flat',6,'Flat',0,2],
            [12,'Irregular Parcel',6,'IrregularParcel',0,2],
            [13,'Flat Rate Envelope',6,'FlatRateEnvelope',0,2],
            [14,'Flat Rate Legal Envelope',6,'FlatRateLegelEnvelope',0,2],
            [15,'Flat Rate Padded Envelope',6,'FlatRatePaddedEnvelope',0,2],
            [16,'Flat Rate Gift Card Envelope',6,'FlatRateGiftCardEnvelope',0,2],
            [17,'Flat Rate Window Envelope',6,'FlatRateWindowEnvelope',0,2],
            [18,'Flat Rate Cardboard Envelope',6,'FlatRateCardboardEnvelope',0,2],
            [19,'Small Flat Rate Envelope',6,'SmallFlatRateEnvelope',0,2],
            [20,'Small Flat Rate Box',6,'SmallFlatRateBox',0,2],
            [21,'Medium Flat Rate Box',6,'MediumFlatRateBox',0,2],
            [22,'Large Flat Rate Box',6,'LargeFlatRateBox',0,2],
            [23,'DVD Flat Rate Box',6,'DVDFlatRateBox',0,2],
            [24,'Large Video Flat Rate Box',6,'LargeVideoFlatRateBox',0,2]
        ];
        $fields = ['id','name','carrier_id','carrier_reference','default','is_international'];

        foreach ($rows as $row) {
            ShippingPackageType::create(array_combine($fields, $row));
        }
    }
}
