-- Drop the database if it exists and create a fresh one
DROP DATABASE IF EXISTS ecomomentum;
CREATE DATABASE ecomomentum;
USE ecomomentum;

-- Create the roles table to distinguish between admin and regular users
CREATE TABLE IF NOT EXISTS roles (
    rid INT PRIMARY KEY AUTO_INCREMENT,         -- Role ID (auto-incremented)
    role_name VARCHAR(50) NOT NULL              -- Role name (admin, regular, etc.)
);

-- Insert predefined roles into the roles table (admin and regular)
INSERT INTO roles (rid, role_name) VALUES 
(1, 'admin'), 
(2, 'regular');

-- Create the users table to store user details and their role
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- User ID (auto-incremented)
    email VARCHAR(255) UNIQUE NOT NULL,         -- User email (unique constraint)
    password VARCHAR(255) NOT NULL,             -- User password (hashed)
    full_name VARCHAR(100) NOT NULL,            -- User full name
    role_id INT DEFAULT 2,                      -- Role ID (default 'regular')
    FOREIGN KEY (role_id) REFERENCES roles(rid) -- Foreign key referencing 'roles'
);

-- Drop the admins table as it is no longer needed
DROP TABLE IF EXISTS admins;

-- Create a table to store climate actions related to users
CREATE TABLE IF NOT EXISTS climate_actions (
    action_id INT PRIMARY KEY AUTO_INCREMENT,  -- Action ID (auto-incremented)
    user_id INT NOT NULL,                      -- User ID (foreign key from 'users')
    action_description TEXT NOT NULL,          -- Description of the climate action
    action_type VARCHAR(100),                  -- Type of action (optional)
    action_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date and time of the action
    FOREIGN KEY (user_id) REFERENCES users(id)  -- Foreign key referencing 'users'
);

-- Create a table to store resources (articles, videos, etc. that admins may want to manage)
CREATE TABLE IF NOT EXISTS resources (
    resource_id INT PRIMARY KEY AUTO_INCREMENT, -- Resource ID (auto-incremented)
    title VARCHAR(255) NOT NULL,                -- Title of the resource
    description TEXT,                           -- Description of the resource
    resource_type ENUM('article', 'video', 'infographic', 'scientific_paper') NOT NULL, -- Type of resource
    resource_url VARCHAR(255),                  -- URL to the resource (if applicable)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp when resource was created
    created_by INT NOT NULL,                    -- Admin ID who created the resource (foreign key)
    FOREIGN KEY (created_by) REFERENCES users(id) -- Foreign key referencing 'users'
);

-- Create a table to track user activities for logging actions related to users and admins
CREATE TABLE IF NOT EXISTS user_activities (
    activity_id INT PRIMARY KEY AUTO_INCREMENT, -- Activity ID (auto-incremented)
    user_id INT NOT NULL,                       -- User ID (foreign key from 'users')
    activity_description TEXT NOT NULL,         -- Description of the activity
    activity_type ENUM('admin', 'user') DEFAULT 'user', -- Type of activity (admin or user)
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date and time of the activity
    FOREIGN KEY (user_id) REFERENCES users(id) -- Foreign key referencing 'users'
);
