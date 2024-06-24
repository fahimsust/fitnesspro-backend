<?php

namespace Domain\Messaging\Enums;

enum OrderMessageKeys: string
{
    case BILLING_ADDRESS_PRINTOUT = "billing_address_printout";
    case BILLING_ADDRESS_PRINTOUT_HTML = "billing_address_printout_html";
    case BILL_ADDRESS = "bill_address_full";
    case BILL_ADDRESS_HTML = "bill_address_full_html";
    case BILL_CITY = "bill_city";
    case BILL_COUNTRY = "bill_country_name";
    case BILL_FIRST_NAME = "bill_first_name";
    case BILL_LAST_NAME = "bill_last_name";
    case BILL_STATE = "bill_state_abbrev";
    case BILL_ZIP = "bill_postal_code";
    case CUSTOMER_FIRST_NAME = "customer_first_name";
    case CUSTOMER_LAST_NAME = "customer_last_name";
    case CUSTOMER_OR_BILLING_NAME = "customer_or_billing_name";
    case ORDER_ADDTL_DISCOUNT = "addtl_discount_display";
    case ORDER_ADDTL_DISCOUNT_HTML = "addtl_discount_display_html";
    case ORDER_ADDTL_FEE = "addtl_fee_display";
    case ORDER_ADDTL_FEE_HTML = "addtl_fee_display_html";
    case ORDER_COMMENTS = "comments";
    case ORDER_CREATED = "order_created";
    case ORDER_CREATED_PRETTY = "order_created_pretty";
    case ORDER_DISCOUNT_TOTAL = "discount_total_display";
    case ORDER_DISCOUNT_TOTAL_HTML = "discount_total_display_html";
    case ORDER_ID = "id";
    case ORDER_NO = "order_no";
    case ORDER_PRODUCTS_HTML_LIST = "products_list_html";
    case ORDER_PRODUCTS_LIST = "products_list";
    case ORDER_SHIPPING_TOTAL = "shipping_total_display";
    case ORDER_SUBTOTAL = "subtotal_display";
    case ORDER_SUMMARY = "order_summary_display";
    case ORDER_SUMMARY_HTML = "order_summary_display_html";
    case ORDER_TAX = "tax_total_display";
    case ORDER_TOTAL = "total_display";
    case PAYMENT_METHOD = "payment_method_name";
    case PAYMENT_METHOD_DISPLAY = "payment_method_display";
    case SHIPPING_ADDRESS_PRINTOUT = "shipping_address_printout";
    case SHIPPING_ADDRESS_PRINTOUT_HTML = "shipping_address_printout_html";
    case SHIP_ADDRESS = "ship_address_full";
    case SHIP_ADDRESS_HTML = "ship_address_full_html";
    case SHIP_CITY = "ship_city";
    case SHIP_COMPANY = "ship_company";
    case SHIP_COUNTRY = "ship_country_name";
    case SHIP_FIRST_NAME = "ship_first_name";
    case SHIP_LAST_NAME = "ship_last_name";
    case SHIP_STATE = "ship_state_abbrev";
    case SHIP_ZIP = "ship_postal_code";
}
