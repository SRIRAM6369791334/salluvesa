# 🗄️ Database Schema Documentation: `saaluvesa_db`

**Host**: `127.0.0.1` | **Generated At**: 2026-07-29 06:44:27 | **Total Tables**: 84

---

## 📌 Table List & Row Counts

| Table Name | Row Count |
| :--- | :--- |
| `address_types` | 3 |
| `all_india_pincodes` | 0 |
| `app_alerts` | 0 |
| `app_notifications` | 0 |
| `app_settings` | 8 |
| `area_assigns` | 0 |
| `areas` | 0 |
| `bank_details` | 6 |
| `banner_images` | 1 |
| `bulk_orders` | 1 |
| `cache` | 1 |
| `cache_locks` | 0 |
| `cancel_requests` | 0 |
| `carts` | 0 |
| `categories` | 3 |
| `checkout_settings` | 1 |
| `cities` | 7692 |
| `contact_details` | 0 |
| `contact_messages` | 0 |
| `country_tables` | 0 |
| `coupons` | 0 |
| `customers` | 0 |
| `customproduct_designs` | 11 |
| `customproducts` | 1 |
| `dashboard_users` | 1 |
| `delivery_charge_details` | 1 |
| `delivery_people` | 0 |
| `design_layers` | 15 |
| `design_variants` | 0 |
| `designs` | 0 |
| `districts` | 38 |
| `exchange_rates` | 39 |
| `failed_jobs` | 2 |
| `gender_types` | 3 |
| `invoices` | 0 |
| `jobs` | 8 |
| `mail_otps` | 0 |
| `migrations` | 125 |
| `milk_order_user_addresses` | 0 |
| `milk_orders` | 0 |
| `milk_refunds` | 0 |
| `milk_slots` | 0 |
| `milk_transaction_logs` | 0 |
| `notifications` | 0 |
| `offer_images` | 0 |
| `onetimes` | 0 |
| `order_export_data` | 1 |
| `otps` | 0 |
| `password_reset_tokens` | 0 |
| `password_resets` | 0 |
| `personal_access_tokens` | 54 |
| `plan_types` | 3 |
| `product_child_images` | 0 |
| `product_color_images` | 8 |
| `product_colors` | 2 |
| `product_order_user_addresses` | 5 |
| `product_orders` | 5 |
| `product_refunds` | 0 |
| `product_slots` | 5 |
| `product_tracking` | 1 |
| `product_transaction_logs` | 0 |
| `product_varient` | 0 |
| `products` | 4 |
| `productstocks` | 0 |
| `reviews` | 0 |
| `sample_order_full_details` | 5 |
| `sample_variants` | 0 |
| `samples` | 2 |
| `sessions` | 7 |
| `shippings` | 0 |
| `size_charts` | 6 |
| `states` | 39 |
| `sub_categories` | 5 |
| `telescope_entries` | 530 |
| `telescope_entries_tags` | 127 |
| `telescope_monitoring` | 0 |
| `testimonials` | 0 |
| `tests` | 0 |
| `today_deals` | 0 |
| `user_addresses` | 2 |
| `user_read_notifications` | 0 |
| `users` | 2 |
| `web_images` | 0 |
| `wishlists` | 0 |

---

## 📋 Detailed Table Structures

### 🗂️ Table: `address_types` (Rows: 3)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `address_type_name` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `all_india_pincodes` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `officename` | `varchar(50)` | YES | - | *NULL* |
| `pincode` | `bigint(20)` | YES | - | *NULL* |
| `officeType` | `varchar(50)` | YES | - | *NULL* |
| `Deliverystatus` | `varchar(50)` | YES | - | *NULL* |
| `divisionname` | `varchar(50)` | YES | - | *NULL* |
| `regionname` | `varchar(50)` | YES | - | *NULL* |
| `circlename` | `varchar(50)` | YES | - | *NULL* |
| `Taluk` | `varchar(50)` | YES | - | *NULL* |
| `Districtname` | `varchar(50)` | YES | - | *NULL* |
| `statename` | `varchar(50)` | YES | **MUL** | *NULL* |
| `Telephone` | `varchar(50)` | YES | - | *NULL* |
| `relatedSuboffice` | `varchar(50)` | YES | - | *NULL* |
| `relatedHeadoffice` | `varchar(50)` | YES | - | *NULL* |

---

### 🗂️ Table: `app_alerts` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `alert_id` | `text` | YES | - | *NULL* |
| `user_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `alert_title` | `text` | YES | - | *NULL* |
| `alert_content` | `text` | YES | - | *NULL* |
| `alert_image` | `text` | YES | - | *NULL* |
| `mark_as_read` | `int(11)` | NO | - | `0` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `app_notifications` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `notification_id` | `text` | YES | - | *NULL* |
| `user_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `notification_title` | `text` | YES | - | *NULL* |
| `notification_content` | `text` | YES | - | *NULL* |
| `notification_image` | `text` | YES | - | *NULL* |
| `mark_as_read` | `int(11)` | NO | - | `0` |
| `created_at` | `timestamp` | YES | - | `current_timestamp()` |
| `updated_at` | `timestamp` | YES | - | `current_timestamp()` |

---

