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


-- Create a table to track events
CREATE TABLE IF NOT EXISTS events (
    event_id INT PRIMARY KEY AUTO_INCREMENT,   -- Event ID (auto-incremented)
    name VARCHAR(255) NOT NULL,                -- Name of the event
    event_date DATE NOT NULL,                  -- Date of the event
    description TEXT,                          -- Description of the event
    location VARCHAR(255),                     -- Location of the event
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp when the event was created
);




-- Create the table (if not already created)
CREATE TABLE IF NOT EXISTS impact_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NOT NULL
);

-- Insert data into the table
INSERT INTO impact_content (title, description) VALUES
('Mission', 'Our mission is to mobilise and empower millions of young activists globally to demand urgent climate action from world leaders.'),
('Achievements', 'We’ve successfully organised over 14,000 climate strikes across 7,500 cities and influenced policy changes in several countries.'),
('Impact', 'The movement has reached over 10 million participants worldwide, fostering awareness, resilience, and hope for a sustainable future.'),
('Future Goals', 'By 2030, we aim to mobilise 100 million individuals, with concrete changes in emissions policies globally.');

);



-- Insert default data into the mentors table
INSERT INTO mentors (name, expertise, email, twitter, linkedin, description) VALUES
('Dr. Sarah Green', 'Renewable Energy and Policy', 'sarah.green@hotmail.com', 'https://twitter.com/sarahgreen', 'https://linkedin.com/in/sarahgreen', 'Dr. Green has over 15 years of experience in climate policy and renewable energy solutions. She has guided multiple projects in Europe and Africa, focusing on clean energy transitions.'),
('Mr. James Eco', 'Sustainable Agriculture', 'james.eco@hotmail.com', 'https://twitter.com/jameseco', 'https://linkedin.com/in/jameseco', 'Mr. Eco specialises in sustainable farming practices and agroecology. With a decade of experience, he has mentored numerous activists in creating impactful agricultural reforms.'),
('Ms. Angela Woods', 'Urban Sustainability', 'angela.woods@hotmail.com', 'https://twitter.com/angelawoods', 'https://linkedin.com/in/angelawoods', 'Ms. Woods has worked extensively on urban greening projects, helping cities incorporate sustainable practices. Her mentorship is perfect for those passionate about eco-friendly urban planning.'),
('Prof. Richard Leaf', 'Environmental Economics', 'richard.leaf@hotmail.com', 'https://twitter.com/richardleaf', 'https://linkedin.com/in/richardleaf', 'Prof. Leaf is an economist who connects environmental preservation with economic benefits. He has advised governments on climate investments and eco-tourism development.');


