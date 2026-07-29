# Database Schema Report

**Generated:** 2026-07-27 14:01:56
**Database:** `saaluvesa_db`

---

## Table of Contents

- [address_types](#address_types)
- [all_india_pincodes](#all_india_pincodes)
- [app_alerts](#app_alerts)
- [app_notifications](#app_notifications)
- [app_settings](#app_settings)
- [area_assigns](#area_assigns)
- [areas](#areas)
- [bank_details](#bank_details)
- [banner_images](#banner_images)
- [bulk_orders](#bulk_orders)
- [cache](#cache)
- [cache_locks](#cache_locks)
- [cancel_requests](#cancel_requests)
- [carts](#carts)
- [categories](#categories)
- [checkout_settings](#checkout_settings)
- [cities](#cities)
- [contact_details](#contact_details)
- [contact_messages](#contact_messages)
- [country_tables](#country_tables)
- [coupons](#coupons)
- [customers](#customers)
- [customproduct_designs](#customproduct_designs)
- [customproducts](#customproducts)
- [dashboard_users](#dashboard_users)
- [delivery_charge_details](#delivery_charge_details)
- [delivery_people](#delivery_people)
- [design_layers](#design_layers)
- [design_variants](#design_variants)
- [designs](#designs)
- [districts](#districts)
- [exchange_rates](#exchange_rates)
- [failed_jobs](#failed_jobs)
- [gender_types](#gender_types)
- [invoices](#invoices)
- [jobs](#jobs)
- [mail_otps](#mail_otps)
- [migrations](#migrations)
- [milk_order_user_addresses](#milk_order_user_addresses)
- [milk_orders](#milk_orders)
- [milk_refunds](#milk_refunds)
- [milk_slots](#milk_slots)
- [milk_transaction_logs](#milk_transaction_logs)
- [notifications](#notifications)
- [offer_images](#offer_images)
- [onetimes](#onetimes)
- [order_export_data](#order_export_data)
- [otps](#otps)
- [password_reset_tokens](#password_reset_tokens)
- [password_resets](#password_resets)
- [personal_access_tokens](#personal_access_tokens)
- [plan_types](#plan_types)
- [product_child_images](#product_child_images)
- [product_color_images](#product_color_images)
- [product_colors](#product_colors)
- [product_order_user_addresses](#product_order_user_addresses)
- [product_orders](#product_orders)
- [product_refunds](#product_refunds)
- [product_slots](#product_slots)
- [product_tracking](#product_tracking)
- [product_transaction_logs](#product_transaction_logs)
- [product_varient](#product_varient)
- [products](#products)
- [productstocks](#productstocks)
- [reviews](#reviews)
- [sample_order_full_details](#sample_order_full_details)
- [sample_variants](#sample_variants)
- [samples](#samples)
- [sessions](#sessions)
- [shippings](#shippings)
- [size_charts](#size_charts)
- [states](#states)
- [sub_categories](#sub_categories)
- [telescope_entries](#telescope_entries)
- [telescope_entries_tags](#telescope_entries_tags)
- [telescope_monitoring](#telescope_monitoring)
- [testimonials](#testimonials)
- [tests](#tests)
- [today_deals](#today_deals)
- [user_addresses](#user_addresses)
- [user_read_notifications](#user_read_notifications)
- [users](#users)
- [web_images](#web_images)
- [wishlists](#wishlists)

---

## `address_types`

**Row count:** 3

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `address_type_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `all_india_pincodes`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `officename` | `varchar(50)` | YES | `NULL` | `—` | — |
| `pincode` | `bigint(20)` | YES | `NULL` | `—` | — |
| `officeType` | `varchar(50)` | YES | `NULL` | `—` | — |
| `Deliverystatus` | `varchar(50)` | YES | `NULL` | `—` | — |
| `divisionname` | `varchar(50)` | YES | `NULL` | `—` | — |
| `regionname` | `varchar(50)` | YES | `NULL` | `—` | — |
| `circlename` | `varchar(50)` | YES | `NULL` | `—` | — |
| `Taluk` | `varchar(50)` | YES | `NULL` | `—` | — |
| `Districtname` | `varchar(50)` | YES | `NULL` | `—` | — |
| `statename` | `varchar(50)` | YES | `NULL` | `MUL` | — |
| `Telephone` | `varchar(50)` | YES | `NULL` | `—` | — |
| `relatedSuboffice` | `varchar(50)` | YES | `NULL` | `—` | — |
| `relatedHeadoffice` | `varchar(50)` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `statename` on `statename`

---

## `app_alerts`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `alert_id` | `text` | YES | `NULL` | `—` | — |
| `user_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `alert_title` | `text` | YES | `NULL` | `—` | — |
| `alert_content` | `text` | YES | `NULL` | `—` | — |
| `alert_image` | `text` | YES | `NULL` | `—` | — |
| `mark_as_read` | `int(11)` | NO | `0` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `app_alerts_user_id_foreign` | `user_id` | `users`.`user_id` |

**Indexes (non-primary):**

- `app_alerts_user_id_foreign` on `user_id`

---

## `app_notifications`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `notification_id` | `text` | YES | `NULL` | `—` | — |
| `user_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `notification_title` | `text` | YES | `NULL` | `—` | — |
| `notification_content` | `text` | YES | `NULL` | `—` | — |
| `notification_image` | `text` | YES | `NULL` | `—` | — |
| `mark_as_read` | `int(11)` | NO | `0` | `—` | — |
| `created_at` | `timestamp` | YES | `current_timestamp()` | `—` | — |
| `updated_at` | `timestamp` | YES | `current_timestamp()` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `app_notifications_user_id_foreign` | `user_id` | `users`.`user_id` |

**Indexes (non-primary):**

- `app_notifications_user_id_foreign` on `user_id`

---

## `app_settings`

**Row count:** 8

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `user_type` | `varchar(255)` | NO | `NULL` | `MUL` | — |
| `product_type` | `varchar(255)` | NO | `NULL` | `—` | — |
| `min_quantity` | `int(11)` | NO | `1` | `—` | — |
| `max_quantity` | `int(11)` | NO | `100` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `app_settings_user_type_product_type_unique` on `user_type` (UNIQUE)

---

## `area_assigns`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `area_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `delivery_people_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `area_assigns_ibfk_1` | `area_id` | `areas`.`id` |
| `area_assigns_ibfk_2` | `delivery_people_id` | `delivery_people`.`id` |

**Indexes (non-primary):**

- `area_id` on `area_id`
- `delivery_people_id` on `delivery_people_id`

---

## `areas`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `area_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `area_pincode` | `bigint(20)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `bank_details`

**Row count:** 6

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `account_holder_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `bank_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `account_number` | `varchar(255)` | YES | `NULL` | `—` | — |
| `account_type` | `varchar(255)` | YES | `NULL` | `—` | — |
| `payment_method` | `varchar(255)` | YES | `NULL` | `—` | — |
| `routing_number` | `varchar(255)` | YES | `NULL` | `—` | — |
| `ifsc_code` | `varchar(255)` | YES | `NULL` | `—` | — |
| `swift_code` | `varchar(255)` | YES | `NULL` | `—` | — |
| `bank_branch_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `bank_branch_address` | `text` | YES | `NULL` | `—` | — |
| `beneficiary_address` | `text` | YES | `NULL` | `—` | — |
| `bank_country` | `varchar(255)` | YES | `NULL` | `—` | — |
| `description` | `longtext` | YES | `NULL` | `—` | — |
| `currency_accepted` | `varchar(255)` | YES | `NULL` | `—` | — |
| `business_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `business_address` | `text` | YES | `NULL` | `—` | — |
| `business_email` | `varchar(255)` | YES | `NULL` | `—` | — |
| `business_contact_number` | `varchar(255)` | YES | `NULL` | `—` | — |
| `gst_number` | `varchar(255)` | YES | `NULL` | `—` | — |
| `payment_confirmation_time` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `banner_images`

**Row count:** 1

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `banner_image` | `text` | YES | `NULL` | `—` | — |
| `banner_position` | `text` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |
| `title` | `varchar(255)` | YES | `NULL` | `—` | — |
| `subtitle` | `varchar(255)` | YES | `NULL` | `—` | — |
| `button_text` | `varchar(255)` | YES | `NULL` | `—` | — |
| `button_url` | `varchar(500)` | YES | `NULL` | `—` | — |

---

## `bulk_orders`

**Row count:** 1

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `order_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `name` | `varchar(255)` | NO | `NULL` | `—` | — |
| `email` | `varchar(255)` | NO | `NULL` | `—` | — |
| `user_type` | `varchar(255)` | NO | `NULL` | `—` | — |
| `quantity` | `int(11)` | NO | `NULL` | `—` | — |
| `product_type` | `varchar(255)` | NO | `NULL` | `—` | — |
| `product_id` | `bigint(20) unsigned` | YES | `NULL` | `—` | — |
| `custom_image` | `varchar(255)` | YES | `NULL` | `—` | — |
| `notes` | `text` | YES | `NULL` | `—` | — |
| `status` | `tinyint(4)` | NO | `0` | `—` | — |
| `admin_notes` | `text` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `cache`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `key` | `varchar(255)` | NO | `NULL` | `PRI` | — |
| `value` | `mediumtext` | NO | `NULL` | `—` | — |
| `expiration` | `int(11)` | NO | `NULL` | `—` | — |

---

## `cache_locks`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `key` | `varchar(255)` | NO | `NULL` | `PRI` | — |
| `owner` | `varchar(255)` | NO | `NULL` | `—` | — |
| `expiration` | `int(11)` | NO | `NULL` | `—` | — |

---

## `cancel_requests`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `order_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `approval_status` | `int(11)` | NO | `0` | `—` | — |
| `created_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |
| `updated_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |

---

## `carts`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `session_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `product_id` | `bigint(20) unsigned` | YES | `NULL` | `—` | — |
| `product_varient_id` | `bigint(20)` | YES | `NULL` | `—` | — |
| `product_quantity` | `int(11)` | YES | `NULL` | `—` | — |
| `product_name` | `text` | YES | `NULL` | `—` | — |
| `product_color` | `text` | YES | `NULL` | `—` | — |
| `roster_data` | `longtext` | YES | `NULL` | `—` | — |
| `design_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `price` | `text` | YES | `NULL` | `—` | — |
| `extra_price` | `decimal(10,2)` | NO | `0.00` | `—` | — |
| `product_size` | `text` | YES | `NULL` | `—` | — |
| `product_image` | `text` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |
| `product_type` | `varchar(255)` | YES | `NULL` | `—` | — |
| `stock_id` | `int(11)` | YES | `NULL` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `carts_design_id_foreign` | `design_id` | `customproduct_designs`.`id` |

**Indexes (non-primary):**

- `carts_design_id_foreign` on `design_id`
- `carts_session_id_index` on `session_id`

---

## `categories`

**Row count:** 3

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `category_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `category_image` | `varchar(255)` | YES | `NULL` | `—` | — |
| `status` | `int(11)` | YES | `0` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `checkout_settings`

**Row count:** 1

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `paypal_max_quantity` | `int(11)` | NO | `10` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `cities`

**Row count:** 7692

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `name` | `varchar(30)` | NO | `NULL` | `—` | — |
| `state_id` | `int(11)` | NO | `NULL` | `—` | — |

---

## `contact_details`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `mobile_number1` | `varchar(20)` | YES | `NULL` | `—` | — |
| `mobile_number2` | `varchar(20)` | YES | `NULL` | `—` | — |
| `address` | `text` | YES | `NULL` | `—` | — |
| `email` | `varchar(100)` | YES | `NULL` | `—` | — |
| `fb_link` | `text` | YES | `NULL` | `—` | — |
| `insta_link` | `text` | YES | `NULL` | `—` | — |
| `twitter_link` | `text` | YES | `NULL` | `—` | — |
| `map_link` | `text` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |

---

## `contact_messages`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `name` | `varchar(255)` | NO | `NULL` | `—` | — |
| `email` | `varchar(255)` | NO | `NULL` | `—` | — |
| `phone` | `varchar(20)` | YES | `NULL` | `—` | — |
| `country` | `varchar(100)` | YES | `NULL` | `—` | — |
| `subject` | `varchar(500)` | NO | `NULL` | `—` | — |
| `message` | `text` | NO | `NULL` | `—` | — |
| `ip_address` | `varchar(45)` | YES | `NULL` | `—` | — |
| `user_agent` | `varchar(500)` | YES | `NULL` | `—` | — |
| `status` | `enum('new','read','replied')` | NO | `new` | `MUL` | — |
| `created_at` | `timestamp` | YES | `NULL` | `MUL` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `contact_messages_status_index` on `status`
- `contact_messages_created_at_index` on `created_at`

---

## `country_tables`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `coupons`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `codename` | `varchar(255)` | YES | `NULL` | `—` | — |
| `mini_amt` | `int(11)` | YES | `NULL` | `—` | — |
| `discounttype` | `int(11)` | YES | `NULL` | `—` | — |
| `discount` | `int(11)` | YES | `NULL` | `—` | — |
| `start_date` | `date` | YES | `NULL` | `—` | — |
| `end_date` | `date` | YES | `NULL` | `—` | — |
| `default_id` | `varchar(255)` | YES | `0` | `—` | — |
| `coupon_status` | `int(11)` | NO | `0` | `—` | — |
| `created_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |
| `updated_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |

---

## `customers`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `order_id` | `varchar(255)` | NO | `NULL` | `—` | — |
| `user_id` | `varchar(255)` | NO | `NULL` | `—` | — |
| `customername` | `varchar(255)` | NO | `NULL` | `—` | — |
| `phone_number` | `varchar(255)` | NO | `NULL` | `—` | — |
| `email` | `varchar(255)` | NO | `NULL` | `—` | — |
| `product_quantity` | `varchar(255)` | NO | `NULL` | `—` | — |
| `product_price` | `varchar(255)` | NO | `NULL` | `—` | — |
| `total_price` | `varchar(255)` | NO | `NULL` | `—` | — |
| `couponcode` | `varchar(255)` | NO | `NULL` | `—` | — |
| `shippingname` | `varchar(255)` | NO | `NULL` | `—` | — |
| `shippingphone` | `varchar(255)` | NO | `NULL` | `—` | — |
| `shippingemail` | `varchar(255)` | NO | `NULL` | `—` | — |
| `shippingstate` | `varchar(255)` | NO | `NULL` | `—` | — |
| `shippingcity` | `varchar(255)` | NO | `NULL` | `—` | — |
| `shippingpostal_code` | `varchar(255)` | NO | `NULL` | `—` | — |
| `state` | `varchar(255)` | NO | `NULL` | `—` | — |
| `city` | `varchar(255)` | NO | `NULL` | `—` | — |
| `postal_code` | `varchar(255)` | NO | `NULL` | `—` | — |
| `payment_status` | `varchar(255)` | NO | `NULL` | `—` | — |
| `delivery_status` | `varchar(255)` | NO | `NULL` | `—` | — |
| `order_date` | `date` | NO | `NULL` | `—` | — |
| `shippingamt` | `varchar(255)` | NO | `NULL` | `—` | — |
| `netamount` | `varchar(255)` | NO | `NULL` | `—` | — |
| `trackingid` | `varchar(255)` | NO | `NULL` | `—` | — |
| `delivery_date` | `varchar(255)` | NO | `NULL` | `—` | — |
| `dispatched_date` | `varchar(255)` | NO | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `customproduct_designs`

**Row count:** 11

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `user_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `session_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `customproduct_id` | `bigint(20) unsigned` | NO | `NULL` | `MUL` | — |
| `design_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `product_color_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `canvas_width` | `int(11)` | YES | `400` | `—` | — |
| `canvas_height` | `int(11)` | YES | `500` | `—` | — |
| `product_color` | `varchar(255)` | YES | `white` | `—` | — |
| `product_size` | `varchar(255)` | YES | `M` | `—` | — |
| `design_json_front` | `longtext` | YES | `NULL` | `—` | — |
| `design_json_back` | `longtext` | YES | `NULL` | `—` | — |
| `design_json_chest` | `longtext` | YES | `NULL` | `—` | — |
| `design_json_shoulder` | `longtext` | YES | `NULL` | `—` | — |
| `preview_image_front` | `varchar(255)` | YES | `NULL` | `—` | — |
| `preview_image_back` | `varchar(255)` | YES | `NULL` | `—` | — |
| `preview_image_chest` | `varchar(255)` | YES | `NULL` | `—` | — |
| `preview_image_shoulder` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |
| `design_json_right_shoulder` | `longtext` | YES | `NULL` | `—` | — |
| `design_json_left_shoulder` | `longtext` | YES | `NULL` | `—` | — |
| `preview_image_right_shoulder` | `varchar(255)` | YES | `NULL` | `—` | — |
| `preview_image_left_shoulder` | `varchar(255)` | YES | `NULL` | `—` | — |
| `thumbnail_path` | `varchar(255)` | YES | `NULL` | `—` | — |
| `status` | `varchar(255)` | NO | `draft` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `customproduct_designs_customproduct_id_foreign` | `customproduct_id` | `customproducts`.`id` |
| `customproduct_designs_product_color_id_foreign` | `product_color_id` | `product_colors`.`id` |

**Indexes (non-primary):**

- `customproduct_designs_product_color_id_foreign` on `product_color_id`
- `customproduct_designs_customproduct_id_index` on `customproduct_id`
- `customproduct_designs_user_id_index` on `user_id`
- `customproduct_designs_session_id_index` on `session_id`

---

## `customproducts`

**Row count:** 1

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `name` | `varchar(255)` | NO | `NULL` | `—` | — |
| `description` | `text` | YES | `NULL` | `—` | — |
| `base_price` | `decimal(10,2)` | NO | `NULL` | `—` | — |
| `extra_element_price` | `decimal(10,2)` | NO | `50.00` | `—` | — |
| `product_type` | `enum('tshirt','hoodie','mug','cap','bag')` | NO | `tshirt` | `—` | — |
| `front_mockup` | `varchar(255)` | YES | `NULL` | `—` | — |
| `back_mockup` | `varchar(255)` | YES | `NULL` | `—` | — |
| `right_shoulder_mockup` | `varchar(255)` | YES | `NULL` | `—` | — |
| `left_shoulder_mockup` | `varchar(255)` | YES | `NULL` | `—` | — |
| `printable_rect` | `longtext` | YES | `NULL` | `—` | — |
| `is_two_sided` | `tinyint(1)` | NO | `0` | `—` | — |
| `available_sizes` | `longtext` | YES | `NULL` | `—` | — |
| `canvas_config` | `longtext` | YES | `NULL` | `—` | — |
| `status` | `enum('active','inactive')` | NO | `active` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `dashboard_users`

**Row count:** 1

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `name` | `varchar(255)` | NO | `NULL` | `—` | — |
| `empl_num` | `varchar(255)` | YES | `NULL` | `—` | — |
| `email` | `varchar(255)` | NO | `NULL` | `UNI` | — |
| `phone_number` | `varchar(255)` | YES | `NULL` | `—` | — |
| `role` | `varchar(255)` | YES | `NULL` | `—` | — |
| `status` | `int(11)` | YES | `NULL` | `—` | — |
| `email_verified_at` | `timestamp` | YES | `NULL` | `—` | — |
| `password` | `varchar(255)` | NO | `NULL` | `—` | — |
| `avatar` | `varchar(255)` | YES | `NULL` | `—` | — |
| `remember_token` | `varchar(100)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `dashboard_users_email_unique` on `email` (UNIQUE)

---

## `delivery_charge_details`

**Row count:** 1

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `delivery_charge` | `int(11)` | NO | `0` | `—` | — |
| `minimum_price` | `int(11)` | NO | `0` | `—` | — |
| `created_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |

---

## `delivery_people`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `delivery_person_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `name` | `varchar(255)` | NO | `NULL` | `—` | — |
| `email` | `varchar(255)` | NO | `NULL` | `UNI` | — |
| `phone_number` | `bigint(20)` | NO | `NULL` | `UNI` | — |
| `email_verified_at` | `timestamp` | YES | `NULL` | `—` | — |
| `password` | `varchar(255)` | NO | `NULL` | `—` | — |
| `enc_password` | `varchar(255)` | NO | `NULL` | `—` | — |
| `remember_token` | `varchar(100)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `delivery_people_email_unique` on `email` (UNIQUE)
- `delivery_people_phone_number_unique` on `phone_number` (UNIQUE)
- `delivery_person_id` on `delivery_person_id`

---

## `design_layers`

**Row count:** 15

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `design_id` | `bigint(20) unsigned` | NO | `NULL` | `MUL` | — |
| `layer_type` | `varchar(255)` | NO | `NULL` | `—` | — |
| `layer_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `source_path` | `varchar(500)` | YES | `NULL` | `—` | — |
| `text_content` | `text` | YES | `NULL` | `—` | — |
| `x_position` | `decimal(12,4)` | NO | `NULL` | `—` | — |
| `y_position` | `decimal(12,4)` | NO | `NULL` | `—` | — |
| `width` | `decimal(12,4)` | NO | `NULL` | `—` | — |
| `height` | `decimal(12,4)` | NO | `NULL` | `—` | — |
| `rotation` | `decimal(8,2)` | NO | `0.00` | `—` | — |
| `scale_x` | `decimal(12,4)` | NO | `1.0000` | `—` | — |
| `scale_y` | `decimal(12,4)` | NO | `1.0000` | `—` | — |
| `print_position` | `varchar(255)` | NO | `NULL` | `MUL` | — |
| `z_index` | `int(11)` | NO | `0` | `—` | — |
| `layer_json` | `longtext` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `design_layers_design_id_foreign` | `design_id` | `customproduct_designs`.`id` |

**Indexes (non-primary):**

- `design_layers_design_id_index` on `design_id`
- `design_layers_print_position_index` on `print_position`

---

## `design_variants`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `design_id` | `bigint(20) unsigned` | NO | `NULL` | `MUL` | — |
| `varient_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `varient_img` | `varchar(255)` | YES | `NULL` | `—` | — |
| `size_value` | `varchar(255)` | YES | `NULL` | `—` | — |
| `color_value` | `varchar(255)` | YES | `NULL` | `—` | — |
| `design_qty` | `int(11)` | NO | `0` | `—` | — |
| `mrp_price` | `decimal(10,2)` | NO | `0.00` | `—` | — |
| `offer_price` | `decimal(10,2)` | NO | `0.00` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `design_variants_design_id_foreign` | `design_id` | `designs`.`id` |

**Indexes (non-primary):**

- `design_variants_design_id_foreign` on `design_id`

---

## `designs`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `image` | `varchar(255)` | NO | `NULL` | `—` | — |
| `title` | `varchar(255)` | NO | `NULL` | `—` | — |
| `tag` | `varchar(255)` | NO | `NULL` | `—` | — |
| `type` | `varchar(255)` | NO | `NULL` | `—` | — |
| `price` | `decimal(10,2)` | NO | `NULL` | `—` | — |
| `description` | `text` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |
| `stocks` | `int(11)` | YES | `0` | `—` | — |
| `size` | `text` | YES | `NULL` | `—` | — |
| `cloth_types` | `text` | YES | `NULL` | `—` | — |

---

## `districts`

**Row count:** 38

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `name` | `varchar(255)` | NO | `NULL` | `—` | — |
| `state_id` | `int(11)` | YES | `NULL` | `—` | — |
| `state_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `exchange_rates`

**Row count:** 39

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `base_currency` | `varchar(3)` | NO | `NULL` | `MUL` | — |
| `target_currency` | `varchar(3)` | NO | `NULL` | `MUL` | — |
| `rate` | `decimal(15,6)` | NO | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `exchange_rates_base_currency_target_currency_unique` on `base_currency` (UNIQUE)
- `exchange_rates_base_currency_index` on `base_currency`
- `exchange_rates_target_currency_index` on `target_currency`

---

## `failed_jobs`

**Row count:** 2

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `uuid` | `varchar(255)` | NO | `NULL` | `UNI` | — |
| `connection` | `text` | NO | `NULL` | `—` | — |
| `queue` | `text` | NO | `NULL` | `—` | — |
| `payload` | `longtext` | NO | `NULL` | `—` | — |
| `exception` | `longtext` | NO | `NULL` | `—` | — |
| `failed_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |

**Indexes (non-primary):**

- `failed_jobs_uuid_unique` on `uuid` (UNIQUE)

---

## `gender_types`

**Row count:** 3

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `gender_name` | `varchar(255)` | NO | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `invoices`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `jobs`

**Row count:** 8

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `queue` | `varchar(255)` | NO | `NULL` | `MUL` | — |
| `payload` | `longtext` | NO | `NULL` | `—` | — |
| `attempts` | `tinyint(3) unsigned` | NO | `NULL` | `—` | — |
| `reserved_at` | `int(10) unsigned` | YES | `NULL` | `—` | — |
| `available_at` | `int(10) unsigned` | NO | `NULL` | `—` | — |
| `created_at` | `int(10) unsigned` | NO | `NULL` | `—` | — |

**Indexes (non-primary):**

- `jobs_queue_index` on `queue`

---

## `mail_otps`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `otp` | `bigint(20)` | YES | `NULL` | `—` | — |
| `email` | `bigint(20)` | YES | `NULL` | `—` | — |
| `validity_time` | `datetime` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `migrations`

**Row count:** 125

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(10) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `migration` | `varchar(255)` | NO | `NULL` | `—` | — |
| `batch` | `int(11)` | NO | `NULL` | `—` | — |

---

## `milk_order_user_addresses`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `order_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_line_one` | `longtext` | YES | `NULL` | `—` | — |
| `address_line_two` | `longtext` | YES | `NULL` | `—` | — |
| `landmark` | `longtext` | YES | `NULL` | `—` | — |
| `area_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `city` | `longtext` | YES | `NULL` | `—` | — |
| `address_phone_number` | `bigint(20)` | YES | `NULL` | `—` | — |
| `address_type_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `address_type_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_type_others_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `users_area_id_foreign` on `area_id`
- `users_address_type_id_foreign` on `address_type_id`

---

## `milk_orders`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `product_id` | `bigint(20) unsigned` | YES | `NULL` | `—` | — |
| `quantity` | `int(11)` | YES | `NULL` | `—` | — |
| `order_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `payment_id` | `longtext` | YES | `NULL` | `—` | — |
| `from_date` | `date` | YES | `NULL` | `—` | — |
| `to_date` | `date` | YES | `NULL` | `—` | — |
| `date_to_delivery` | `longtext` | YES | `NULL` | `—` | — |
| `date_ordered_on` | `datetime` | YES | `current_timestamp()` | `—` | — |
| `no_of_days` | `int(11)` | YES | `NULL` | `—` | — |
| `plan_type` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `delivery_person_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `is_delivery_assigned` | `int(11)` | YES | `0` | `MUL` | — |
| `user_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `payment_status` | `int(11)` | YES | `0` | `—` | — |
| `current_status` | `int(11)` | YES | `0` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `milk_orders_ibfk_3` | `plan_type` | `plan_types`.`id` |
| `milk_orders_ibfk_4` | `user_id` | `users`.`user_id` |
| `milk_orders_ibfk_5` | `delivery_person_id` | `delivery_people`.`delivery_person_id` |

**Indexes (non-primary):**

- `plan_type` on `plan_type`
- `user_id` on `user_id`
- `delivery_person_id` on `delivery_person_id`
- `order_id` on `order_id`
- `is_delivery_assigned` on `is_delivery_assigned`

---

## `milk_refunds`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `order_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `slot_id` | `bigint(20)` | YES | `NULL` | `—` | — |
| `cancelled_by` | `varchar(255)` | YES | `NULL` | `—` | — |
| `refund_status` | `int(11)` | YES | `0` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `milk_slots`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `delivery_date` | `date` | YES | `NULL` | `—` | — |
| `order_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `delivery_status` | `int(11)` | YES | `0` | `—` | — |
| `order_delivered_time` | `datetime` | YES | `NULL` | `—` | — |
| `deliver_person_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `is_cancelled` | `int(11)` | YES | `0` | `—` | — |
| `cancel_reason` | `text` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `milk_slots_ibfk_1` | `order_id` | `milk_orders`.`order_id` |

**Indexes (non-primary):**

- `order_id` on `order_id`

---

## `milk_transaction_logs`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `order_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `slot_id` | `bigint(20) unsigned` | YES | `NULL` | `—` | — |
| `order_date` | `datetime` | YES | `NULL` | `—` | — |
| `order_amount` | `varchar(255)` | YES | `NULL` | `—` | — |
| `amount_credited` | `bigint(20)` | YES | `0` | `—` | — |
| `amount_debited` | `bigint(20)` | YES | `0` | `—` | — |
| `user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `notifications`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `title` | `varchar(255)` | YES | `NULL` | `—` | — |
| `content` | `varchar(255)` | YES | `NULL` | `—` | — |
| `image` | `text` | YES | `NULL` | `—` | — |
| `cate_id` | `text` | YES | `NULL` | `—` | — |
| `pro_id` | `text` | YES | `NULL` | `—` | — |
| `review` | `text` | YES | `NULL` | `—` | — |
| `cate_name` | `text` | YES | `NULL` | `—` | — |
| `pro_name` | `text` | YES | `NULL` | `—` | — |
| `star` | `int(11)` | YES | `NULL` | `—` | — |
| `approval` | `int(11)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |
| `updated_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |

---

## `offer_images`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `offer_image` | `text` | YES | `NULL` | `—` | — |
| `offer_position` | `text` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |
| `updated_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |

---

## `onetimes`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `otp` | `bigint(20)` | YES | `NULL` | `—` | — |
| `phone_number` | `varchar(255)` | YES | `NULL` | `—` | — |
| `validity_time` | `datetime` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `order_export_data`

**Row count:** 1

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `order_id` | `varchar(255)` | NO | `NULL` | `UNI` | — |
| `form_data` | `longtext` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `order_export_data_order_id_unique` on `order_id` (UNIQUE)

---

## `otps`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `otp` | `bigint(20)` | YES | `NULL` | `—` | — |
| `phone_number` | `varchar(255)` | YES | `NULL` | `—` | — |
| `validity_time` | `datetime` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `current_timestamp()` | `—` | — |
| `updated_at` | `timestamp` | YES | `current_timestamp()` | `—` | — |

---

## `password_reset_tokens`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `email` | `varchar(255)` | NO | `NULL` | `PRI` | — |
| `token` | `varchar(255)` | NO | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `password_resets`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `email` | `varchar(255)` | NO | `NULL` | `MUL` | — |
| `token` | `varchar(255)` | NO | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `password_resets_email_index` on `email`

---

## `personal_access_tokens`

**Row count:** 54

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `tokenable_type` | `varchar(255)` | NO | `NULL` | `MUL` | — |
| `tokenable_id` | `bigint(20) unsigned` | NO | `NULL` | `—` | — |
| `name` | `varchar(255)` | NO | `NULL` | `—` | — |
| `token` | `varchar(64)` | NO | `NULL` | `UNI` | — |
| `abilities` | `text` | YES | `NULL` | `—` | — |
| `last_used_at` | `timestamp` | YES | `NULL` | `—` | — |
| `expires_at` | `timestamp` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `personal_access_tokens_token_unique` on `token` (UNIQUE)
- `personal_access_tokens_tokenable_type_tokenable_id_index` on `tokenable_type`

---

## `plan_types`

**Row count:** 3

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `plan_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `product_child_images`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `product_id` | `int(11)` | YES | `NULL` | `—` | — |
| `variant_id` | `int(11)` | YES | `NULL` | `—` | — |
| `product_child_image` | `text` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | NO | `current_timestamp()` | `—` | on update current_timestamp() |
| `updated_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |

---

## `product_color_images`

**Row count:** 8

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `product_color_id` | `bigint(20) unsigned` | NO | `NULL` | `MUL` | — |
| `view_type` | `enum('front','back','chest','shoulder','right-shoulder','left-shoulder')` | NO | `NULL` | `—` | — |
| `image_path` | `varchar(255)` | NO | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `product_color_images_product_color_id_foreign` | `product_color_id` | `product_colors`.`id` |

**Indexes (non-primary):**

- `product_color_images_product_color_id_foreign` on `product_color_id`

---

## `product_colors`

**Row count:** 2

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `customproduct_id` | `bigint(20) unsigned` | NO | `NULL` | `MUL` | — |
| `color_name` | `varchar(255)` | NO | `NULL` | `—` | — |
| `color_code` | `varchar(255)` | NO | `NULL` | `—` | — |
| `status` | `enum('active','inactive')` | NO | `active` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `product_colors_customproduct_id_foreign` | `customproduct_id` | `customproducts`.`id` |

**Indexes (non-primary):**

- `product_colors_customproduct_id_foreign` on `customproduct_id`

---

## `product_order_user_addresses`

**Row count:** 5

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `address_username` | `varchar(255)` | YES | `NULL` | `—` | — |
| `user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `guest_user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `order_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_line_one` | `longtext` | YES | `NULL` | `—` | — |
| `address_line_two` | `longtext` | YES | `NULL` | `—` | — |
| `landmark` | `longtext` | YES | `NULL` | `—` | — |
| `area_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `city` | `longtext` | YES | `NULL` | `—` | — |
| `state` | `varchar(255)` | YES | `NULL` | `—` | — |
| `pincode` | `int(11)` | YES | `NULL` | `—` | — |
| `country` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_phone_number` | `text` | YES | `NULL` | `—` | — |
| `address_type_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `address_type_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_type_others_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `users_area_id_foreign` on `area_id`
- `users_address_type_id_foreign` on `address_type_id`

---

## `product_orders`

**Row count:** 5

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `order_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `order_name` | `text` | YES | `NULL` | `—` | — |
| `total_amount` | `int(11)` | YES | `0` | `—` | — |
| `gst_amount` | `int(11)` | NO | `0` | `—` | — |
| `discount_amount` | `int(11)` | NO | `0` | `—` | — |
| `delivery_charge` | `int(11)` | NO | `0` | `—` | — |
| `grand_total_amount` | `int(11)` | NO | `0` | `—` | — |
| `base_currency` | `varchar(3)` | NO | `INR` | `—` | — |
| `base_amount` | `decimal(15,2)` | YES | `NULL` | `—` | — |
| `selected_currency` | `varchar(3)` | YES | `NULL` | `—` | — |
| `converted_amount` | `decimal(15,2)` | YES | `NULL` | `—` | — |
| `exchange_rate` | `decimal(15,6)` | YES | `NULL` | `—` | — |
| `coupons_id` | `varchar(155)` | YES | `NULL` | `—` | — |
| `date_ordered_on` | `datetime` | YES | `current_timestamp()` | `—` | — |
| `delivery_person_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `is_delivery_assigned` | `int(11)` | YES | `0` | `—` | — |
| `user_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `guest_user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `payment_status` | `int(11)` | YES | `0` | `—` | — |
| `delivery_status` | `int(11)` | YES | `0` | `—` | — |
| `current_status` | `int(11)` | YES | `0` | `—` | — |
| `is_cancelled` | `int(11)` | NO | `0` | `—` | — |
| `approve_staus` | `int(11)` | NO | `0` | `—` | — |
| `cancel_reason` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |
| `shiprocket_order_id` | `int(11)` | YES | `NULL` | `—` | — |
| `shiprocket_shipping_id` | `int(11)` | YES | `NULL` | `—` | — |
| `awb_code` | `varchar(255)` | YES | `NULL` | `—` | — |
| `paypal_payment_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `paypal_payer_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `payment_method` | `text` | YES | `NULL` | `—` | — |
| `bank_country` | `varchar(255)` | YES | `NULL` | `—` | — |
| `payment_proof` | `varchar(255)` | YES | `NULL` | `—` | — |
| `coupon_code` | `text` | YES | `NULL` | `—` | — |
| `tracking_id` | `text` | YES | `NULL` | `—` | — |
| `order_type` | `int(11)` | YES | `0` | `—` | — |
| `printing_method` | `varchar(255)` | YES | `NULL` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `product_orders_ibfk_5` | `delivery_person_id` | `delivery_people`.`delivery_person_id` |

**Indexes (non-primary):**

- `user_id` on `user_id`
- `delivery_person_id` on `delivery_person_id`

---

## `product_refunds`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `order_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `slot_id` | `bigint(20)` | YES | `NULL` | `—` | — |
| `cancelled_by` | `varchar(255)` | YES | `NULL` | `—` | — |
| `refund_status` | `int(11)` | YES | `0` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `product_slots`

**Row count:** 5

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `delivery_date` | `varchar(255)` | YES | `NULL` | `—` | — |
| `order_id` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `product_id` | `bigint(20) unsigned` | YES | `NULL` | `—` | — |
| `design_id` | `bigint(20) unsigned` | YES | `NULL` | `—` | — |
| `snapshot_path` | `varchar(255)` | YES | `NULL` | `—` | — |
| `snapshot_json` | `longtext` | YES | `NULL` | `—` | — |
| `product_varient_id` | `bigint(20)` | YES | `NULL` | `—` | — |
| `product_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `order_name` | `text` | YES | `NULL` | `—` | — |
| `product_image` | `text` | YES | `NULL` | `—` | — |
| `product_rate` | `varchar(255)` | YES | `NULL` | `—` | — |
| `gst_amt` | `varchar(255)` | YES | `NULL` | `—` | — |
| `gst_per` | `varchar(255)` | YES | `NULL` | `—` | — |
| `product_value` | `varchar(255)` | YES | `NULL` | `—` | — |
| `quantity` | `int(11)` | YES | `NULL` | `—` | — |
| `product_total` | `varchar(255)` | YES | `NULL` | `—` | — |
| `shipping` | `text` | YES | `NULL` | `—` | — |
| `discount` | `text` | YES | `NULL` | `—` | — |
| `size_value` | `text` | YES | `NULL` | `—` | — |
| `color_value` | `text` | YES | `NULL` | `—` | — |
| `delivery_status` | `int(11)` | YES | `0` | `—` | — |
| `preorder` | `bigint(20)` | YES | `NULL` | `—` | — |
| `dispatch_date` | `date` | YES | `NULL` | `—` | — |
| `order_delivered_time` | `datetime` | YES | `NULL` | `—` | — |
| `deliver_person_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `is_cancelled` | `int(11)` | YES | `0` | `—` | — |
| `cancel_reason` | `text` | YES | `NULL` | `—` | — |
| `approve_staus` | `int(11)` | NO | `0` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `order_id` on `order_id`

---

## `product_tracking`

**Row count:** 1

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `order_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `delivery_status` | `varchar(255)` | YES | `NULL` | `—` | — |
| `status` | `varchar(255)` | YES | `NULL` | `—` | — |
| `channel_id` | `int(11)` | YES | `NULL` | `—` | — |
| `shiprocket_order_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `shiprocket_shipment_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `awb_code` | `varchar(255)` | YES | `NULL` | `—` | — |
| `tracking_url` | `varchar(255)` | YES | `NULL` | `—` | — |
| `delivered_date` | `varchar(255)` | YES | `NULL` | `—` | — |
| `return_requested` | `int(11)` | NO | `0` | `—` | — |
| `return_approval_date` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `product_transaction_logs`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `order_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `slot_id` | `bigint(20) unsigned` | YES | `NULL` | `—` | — |
| `order_date` | `datetime` | YES | `NULL` | `—` | — |
| `order_amount` | `varchar(255)` | YES | `NULL` | `—` | — |
| `amount_credited` | `bigint(20)` | YES | `0` | `—` | — |
| `amount_debited` | `bigint(20)` | YES | `0` | `—` | — |
| `user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `product_varient`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20)` | NO | `NULL` | `PRI` | auto_increment |
| `categoryid` | `bigint(20)` | YES | `NULL` | `—` | — |
| `subcategoryid` | `varchar(255)` | YES | `NULL` | `—` | — |
| `product_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `varient` | `int(11)` | YES | `NULL` | `—` | — |
| `varient_img` | `varchar(255)` | YES | `NULL` | `—` | — |
| `varient_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `value` | `varchar(50)` | YES | `NULL` | `—` | — |
| `offer_price` | `int(11)` | YES | `NULL` | `—` | — |
| `mrp_price` | `int(11)` | YES | `NULL` | `—` | — |
| `product_qty` | `int(11)` | YES | `NULL` | `—` | — |
| `low_stock` | `varchar(255)` | YES | `NULL` | `—` | — |
| `hot_deals` | `int(11)` | YES | `0` | `—` | — |
| `Popular_products` | `int(11)` | NO | `0` | `—` | — |
| `product_gst` | `int(11)` | NO | `0` | `—` | — |
| `subcatename` | `varchar(255)` | YES | `NULL` | `—` | — |
| `size_value` | `varchar(255)` | YES | `NULL` | `—` | — |
| `color_value` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | NO | `current_timestamp()` | `—` | on update current_timestamp() |
| `updated_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |

**Indexes (non-primary):**

- `product_id` on `product_id`

---

## `products`

**Row count:** 4

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `category_id` | `bigint(20) unsigned` | NO | `NULL` | `MUL` | — |
| `subcategory_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `product_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `prod_unique_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `product_quantity` | `bigint(20)` | YES | `NULL` | `—` | — |
| `product_mrp_price` | `bigint(20)` | YES | `NULL` | `—` | — |
| `product_regular_price` | `bigint(20)` | YES | `NULL` | `—` | — |
| `product_description` | `longtext` | YES | `NULL` | `—` | — |
| `product_image` | `varchar(255)` | YES | `NULL` | `—` | — |
| `product_specification` | `longtext` | YES | `NULL` | `—` | — |
| `product_specfication` | `longtext` | YES | `NULL` | `—` | — |
| `brand_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `brand_material` | `varchar(255)` | YES | `NULL` | `—` | — |
| `brand_type` | `varchar(255)` | YES | `NULL` | `—` | — |
| `approval_days` | `int(11)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |
| `unit_value` | `varchar(255)` | YES | `NULL` | `—` | — |
| `product_value` | `varchar(255)` | YES | `NULL` | `—` | — |
| `cate_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `subcate_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `size_value` | `int(11)` | YES | `0` | `—` | — |
| `size_chart_image` | `varchar(255)` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `products_category_id_foreign` on `category_id`

---

## `productstocks`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `productid` | `int(11)` | YES | `NULL` | `—` | — |
| `category_id` | `int(11)` | YES | `NULL` | `—` | — |
| `subcategory_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `pro_ver_id` | `bigint(20)` | NO | `NULL` | `MUL` | — |
| `productname` | `varchar(255)` | YES | `NULL` | `—` | — |
| `overallstock` | `int(11)` | YES | `NULL` | `—` | — |
| `availablestock` | `int(11)` | YES | `NULL` | `—` | — |
| `salestock` | `int(11)` | YES | `NULL` | `—` | — |
| `low_stocks` | `varchar(255)` | YES | `NULL` | `—` | — |
| `last_stockupdate_date` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |
| `updated_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |

**Indexes (non-primary):**

- `pro_ver_id` on `pro_ver_id`

---

## `reviews`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `email` | `varchar(255)` | YES | `NULL` | `—` | — |
| `prod_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `prod_var_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `review` | `varchar(255)` | YES | `NULL` | `—` | — |
| `ratings` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |
| `updated_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |

---

## `sample_order_full_details`

**Row count:** 5

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `order_primary_id` | `bigint(20) unsigned` | NO | `NULL` | `—` | — |
| `order_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `printing_method` | `varchar(255)` | YES | `NULL` | `—` | — |
| `user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `user_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `user_email` | `varchar(255)` | YES | `NULL` | `—` | — |
| `user_phone` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_username` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_phone_number` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_line_one` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_line_two` | `varchar(255)` | YES | `NULL` | `—` | — |
| `landmark` | `varchar(255)` | YES | `NULL` | `—` | — |
| `city` | `varchar(255)` | YES | `NULL` | `—` | — |
| `state` | `varchar(255)` | YES | `NULL` | `—` | — |
| `pincode` | `varchar(255)` | YES | `NULL` | `—` | — |
| `country` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_type_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `total_amount` | `decimal(10,2)` | NO | `0.00` | `—` | — |
| `grand_total_amount` | `decimal(10,2)` | NO | `0.00` | `—` | — |
| `payment_method` | `varchar(255)` | YES | `NULL` | `—` | — |
| `bank_country` | `varchar(255)` | YES | `NULL` | `—` | — |
| `paypal_payment_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `paypal_payer_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `payment_status_text` | `varchar(255)` | YES | `NULL` | `—` | — |
| `order_items` | `longtext` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `sample_variants`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `sample_id` | `bigint(20) unsigned` | NO | `NULL` | `MUL` | — |
| `varient_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `varient_img` | `varchar(255)` | YES | `NULL` | `—` | — |
| `size_value` | `varchar(255)` | YES | `NULL` | `—` | — |
| `color_value` | `varchar(255)` | YES | `NULL` | `—` | — |
| `sample_qty` | `int(11)` | NO | `0` | `—` | — |
| `mrp_price` | `decimal(10,2)` | NO | `0.00` | `—` | — |
| `offer_price` | `decimal(10,2)` | NO | `0.00` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Foreign Keys:**

| Constraint | Column | References |
|------------|--------|------------|
| `sample_variants_sample_id_foreign` | `sample_id` | `samples`.`id` |

**Indexes (non-primary):**

- `sample_variants_sample_id_foreign` on `sample_id`

---

## `samples`

**Row count:** 2

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `title` | `varchar(255)` | NO | `NULL` | `—` | — |
| `category` | `varchar(255)` | YES | `NULL` | `—` | — |
| `description` | `text` | YES | `NULL` | `—` | — |
| `image` | `varchar(255)` | YES | `NULL` | `—` | — |
| `badge` | `varchar(255)` | YES | `NULL` | `—` | — |
| `badge_type` | `varchar(255)` | YES | `NULL` | `—` | — |
| `price` | `decimal(10,2)` | NO | `0.00` | `—` | — |
| `sizes` | `longtext` | YES | `NULL` | `—` | — |
| `features` | `longtext` | YES | `NULL` | `—` | — |
| `gsm` | `text` | YES | `NULL` | `—` | — |
| `colors` | `text` | YES | `NULL` | `—` | — |
| `is_active` | `tinyint(1)` | NO | `1` | `—` | — |
| `sort_order` | `int(11)` | NO | `0` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |
| `stocks` | `int(11)` | YES | `0` | `—` | — |
| `cloth_types` | `text` | YES | `NULL` | `—` | — |

---

## `sessions`

**Row count:** 6

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `varchar(255)` | NO | `NULL` | `PRI` | — |
| `user_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `ip_address` | `varchar(45)` | YES | `NULL` | `—` | — |
| `user_agent` | `text` | YES | `NULL` | `—` | — |
| `payload` | `longtext` | NO | `NULL` | `—` | — |
| `last_activity` | `int(11)` | NO | `NULL` | `MUL` | — |

**Indexes (non-primary):**

- `sessions_user_id_index` on `user_id`
- `sessions_last_activity_index` on `last_activity`

---

## `shippings`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `location` | `text` | YES | `NULL` | `—` | — |
| `shipping_amt` | `text` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `size_charts`

**Row count:** 6

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `serial_no` | `int(11)` | NO | `NULL` | `—` | — |
| `usa_uk` | `varchar(255)` | NO | `NULL` | `—` | — |
| `eu` | `varchar(255)` | NO | `NULL` | `—` | — |
| `japan` | `varchar(255)` | NO | `NULL` | `—` | — |
| `korea` | `varchar(255)` | NO | `NULL` | `—` | — |
| `chest_cm` | `varchar(255)` | NO | `NULL` | `—` | — |
| `chest_inches` | `varchar(255)` | NO | `NULL` | `—` | — |
| `is_active` | `tinyint(1)` | YES | `1` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `states`

**Row count:** 39

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `name` | `varchar(30)` | NO | `NULL` | `—` | — |
| `country_id` | `int(11)` | NO | `1` | `—` | — |

---

## `sub_categories`

**Row count:** 5

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `subcategory_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `subcategory_image` | `varchar(255)` | YES | `NULL` | `—` | — |
| `category_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `category_display` | `varchar(255)` | YES | `NULL` | `—` | — |
| `status` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `telescope_entries`

**Row count:** 530

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `sequence` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `uuid` | `char(36)` | NO | `NULL` | `UNI` | — |
| `batch_id` | `char(36)` | NO | `NULL` | `MUL` | — |
| `family_hash` | `varchar(255)` | YES | `NULL` | `MUL` | — |
| `should_display_on_index` | `tinyint(1)` | NO | `1` | `—` | — |
| `type` | `varchar(20)` | NO | `NULL` | `MUL` | — |
| `content` | `longtext` | NO | `NULL` | `—` | — |
| `created_at` | `datetime` | YES | `NULL` | `MUL` | — |

**Indexes (non-primary):**

- `telescope_entries_uuid_unique` on `uuid` (UNIQUE)
- `telescope_entries_batch_id_index` on `batch_id`
- `telescope_entries_family_hash_index` on `family_hash`
- `telescope_entries_created_at_index` on `created_at`
- `telescope_entries_type_should_display_on_index_index` on `type`

---

## `telescope_entries_tags`

**Row count:** 127

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `entry_uuid` | `char(36)` | NO | `NULL` | `MUL` | — |
| `tag` | `varchar(255)` | NO | `NULL` | `MUL` | — |

**Indexes (non-primary):**

- `telescope_entries_tags_entry_uuid_tag_index` on `entry_uuid`
- `telescope_entries_tags_tag_index` on `tag`

---

## `telescope_monitoring`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `tag` | `varchar(255)` | NO | `NULL` | `—` | — |

---

## `testimonials`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `para` | `varchar(255)` | YES | `NULL` | `—` | — |
| `image` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `current_timestamp()` | `—` | — |
| `updated_at` | `timestamp` | YES | `current_timestamp()` | `—` | — |
| `firstname` | `varchar(255)` | YES | `NULL` | `—` | — |

---

## `tests`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `today_deals`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `product_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `variant_id` | `int(11)` | YES | `NULL` | `—` | — |
| `product_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `offer_value` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

---

## `user_addresses`

**Row count:** 2

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `address_username` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_first_name` | `varchar(50)` | YES | `NULL` | `—` | — |
| `address_last_name` | `varchar(20)` | YES | `NULL` | `—` | — |
| `user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `guest_user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_line_one` | `longtext` | YES | `NULL` | `—` | — |
| `address_line_two` | `longtext` | YES | `NULL` | `—` | — |
| `landmark` | `longtext` | YES | `NULL` | `—` | — |
| `area_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `area_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `city` | `longtext` | YES | `NULL` | `—` | — |
| `city_id` | `int(11)` | YES | `NULL` | `—` | — |
| `state_id` | `int(11)` | YES | `NULL` | `—` | — |
| `pincode` | `varchar(20)` | NO | `NULL` | `—` | — |
| `pincode_id` | `int(11)` | YES | `NULL` | `—` | — |
| `district` | `varchar(255)` | YES | `NULL` | `—` | — |
| `country` | `varchar(255)` | YES | `NULL` | `—` | — |
| `state` | `varchar(225)` | YES | `NULL` | `—` | — |
| `address_phone_number` | `bigint(20)` | YES | `NULL` | `—` | — |
| `address_type_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `address_type_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `address_type_others_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `NULL` | `—` | — |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `users_area_id_foreign` on `area_id`
- `users_address_type_id_foreign` on `address_type_id`

---

## `user_read_notifications`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `notification_id` | `bigint(20)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | NO | `current_timestamp()` | `—` | — |

---

## `users`

**Row count:** 2

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `bigint(20) unsigned` | NO | `NULL` | `PRI` | auto_increment |
| `user_id` | `varchar(255)` | YES | `NULL` | `UNI` | — |
| `is_guest_user` | `int(11)` | NO | `0` | `—` | — |
| `user_token` | `text` | YES | `NULL` | `—` | — |
| `name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `email` | `varchar(255)` | YES | `NULL` | `UNI` | — |
| `user_type` | `varchar(255)` | NO | `normaluser` | `—` | — |
| `gst_number` | `varchar(255)` | YES | `NULL` | `—` | — |
| `phone_number` | `varchar(255)` | YES | `NULL` | `UNI` | — |
| `first_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `last_name` | `varchar(255)` | YES | `NULL` | `—` | — |
| `gender` | `smallint(6)` | YES | `NULL` | `—` | — |
| `profile_image` | `text` | YES | `NULL` | `—` | — |
| `user_default_address_id` | `bigint(20) unsigned` | YES | `NULL` | `—` | — |
| `area_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `address_type_id` | `bigint(20) unsigned` | YES | `NULL` | `MUL` | — |
| `email_verified_at` | `timestamp` | YES | `NULL` | `—` | — |
| `password` | `varchar(255)` | YES | `NULL` | `—` | — |
| `otp` | `text` | YES | `NULL` | `—` | — |
| `otp_expiry` | `text` | YES | `NULL` | `—` | — |
| `enc_password` | `text` | YES | `NULL` | `—` | — |
| `remember_token` | `varchar(100)` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `current_timestamp()` | `—` | — |
| `updated_at` | `timestamp` | YES | `current_timestamp()` | `—` | — |
| `from_app` | `int(11)` | NO | `0` | `—` | — |
| `firebase_fcm_token` | `text` | YES | `NULL` | `—` | — |

**Indexes (non-primary):**

- `users_email_unique` on `email` (UNIQUE)
- `users_phone_number_unique` on `phone_number` (UNIQUE)
- `users_user_id_unique` on `user_id` (UNIQUE)
- `users_address_type_id_foreign` on `address_type_id`
- `users_area_id_foreign` on `area_id`

---

## `web_images`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `image` | `text` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | NO | `current_timestamp()` | `—` | on update current_timestamp() |
| `updated_at` | `timestamp` | YES | `NULL` | `—` | — |
| `title` | `varchar(255)` | YES | `NULL` | `—` | — |
| `subtitle` | `varchar(255)` | YES | `NULL` | `—` | — |
| `button_text` | `varchar(255)` | YES | `NULL` | `—` | — |
| `button_url` | `varchar(500)` | YES | `NULL` | `—` | — |

---

## `wishlists`

**Row count:** 0

| Column | Type | Nullable | Default | Key | Extra |
|--------|------|----------|---------|-----|-------|
| `id` | `int(11)` | NO | `NULL` | `PRI` | auto_increment |
| `user_id` | `varchar(255)` | YES | `NULL` | `—` | — |
| `product_id` | `int(11)` | YES | `NULL` | `—` | — |
| `product_name` | `text` | YES | `NULL` | `—` | — |
| `product_varient_id` | `int(11)` | YES | `NULL` | `—` | — |
| `product_quantity` | `int(11)` | YES | `NULL` | `—` | — |
| `product_color` | `text` | YES | `NULL` | `—` | — |
| `product_image` | `text` | YES | `NULL` | `—` | — |
| `price` | `text` | YES | `NULL` | `—` | — |
| `product_size` | `text` | YES | `NULL` | `—` | — |
| `created_at` | `timestamp` | YES | `current_timestamp()` | `—` | — |
| `updated_at` | `timestamp` | YES | `current_timestamp()` | `—` | — |

---

## Relationships

### Foreign Key Mappings

| From Table | From Column | → | To Table | To Column |
|------------|-------------|---|----------|-----------|
| `app_alerts` | `user_id` | → | `users` | `user_id` |
| `app_notifications` | `user_id` | → | `users` | `user_id` |
| `area_assigns` | `area_id` | → | `areas` | `id` |
| `area_assigns` | `delivery_people_id` | → | `delivery_people` | `id` |
| `carts` | `design_id` | → | `customproduct_designs` | `id` |
| `customproduct_designs` | `customproduct_id` | → | `customproducts` | `id` |
| `customproduct_designs` | `product_color_id` | → | `product_colors` | `id` |
| `design_layers` | `design_id` | → | `customproduct_designs` | `id` |
| `design_variants` | `design_id` | → | `designs` | `id` |
| `milk_orders` | `plan_type` | → | `plan_types` | `id` |
| `milk_orders` | `user_id` | → | `users` | `user_id` |
| `milk_orders` | `delivery_person_id` | → | `delivery_people` | `delivery_person_id` |
| `milk_slots` | `order_id` | → | `milk_orders` | `order_id` |
| `product_color_images` | `product_color_id` | → | `product_colors` | `id` |
| `product_colors` | `customproduct_id` | → | `customproducts` | `id` |
| `product_orders` | `delivery_person_id` | → | `delivery_people` | `delivery_person_id` |
| `sample_variants` | `sample_id` | → | `samples` | `id` |

### Relationship Descriptions (Plain Language)

- `app_alerts`.`user_id` → `users`.`user_id` (relationship unknown (empty table))
- `app_notifications`.`user_id` → `users`.`user_id` (relationship unknown (empty table))
- `area_assigns`.`area_id` → `areas`.`id` (relationship unknown (empty table))
- `area_assigns`.`delivery_people_id` → `delivery_people`.`id` (relationship unknown (empty table))
- `carts`.`design_id` → `customproduct_designs`.`id` (relationship unknown (empty table))
- `customproduct_designs`.`customproduct_id` → `customproducts`.`id` (many-to-one (many customproduct_designs per customproducts))
- `customproduct_designs`.`product_color_id` → `product_colors`.`id` (many-to-one (many customproduct_designs per product_colors))
- `design_layers`.`design_id` → `customproduct_designs`.`id` (many-to-one (many design_layers per customproduct_designs))
- `design_variants`.`design_id` → `designs`.`id` (relationship unknown (empty table))
- `milk_orders`.`plan_type` → `plan_types`.`id` (relationship unknown (empty table))
- `milk_orders`.`user_id` → `users`.`user_id` (relationship unknown (empty table))
- `milk_orders`.`delivery_person_id` → `delivery_people`.`delivery_person_id` (relationship unknown (empty table))
- `milk_slots`.`order_id` → `milk_orders`.`order_id` (relationship unknown (empty table))
- `product_color_images`.`product_color_id` → `product_colors`.`id` (many-to-one (many product_color_images per product_colors))
- `product_colors`.`customproduct_id` → `customproducts`.`id` (many-to-one (many product_colors per customproducts))
- `product_orders`.`delivery_person_id` → `delivery_people`.`delivery_person_id` (many-to-one (many product_orders per delivery_people))
- `sample_variants`.`sample_id` → `samples`.`id` (relationship unknown (empty table))

### Detected Eloquent Relationships (from Models)

| App | Model | Relationship | Related Model | Type |
|-----|-------|-------------|---------------|------|
| dash | `AddressType` | `user()` | `User` | `belongsTo` |
| dash | `AppAlert` | `user()` | `User` | `belongsTo` |
| dash | `AppNotification` | `user()` | `User` | `belongsTo` |
| dash | `Area` | `areaAssigns()` | `AreaAssign` | `hasMany` |
| dash | `AreaAssign` | `area()` | `Area` | `belongsTo` |
| dash | `AreaAssign` | `deliveryPerson()` | `DeliveryPerson` | `belongsTo` |
| dash | `BulkOrder` | `product()` | `Product` | `belongsTo` |
| dash | `Cart` | `product()` | `Product` | `belongsTo` |
| dash | `Category` | `products()` | `Product` | `hasMany` |
| dash | `CustomProduct` | `colors()` | `ProductColor` | `hasMany` |
| dash | `DeliveryPerson` | `areaAssigns()` | `AreaAssign` | `hasMany` |
| dash | `DeliveryPerson` | `milkOrders()` | `MilkOrder` | `hasMany` |
| dash | `DeliveryPerson` | `productOrders()` | `ProductOrder` | `hasMany` |
| dash | `MilkOrder` | `product()` | `Product` | `belongsTo` |
| dash | `MilkOrder` | `customer()` | `User` | `belongsTo` |
| dash | `MilkOrder` | `area()` | `MilkTransactionLog` | `hasOne` |
| dash | `MilkOrder` | `transactionLog()` | `MilkOrderUserAddress` | `hasOne` |
| dash | `MilkOrderUserAddress` | `milkOrder()` | `MilkOrder` | `belongsTo` |
| dash | `MilkOrderUserAddress` | `area()` | `Area` | `belongsTo` |
| dash | `MilkRefund` | `milk_order()` | `MilkOrder` | `belongsTo` |
| dash | `MilkSlot` | `order()` | `MilkOrder` | `belongsTo` |
| dash | `MilkTransactionLog` | `milkOrder()` | `MilkOrder` | `belongsTo` |
| dash | `Product` | `category()` | `Category` | `belongsTo` |
| dash | `Product` | `Subcategory()` | `SubCategory` | `belongsTo` |
| dash | `Product` | `productvari()` | `ProductVerient` | `hasMany` |
| dash | `Product` | `childImages()` | `ProductChildImage` | `hasMany` |
| dash | `ProductChildImage` | `product()` | `Product` | `belongsTo` |
| dash | `ProductChildImage` | `variant()` | `ProductVarient` | `belongsTo` |
| dash | `ProductColor` | `customProduct()` | `CustomProduct` | `belongsTo` |
| dash | `ProductColor` | `images()` | `ProductColorImage` | `hasMany` |
| dash | `ProductColorImage` | `productColor()` | `ProductColor` | `belongsTo` |
| dash | `ProductOrder` | `product()` | `Product` | `belongsTo` |
| dash | `ProductOrder` | `customer()` | `User` | `belongsTo` |
| dash | `ProductOrder` | `area()` | `ProductTransactionLog` | `hasOne` |
| dash | `ProductOrder` | `transactionLog()` | `ProductOrderUserAddress` | `hasOne` |
| dash | `ProductOrder` | `getDateOrderedOnAttribute()` | `UserAddress` | `hasOne` |
| dash | `ProductOrder` | `orderAddress()` | `State` | `belongsTo` |
| dash | `ProductOrderUserAddress` | `productOrder()` | `ProductOrder` | `belongsTo` |
| dash | `ProductOrderUserAddress` | `area()` | `Area` | `belongsTo` |
| dash | `ProductOrderUserAddress` | `state()` | `State` | `belongsTo` |
| dash | `ProductRefund` | `product_order()` | `ProductOrder` | `belongsTo` |
| dash | `ProductRefund` | `product()` | `Product` | `belongsTo` |
| dash | `ProductRefund` | `productverient()` | `ProductVarient` | `belongsTo` |
| dash | `ProductRefund` | `product_slot()` | `ProductSlot` | `belongsTo` |
| dash | `ProductSlot` | `productOrder()` | `ProductOrder` | `belongsTo` |
| dash | `ProductSlot` | `order()` | `ProductOrder` | `belongsTo` |
| dash | `ProductSlot` | `product()` | `Product` | `belongsTo` |
| dash | `ProductSlot` | `productVarient()` | `ProductVarient` | `belongsTo` |
| dash | `ProductSlot` | `productorderAddress()` | `ProductOrderUserAddress` | `belongsTo` |
| dash | `ProductSlot` | `state()` | `State` | `belongsTo` |
| dash | `ProductStock` | `category()` | `Category` | `belongsTo` |
| dash | `ProductStock` | `Productvarient()` | `ProductVarient` | `belongsTo` |
| dash | `ProductVarient` | `category()` | `Category` | `belongsTo` |
| dash | `SubCategory` | `category()` | `Category` | `belongsTo` |
| dash | `User` | `milkOrder()` | `MilkOrder` | `hasOne` |
| dash | `User` | `area()` | `Area` | `belongsTo` |
| dash | `User` | `user_addresses()` | `UserAddress` | `hasMany` |
| dash | `User` | `defaultAddress()` | `UserAddress` | `belongsTo` |
| dash | `User` | `latestAddress()` | `UserAddress` | `hasOne` |
| dash | `UserAddress` | `user()` | `User` | `belongsTo` |
| dash | `UserAddress` | `area()` | `Area` | `belongsTo` |
| web | `Cart` | `design()` | `CustomproductDesign` | `belongsTo` |
| web | `Category` | `subCategories()` | `SubCategory` | `hasMany` |
| web | `Customproduct` | `designs()` | `CustomproductDesign` | `hasMany` |
| web | `Customproduct` | `colors()` | `ProductColor` | `hasMany` |
| web | `CustomproductDesign` | `customproduct()` | `Customproduct` | `belongsTo` |
| web | `CustomproductDesign` | `color()` | `ProductColor` | `belongsTo` |
| web | `CustomproductDesign` | `layers()` | `DesignLayer` | `hasMany` |
| web | `CustomproductDesign` | `user()` | `User` | `belongsTo` |
| web | `CustomproductDesign` | `cartItems()` | `Cart` | `hasMany` |
| web | `DesignLayer` | `design()` | `CustomproductDesign` | `belongsTo` |
| web | `Product` | `category()` | `Category` | `belongsTo` |
| web | `Product` | `subcategory()` | `SubCategory` | `belongsTo` |
| web | `ProductColor` | `product()` | `Customproduct` | `belongsTo` |
| web | `ProductColor` | `images()` | `ProductColorImage` | `hasMany` |
| web | `ProductColor` | `designs()` | `CustomproductDesign` | `hasMany` |
| web | `ProductColorImage` | `color()` | `ProductColor` | `belongsTo` |
| web | `ProductOrder` | `items()` | `ProductOrderDetail` | `hasMany` |
| web | `ProductOrder` | `shippingAddress()` | `ProductOrderUserAddress` | `hasOne` |
| web | `SubCategory` | `category()` | `Category` | `belongsTo` |
| web | `User` | `addresses()` | `UserAddress` | `hasMany` |
| web | `User` | `cartItems()` | `Cart` | `hasMany` |
| web | `User` | `orders()` | `ProductOrder` | `hasMany` |
| web | `User` | `designs()` | `CustomproductDesign` | `hasMany` |