### 🗂️ Table: `app_settings` (Rows: 8)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `user_type` | `varchar(255)` | NO | **MUL** | *NULL* |
| `product_type` | `varchar(255)` | NO | - | *NULL* |
| `min_quantity` | `int(11)` | NO | - | `1` |
| `max_quantity` | `int(11)` | NO | - | `100` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `area_assigns` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `area_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `delivery_people_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `areas` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `area_name` | `varchar(255)` | YES | - | *NULL* |
| `area_pincode` | `bigint(20)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `bank_details` (Rows: 6)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `account_holder_name` | `varchar(255)` | YES | - | *NULL* |
| `bank_name` | `varchar(255)` | YES | - | *NULL* |
| `account_number` | `varchar(255)` | YES | - | *NULL* |
| `account_type` | `varchar(255)` | YES | - | *NULL* |
| `payment_method` | `varchar(255)` | YES | - | *NULL* |
| `routing_number` | `varchar(255)` | YES | - | *NULL* |
| `ifsc_code` | `varchar(255)` | YES | - | *NULL* |
| `swift_code` | `varchar(255)` | YES | - | *NULL* |
| `bank_branch_name` | `varchar(255)` | YES | - | *NULL* |
| `bank_branch_address` | `text` | YES | - | *NULL* |
| `beneficiary_address` | `text` | YES | - | *NULL* |
| `bank_country` | `varchar(255)` | YES | - | *NULL* |
| `description` | `longtext` | YES | - | *NULL* |
| `currency_accepted` | `varchar(255)` | YES | - | *NULL* |
| `business_name` | `varchar(255)` | YES | - | *NULL* |
| `business_address` | `text` | YES | - | *NULL* |
| `business_email` | `varchar(255)` | YES | - | *NULL* |
| `business_contact_number` | `varchar(255)` | YES | - | *NULL* |
| `gst_number` | `varchar(255)` | YES | - | *NULL* |
| `payment_confirmation_time` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `banner_images` (Rows: 1)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `banner_image` | `text` | YES | - | *NULL* |
| `banner_position` | `text` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |
| `title` | `varchar(255)` | YES | - | *NULL* |
| `subtitle` | `varchar(255)` | YES | - | *NULL* |
| `button_text` | `varchar(255)` | YES | - | *NULL* |
| `button_url` | `varchar(500)` | YES | - | *NULL* |

---

### 🗂️ Table: `bulk_orders` (Rows: 1)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `order_id` | `varchar(255)` | YES | - | *NULL* |
| `name` | `varchar(255)` | NO | - | *NULL* |
| `email` | `varchar(255)` | NO | - | *NULL* |
| `user_type` | `varchar(255)` | NO | - | *NULL* |
| `quantity` | `int(11)` | NO | - | *NULL* |
| `product_type` | `varchar(255)` | NO | - | *NULL* |
| `product_id` | `bigint(20) unsigned` | YES | - | *NULL* |
| `custom_image` | `varchar(255)` | YES | - | *NULL* |
| `notes` | `text` | YES | - | *NULL* |
| `status` | `tinyint(4)` | NO | - | `0` |
| `admin_notes` | `text` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `cache` (Rows: 1)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `key` | `varchar(255)` | NO | **PRI** | *NULL* |
| `value` | `mediumtext` | NO | - | *NULL* |
| `expiration` | `int(11)` | NO | - | *NULL* |

---

### 🗂️ Table: `cache_locks` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `key` | `varchar(255)` | NO | **PRI** | *NULL* |
| `owner` | `varchar(255)` | NO | - | *NULL* |
| `expiration` | `int(11)` | NO | - | *NULL* |

---

### 🗂️ Table: `cancel_requests` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `order_id` | `varchar(255)` | YES | - | *NULL* |
| `user_id` | `varchar(255)` | YES | - | *NULL* |
| `approval_status` | `int(11)` | NO | - | `0` |
| `created_at` | `timestamp` | NO | - | `current_timestamp()` |
| `updated_at` | `timestamp` | NO | - | `current_timestamp()` |

---

### 🗂️ Table: `carts` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `user_id` | `varchar(255)` | YES | - | *NULL* |
| `session_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `product_id` | `bigint(20) unsigned` | YES | - | *NULL* |
| `product_varient_id` | `bigint(20)` | YES | - | *NULL* |
| `product_quantity` | `int(11)` | YES | - | *NULL* |
| `product_name` | `text` | YES | - | *NULL* |
| `product_color` | `text` | YES | - | *NULL* |
| `roster_data` | `longtext` | YES | - | *NULL* |
| `design_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `price` | `text` | YES | - | *NULL* |
| `extra_price` | `decimal(10,2)` | NO | - | `0.00` |
| `product_size` | `text` | YES | - | *NULL* |
| `product_image` | `text` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |
| `product_type` | `varchar(255)` | YES | - | *NULL* |
| `stock_id` | `int(11)` | YES | - | *NULL* |

---

### 🗂️ Table: `categories` (Rows: 3)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `category_name` | `varchar(255)` | YES | - | *NULL* |
| `category_image` | `varchar(255)` | YES | - | *NULL* |
| `status` | `int(11)` | YES | - | `0` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `checkout_settings` (Rows: 1)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `paypal_max_quantity` | `int(11)` | NO | - | `10` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `cities` (Rows: 7692)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `name` | `varchar(30)` | NO | - | *NULL* |
| `state_id` | `int(11)` | NO | - | *NULL* |

---

### 🗂️ Table: `contact_details` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `mobile_number1` | `varchar(20)` | YES | - | *NULL* |
| `mobile_number2` | `varchar(20)` | YES | - | *NULL* |
| `address` | `text` | YES | - | *NULL* |
| `email` | `varchar(100)` | YES | - | *NULL* |
| `fb_link` | `text` | YES | - | *NULL* |
| `insta_link` | `text` | YES | - | *NULL* |
| `twitter_link` | `text` | YES | - | *NULL* |
| `map_link` | `text` | YES | - | *NULL* |
| `created_at` | `timestamp` | NO | - | `current_timestamp()` |

---

### 🗂️ Table: `contact_messages` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `name` | `varchar(255)` | NO | - | *NULL* |
| `email` | `varchar(255)` | NO | - | *NULL* |
| `phone` | `varchar(20)` | YES | - | *NULL* |
| `country` | `varchar(100)` | YES | - | *NULL* |
| `subject` | `varchar(500)` | NO | - | *NULL* |
| `message` | `text` | NO | - | *NULL* |
| `ip_address` | `varchar(45)` | YES | - | *NULL* |
| `user_agent` | `varchar(500)` | YES | - | *NULL* |
| `status` | `enum('new','read','replied')` | NO | **MUL** | `new` |
| `created_at` | `timestamp` | YES | **MUL** | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `country_tables` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `coupons` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `codename` | `varchar(255)` | YES | - | *NULL* |
| `mini_amt` | `int(11)` | YES | - | *NULL* |
| `discounttype` | `int(11)` | YES | - | *NULL* |
| `discount` | `int(11)` | YES | - | *NULL* |
| `start_date` | `date` | YES | - | *NULL* |
| `end_date` | `date` | YES | - | *NULL* |
| `default_id` | `varchar(255)` | YES | - | `0` |
| `coupon_status` | `int(11)` | NO | - | `0` |
| `created_at` | `timestamp` | NO | - | `current_timestamp()` |
| `updated_at` | `timestamp` | NO | - | `current_timestamp()` |

---

### 🗂️ Table: `customers` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `order_id` | `varchar(255)` | NO | - | *NULL* |
| `user_id` | `varchar(255)` | NO | - | *NULL* |
| `customername` | `varchar(255)` | NO | - | *NULL* |
| `phone_number` | `varchar(255)` | NO | - | *NULL* |
| `email` | `varchar(255)` | NO | - | *NULL* |
| `product_quantity` | `varchar(255)` | NO | - | *NULL* |
| `product_price` | `varchar(255)` | NO | - | *NULL* |
| `total_price` | `varchar(255)` | NO | - | *NULL* |
| `couponcode` | `varchar(255)` | NO | - | *NULL* |
| `shippingname` | `varchar(255)` | NO | - | *NULL* |
| `shippingphone` | `varchar(255)` | NO | - | *NULL* |
| `shippingemail` | `varchar(255)` | NO | - | *NULL* |
| `shippingstate` | `varchar(255)` | NO | - | *NULL* |
| `shippingcity` | `varchar(255)` | NO | - | *NULL* |
| `shippingpostal_code` | `varchar(255)` | NO | - | *NULL* |
| `state` | `varchar(255)` | NO | - | *NULL* |
| `city` | `varchar(255)` | NO | - | *NULL* |
| `postal_code` | `varchar(255)` | NO | - | *NULL* |
| `payment_status` | `varchar(255)` | NO | - | *NULL* |
| `delivery_status` | `varchar(255)` | NO | - | *NULL* |
| `order_date` | `date` | NO | - | *NULL* |
| `shippingamt` | `varchar(255)` | NO | - | *NULL* |
| `netamount` | `varchar(255)` | NO | - | *NULL* |
| `trackingid` | `varchar(255)` | NO | - | *NULL* |
| `delivery_date` | `varchar(255)` | NO | - | *NULL* |
| `dispatched_date` | `varchar(255)` | NO | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `customproduct_designs` (Rows: 11)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `user_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `session_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `customproduct_id` | `bigint(20) unsigned` | NO | **MUL** | *NULL* |
| `design_name` | `varchar(255)` | YES | - | *NULL* |
| `product_color_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `canvas_width` | `int(11)` | YES | - | `400` |
| `canvas_height` | `int(11)` | YES | - | `500` |
| `product_color` | `varchar(255)` | YES | - | `white` |
| `product_size` | `varchar(255)` | YES | - | `M` |
| `design_json_front` | `longtext` | YES | - | *NULL* |
| `design_json_back` | `longtext` | YES | - | *NULL* |
| `design_json_chest` | `longtext` | YES | - | *NULL* |
| `design_json_shoulder` | `longtext` | YES | - | *NULL* |
| `preview_image_front` | `varchar(255)` | YES | - | *NULL* |
| `preview_image_back` | `varchar(255)` | YES | - | *NULL* |
| `preview_image_chest` | `varchar(255)` | YES | - | *NULL* |
| `preview_image_shoulder` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |
| `design_json_right_shoulder` | `longtext` | YES | - | *NULL* |
| `design_json_left_shoulder` | `longtext` | YES | - | *NULL* |
| `preview_image_right_shoulder` | `varchar(255)` | YES | - | *NULL* |
| `preview_image_left_shoulder` | `varchar(255)` | YES | - | *NULL* |
| `thumbnail_path` | `varchar(255)` | YES | - | *NULL* |
| `status` | `varchar(255)` | NO | - | `draft` |

