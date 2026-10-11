-- Assignment 14: Secure Website Form
-- Run these statements in a MySQL or MariaDB SQL client.

CREATE DATABASE IF NOT EXISTS assignment14_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE assignment14_db;

CREATE TABLE IF NOT EXISTS contact_messages (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    email VARCHAR(254) NOT NULL,
    message VARCHAR(2000) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

-- Create a dedicated application account with a unique password.
-- Replace the placeholder before running these commands as a database administrator.
-- The PHP example only inserts rows, so it needs INSERT permission only.
-- CREATE USER 'assignment14_app'@'127.0.0.1'
--     IDENTIFIED BY 'REPLACE_WITH_A_UNIQUE_STRONG_PASSWORD';
-- GRANT INSERT ON assignment14_db.contact_messages
--     TO 'assignment14_app'@'127.0.0.1';
