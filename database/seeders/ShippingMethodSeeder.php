<?php

namespace Database\Seeders;

use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
//            [1,'FedEx Ground','','FEDEX_GROUND','FDXG',1,0.00,1,2,1,0.00,0.00,0],
//            [2,'FedEx 2nd Day Air (US Only)','','FEDEX_2_DAY','FDXE',1,9.98,1,0,1,0.00,0.00,0],
//            [3,'FedEx Overnight (US Only)','','STANDARD_OVERNIGHT','FDXE',1,19.98,1,0,1,0.00,0.00,0],
//            [12,'FedEx First Overnight','','FIRST_OVERNIGHT','FDXE',1,29.98,0,0,1,0.00,0.00,0],
//            [13,'FedEx Express Saver','','FEDEX_EXPRESS_SAVER','FDXE',1,0.00,1,0,1,0.00,0.00,0],
//            [14,'FedEx Home Delivery','','GROUND_HOME_DELIVERY','FDXG',1,29.98,1,1,1,0.00,0.00,0],
//            [15,'FedEx Priority Overnight','','PRIORITY_OVERNIGHT','FDXE',1,24.98,1,0,1,0.00,0.00,0],
//            [16,'FedEx Saturday Delivery','','1266','',0,35.95,0,0,1,0.00,0.00,0],
//            [17,'FedEx International Priority','','INTERNATIONAL_PRIORITY','FDXG',1,0.00,0,0,1,0.00,0.00,0],
//            [18,'FedEx International Economy','','INTERNATIONAL_ECONOMY','FDXG',1,0.00,0,0,1,0.00,0.00,0],
//            [19,'FedEx International First','','INTERNATIONAL_FIRST','FDXG',1,0.00,0,2,1,0.00,0.00,1],
//            [20,'USPS Priority Mail','','USPS1','PRIORITY',1,0.00,0,0,3,0.00,0.00,0],
//            [21,'USPS First Class','','USPS0','FIRST CLAS',1,0.00,0,0,3,0.00,0.00,0],
//            [22,'USPS Parcel Post','','USPS4','PARCEL',1,0.00,0,0,3,0.00,0.00,0],
//            [24,'USPS Media Mail','','USPS6','MEDIA',1,0.00,0,0,3,0.00,0.00,0],
//            [25,'USPS Library Mail','','USPS7','LIBRARY',1,0.00,0,0,3,0.00,0.00,0],
//            [26,'USPS Express Mail','','USPS3','EXPRESS',1,0.00,0,0,3,0.00,0.00,0],
            [30,'UPS Next Day Air','','01','',1,0.00,0,0,2,0.00,0.00,0],
            [31,'UPS 2nd Day Air','','02','',1,0.00,0,0,2,0.00,0.00,0],
            [32,'UPS Ground','','03','',1,0.00,0,0,2,0.00,0.00,0],
            [33,'UPS Wordwide Express','','07','',1,0.00,0,0,2,0.00,0.00,0],
            [34,'UPS Worldwide Expedited','','08','',1,0.00,0,0,2,0.00,0.00,0],
            [35,'UPS Standard','','11','',1,0.00,0,0,2,0.00,0.00,0],
            [36,'UPS 3 Day Select','','12','',1,0.00,0,0,2,0.00,0.00,0],
            [37,'UPS Next Day Air Saver','','13','',1,0.00,0,0,2,0.00,0.00,0],
            [38,'UPS Next Day Air Early A.M.','','14','',1,0.00,0,2,2,0.00,0.00,0],
            [43,'Pick-up at Store','','pickup','pickup',1,0.00,0,0,5,0.00,0.00,0],