---

### 🗂️ Table: `customproducts` (Rows: 1)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `name` | `varchar(255)` | NO | - | *NULL* |
| `description` | `text` | YES | - | *NULL* |
| `base_price` | `decimal(10,2)` | NO | - | *NULL* |
| `extra_element_price` | `decimal(10,2)` | NO | - | `50.00` |
| `product_type` | `enum('tshirt','hoodie','mug','cap','bag')` | NO | - | `tshirt` |
| `front_mockup` | `varchar(255)` | YES | - | *NULL* |
| `back_mockup` | `varchar(255)` | YES | - | *NULL* |
| `right_shoulder_mockup` | `varchar(255)` | YES | - | *NULL* |
| `left_shoulder_mockup` | `varchar(255)` | YES | - | *NULL* |
| `printable_rect` | `longtext` | YES | - | *NULL* |
| `is_two_sided` | `tinyint(1)` | NO | - | `0` |
| `available_sizes` | `longtext` | YES | - | *NULL* |
| `canvas_config` | `longtext` | YES | - | *NULL* |
| `status` | `enum('active','inactive')` | NO | - | `active` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `dashboard_users` (Rows: 1)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `name` | `varchar(255)` | NO | - | *NULL* |
| `empl_num` | `varchar(255)` | YES | - | *NULL* |
| `email` | `varchar(255)` | NO | **UNI** | *NULL* |
| `phone_number` | `varchar(255)` | YES | - | *NULL* |
| `role` | `varchar(255)` | YES | - | *NULL* |
| `status` | `int(11)` | YES | - | *NULL* |
| `email_verified_at` | `timestamp` | YES | - | *NULL* |
| `password` | `varchar(255)` | NO | - | *NULL* |
| `avatar` | `varchar(255)` | YES | - | *NULL* |
| `remember_token` | `varchar(100)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `delivery_charge_details` (Rows: 1)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `delivery_charge` | `int(11)` | NO | - | `0` |
| `minimum_price` | `int(11)` | NO | - | `0` |
| `created_at` | `timestamp` | NO | - | `current_timestamp()` |

---

### 🗂️ Table: `delivery_people` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `delivery_person_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `name` | `varchar(255)` | NO | - | *NULL* |
| `email` | `varchar(255)` | NO | **UNI** | *NULL* |
| `phone_number` | `bigint(20)` | NO | **UNI** | *NULL* |
| `email_verified_at` | `timestamp` | YES | - | *NULL* |
| `password` | `varchar(255)` | NO | - | *NULL* |
| `enc_password` | `varchar(255)` | NO | - | *NULL* |
| `remember_token` | `varchar(100)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `design_layers` (Rows: 15)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `design_id` | `bigint(20) unsigned` | NO | **MUL** | *NULL* |
| `layer_type` | `varchar(255)` | NO | - | *NULL* |
| `layer_name` | `varchar(255)` | YES | - | *NULL* |
| `source_path` | `varchar(500)` | YES | - | *NULL* |
| `text_content` | `text` | YES | - | *NULL* |
| `x_position` | `decimal(12,4)` | NO | - | *NULL* |
| `y_position` | `decimal(12,4)` | NO | - | *NULL* |
| `width` | `decimal(12,4)` | NO | - | *NULL* |
| `height` | `decimal(12,4)` | NO | - | *NULL* |
| `rotation` | `decimal(8,2)` | NO | - | `0.00` |
| `scale_x` | `decimal(12,4)` | NO | - | `1.0000` |
| `scale_y` | `decimal(12,4)` | NO | - | `1.0000` |
| `print_position` | `varchar(255)` | NO | **MUL** | *NULL* |
| `z_index` | `int(11)` | NO | - | `0` |
| `layer_json` | `longtext` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `design_variants` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `design_id` | `bigint(20) unsigned` | NO | **MUL** | *NULL* |
| `varient_name` | `varchar(255)` | YES | - | *NULL* |
| `varient_img` | `varchar(255)` | YES | - | *NULL* |
| `size_value` | `varchar(255)` | YES | - | *NULL* |
| `color_value` | `varchar(255)` | YES | - | *NULL* |
| `design_qty` | `int(11)` | NO | - | `0` |
| `mrp_price` | `decimal(10,2)` | NO | - | `0.00` |
| `offer_price` | `decimal(10,2)` | NO | - | `0.00` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `designs` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `image` | `varchar(255)` | NO | - | *NULL* |
| `title` | `varchar(255)` | NO | - | *NULL* |
| `tag` | `varchar(255)` | NO | - | *NULL* |
| `type` | `varchar(255)` | NO | - | *NULL* |
| `price` | `decimal(10,2)` | NO | - | *NULL* |
| `description` | `text` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |
| `stocks` | `int(11)` | YES | - | `0` |
| `size` | `text` | YES | - | *NULL* |
| `cloth_types` | `text` | YES | - | *NULL* |

---

### 🗂️ Table: `districts` (Rows: 38)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `name` | `varchar(255)` | NO | - | *NULL* |
| `state_id` | `int(11)` | YES | - | *NULL* |
| `state_name` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `exchange_rates` (Rows: 39)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `base_currency` | `varchar(3)` | NO | **MUL** | *NULL* |
| `target_currency` | `varchar(3)` | NO | **MUL** | *NULL* |
| `rate` | `decimal(15,6)` | NO | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `failed_jobs` (Rows: 2)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `uuid` | `varchar(255)` | NO | **UNI** | *NULL* |
| `connection` | `text` | NO | - | *NULL* |
| `queue` | `text` | NO | - | *NULL* |
| `payload` | `longtext` | NO | - | *NULL* |
| `exception` | `longtext` | NO | - | *NULL* |
| `failed_at` | `timestamp` | NO | - | `current_timestamp()` |

---

### 🗂️ Table: `gender_types` (Rows: 3)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `gender_name` | `varchar(255)` | NO | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `invoices` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `jobs` (Rows: 8)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `queue` | `varchar(255)` | NO | **MUL** | *NULL* |
| `payload` | `longtext` | NO | - | *NULL* |
| `attempts` | `tinyint(3) unsigned` | NO | - | *NULL* |
| `reserved_at` | `int(10) unsigned` | YES | - | *NULL* |
| `available_at` | `int(10) unsigned` | NO | - | *NULL* |
| `created_at` | `int(10) unsigned` | NO | - | *NULL* |

---

### 🗂️ Table: `mail_otps` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `otp` | `bigint(20)` | YES | - | *NULL* |
| `email` | `bigint(20)` | YES | - | *NULL* |
| `validity_time` | `datetime` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `migrations` (Rows: 125)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(10) unsigned` | NO | **PRI** | *NULL* |
| `migration` | `varchar(255)` | NO | - | *NULL* |
| `batch` | `int(11)` | NO | - | *NULL* |

