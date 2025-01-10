create database taskflow;
use taskflow;
-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'project_manager', 'team_member', 'guest') NOT NULL DEFAULT 'team_member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create projects table
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    user_id INT,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Create tasks table
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('todo', 'in_progress', 'done') DEFAULT 'todo',
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    project_id INT,
    assigned_to INT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Create tags table
CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Create task_tags table
CREATE TABLE task_tags (
    task_id INT,
    tag_id INT,
    PRIMARY KEY (task_id, tag_id),
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

-- Create kanban_boards table
CREATE TABLE kanban_boards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Create kanban_columns table
CREATE TABLE kanban_columns (
    id INT AUTO_INCREMENT PRIMARY KEY,
    board_id INT,
    name VARCHAR(255) NOT NULL,
    position INT NOT NULL,
    FOREIGN KEY (board_id) REFERENCES kanban_boards(id) ON DELETE CASCADE
);

-- Create kanban_tasks table
CREATE TABLE kanban_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT,
    column_id INT,
    position INT NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (column_id) REFERENCES kanban_columns(id) ON DELETE CASCADE
);

-- Insert sample data

-- Users
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@taskflow.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG', 'admin'),
('Project Manager', 'pm@taskflow.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG', 'project_manager'),
('Team Member 1', 'team1@taskflow.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG', 'team_member'),
('Team Member 2', 'team2@taskflow.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG', 'team_member'),
('Guest User', 'guest@taskflow.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG', 'guest');

-- Projects
INSERT INTO projects (name, description, user_id, is_public) VALUES
('Website Redesign', 'Redesign company website for better user experience', 2, true),
('Mobile App Development', 'Develop a new mobile app for task management', 2, false),
('Marketing Campaign', 'Plan and execute Q4 marketing campaign', 2, true);

-- Tasks
INSERT INTO tasks (title, description, status, priority, project_id, assigned_to, created_by) VALUES
('Design Homepage', 'Create a new design for the homepage', 'todo', 'high', 1, 3, 2),
('Implement User Authentication', 'Add user login and registration functionality', 'in_progress', 'high', 1, 4, 2),
('Create App Wireframes', 'Design initial wireframes for the mobile app', 'done', 'medium', 2, 3, 2),
('Develop API', 'Create RESTful API for the mobile app', 'in_progress', 'high', 2, 4, 2),
('Content Strategy', 'Develop content strategy for the marketing campaign', 'todo', 'medium', 3, 3, 2),
('Social Media Plan', 'Create a social media plan for the campaign', 'todo', 'low', 3, 4, 2);

-- Tags
INSERT INTO tags (name) VALUES
('UI/UX'),
('Frontend'),
('Backend'),
('Mobile'),
('Marketing');

-- Task Tags
INSERT INTO task_tags (task_id, tag_id) VALUES
(1, 1), (1, 2),
(2, 2), (2, 3),
(3, 1), (3, 4),
(4, 3), (4, 4),
(5, 5),
(6, 5);

-- Kanban Boards
INSERT INTO kanban_boards (project_id, name) VALUES
(1, 'Website Redesign Board'),
(2, 'Mobile App Development Board'),
(3, 'Marketing Campaign Board');

-- Kanban Columns
INSERT INTO kanban_columns (board_id, name, position) VALUES
(1, 'To Do', 1),
(1, 'In Progress', 2),
(1, 'Done', 3),
(2, 'Backlog', 1),
(2, 'In Development', 2),
(2, 'Testing', 3),
(2, 'Done', 4),
(3, 'Planning', 1),
(3, 'Execution', 2),
(3, 'Review', 3);

-- Kanban Tasks
INSERT INTO kanban_tasks (task_id, column_id, position) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 7, 1),
(4, 5, 1),
(5, 8, 1),
(6, 8, 2);