//            [44,'StarTrack 1KG Nationwide','StarTrack 1KG Nationwide','1KN','1KN',0,0.00,0,0,4,1.00,0.00,0],
//            [45,'StarTrack 1KG Overnight','StarTrack 1KG Overnight','1KO','1KO',0,0.00,0,0,4,1.00,0.00,0],
//            [46,'StarTrack 3KG Nationwide','StarTrack 3KG Nationwide','3KN','3KN',0,0.00,0,0,4,3.00,0.00,0],
//            [47,'StarTrack 3KG Overnight','StarTrack 3KG Overnight','3KO','3KO',0,0.00,0,0,4,3.00,0.00,0],
//            [48,'StarTrack 5KG Nationwide','StarTrack 5KG Nationwide','5KN','5KN',0,0.00,0,0,4,5.00,0.00,0],
//            [49,'StarTrack 5KG Overnight','StarTrack 5KG Overnight','5KO','5KO',0,0.00,0,0,4,5.00,0.00,0],
//            [50,'StarTrack Road Express','StarTrack Road Express','EXP','EXP',0,0.00,0,0,4,0.00,0.00,0],
//            [51,'StarTrack Home Delivery AM','StarTrack Home Delivery AM','HDA','HDA',0,0.00,0,0,4,0.00,0.00,0],
//            [52,'StarTrack Home Delivery Express','StarTrack Home Delivery Express','HDX','HDX',0,0.00,0,0,4,0.00,0.00,0],
//            [53,'StarTrack International Bulk Air','StarTrack International Bulk Air','IBF','IBF',0,0.00,0,0,4,0.00,0.00,1],
//            [54,'StarTrack International Express Freight','StarTrack International Express Freight','ITL','ITL',0,0.00,0,0,4,0.00,0.00,1],
//            [55,'StarTrack Overnight','StarTrack Overnight','OVR','OVR',0,0.00,0,0,4,0.00,0.00,0],
//            [56,'StarTrack Priority Air Service','StarTrack Priority Air Service','PAC','PAC',0,0.00,0,0,4,0.00,0.00,0],
//            [57,'Standard Shipping','Standard Shipping','Standard','Standard',1,0.00,0,0,5,0.00,0.00,0],
//            [58,'Expedited Shipping','Expedited Shipping','Expedited','Expedited',1,0.00,1,0,5,0.00,0.00,0],
//            [59,'International Standard','International Standard','Intl Standard','Intl Std',1,0.00,0,0,5,0.00,0.00,1],
//            [60,'International Expedited','International Expedited','International Expedited','Intl Exp',1,0.00,0,0,5,0.00,0.00,1],
//            [61,'USPS International - Global Express','USPS Intl. Global Express','USPSIntl4','USPSI_GEXP',0,0.00,0,0,3,0.00,0.00,1],
//            [62,'USPS International - Express Mail','USPS Intl. Express Mail','USPSIntl1','USPSI_EXP',0,0.00,0,0,3,0.00,0.00,1],
//            [63,'USPS International - Priority Mail','USPS Intl. Priority Mail','USPSIntl2','USPSI_PM',0,0.00,0,0,3,0.00,0.00,1],
//            [64,'USPS via Endicia - Priority Express','USPS Priority Express','EndiciaPriorityExpress','PriorityExpress',1,0.00,0,0,6,70.00,0.00,0],
//            [65,'USPS via Endicia - First Class','USPS First Class','EndiciaFirst','First',1,0.00,0,0,6,0.81,0.00,0],
//            [66,'USPS via Endicia - Library Mail','USPS Library Mail','EndiciaLibraryMail','LibraryMail',1,0.00,0,0,6,70.00,0.00,0],
//            [67,'USPS via Endicia - Media Mail','USPS Media Mail','EndiciaMediaMail','MediaMail',1,0.00,0,0,6,70.00,0.00,0],
//            [68,'USPS via Endicia - Standard Post','USPS Standard Post','EndiciaStandardPost','StandardPost',1,0.00,0,0,6,70.00,0.00,0],
//            [69,'USPS via Endicia - Parcel Select','USPS Parcel Select','EndiciaParcelSelect','ParcelSelect',1,0.00,0,0,6,70.00,0.00,0],
//            [70,'USPS via Endicia - Priority','USPS Priority','EndiciaPriority','Priority',1,0.00,0,0,6,70.00,0.00,0],
//            [71,'USPS via Endicia - Critical Mail','USPS Critical','EndiciaCriticalMail','CriticalMail',0,0.00,0,0,6,0.00,0.00,0],
//            [72,'USPS via Endicia - Priority Mail Express International','USPS Priority Mail Express International','EndiciaExpressMailInternational','ExpressMailInternational',1,0.00,0,0,6,70.00,0.00,1],
//            [73,'USPS via Endicia - First Class Mail International','USPS First Class Mail International','EndiciaFirstClassMailInternational','FirstClassMailInternational',1,0.00,0,0,6,0.81,0.00,1],
//            [74,'USPS via Endicia - First Class Package International Service','USPS First Class Package International','EndiciaFirstClassPackageInternationalService','FirstClassPackageInternationalService',1,0.00,0,0,6,0.00,0.00,1],
//            [75,'USPS via Endicia - Priority Mail International','USPS Priority Mail International','EndiciaPriorityMailInternational','PriorityMailInternational',1,0.00,0,0,6,70.00,0.00,1],
//            [76,'USPS via Endicia - Global Express Guaranteed','USPS Global Express Guaranteed','EndiciaGXG','GXG',1,0.00,0,0,6,0.00,0.00,0],
//            [77,'Freight - Domestic','Freight - Domestic','Freight Domestic','Freight Domestic',1,0.00,25,0,5,0.00,150.00,0],
//            [78,'Freight - International','Freight - International','Freight Intl','Freight Intl',1,0.00,30,0,5,0.00,150.00,0],
//            [79,'CanadaPost Expedited Parcel','','CanadaPostDOM.EP','DOM.EP',1,0.00,5,0,7,0.00,0.00,1],
//            [80,'CanadaPost Library Books','','CanadaPostDOM.LIB','DOM.LIB',1,0.00,10,0,7,0.00,0.00,0],
//            [81,'CanadaPost Priority','','CanadaPostDOM.PC','DOM.PC',1,0.00,15,0,7,0.00,0.00,0],
//            [82,'CanadaPost Regular Parcel','','CanadaPostDOM.RP','DOM.RP',1,0.00,20,0,7,0.00,0.00,0],
//            [83,'CanadaPost Xpresspost','','CanadaPostDOM.XP','DOM.XP',1,0.00,22,0,7,0.00,0.00,0],
//            [84,'CanadaPost Xpresspost Certified','','CanadaPostDOM.XP.CERT','DOM.XP.CERT',1,0.00,24,0,7,0.00,0.00,0],
//            [85,'CanadaPost International Parcel Air','','CanadaPostINT.IP.AIR','INT.IP.AIR',1,0.00,26,0,7,0.00,0.00,0],
//            [86,'CanadaPost International Parcel Surface','','CanadaPostINT.IP.SURF','INT.IP.SURF',1,0.00,28,0,7,0.00,0.00,1],
//            [87,'CanadaPost Prioirity Worldwide Envelope Intl','','CanadaPostINT.PW.ENV','INT.PW.ENV',1,0.00,30,0,7,0.00,0.00,1],
//            [88,'CanadaPost Priority Worldwide Pak Intl','','CanadaPostINT.PW.PAK','INT.PW.PAK',1,0.00,32,0,7,0.00,0.00,0],
//            [89,'CanadaPost Priority Worldwide Parcel Intl','','CanadaPostINT.PW.PARCEL','INT.PW.PARCEL',1,0.00,34,0,7,0.00,0.00,0],
//            [90,'CanadaPost Small Packet International Air','','CanadaPostINT.SP.AIR','INT.SP.AIR',1,0.00,36,0,7,0.00,0.00,0],
//            [91,'CanadaPost Small Packet International Surface','','CanadaPostINT.SP.SURF','INT.SP.SURF',1,0.00,36,0,7,0.00,0.00,1],
//            [92,'CanadaPost Tracked Packet Intl','','CanadaPostINT.TP','INT.TP',1,0.00,38,0,7,0.00,0.00,1],
//            [93,'CanadaPost Xpresspost Intl','','CanadaPostINT.XP','INT.XP',1,0.00,40,0,7,0.00,0.00,0],
//            [94,'CanadaPost Expedited Parcel USA','','CanadaPostUSA.EP','USA.EP',1,0.00,42,0,7,0.00,0.00,0],
//            [95,'CanadaPost Priority Worldwide Envelope USA','','CanadaPostUSA.PW.ENV','USA.PW.ENV',1,0.00,44,0,7,0.00,0.00,0],
//            [96,'CanadaPost Priority Worldwide Pak USA','','CanadaPostUSA.PW.PAK','USA.PW.PAK',1,0.00,44,0,7,0.00,0.00,0],
//            [97,'CanadaPost Priority Worldwide Parcel USA','','CanadaPostUSA.PW.PARCEL','USA.PW.PARCEL',1,0.00,46,0,7,0.00,0.00,0],
//            [98,'CanadaPost Small Packet USA Air','','CanadaPostUSA.SP.AIR','USA.SP.AIR',1,0.00,48,0,7,0.00,0.00,0],
//            [99,'CanadaPost Tracked Packet USA','','CanadaPostUSA.TP','USA.TP',1,0.00,50,0,7,0.00,0.00,0],
//            [100,'CanadaPost Tracked Packet USA LVM','','CanadaPostUSA.TP.LVM','USA.TP.LVM',1,0.00,52,0,7,0.00,0.00,0],
//            [101,'CanadaPost Xpresspost USA','','CanadaPostUSA.XP','USA.XP',1,0.00,54,0,7,0.00,0.00,0],
//            [103,'Overnight Shipping','Overnight Shipping','Overnight','Overnight',1,0.00,5,0,5,0.00,0.00,0]
        ];
        $fields = ['id','name','display','refname','carriercode','status','price','rank','ships_residential','carrier_id','weight_limit','weight_min','is_international'];

        foreach ($rows as $row) {
            ShippingMethod::create(array_combine($fields, $row));
        }
    }
}