---

### 🗂️ Table: `milk_order_user_addresses` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `user_id` | `varchar(255)` | YES | - | *NULL* |
| `order_id` | `varchar(255)` | YES | - | *NULL* |
| `address_line_one` | `longtext` | YES | - | *NULL* |
| `address_line_two` | `longtext` | YES | - | *NULL* |
| `landmark` | `longtext` | YES | - | *NULL* |
| `area_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `city` | `longtext` | YES | - | *NULL* |
| `address_phone_number` | `bigint(20)` | YES | - | *NULL* |
| `address_type_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `address_type_name` | `varchar(255)` | YES | - | *NULL* |
| `address_type_others_name` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `milk_orders` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `product_id` | `bigint(20) unsigned` | YES | - | *NULL* |
| `quantity` | `int(11)` | YES | - | *NULL* |
| `order_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `payment_id` | `longtext` | YES | - | *NULL* |
| `from_date` | `date` | YES | - | *NULL* |
| `to_date` | `date` | YES | - | *NULL* |
| `date_to_delivery` | `longtext` | YES | - | *NULL* |
| `date_ordered_on` | `datetime` | YES | - | `current_timestamp()` |
| `no_of_days` | `int(11)` | YES | - | *NULL* |
| `plan_type` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `delivery_person_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `is_delivery_assigned` | `int(11)` | YES | **MUL** | `0` |
| `user_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `payment_status` | `int(11)` | YES | - | `0` |
| `current_status` | `int(11)` | YES | - | `0` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `milk_refunds` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `order_id` | `varchar(255)` | YES | - | *NULL* |
| `slot_id` | `bigint(20)` | YES | - | *NULL* |
| `cancelled_by` | `varchar(255)` | YES | - | *NULL* |
| `refund_status` | `int(11)` | YES | - | `0` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `milk_slots` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `delivery_date` | `date` | YES | - | *NULL* |
| `order_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `delivery_status` | `int(11)` | YES | - | `0` |
| `order_delivered_time` | `datetime` | YES | - | *NULL* |
| `deliver_person_id` | `varchar(255)` | YES | - | *NULL* |
| `is_cancelled` | `int(11)` | YES | - | `0` |
| `cancel_reason` | `text` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `milk_transaction_logs` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `order_id` | `varchar(255)` | YES | - | *NULL* |
| `slot_id` | `bigint(20) unsigned` | YES | - | *NULL* |
| `order_date` | `datetime` | YES | - | *NULL* |
| `order_amount` | `varchar(255)` | YES | - | *NULL* |
| `amount_credited` | `bigint(20)` | YES | - | `0` |
| `amount_debited` | `bigint(20)` | YES | - | `0` |
| `user_id` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `notifications` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `title` | `varchar(255)` | YES | - | *NULL* |
| `content` | `varchar(255)` | YES | - | *NULL* |
| `image` | `text` | YES | - | *NULL* |
| `cate_id` | `text` | YES | - | *NULL* |
| `pro_id` | `text` | YES | - | *NULL* |
| `review` | `text` | YES | - | *NULL* |
| `cate_name` | `text` | YES | - | *NULL* |
| `pro_name` | `text` | YES | - | *NULL* |
| `star` | `int(11)` | YES | - | *NULL* |
| `approval` | `int(11)` | YES | - | *NULL* |
| `created_at` | `timestamp` | NO | - | `current_timestamp()` |
| `updated_at` | `timestamp` | NO | - | `current_timestamp()` |

