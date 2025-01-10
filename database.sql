-- -- Create tables
-- CREATE TABLE users (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(255) NOT NULL,
--     email VARCHAR(255) NOT NULL UNIQUE,
--     password VARCHAR(255) NOT NULL,
--     role ENUM('admin', 'manager', 'developer', 'user') DEFAULT 'user'
-- );

-- CREATE TABLE projects (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(255) NOT NULL,
--     description TEXT,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     user_id INT,
--     FOREIGN KEY (user_id) REFERENCES users(id)
-- );

-- CREATE TABLE tasks (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     title VARCHAR(255) NOT NULL,
--     description TEXT,
--     status ENUM('todo', 'in_progress', 'completed') DEFAULT 'todo',
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     project_id INT,
--     assigned_to INT,
--     FOREIGN KEY (project_id) REFERENCES projects(id),
--     FOREIGN KEY (assigned_to) REFERENCES users(id)
-- );

-- CREATE TABLE roles (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(50) NOT NULL UNIQUE
-- );

-- CREATE TABLE permissions (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(50) NOT NULL UNIQUE
-- );

-- CREATE TABLE role_permissions (
--     role_id INT,
--     permission_id INT,
--     PRIMARY KEY (role_id, permission_id),
--     FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
--     FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
-- );

-- -- Insert sample users
-- INSERT INTO users (name, email, password, role) VALUES
-- ('Admin User', 'admin@example.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG', 'admin'),
-- ('Manager User', 'manager@example.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG', 'manager'),
-- ('Developer 1', 'dev1@example.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG', 'developer'),
-- ('Developer 2', 'dev2@example.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG', 'developer'),
-- ('Regular User 1', 'user1@example.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG', 'user'),
-- ('Regular User 2', 'user2@example.com', '$2y$10$jb2COpaZSdFhs4PXUcRSHOX7LvQrROHZ.Qe5zhNuAIXWiFOj4injG', 'user');

-- -- Insert sample projects
-- INSERT INTO projects (name, description, user_id) VALUES
-- ('Website Redesign', 'Redesign the company website for better user experience', 1),
-- ('Mobile App Development', 'Develop a new mobile app for customer engagement', 2),
-- ('Database Optimization', 'Optimize database queries for improved performance', 1),
-- ('User Authentication System', 'Implement a secure user authentication system', 3),
-- ('API Integration', 'Integrate third-party APIs for enhanced functionality', 4);

-- -- Insert sample tasks
-- INSERT INTO tasks (title, description, status, project_id, assigned_to) VALUES
-- ('Design Homepage', 'Create a new design for the homepage', 'in_progress', 1, 3),
-- ('Implement User Registration', 'Add user registration functionality to the website', 'todo', 1, 4),
-- ('Develop Login Screen', 'Create the login screen for the mobile app', 'in_progress', 2, 3),
-- ('Optimize SQL Queries', 'Review and optimize slow SQL queries', 'todo', 3, 4),
-- ('Implement OAuth', 'Add OAuth authentication to the system', 'todo', 4, 3),
-- ('Integrate Payment Gateway', 'Integrate a payment gateway API', 'in_progress', 5, 4),
-- ('Write API Documentation', 'Document the new API endpoints', 'todo', 5, 5);

-- -- Insert roles
-- INSERT INTO roles (name) VALUES
-- ('Admin'),
-- ('Project Manager'),
-- ('Developer'),
-- ('User');

-- -- Insert permissions
-- INSERT INTO permissions (name) VALUES
-- ('manage_users'),
-- ('manage_roles'),
-- ('manage_permissions'),
-- ('create_project'),
-- ('edit_project'),
-- ('delete_project'),
-- ('create_task'),
-- ('edit_task'),
-- ('delete_task'),
-- ('assign_task'),
-- ('view_project'),
-- ('view_task');

-- -- Assign permissions to roles
-- INSERT INTO role_permissions (role_id, permission_id)
-- SELECT 1, id FROM permissions;  -- Assign all permissions to Admin

-- INSERT INTO role_permissions (role_id, permission_id)
-- SELECT 2, id FROM permissions 
-- WHERE name IN ('create_project', 'edit_project', 'delete_project', 'create_task', 'edit_task', 'delete_task', 'assign_task', 'view_project', 'view_task');

-- INSERT INTO role_permissions (role_id, permission_id)
-- SELECT 3, id FROM permissions 
-- WHERE name IN ('create_task', 'edit_task', 'view_project', 'view_task');

-- INSERT INTO role_permissions (role_id, permission_id)
-- SELECT 4, id FROM permissions 
-- WHERE name IN ('view_project', 'view_task');









-- -- Create tables
-- CREATE TABLE users (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(255) NOT NULL,
--     email VARCHAR(255) NOT NULL UNIQUE,
--     password VARCHAR(255) NOT NULL,
--     role ENUM('admin', 'project_manager', 'team_member', 'guest') DEFAULT 'team_member'
-- );

-- CREATE TABLE projects (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(255) NOT NULL,
--     description TEXT,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--     user_id INT,
--     is_public BOOLEAN DEFAULT FALSE,
--     FOREIGN KEY (user_id) REFERENCES users(id)
-- );

-- CREATE TABLE tasks (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     title VARCHAR(255) NOT NULL,
--     description TEXT,
--     status ENUM('todo', 'in_progress', 'done') DEFAULT 'todo',
--     type ENUM('basic', 'bug', 'feature') DEFAULT 'basic',
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--     project_id INT,
--     assigned_to INT,
--     FOREIGN KEY (project_id) REFERENCES projects(id),
--     FOREIGN KEY (assigned_to) REFERENCES users(id)
-- );

-- CREATE TABLE tags (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(50) NOT NULL UNIQUE
-- );

-- CREATE TABLE task_tags (
--     task_id INT,
--     tag_id INT,
--     PRIMARY KEY (task_id, tag_id),
--     FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
--     FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
-- );

-- CREATE TABLE project_members (
--     project_id INT,
--     user_id INT,
--     PRIMARY KEY (project_id, user_id),
--     FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
--     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
-- );

-- CREATE TABLE activity_log (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT,
--     project_id INT,
--     task_id INT,
--     action VARCHAR(255) NOT NULL,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (user_id) REFERENCES users(id),
--     FOREIGN KEY (project_id) REFERENCES projects(id),
--     FOREIGN KEY (task_id) REFERENCES tasks(id)
-- );



CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'project_manager', 'team_member', 'guest') NOT NULL DEFAULT 'team_member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    user_id INT,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS tasks (
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

CREATE TABLE IF NOT EXISTS tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS task_tags (
    task_id INT,
    tag_id INT,
    PRIMARY KEY (task_id, tag_id),
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS kanban_boards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS kanban_columns (
    id INT AUTO_INCREMENT PRIMARY KEY,
    board_id INT,
    name VARCHAR(255) NOT NULL,
    position INT NOT NULL,
    FOREIGN KEY (board_id) REFERENCES kanban_boards(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS kanban_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT,
    column_id INT,
    position INT NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (column_id) REFERENCES kanban_columns(id) ON DELETE CASCADE
);

