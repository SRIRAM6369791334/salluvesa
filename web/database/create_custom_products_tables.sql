-- SQL Script to create custom products tables with color support
-- Run this in phpMyAdmin or MySQL command line

-- Create customproducts table (if not exists)
CREATE TABLE IF NOT EXISTS `customproducts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `product_type` enum('tshirt','hoodie','mug','cap','bag') NOT NULL DEFAULT 'tshirt',
  `front_mockup` varchar(255) DEFAULT NULL,
  `back_mockup` varchar(255) DEFAULT NULL,
  `printable_rect` json DEFAULT NULL,
  `is_two_sided` tinyint(1) NOT NULL DEFAULT 0,
  `available_sizes` json DEFAULT NULL,
  `canvas_config` json DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create product_colors table
CREATE TABLE IF NOT EXISTS `product_colors` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customproduct_id` bigint(20) UNSIGNED NOT NULL,
  `color_name` varchar(255) NOT NULL,
  `color_code` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_colors_customproduct_id_foreign` (`customproduct_id`),
  CONSTRAINT `product_colors_customproduct_id_foreign` FOREIGN KEY (`customproduct_id`) REFERENCES `customproducts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create product_color_images table
CREATE TABLE IF NOT EXISTS `product_color_images` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_color_id` bigint(20) UNSIGNED NOT NULL,
  `view_type` enum('front','back','chest','shoulder') NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_color_images_product_color_id_foreign` (`product_color_id`),
  CONSTRAINT `product_color_images_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `product_colors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add columns to existing customproducts table if they don't exist
ALTER TABLE `customproducts` 
ADD COLUMN IF NOT EXISTS `available_sizes` json DEFAULT NULL AFTER `is_two_sided`,
ADD COLUMN IF NOT EXISTS `canvas_config` json DEFAULT NULL AFTER `available_sizes`;