---

### 🗂️ Table: `offer_images` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `offer_image` | `text` | YES | - | *NULL* |
| `offer_position` | `text` | YES | - | *NULL* |
| `created_at` | `timestamp` | NO | - | `current_timestamp()` |
| `updated_at` | `timestamp` | NO | - | `current_timestamp()` |

---

### 🗂️ Table: `onetimes` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `otp` | `bigint(20)` | YES | - | *NULL* |
| `phone_number` | `varchar(255)` | YES | - | *NULL* |
| `validity_time` | `datetime` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `order_export_data` (Rows: 1)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `order_id` | `varchar(255)` | NO | **UNI** | *NULL* |
| `form_data` | `longtext` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `otps` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `otp` | `bigint(20)` | YES | - | *NULL* |
| `phone_number` | `varchar(255)` | YES | - | *NULL* |
| `validity_time` | `datetime` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | `current_timestamp()` |
| `updated_at` | `timestamp` | YES | - | `current_timestamp()` |

---

### 🗂️ Table: `password_reset_tokens` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `email` | `varchar(255)` | NO | **PRI** | *NULL* |
| `token` | `varchar(255)` | NO | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `password_resets` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `email` | `varchar(255)` | NO | **MUL** | *NULL* |
| `token` | `varchar(255)` | NO | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `personal_access_tokens` (Rows: 54)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `tokenable_type` | `varchar(255)` | NO | **MUL** | *NULL* |
| `tokenable_id` | `bigint(20) unsigned` | NO | - | *NULL* |
| `name` | `varchar(255)` | NO | - | *NULL* |
| `token` | `varchar(64)` | NO | **UNI** | *NULL* |
| `abilities` | `text` | YES | - | *NULL* |
| `last_used_at` | `timestamp` | YES | - | *NULL* |
| `expires_at` | `timestamp` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `plan_types` (Rows: 3)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `plan_name` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `product_child_images` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `product_id` | `int(11)` | YES | - | *NULL* |
| `variant_id` | `int(11)` | YES | - | *NULL* |
| `product_child_image` | `text` | YES | - | *NULL* |
| `created_at` | `timestamp` | NO | - | `current_timestamp()` |
| `updated_at` | `timestamp` | NO | - | `current_timestamp()` |

---

### 🗂️ Table: `product_color_images` (Rows: 8)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `product_color_id` | `bigint(20) unsigned` | NO | **MUL** | *NULL* |
| `view_type` | `enum('front','back','chest','shoulder','right-shoulder','left-shoulder')` | NO | - | *NULL* |
| `image_path` | `varchar(255)` | NO | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `product_colors` (Rows: 2)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `customproduct_id` | `bigint(20) unsigned` | NO | **MUL** | *NULL* |
| `color_name` | `varchar(255)` | NO | - | *NULL* |
| `color_code` | `varchar(255)` | NO | - | *NULL* |
| `status` | `enum('active','inactive')` | NO | - | `active` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `product_order_user_addresses` (Rows: 5)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `address_username` | `varchar(255)` | YES | - | *NULL* |
| `user_id` | `varchar(255)` | YES | - | *NULL* |
| `guest_user_id` | `varchar(255)` | YES | - | *NULL* |
| `order_id` | `varchar(255)` | YES | - | *NULL* |
| `address_line_one` | `longtext` | YES | - | *NULL* |
| `address_line_two` | `longtext` | YES | - | *NULL* |
| `landmark` | `longtext` | YES | - | *NULL* |
| `area_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `city` | `longtext` | YES | - | *NULL* |
| `state` | `varchar(255)` | YES | - | *NULL* |
| `pincode` | `int(11)` | YES | - | *NULL* |
| `country` | `varchar(255)` | YES | - | *NULL* |
| `address_phone_number` | `text` | YES | - | *NULL* |
| `address_type_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `address_type_name` | `varchar(255)` | YES | - | *NULL* |
| `address_type_others_name` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `product_orders` (Rows: 5)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `order_id` | `varchar(255)` | YES | - | *NULL* |
| `order_name` | `text` | YES | - | *NULL* |
| `total_amount` | `int(11)` | YES | - | `0` |
| `gst_amount` | `int(11)` | NO | - | `0` |
| `discount_amount` | `int(11)` | NO | - | `0` |
| `delivery_charge` | `int(11)` | NO | - | `0` |
| `grand_total_amount` | `int(11)` | NO | - | `0` |
| `base_currency` | `varchar(3)` | NO | - | `INR` |
| `base_amount` | `decimal(15,2)` | YES | - | *NULL* |
| `selected_currency` | `varchar(3)` | YES | - | *NULL* |
| `converted_amount` | `decimal(15,2)` | YES | - | *NULL* |
| `exchange_rate` | `decimal(15,6)` | YES | - | *NULL* |
| `coupons_id` | `varchar(155)` | YES | - | *NULL* |
| `date_ordered_on` | `datetime` | YES | - | `current_timestamp()` |
| `delivery_person_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `is_delivery_assigned` | `int(11)` | YES | - | `0` |
| `user_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `guest_user_id` | `varchar(255)` | YES | - | *NULL* |
| `payment_status` | `int(11)` | YES | - | `0` |
| `delivery_status` | `int(11)` | YES | - | `0` |
| `current_status` | `int(11)` | YES | - | `0` |
| `is_cancelled` | `int(11)` | NO | - | `0` |
| `approve_staus` | `int(11)` | NO | - | `0` |
| `cancel_reason` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |
| `shiprocket_order_id` | `int(11)` | YES | - | *NULL* |
| `shiprocket_shipping_id` | `int(11)` | YES | - | *NULL* |
| `awb_code` | `varchar(255)` | YES | - | *NULL* |
| `paypal_payment_id` | `varchar(255)` | YES | - | *NULL* |
| `paypal_payer_id` | `varchar(255)` | YES | - | *NULL* |
| `payment_method` | `text` | YES | - | *NULL* |
| `bank_country` | `varchar(255)` | YES | - | *NULL* |
| `payment_proof` | `varchar(255)` | YES | - | *NULL* |
| `coupon_code` | `text` | YES | - | *NULL* |
| `tracking_id` | `text` | YES | - | *NULL* |
| `order_type` | `int(11)` | YES | - | `0` |
| `printing_method` | `varchar(255)` | YES | - | *NULL* |

