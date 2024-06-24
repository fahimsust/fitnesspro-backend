<?php

namespace Database\Seeders;

use Domain\Messaging\Models\MessageTemplate;
use Illuminate\Database\Seeder;

class MessageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultTemplates = [
            //getting seeded elswhere?  throwing error when included with migrate:fresh --seed
            [1,1, 'Order Complete (Auto)', 'Your {SITE_NAME} order has been received', 'Thank you for your order, {CUSTOMER_FIRST_NAME}!\r\n\r\n{ORDER_SUMMARY}', '&lt;p&gt;\r\n	&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;\r\n	Thank you for your order,&amp;nbsp;{CUSTOMER_FIRST_NAME}!&lt;/p&gt;\r\n&lt;p&gt;\r\n	{ORDER_SUMMARY_HTML}&lt;/p&gt;\r\n&lt;p&gt;\r\n	&amp;nbsp;&lt;/p&gt;', 'Auto sent on all new orders'],
            [2,2, 'Affiliate - Forgot Password', 'Affiliate Login Info for {SITE_NAME}', 'Dear {AFF_NAME}:\r\n\r\nYour affiliate password is {AFF_PASS}.  You can login to your affiliate account at {SITE_URL}affiliates.', '&lt;p&gt;\r\n	Dear {AFF_NAME}:&lt;/p&gt;\r\n&lt;p&gt;\r\n	Your affiliate password is&amp;nbsp;&lt;strong&gt;{AFF_PASS}&lt;/strong&gt;. &amp;nbsp;You can login to your affiliate account at {SITE_URL}affiliates.&lt;/p&gt;', 'Sends forgotten password to affiliate when they request while logged in'],
            [3,3, 'New Order Email to Drop Shipper', 'New Dropship Order from {SITE_NAME}', 'Account No.: {DISTRIBUTOR_ACCOUNT_NO}\r\n\r\nBelow are the details for this new order from {SITE_NAME} - Shipment ID {SHIPMENT_ID}:\r\n\r\n{ORDER_PRODUCTS_LIST}\r\n\r\nPlease ship to the following address using {SHIPPING_METHOD_NAME}:\r\n\r\n{SHIP_FIRST_NAME} {SHIP_LAST_NAME}\r\n{SHIP_ADDRESS}\r\n{SHIP_CITY}, {SHIP_STATE} {SHIP_ZIP}\r\n{SHIP_COUNTRY}', '&lt;p&gt;\r\n	Account No.: {DISTRIBUTOR_ACCOUNT_NO}&lt;/p&gt;\r\n&lt;p&gt;\r\n	Below are the details for this new order from {SITE_NAME} - Shipment ID {SHIPMENT_ID}:&lt;/p&gt;\r\n&lt;p&gt;\r\n	{ORDER_PRODUCTS_HTML_LIST}&lt;/p&gt;\r\n&lt;p&gt;\r\n	Please ship to the following address using {SHIPPING_METHOD_NAME}:&lt;/p&gt;\r\n&lt;p&gt;\r\n	{SHIP_FIRST_NAME} {SHIP_LAST_NAME}&lt;br /&gt;\r\n	{SHIP_ADDRESS_HTML}&lt;br /&gt;\r\n	{SHIP_CITY}, {SHIP_STATE} {SHIP_ZIP}&lt;br /&gt;\r\n	{SHIP_COUNTRY}&lt;/p&gt;', 'Email sent to dropshipper to process new shipment'],
            [4,6, 'Customer Account - Forgot Password', '{SITE_NAME} Password Reset', 'Dear {ACCOUNT_FIRST_NAME},\r\n\r\nYour {SITE_NAME} account password has been reset. Your new password is {NEW_PASSWORD}.\r\n\r\nYou can now login to your account using your email address and new password.', '&lt;p&gt;\r\n	Dear {ACCOUNT_FIRST_NAME},&lt;/p&gt;\r\n&lt;div&gt;\r\n	&lt;p&gt;\r\n		Your {SITE_NAME} account password has been reset. Your new password is&amp;nbsp;&lt;strong&gt;{NEW_PASSWORD}&lt;/strong&gt;.&lt;/p&gt;\r\n	&lt;p&gt;\r\n		You can now login to your account using your email address and new password.&lt;/p&gt;\r\n&lt;/div&gt;', 'from front end, customer can request password'],
            [5,'giftcard_info', 'Gift Card Information', 'Your Gift Card Information', 'Here is your gift card information:\r\n\r\nGift Card Code: {GIFTCARD_CODE}\r\nGift Card Expiration: {GIFTCARD_EXP}', '&lt;p&gt;Here is your gift card information:&lt;/p&gt;\r\n&lt;p&gt;Gift Card Code:&amp;nbsp;{GIFTCARD_CODE}&lt;br /&gt; Gift Card Expiration:&amp;nbsp;{GIFTCARD_EXP}&lt;/p&gt;', ''],
            [6,'forgot_username', 'Customer Account - Forgot Username', 'Your {SITE_NAME} Account Username', 'Dear {ACCOUNT_FIRST_NAME},\r\n\r\nYour {SITE_NAME} account username is listed below.  You can login to your account by clicking (or copy and pasting) this link:\r\n\r\n{ACCOUNT_LOGIN_LINK}\r\n\r\nYour username is {ACCOUNT_USER}.\r\n\r\nDo Not Copy and Paste - Manually type userid and password into login fields.\r\n\r\nYou can now login to your account using your userid and password.', '&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;table style=&quot;height: 703px;&quot; border=&quot;4&quot; width=&quot;629&quot; cellpadding=&quot;5&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td&gt;\r\n&lt;p style=&quot;text-align: left;&quot;&gt;Dear {ACCOUNT_FIRST_NAME},&lt;br /&gt; &amp;nbsp;&lt;/p&gt;\r\n&lt;div&gt;\r\n&lt;p&gt;Your {SITE_NAME} account&amp;nbsp;username is listed below. &amp;nbsp;You can login to your account by clicking (or copy and pasting) the following link. From that link you will be prompted to change your password. Once doing this you can access the site via any menu tab.&lt;/p&gt;\r\n&lt;p&gt;{ACCOUNT_LOGIN_LINK_HTML}&lt;/p&gt;\r\n&lt;p&gt;Your username is &lt;strong&gt;{ACCOUNT_USER}&lt;/strong&gt;', ''],
            [7,'registration_recover', 'Customer Account - Recover Registration', 'Recover Registration', 'Dear {ACCOUNT_FIRST_NAME},\r\n\r\nYour {SITE_NAME} account username is listed below.  You can recover your registration by clicking (or copy and pasting) this link:\r\n\r\n{REGISTRATION_REOVERY_LINK_HTML}.', '&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;table style=&quot;height: 703px;&quot; border=&quot;4&quot; width=&quot;629&quot; cellpadding=&quot;5&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td&gt;\r\n&lt;p style=&quot;text-align: left;&quot;&gt;Dear {ACCOUNT_FIRST_NAME},&lt;br /&gt; &amp;nbsp;&lt;/p&gt;\r\n&lt;div&gt;\r\n&lt;p&gt;You can recover your registration by clicking (or copy and pasting) the following link. .&lt;/p&gt;\r\n&lt;p&gt;{ACCOUNT_LOGIN_LINK_HTML}&lt;/p&gt;', ''],
        ];

        $columns = ['id','system_id', 'name', 'subject', 'alt_body', 'html_body', 'note'];

        foreach ($defaultTemplates as $template) {
            MessageTemplate::create(array_combine($columns, $template));
        }
    }
}
