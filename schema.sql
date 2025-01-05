CREATE DATABASE IF NOT EXISTS kanban_project;
USE kanban_project;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    status ENUM('TODO', 'DOING', 'REVIEW', 'DONE') DEFAULT 'TODO',
    priority ENUM('LOW', 'MEDIUM', 'HIGH') DEFAULT 'MEDIUM',
    assigned_to INT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE project_members (
    project_id INT,
    user_id INT,
    role ENUM('OWNER', 'MEMBER') DEFAULT 'MEMBER',
    PRIMARY KEY (project_id, user_id),
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);



-- Insert sample users
INSERT INTO users (username, email, password) VALUES
('john_doe', 'john@example.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG'), -- password: password
('jane_smith', 'jane@example.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG'),
('bob_johnson', 'bob@example.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG'),
('alice_williams', 'alice@example.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG'),
('charlie_brown', 'charlie@example.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG');

-- Insert sample projects
INSERT INTO projects (name, description, created_by) VALUES
('Web App Redesign', 'Redesign the company''s web application using modern frameworks', 1),
('Mobile App Development', 'Create a new mobile app for both iOS and Android platforms', 2),
('Database Optimization', 'Optimize database queries and improve overall performance', 3),
('API Integration', 'Integrate third-party APIs into our existing systems', 4),
('Machine Learning Model', 'Develop a machine learning model for predictive analytics', 5);

-- Insert sample tasks
INSERT INTO tasks (project_id, title, description, status, priority, assigned_to, created_by) VALUES
(1, 'Create wireframes', 'Design initial wireframes for the new web app layout', 'TODO', 'HIGH', 2, 1),
(1, 'Implement responsive design', 'Ensure the new design is responsive across all devices', 'DOING', 'MEDIUM', 1, 1),
(1, 'Optimize asset loading', 'Improve asset loading times for better performance', 'REVIEW', 'LOW', 3, 1),
(2, 'Design app icon', 'Create an appealing app icon for both iOS and Android', 'TODO', 'MEDIUM', 4, 2),
(2, 'Implement user authentication', 'Set up secure user authentication system', 'DOING', 'HIGH', 2, 2),
(2, 'Create offline mode', 'Implement offline functionality for the app', 'TODO', 'LOW', 5, 2),
(3, 'Analyze slow queries', 'Identify and document slow-performing database queries', 'DONE', 'HIGH', 3, 3),
(3, 'Optimize indexing', 'Improve database indexing for faster query execution', 'DOING', 'MEDIUM', 1, 3),
(3, 'Implement query caching', 'Set up query caching to reduce database load', 'TODO', 'LOW', 4, 3),
(4, 'Research API options', 'Evaluate and compare different API integration options', 'DONE', 'MEDIUM', 5, 4),
(4, 'Implement OAuth', 'Set up OAuth for secure API authentication', 'DOING', 'HIGH', 2, 4),
(4, 'Write API documentation', 'Create comprehensive documentation for the API integration', 'TODO', 'LOW', 1, 4),
(5, 'Collect and preprocess data', 'Gather and clean data for the machine learning model', 'DOING', 'HIGH', 3, 5),
(5, 'Train model', 'Develop and train the initial machine learning model', 'TODO', 'MEDIUM', 5, 5),
(5, 'Evaluate model performance', 'Assess the model''s accuracy and make necessary adjustments', 'TODO', 'LOW', 4, 5);

-- Insert sample project members
INSERT INTO project_members (project_id, user_id, role) VALUES
(1, 1, 'OWNER'), (1, 2, 'MEMBER'), (1, 3, 'MEMBER'),
(2, 2, 'OWNER'), (2, 4, 'MEMBER'), (2, 5, 'MEMBER'),
(3, 3, 'OWNER'), (3, 1, 'MEMBER'), (3, 4, 'MEMBER'),
(4, 4, 'OWNER'), (4, 2, 'MEMBER'), (4, 5, 'MEMBER'),
(5, 5, 'OWNER'), (5, 3, 'MEMBER'), (5, 4, 'MEMBER');