---

### 🗂️ Table: `product_refunds` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `order_id` | `varchar(255)` | YES | - | *NULL* |
| `slot_id` | `bigint(20)` | YES | - | *NULL* |
| `cancelled_by` | `varchar(255)` | YES | - | *NULL* |
| `refund_status` | `int(11)` | YES | - | `0` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `product_slots` (Rows: 5)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `delivery_date` | `varchar(255)` | YES | - | *NULL* |
| `order_id` | `varchar(255)` | YES | **MUL** | *NULL* |
| `product_id` | `bigint(20) unsigned` | YES | - | *NULL* |
| `design_id` | `bigint(20) unsigned` | YES | - | *NULL* |
| `snapshot_path` | `varchar(255)` | YES | - | *NULL* |
| `snapshot_json` | `longtext` | YES | - | *NULL* |
| `product_varient_id` | `bigint(20)` | YES | - | *NULL* |
| `product_name` | `varchar(255)` | YES | - | *NULL* |
| `order_name` | `text` | YES | - | *NULL* |
| `product_image` | `text` | YES | - | *NULL* |
| `product_rate` | `varchar(255)` | YES | - | *NULL* |
| `gst_amt` | `varchar(255)` | YES | - | *NULL* |
| `gst_per` | `varchar(255)` | YES | - | *NULL* |
| `product_value` | `varchar(255)` | YES | - | *NULL* |
| `quantity` | `int(11)` | YES | - | *NULL* |
| `product_total` | `varchar(255)` | YES | - | *NULL* |
| `shipping` | `text` | YES | - | *NULL* |
| `discount` | `text` | YES | - | *NULL* |
| `size_value` | `text` | YES | - | *NULL* |
| `color_value` | `text` | YES | - | *NULL* |
| `delivery_status` | `int(11)` | YES | - | `0` |
| `preorder` | `bigint(20)` | YES | - | *NULL* |
| `dispatch_date` | `date` | YES | - | *NULL* |
| `order_delivered_time` | `datetime` | YES | - | *NULL* |
| `deliver_person_id` | `varchar(255)` | YES | - | *NULL* |
| `is_cancelled` | `int(11)` | YES | - | `0` |
| `cancel_reason` | `text` | YES | - | *NULL* |
| `approve_staus` | `int(11)` | NO | - | `0` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `product_tracking` (Rows: 1)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `user_id` | `varchar(255)` | YES | - | *NULL* |
| `order_id` | `varchar(255)` | YES | - | *NULL* |
| `delivery_status` | `varchar(255)` | YES | - | *NULL* |
| `status` | `varchar(255)` | YES | - | *NULL* |
| `channel_id` | `int(11)` | YES | - | *NULL* |
| `shiprocket_order_id` | `varchar(255)` | YES | - | *NULL* |
| `shiprocket_shipment_id` | `varchar(255)` | YES | - | *NULL* |
| `awb_code` | `varchar(255)` | YES | - | *NULL* |
| `tracking_url` | `varchar(255)` | YES | - | *NULL* |
| `delivered_date` | `varchar(255)` | YES | - | *NULL* |
| `return_requested` | `int(11)` | NO | - | `0` |
| `return_approval_date` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `product_transaction_logs` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `order_id` | `varchar(255)` | YES | - | *NULL* |
| `slot_id` | `bigint(20) unsigned` | YES | - | *NULL* |
| `order_date` | `datetime` | YES | - | *NULL* |
| `order_amount` | `varchar(255)` | YES | - | *NULL* |
| `amount_credited` | `bigint(20)` | YES | - | `0` |
| `amount_debited` | `bigint(20)` | YES | - | `0` |
| `user_id` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `product_varient` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20)` | NO | **PRI** | *NULL* |
| `categoryid` | `bigint(20)` | YES | - | *NULL* |
| `subcategoryid` | `varchar(255)` | YES | - | *NULL* |
| `product_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `varient` | `int(11)` | YES | - | *NULL* |
| `varient_img` | `varchar(255)` | YES | - | *NULL* |
| `varient_name` | `varchar(255)` | YES | - | *NULL* |
| `value` | `varchar(50)` | YES | - | *NULL* |
| `offer_price` | `int(11)` | YES | - | *NULL* |
| `mrp_price` | `int(11)` | YES | - | *NULL* |
| `product_qty` | `int(11)` | YES | - | *NULL* |
| `low_stock` | `varchar(255)` | YES | - | *NULL* |
| `hot_deals` | `int(11)` | YES | - | `0` |
| `Popular_products` | `int(11)` | NO | - | `0` |
| `product_gst` | `int(11)` | NO | - | `0` |
| `subcatename` | `varchar(255)` | YES | - | *NULL* |
| `size_value` | `varchar(255)` | YES | - | *NULL* |
| `color_value` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | NO | - | `current_timestamp()` |
| `updated_at` | `timestamp` | NO | - | `current_timestamp()` |

---

