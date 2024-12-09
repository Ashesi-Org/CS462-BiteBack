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
    id INT AUTO_INCREMENT PRIMARY KEY,         --
    email VARCHAR(255) UNIQUE NOT NULL,         -- 
    password VARCHAR(255) NOT NULL,             --)
    full_name VARCHAR(100) NOT NULL,            --
    profile_image VARCHAR(255) DEFAULT 'default-avatar.png', 
    role_id INT DEFAULT 2,                      --
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, --
    FOREIGN KEY (role_id) REFERENCES roles(rid) -- 
);

-- Create a table to store climate actions related to users
CREATE TABLE IF NOT EXISTS climate_actions (
    action_id INT PRIMARY KEY AUTO_INCREMENT,  -- Action ID (auto-incremented)
    user_id INT NOT NULL,                      -- User ID (foreign key from 'users')
    action_description TEXT NOT NULL,          -- Description of the climate action
    action_type ENUM('event', 'pledge', 'other') DEFAULT 'other', -- Type of action
    action_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date and time of the action
    FOREIGN KEY (user_id) REFERENCES users(id)  -- Foreign key referencing 'users'
);

-- Create a table to store resources (articles, videos, etc.)
CREATE TABLE IF NOT EXISTS resources (
    resource_id INT PRIMARY KEY AUTO_INCREMENT, -- Resource ID (auto-incremented)
    title VARCHAR(255) NOT NULL,                -- Title of the resource
    description TEXT,                           -- Description of the resource
    resource_type ENUM('article', 'video', 'infographic', 'scientific_paper') NOT NULL, -- Type of resource
    resource_url VARCHAR(255),                  -- URL to the resource (if applicable)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp when the resource was created
    created_by INT NOT NULL,                    -- Admin ID who created the resource
    FOREIGN KEY (created_by) REFERENCES users(id) -- Foreign key referencing 'users'
);

-- Create a table to store user's saved resources
CREATE TABLE IF NOT EXISTS user_resources (
    id INT PRIMARY KEY AUTO_INCREMENT,         -- ID (auto-incremented)
    user_id INT NOT NULL,                      -- User ID (foreign key from 'users')
    resource_id INT NOT NULL,                  -- Resource ID (foreign key from 'resources')
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp when the resource was saved
    FOREIGN KEY (user_id) REFERENCES users(id), -- Foreign key referencing 'users'
    FOREIGN KEY (resource_id) REFERENCES resources(resource_id) -- Foreign key referencing 'resources'
);

-- Create a table to track events
CREATE TABLE IF NOT EXISTS events (
    event_id INT PRIMARY KEY AUTO_INCREMENT,   -- Event ID (auto-incremented)
    name VARCHAR(255) NOT NULL,                -- Name of the event
    event_date DATE NOT NULL,                  -- Date of the event
    description TEXT,                          -- Description of the event
    location VARCHAR(255),                     -- Location of the event
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp when the event was created
);

-- Create a table to track user's participation in events
CREATE TABLE IF NOT EXISTS user_events (
    id INT PRIMARY KEY AUTO_INCREMENT,         -- ID (auto-incremented)
    user_id INT NOT NULL,                      -- User ID (foreign key from 'users')
    event_id INT NOT NULL,                     -- Event ID (foreign key from 'events')
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp when the user registered
    FOREIGN KEY (user_id) REFERENCES users(id), -- Foreign key referencing 'users'
    FOREIGN KEY (event_id) REFERENCES events(event_id) -- Foreign key referencing 'events'
);

-- Create a table to track user activities for logging actions
CREATE TABLE IF NOT EXISTS user_activities (
    activity_id INT PRIMARY KEY AUTO_INCREMENT, -- Activity ID (auto-incremented)
    user_id INT NOT NULL,                       -- User ID (foreign key from 'users')
    activity_description TEXT NOT NULL,         -- Description of the activity
    activity_type ENUM('admin', 'user') DEFAULT 'user', -- Type of activity (admin or user)
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date and time of the activity
    FOREIGN KEY (user_id) REFERENCES users(id) -- Foreign key referencing 'users'
);
