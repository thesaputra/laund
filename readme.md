Laundry System

Petugas laundry
-name
-address
-phone

Customer:
-code
-name
-address
-phone

Paket
-service_type
-price
-satuan/kilos

Status
-name

Transaction
-customer_id
-price_id
-date_entry
-kilos
-date_eta
-total_price
-user_id

transaction_detail
-transaction_id
-date_status
-status => masuk, selesai cuci, selesai setrika, packing
-user_id

payment_detail
-transaction_id
-date_payment
-description
-total_amount
-user_id