### 🗂️ Table: `products` (Rows: 4)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `category_id` | `bigint(20) unsigned` | NO | **MUL** | *NULL* |
| `subcategory_id` | `varchar(255)` | YES | - | *NULL* |
| `product_name` | `varchar(255)` | YES | - | *NULL* |
| `prod_unique_name` | `varchar(255)` | YES | - | *NULL* |
| `product_quantity` | `bigint(20)` | YES | - | *NULL* |
| `product_mrp_price` | `bigint(20)` | YES | - | *NULL* |
| `product_regular_price` | `bigint(20)` | YES | - | *NULL* |
| `product_description` | `longtext` | YES | - | *NULL* |
| `product_image` | `varchar(255)` | YES | - | *NULL* |
| `product_specification` | `longtext` | YES | - | *NULL* |
| `product_specfication` | `longtext` | YES | - | *NULL* |
| `brand_name` | `varchar(255)` | YES | - | *NULL* |
| `brand_material` | `varchar(255)` | YES | - | *NULL* |
| `brand_type` | `varchar(255)` | YES | - | *NULL* |
| `approval_days` | `int(11)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |
| `unit_value` | `varchar(255)` | YES | - | *NULL* |
| `product_value` | `varchar(255)` | YES | - | *NULL* |
| `cate_name` | `varchar(255)` | YES | - | *NULL* |
| `subcate_name` | `varchar(255)` | YES | - | *NULL* |
| `size_value` | `int(11)` | YES | - | `0` |
| `size_chart_image` | `varchar(255)` | YES | - | *NULL* |

---

### 🗂️ Table: `productstocks` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `productid` | `int(11)` | YES | - | *NULL* |
| `category_id` | `int(11)` | YES | - | *NULL* |
| `subcategory_id` | `varchar(255)` | YES | - | *NULL* |
| `pro_ver_id` | `bigint(20)` | NO | **MUL** | *NULL* |
| `productname` | `varchar(255)` | YES | - | *NULL* |
| `overallstock` | `int(11)` | YES | - | *NULL* |
| `availablestock` | `int(11)` | YES | - | *NULL* |
| `salestock` | `int(11)` | YES | - | *NULL* |
| `low_stocks` | `varchar(255)` | YES | - | *NULL* |
| `last_stockupdate_date` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | NO | - | `current_timestamp()` |
| `updated_at` | `timestamp` | NO | - | `current_timestamp()` |

---

### 🗂️ Table: `reviews` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `user_id` | `varchar(255)` | YES | - | *NULL* |
| `name` | `varchar(255)` | YES | - | *NULL* |
| `email` | `varchar(255)` | YES | - | *NULL* |
| `prod_id` | `varchar(255)` | YES | - | *NULL* |
| `prod_var_id` | `varchar(255)` | YES | - | *NULL* |
| `review` | `varchar(255)` | YES | - | *NULL* |
| `ratings` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | NO | - | `current_timestamp()` |
| `updated_at` | `timestamp` | NO | - | `current_timestamp()` |

---

### 🗂️ Table: `sample_order_full_details` (Rows: 5)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `order_primary_id` | `bigint(20) unsigned` | NO | - | *NULL* |
| `order_id` | `varchar(255)` | YES | - | *NULL* |
| `printing_method` | `varchar(255)` | YES | - | *NULL* |
| `user_id` | `varchar(255)` | YES | - | *NULL* |
| `user_name` | `varchar(255)` | YES | - | *NULL* |
| `user_email` | `varchar(255)` | YES | - | *NULL* |
| `user_phone` | `varchar(255)` | YES | - | *NULL* |
| `address_username` | `varchar(255)` | YES | - | *NULL* |
| `address_phone_number` | `varchar(255)` | YES | - | *NULL* |
| `address_line_one` | `varchar(255)` | YES | - | *NULL* |
| `address_line_two` | `varchar(255)` | YES | - | *NULL* |
| `landmark` | `varchar(255)` | YES | - | *NULL* |
| `city` | `varchar(255)` | YES | - | *NULL* |
| `state` | `varchar(255)` | YES | - | *NULL* |
| `pincode` | `varchar(255)` | YES | - | *NULL* |
| `country` | `varchar(255)` | YES | - | *NULL* |
| `address_type_name` | `varchar(255)` | YES | - | *NULL* |
| `total_amount` | `decimal(10,2)` | NO | - | `0.00` |
| `grand_total_amount` | `decimal(10,2)` | NO | - | `0.00` |
| `payment_method` | `varchar(255)` | YES | - | *NULL* |
| `bank_country` | `varchar(255)` | YES | - | *NULL* |
| `paypal_payment_id` | `varchar(255)` | YES | - | *NULL* |
| `paypal_payer_id` | `varchar(255)` | YES | - | *NULL* |
| `payment_status_text` | `varchar(255)` | YES | - | *NULL* |
| `order_items` | `longtext` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `sample_variants` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `sample_id` | `bigint(20) unsigned` | NO | **MUL** | *NULL* |
| `varient_name` | `varchar(255)` | YES | - | *NULL* |
| `varient_img` | `varchar(255)` | YES | - | *NULL* |
| `size_value` | `varchar(255)` | YES | - | *NULL* |
| `color_value` | `varchar(255)` | YES | - | *NULL* |
| `sample_qty` | `int(11)` | NO | - | `0` |
| `mrp_price` | `decimal(10,2)` | NO | - | `0.00` |
| `offer_price` | `decimal(10,2)` | NO | - | `0.00` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `samples` (Rows: 2)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `title` | `varchar(255)` | NO | - | *NULL* |
| `category` | `varchar(255)` | YES | - | *NULL* |
| `description` | `text` | YES | - | *NULL* |
| `image` | `varchar(255)` | YES | - | *NULL* |
| `badge` | `varchar(255)` | YES | - | *NULL* |
| `badge_type` | `varchar(255)` | YES | - | *NULL* |
| `price` | `decimal(10,2)` | NO | - | `0.00` |
| `sizes` | `longtext` | YES | - | *NULL* |
| `features` | `longtext` | YES | - | *NULL* |
| `gsm` | `text` | YES | - | *NULL* |
| `colors` | `text` | YES | - | *NULL* |
| `is_active` | `tinyint(1)` | NO | - | `1` |
| `sort_order` | `int(11)` | NO | - | `0` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |
| `stocks` | `int(11)` | YES | - | `0` |
| `cloth_types` | `text` | YES | - | *NULL* |

---

### 🗂️ Table: `sessions` (Rows: 7)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `varchar(255)` | NO | **PRI** | *NULL* |
| `user_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `ip_address` | `varchar(45)` | YES | - | *NULL* |
| `user_agent` | `text` | YES | - | *NULL* |
| `payload` | `longtext` | NO | - | *NULL* |
| `last_activity` | `int(11)` | NO | **MUL** | *NULL* |

---

### 🗂️ Table: `shippings` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `location` | `text` | YES | - | *NULL* |
| `shipping_amt` | `text` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `size_charts` (Rows: 6)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `serial_no` | `int(11)` | NO | - | *NULL* |
| `usa_uk` | `varchar(255)` | NO | - | *NULL* |
| `eu` | `varchar(255)` | NO | - | *NULL* |
| `japan` | `varchar(255)` | NO | - | *NULL* |
| `korea` | `varchar(255)` | NO | - | *NULL* |
| `chest_cm` | `varchar(255)` | NO | - | *NULL* |
| `chest_inches` | `varchar(255)` | NO | - | *NULL* |
| `is_active` | `tinyint(1)` | YES | - | `1` |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `states` (Rows: 39)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `name` | `varchar(30)` | NO | - | *NULL* |
| `country_id` | `int(11)` | NO | - | `1` |

---

