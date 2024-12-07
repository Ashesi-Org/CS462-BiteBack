DROP DATABASE IF EXISTS ecomomentum;
CREATE DATABASE ecomomentum;
USE ecomomentum;

-- Create roles table
CREATE TABLE IF NOT EXISTS roles (
    rid INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(50) NOT NULL
);

-- Insert predefined roles
INSERT INTO roles (rid, role_name) VALUES (1, 'admin'), (2, 'regular');

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role INT DEFAULT 2,
    FOREIGN KEY (role) REFERENCES roles(rid)
);

-- Create admins table
CREATE TABLE IF NOT EXISTS admins (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL
);

-- Climate Actions Table
CREATE TABLE climate_actions (
    action_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action_description TEXT,
    action_type VARCHAR(100),
    action_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) -- Corrected foreign key reference
);

-- Resources Table
CREATE TABLE resources (
    resource_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    resource_type ENUM('article', 'video', 'infographic', 'scientific_paper'),
    resource_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- User Activities Log
CREATE TABLE user_activities (
    activity_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    activity_description TEXT,
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) -- Corrected foreign key reference
);
