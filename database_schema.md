# current facturacheck schema
## account
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|tenant_id|int unsigned|N||PRI|auto_increment|||
|fiscal_name|varchar(200)|N||||||
|trade_name|varchar(200)|Y||||||
|subdomain|varchar(100)|N||UNI||||
|status|tinyint unsigned|N|1|MUL|||1=TRIAL,2=ACTIVE,3=INACTIVE,4=CANCELED,5=CHARGEBACK|
|base_currency_id|char(3)|N||MUL||currency.currency_id (u:NA d:NA)||
|default_language_id|varchar(5)|Y||MUL||language.language_id (u:NA d:NA)||
|country_id|char(2)|Y||MUL||country.country_id (u:NA d:NA)||
|timezone|varchar(64)|N|UTC|||||
|nif_id_number|varchar(50)|Y|||||NIF ID|
|vat_id_number|varchar(50)|Y|||||VAT/Tax ID|
|account_settings|json|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
|created_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|updated_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|deleted_at|datetime|Y||||||
|deleted_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
## address
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|address_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|address|varchar(200)|N|||||Street Address|
|city|varchar(100)|Y||||||
|postal_code|varchar(20)|Y||||||
|country_id|char(2)|Y||MUL||country.country_id (u:NA d:NA)|ISO 3166-1 alpha-2 code|
|state_id|int unsigned|Y||MUL||state.state_id (u:NA d:NA)|State reference|
|company_name|varchar(200)|Y||||||
|contact_person|varchar(200)|Y||||||
|phone|varchar(50)|Y||||||
|email|varchar(200)|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
|created_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|updated_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|deleted_at|datetime|Y||||||
|deleted_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
## attachment
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|attachment_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|entity_type|varchar(50)|N||MUL||||
|entity_id|int unsigned|N||||||
|file_path|varchar(500)|N||||||
|filename|varchar(255)|N||||||
|mime_type|varchar(100)|Y||||||
|file_size|bigint unsigned|Y||||||
|storage|tinyint unsigned|N|1||||1=local,2=s3,3=gcs,4=azure|
|checksum|varchar(64)|Y||||||
|is_main|tinyint(1)|N|0|MUL|||Main Attachment|
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|created_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
## audit_log
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|id|bigint unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:C d:C)||
|user_id|int unsigned|Y||MUL||user.user_id (u:C d:SN)||
|event_type|enum('insert','update','delete','bulk','manual')|N||MUL|||Event Type|
|model_class|varchar(255)|N||MUL||||
|model_id|varchar(100)|Y||||||
|controller|varchar(255)|Y||MUL||||
|action|varchar(100)|Y||||||
|ip_address|varchar(45)|Y||||||
|user_agent|varchar(500)|Y||||||
|old_attributes|blob|Y||||||
|new_attributes|blob|Y||||||
|changed_attributes|text|Y||||||
|metadata|text|Y||||||
|created_at|int unsigned|N||MUL||||
## audit_log_archive
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|id|bigint unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||||
|user_id|int unsigned|Y||||||
|event_type|enum('insert','update','delete','bulk','manual')|N|||||Event Type|
|model_class|varchar(255)|N||||||
|model_id|varchar(100)|Y||||||
|controller|varchar(255)|Y||||||
|action|varchar(100)|Y||||||
|ip_address|varchar(45)|Y||||||
|user_agent|varchar(500)|Y||||||
|old_attributes|blob|Y||||||
|new_attributes|blob|Y||||||
|changed_attributes|text|Y||||||
|metadata|text|Y||||||
|created_at|int unsigned|N||MUL||||
|archived_at|int unsigned|N||MUL||||
## auth_assignment
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|tenant_id|int unsigned|N||PRI||||
|item_name|varchar(64)|N||PRI||auth_item.name (u:C d:C)||
|user_id|int unsigned|N||PRI||||
|created_at|bigint unsigned|Y||||||
|created_by|int unsigned|Y||||||
|updated_by|int unsigned|Y||||||
|version|int unsigned|N|1|||||
## auth_audit_log
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|id|bigint|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||||
|actor_user_id|int unsigned|Y||||||
|action|varchar(64)|N||||||
|item_name|varchar(64)|Y||||||
|item_type|smallint|Y||||||
|target_user_id|int unsigned|Y||||||
|data|json|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
## auth_item
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|name|varchar(64)|N||PRI||||
|type|smallint|N||MUL||||
|rule_name|varchar(64)|Y||MUL||auth_rule.name (u:C d:SN)||
|description|text|Y||||||
|data|blob|Y||||||
|created_at|bigint unsigned|Y||||||
|updated_at|bigint unsigned|Y||||||
|created_by|int unsigned|Y||||||
|updated_by|int unsigned|Y||||||
|version|int unsigned|N|1|||||
|is_system|tinyint(1)|N|0|||||
|display_name|varchar(128)|Y||||||
|group_name|varchar(64)|Y||MUL||||
|sort_order|int|Y||||||
## auth_item_child
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|parent|varchar(64)|N||PRI||auth_item.name (u:C d:C)||
|child|varchar(64)|N||PRI||auth_item.name (u:C d:C)||
## auth_rule
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|name|varchar(64)|N||PRI||||
|data|blob|Y||||||
|created_at|bigint unsigned|Y||||||
|updated_at|bigint unsigned|Y||||||
## contact
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|contact_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|type|tinyint unsigned|N|||||1=organization,2=person|
|role|tinyint unsigned|Y|||||NULL=unspecified,1=client,2=supplier,3=lead,4=debtor,5=creditor|
|contact_group_id|int unsigned|Y||||||
|parent_contact_id|int unsigned|Y||MUL||contact.contact_id (u:R d:SN)||
|nif_id_number|varchar(100)|Y|||||NIF ID|
|vat_id_number|varchar(50)|Y|||||VAT/Tax ID|
|code|varchar(100)|Y||||||
|fiscal_name|varchar(200)|N||||||
|trade_name|varchar(200)|Y||||||
|email|varchar(200)|Y||||||
|mobile|varchar(50)|Y||||||
|phone|varchar(50)|Y||||||
|website|varchar(255)|Y|||||Website URL|
|language_id|varchar(5)|Y||MUL||language.language_id (u:NA d:NA)|ISO 639-1 code with optional region|
|currency_id|char(3)|Y||MUL||currency.currency_id (u:NA d:NA)|ISO 4217 alpha-3 code|
|default_payment_method_id|int unsigned|Y||MUL||payment_method.payment_method_id (u:NA d:NA)||
|default_due_days|int|Y||||||
|default_payment_day|tinyint unsigned|Y||||||
|default_discount_percent|decimal(20,6)|Y|||||Default Discount Percent|
|internal_reference|varchar(100)|Y||||||
|show_trade_name_on_docs|tinyint(1)|N|0|||||
|show_country_on_docs|tinyint(1)|N|0|||||
|accumulate_model_347|tinyint(1)|N|0|||||
|sales_accounting_account_id|int unsigned|Y||||||
|purchase_accounting_account_id|int unsigned|Y||||||
|customer_accounting_account_id|int unsigned|Y||||||
|supplier_accounting_account_id|int unsigned|Y||||||
|default_sales_tax_id|int unsigned|Y||MUL||tax.tax_id (u:NA d:NA)||
|default_purchase_tax_id|int unsigned|Y||MUL||tax.tax_id (u:NA d:NA)||
|billing_address_id|int unsigned|Y||MUL||address.address_id (u:NA d:NA)||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
|created_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|updated_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|deleted_at|datetime|Y||MUL||||
|deleted_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
## contact_efactura
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|contact_efactura_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|contact_id|int unsigned|N||UNI||contact.contact_id (u:R d:C)||
|accounting_office_code|varchar(50)|Y||||||
|managing_body_code|varchar(50)|Y||||||
|processing_unit_code|varchar(50)|Y||||||
|proposing_body_code|varchar(50)|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
|created_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|updated_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
## country
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|country_id|char(2)|N||PRI|||ISO 3166-1 alpha-2 code|
|country_id_3|char(3)|N||UNI|||ISO 3166-1 alpha-3 code|
|country_id_numeric|smallint unsigned|Y||MUL|||ISO 3166-1 numeric code|
|name|varchar(100)|N||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
## currency
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|currency_id|char(3)|N||PRI|||ISO 4217 alpha-3 code|
|currency_id_numeric|smallint unsigned|Y||MUL|||ISO 4217 numeric code|
|name|varchar(50)|N||||||
|symbol|varchar(8)|Y||||||
|minor_units|tinyint unsigned|N|2||||Decimal places|
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
## custom_field
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|custom_field_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|entity_type|varchar(50)|N||||||
|field_key|varchar(150)|N||||||
|data_type|tinyint unsigned|N|||||1=string,2=int,3=decimal,4=date,5=datetime,6=bool,7=json|
|label|varchar(150)|Y||||||
|is_active|tinyint(1)|N|1|||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
## custom_field_value
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|custom_field_value_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|custom_field_id|int unsigned|N||MUL||custom_field.custom_field_id (u:R d:C)||
|entity_type|varchar(50)|N||||||
|entity_id|int unsigned|N||||||
|value_text|text|Y||||||
|value_number|decimal(20,6)|Y||||||
|value_date|date|Y||||||
|value_datetime|datetime|Y||||||
|value_bool|tinyint(1)|Y||||||
|value_json|json|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
## document
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|document_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|document_type_id|tinyint unsigned|N||MUL||document_type.document_type_id (u:NA d:NA)|1=invoice, 2=sales_receipt, 3=credit_note, 4=sales_order, 5=proforma, 6=waybill, 7=estimate, 8=purchase, 9=purchase_order, 10=purchase_refund|
|status|tinyint unsigned|N|1||||1=draft,2=approved,3=sent,4=partially_paid,5=paid,6=cancelled|
|document_series_id|int unsigned|Y||MUL||document_series.document_series_id (u:NA d:NA)||
|document_parent_id|int unsigned|Y||MUL||document.document_id (u:NA d:NA)||
|sequence_number|int unsigned|Y||||||
|document_number|varchar(100)|Y||||||
|issue_date|date|N||||||
|due_date|date|Y||||||
|description|varchar(500)|Y||||||
|notes|text|Y|||||Internal Notes|
|base_currency_id|char(3)|N||MUL||currency.currency_id (u:NA d:NA)||
|document_currency_id|char(3)|N||MUL||currency.currency_id (u:NA d:NA)||
|exchange_rate|decimal(20,10)|N|1.0000000000|||||
|payment_method_id|int unsigned|Y||MUL||payment_method.payment_method_id (u:NA d:NA)||
|accounting_account_id|int unsigned|Y||||||
|issuer_name|varchar(200)|Y|||||Issuer Company Name|
|issuer_tax_id|varchar(50)|Y|||||Issuer Tax ID|
|issuer_address|varchar(200)|Y|||||Issuer Street Address|
|issuer_city|varchar(100)|Y|||||Issuer City|
|issuer_postal_code|varchar(20)|Y|||||Issuer Postal Code|
|issuer_state_id|int unsigned|Y||MUL||state.state_id (u:NA d:NA)|State reference|
|issuer_country_id|char(2)|Y||MUL||country.country_id (u:NA d:NA)|ISO 3166-1 alpha-2 code|
|recipient_id|int unsigned|Y||MUL||contact.contact_id (u:NA d:NA)|Recipient Contact Reference|
|recipient_name|varchar(200)|Y|||||Recipient Name|
|recipient_email|varchar(200)|Y|||||Recipient Email|
|recipient_tax_id|varchar(50)|Y|||||Recipient VAT/Tax ID|
|recipient_code|varchar(100)|Y|||||Recipient Code|
|billing_address|varchar(200)|Y|||||Billing Street Address|
|billing_city|varchar(100)|Y|||||Billing City|
|billing_postal_code|varchar(20)|Y|||||Billing Postal Code|
|billing_state_id|int unsigned|Y||MUL||state.state_id (u:NA d:NA)|State reference|
|billing_country_id|char(2)|Y||MUL||country.country_id (u:NA d:NA)|ISO 3166-1 alpha-2 code|
|billing_name|varchar(200)|Y|||||Billing Contact Name|
|billing_phone|varchar(50)|Y|||||Billing Phone|
|billing_email|varchar(200)|Y|||||Billing Email|
|shipping_address_type|tinyint unsigned|Y||||||
|shipping_address|varchar(200)|Y|||||Shipping Street Address|
|shipping_city|varchar(100)|Y|||||Shipping City|
|shipping_postal_code|varchar(20)|Y|||||Shipping Postal Code|
|shipping_state_id|int unsigned|Y||MUL||state.state_id (u:NA d:NA)|State reference|
|shipping_country_id|char(2)|Y||MUL||country.country_id (u:NA d:NA)|ISO 3166-1 alpha-2 code|
|shipping_name|varchar(200)|Y|||||Shipping Contact Name|
|shipping_phone|varchar(50)|Y|||||Shipping Phone|
|shipping_email|varchar(200)|Y|||||Shipping Email|
|discount_type|tinyint unsigned|Y|||||1=percent,2=amount|
|discount_value|decimal(20,4)|Y||||||
|charge_type|tinyint unsigned|Y|||||1=percent,2=amount|
|charge_value|decimal(20,4)|Y||||||
|subtotal_amount|decimal(20,4)|Y||||||
|discount_amount|decimal(20,4)|Y||||||
|charge_amount|decimal(20,4)|Y||||||
|tax_amount|decimal(20,4)|Y||||||
|total_amount|decimal(20,4)|Y||||||
|base_subtotal_amount|decimal(20,4)|Y||||||
|base_discount_amount|decimal(20,4)|Y||||||
|base_charge_amount|decimal(20,4)|Y||||||
|base_tax_amount|decimal(20,4)|Y||||||
|base_total_amount|decimal(20,4)|Y||||||
|lock_version|int unsigned|N|0|||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
|created_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|updated_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|deleted_at|datetime|Y||||||
|deleted_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
## document_item
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|document_item_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|document_id|int unsigned|N||MUL||document.document_id (u:R d:C)||
|position|smallint unsigned|N||||||
|item_type|tinyint unsigned|N|||||1=product,2=service,3=adjustment|
|name|varchar(200)|N||||||
|description|text|Y||||||
|sku|varchar(100)|Y||||||
|product_id|int unsigned|Y||||||
|product_variant_id|int unsigned|Y||||||
|service_id|int unsigned|Y||||||
|accounting_account_id|int unsigned|Y||||||
|quantity|decimal(20,9)|N|1.000000000|||||
|unit_price|decimal(20,6)|N|0.000000|||||
|line_subtotal|decimal(20,4)|Y||||||
|discount_type|tinyint unsigned|Y||||||
|discount_value|decimal(20,4)|Y||||||
|discount_amount|decimal(20,4)|Y||||||
|line_total_excl_tax|decimal(20,4)|Y||||||
|tax_amount|decimal(20,4)|Y||||||
|line_total_incl_tax|decimal(20,4)|Y||||||
|base_unit_price|decimal(20,6)|Y||||||
|base_line_total_excl_tax|decimal(20,4)|Y||||||
|base_tax_amount|decimal(20,4)|Y||||||
|base_line_total_incl_tax|decimal(20,4)|Y||||||
|lock_version|int unsigned|N|0|||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
|created_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|updated_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|deleted_at|datetime|Y||||||
|deleted_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
## document_item_tax
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|document_item_tax_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|document_item_id|int unsigned|N||MUL||document_item.document_item_id (u:R d:C)||
|tax_id|int unsigned|N||MUL||tax.tax_id (u:NA d:NA)||
|tax_name|varchar(150)|Y||||||
|tax_rate|decimal(20,6)|Y||||||
|tax_type|tinyint unsigned|Y||||||
|amount|decimal(20,4)|Y||||||
|base_amount|decimal(20,4)|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
## document_series
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|document_series_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|document_type_id|tinyint unsigned|N||MUL||document_type.document_type_id (u:NA d:NA)||
|name|varchar(200)|N||||||
|prefix|varchar(50)|Y||||||
|suffix|varchar(50)|Y||||||
|reset_annually|tinyint(1)|N|1|||||
|padding|tinyint unsigned|N|6|||||
|last_sequence|int unsigned|N|0|||||
|is_default|tinyint(1)|N|0|||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
## document_type
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|document_type_id|tinyint unsigned|N||PRI||||
|code|varchar(50)|N||UNI||||
|name|varchar(100)|N||||||
## document_type_settings
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|document_type_settings_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|document_type_id|tinyint unsigned|N||MUL||document_type.document_type_id (u:NA d:NA)||
|design_template|varchar(100)|N|default|||||
|email_template|varchar(100)|N|default|||||
|document_mode|tinyint unsigned|N|1||||1=default,2=items,3=time,4=total,5=tax_exempt|
|show_discount|tinyint(1)|N|1|||||
|show_item_discount|tinyint(1)|N|0|||||
|show_customer_portal_qr|tinyint(1)|N|0|||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
|created_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|updated_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
## error_log
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|error_log_id|bigint unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|Y||MUL||account.tenant_id (u:R d:SN)||
|user_id|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|level|tinyint unsigned|N|||||1=debug,2=info,3=warning,4=error,5=critical|
|code|int|Y||MUL||||
|exception_class|varchar(255)|Y||||||
|message|text|N||||||
|file|varchar(255)|Y||||||
|line|int|Y||||||
|trace|text|Y||||||
|context|json|Y||||||
|last_error_date|datetime|N|CURRENT_TIMESTAMP|MUL|DEFAULT_GENERATED|||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|expire_at|datetime|Y||MUL||||
## idempotency_key
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|user_id|int unsigned|N||MUL||user.user_id (u:R d:C)||
|idempotency_key|varchar(255)|N||||||
|request_method|varchar(10)|N||||||
|request_path|varchar(500)|N||||||
|request_hash|char(64)|Y||||||
|response_code|int|Y||||||
|response_body|text|Y||||||
|status|varchar(20)|N|pending|||||
|expires_at|datetime|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
## language
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|language_id|varchar(5)|N||PRI|||ISO 639-1 code with optional region|
|language_id_3|char(3)|Y||MUL|||ISO 639-3 three-letter code|
|name|varchar(100)|N||||||
|locale|varchar(20)|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
## migration
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|version|varchar(180)|N||PRI||||
|apply_time|int|Y||||||
## payment_method
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|payment_method_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|payment_method_type_id|int unsigned|N||MUL||payment_method_type.payment_method_type_id (u:NA d:NA)||
|name|varchar(100)|N||||||
|description|text|Y||||||
|due_days|int|Y||||||
|is_active|tinyint(1)|N|1|||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
|created_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|updated_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
## payment_method_type
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|payment_method_type_id|int unsigned|N||PRI|auto_increment|||
|name|varchar(100)|N||UNI||||
|description|varchar(255)|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
## plan
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|plan_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||UNI||account.tenant_id (u:R d:C)||
|plan_type_id|int unsigned|N||MUL||plan_type.plan_type_id (u:NA d:NA)||
|price_amount|decimal(20,4)|N||||||
|currency_id|char(3)|N||MUL||currency.currency_id (u:NA d:NA)||
|external_subscription_id|varchar(100)|Y||||||
|active_from|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|active_until|datetime|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
|created_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|updated_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
## plan_feature
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|plan_feature_id|int unsigned|N||PRI|auto_increment|||
|plan_type_id|int unsigned|N||MUL||plan_type.plan_type_id (u:R d:C)||
|feature_key|varchar(100)|N||||||
|feature_value|varchar(255)|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
## plan_history
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|plan_history_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|plan_type_id|int unsigned|N||MUL||plan_type.plan_type_id (u:NA d:NA)||
|price_amount|decimal(20,4)|N||||||
|currency_id|char(3)|N||MUL||currency.currency_id (u:NA d:NA)||
|period_start|datetime|N||||||
|period_end|datetime|Y||||||
|external_subscription_id|varchar(100)|Y||||||
|note|varchar(255)|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|created_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
## plan_type
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|plan_type_id|int unsigned|N||PRI|auto_increment|||
|name|varchar(100)|N||||||
|description|text|Y||||||
|billing_period|tinyint unsigned|N|||||1=monthly,2=yearly|
|price_amount|decimal(20,4)|N|||||Price|
|currency_id|char(3)|N||MUL||currency.currency_id (u:NA d:NA)||
|is_active|tinyint(1)|N|1|||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
## platform_configuration
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|platform_configuration_id|int unsigned|N||PRI|auto_increment|||
|config_key|varchar(150)|N||UNI||||
|config_value|json|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
## state
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|state_id|int unsigned|N||PRI|auto_increment|||
|country_id|char(2)|N||MUL||country.country_id (u:R d:C)||
|state_id_code|varchar(10)|N|||||ISO 3166-2 subdivision code|
|name|varchar(100)|N||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
## status_history
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|status_history_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|Y||MUL||account.tenant_id (u:R d:SN)||
|entity_type|varchar(50)|N||MUL||||
|entity_id|int unsigned|N||||||
|old_status|int|Y||||||
|new_status|int|N||||||
|note|varchar(500)|Y||||||
|changed_by|int unsigned|Y||MUL||user.user_id (u:R d:SN)||
|changed_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
## tax
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|tax_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|N||MUL||account.tenant_id (u:R d:C)||
|code|varchar(50)|N||||||
|name|varchar(150)|N||||||
|rate|decimal(20,6)|N||||||
|tax_type|tinyint unsigned|N|1||||1=vat,2=withholding,3=other|
|scope|tinyint unsigned|N|3||||1=sales,2=purchases,3=both|
|is_inclusive|tinyint(1)|N|0|||||
|is_compound|tinyint(1)|N|0|||||
|priority|tinyint unsigned|N|1|||||
|is_active|tinyint(1)|N|1|MUL||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
## user
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|user_id|int unsigned|N||PRI|auto_increment|||
|tenant_id|int unsigned|Y||MUL||||
|email|varchar(200)|N||UNI||||
|password_hash|varchar(255)|N||||||
|auth_key|varchar(32)|N||||||
|password_reset_token|varchar(255)|Y||UNI||||
|email_verification_token|varchar(255)|Y||UNI||||
|first_name|varchar(100)|N||||||
|last_name|varchar(100)|Y||||||
|is_superadmin|tinyint(1)|N|0|||||
|is_active|tinyint(1)|N|1|MUL||||
|user_settings|json|Y||||||
|last_login_at|datetime|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
|password_updated_at|datetime|Y||||||
|created_by|int unsigned|Y||||||
|updated_by|int unsigned|Y||||||
|deleted_at|datetime|Y||||||
|deleted_by|int unsigned|Y||||||
## user_api_key
|c|t|n|d|k|x|ref|comment|
|---|---|---|---|---|---|---|---|
|api_key_id|int unsigned|N||PRI|auto_increment|||
|user_id|int unsigned|N||UNI||user.user_id (u:R d:C)||
|api_key_hash|varchar(255)|N||UNI||||
|key_preview|varchar(12)|Y||MUL||||
|allowed_ip|varchar(45)|Y||||||
|expires_at|datetime|Y||MUL||||
|last_used_at|datetime|Y||||||
|created_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED|||
|updated_at|datetime|N|CURRENT_TIMESTAMP||DEFAULT_GENERATED on update CURRENT_TIMESTAMP|||