### 🗂️ Table: `sub_categories` (Rows: 5)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `subcategory_name` | `varchar(255)` | YES | - | *NULL* |
| `subcategory_image` | `varchar(255)` | YES | - | *NULL* |
| `category_name` | `varchar(255)` | YES | - | *NULL* |
| `category_display` | `varchar(255)` | YES | - | *NULL* |
| `status` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `telescope_entries` (Rows: 530)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `sequence` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `uuid` | `char(36)` | NO | **UNI** | *NULL* |
| `batch_id` | `char(36)` | NO | **MUL** | *NULL* |
| `family_hash` | `varchar(255)` | YES | **MUL** | *NULL* |
| `should_display_on_index` | `tinyint(1)` | NO | - | `1` |
| `type` | `varchar(20)` | NO | **MUL** | *NULL* |
| `content` | `longtext` | NO | - | *NULL* |
| `created_at` | `datetime` | YES | **MUL** | *NULL* |

---

### 🗂️ Table: `telescope_entries_tags` (Rows: 127)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `entry_uuid` | `char(36)` | NO | **MUL** | *NULL* |
| `tag` | `varchar(255)` | NO | **MUL** | *NULL* |

---

### 🗂️ Table: `telescope_monitoring` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `tag` | `varchar(255)` | NO | - | *NULL* |

---

### 🗂️ Table: `testimonials` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `para` | `varchar(255)` | YES | - | *NULL* |
| `image` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | `current_timestamp()` |
| `updated_at` | `timestamp` | YES | - | `current_timestamp()` |
| `firstname` | `varchar(255)` | YES | - | *NULL* |

---

### 🗂️ Table: `tests` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `today_deals` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `product_id` | `varchar(255)` | YES | - | *NULL* |
| `variant_id` | `int(11)` | YES | - | *NULL* |
| `product_name` | `varchar(255)` | YES | - | *NULL* |
| `offer_value` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `user_addresses` (Rows: 2)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `address_username` | `varchar(255)` | YES | - | *NULL* |
| `address_first_name` | `varchar(50)` | YES | - | *NULL* |
| `address_last_name` | `varchar(20)` | YES | - | *NULL* |
| `user_id` | `varchar(255)` | YES | - | *NULL* |
| `guest_user_id` | `varchar(255)` | YES | - | *NULL* |
| `address_line_one` | `longtext` | YES | - | *NULL* |
| `address_line_two` | `longtext` | YES | - | *NULL* |
| `landmark` | `longtext` | YES | - | *NULL* |
| `area_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `area_name` | `varchar(255)` | YES | - | *NULL* |
| `city` | `longtext` | YES | - | *NULL* |
| `city_id` | `int(11)` | YES | - | *NULL* |
| `state_id` | `int(11)` | YES | - | *NULL* |
| `pincode` | `varchar(20)` | NO | - | *NULL* |
| `pincode_id` | `int(11)` | YES | - | *NULL* |
| `district` | `varchar(255)` | YES | - | *NULL* |
| `country` | `varchar(255)` | YES | - | *NULL* |
| `state` | `varchar(225)` | YES | - | *NULL* |
| `address_phone_number` | `bigint(20)` | YES | - | *NULL* |
| `address_type_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `address_type_name` | `varchar(255)` | YES | - | *NULL* |
| `address_type_others_name` | `varchar(255)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | *NULL* |
| `updated_at` | `timestamp` | YES | - | *NULL* |

---

### 🗂️ Table: `user_read_notifications` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `user_id` | `varchar(255)` | YES | - | *NULL* |
| `notification_id` | `bigint(20)` | YES | - | *NULL* |
| `created_at` | `timestamp` | NO | - | `current_timestamp()` |

---

### 🗂️ Table: `users` (Rows: 2)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `bigint(20) unsigned` | NO | **PRI** | *NULL* |
| `user_id` | `varchar(255)` | YES | **UNI** | *NULL* |
| `is_guest_user` | `int(11)` | NO | - | `0` |
| `user_token` | `text` | YES | - | *NULL* |
| `name` | `varchar(255)` | YES | - | *NULL* |
| `email` | `varchar(255)` | YES | **UNI** | *NULL* |
| `user_type` | `varchar(255)` | NO | - | `normaluser` |
| `gst_number` | `varchar(255)` | YES | - | *NULL* |
| `phone_number` | `varchar(255)` | YES | **UNI** | *NULL* |
| `first_name` | `varchar(255)` | YES | - | *NULL* |
| `last_name` | `varchar(255)` | YES | - | *NULL* |
| `gender` | `smallint(6)` | YES | - | *NULL* |
| `profile_image` | `text` | YES | - | *NULL* |
| `user_default_address_id` | `bigint(20) unsigned` | YES | - | *NULL* |
| `area_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `address_type_id` | `bigint(20) unsigned` | YES | **MUL** | *NULL* |
| `email_verified_at` | `timestamp` | YES | - | *NULL* |
| `password` | `varchar(255)` | YES | - | *NULL* |
| `otp` | `text` | YES | - | *NULL* |
| `otp_expiry` | `text` | YES | - | *NULL* |
| `enc_password` | `text` | YES | - | *NULL* |
| `remember_token` | `varchar(100)` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | `current_timestamp()` |
| `updated_at` | `timestamp` | YES | - | `current_timestamp()` |
| `from_app` | `int(11)` | NO | - | `0` |
| `firebase_fcm_token` | `text` | YES | - | *NULL* |

---

### 🗂️ Table: `web_images` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `image` | `text` | YES | - | *NULL* |
| `created_at` | `timestamp` | NO | - | `current_timestamp()` |
| `updated_at` | `timestamp` | YES | - | *NULL* |
| `title` | `varchar(255)` | YES | - | *NULL* |
| `subtitle` | `varchar(255)` | YES | - | *NULL* |
| `button_text` | `varchar(255)` | YES | - | *NULL* |
| `button_url` | `varchar(500)` | YES | - | *NULL* |

---

### 🗂️ Table: `wishlists` (Rows: 0)

| Column Name | Type | Nullable | Key | Default |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `int(11)` | NO | **PRI** | *NULL* |
| `user_id` | `varchar(255)` | YES | - | *NULL* |
| `product_id` | `int(11)` | YES | - | *NULL* |
| `product_name` | `text` | YES | - | *NULL* |
| `product_varient_id` | `int(11)` | YES | - | *NULL* |
| `product_quantity` | `int(11)` | YES | - | *NULL* |
| `product_color` | `text` | YES | - | *NULL* |
| `product_image` | `text` | YES | - | *NULL* |
| `price` | `text` | YES | - | *NULL* |
| `product_size` | `text` | YES | - | *NULL* |
| `created_at` | `timestamp` | YES | - | `current_timestamp()` |
| `updated_at` | `timestamp` | YES | - | `current_timestamp()` |

---

