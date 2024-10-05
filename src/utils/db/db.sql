DROP DATABASE IF EXISTS tfg_mediupp_local;
CREATE DATABASE IF NOT EXISTS tfg_mediupp_local;
USE tfg_mediupp_local;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS content;
DROP TABLE IF EXISTS user_events;
DROP TABLE IF EXISTS event_admins;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    pfp VARCHAR(255),
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type ENUM('General', 'Boda', 'Vacaciones') DEFAULT 'General',
    start_date DATETIME,
    end_date DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT check_event_dates CHECK (start_date <= end_date)
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    user_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    content_array JSON,
    FOREIGN KEY (event_id) REFERENCES events(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT,
    src LONGTEXT,
    FOREIGN KEY (post_id) REFERENCES posts(id)
);

CREATE TABLE user_events (
    user_id INT,
    event_id INT,
    PRIMARY KEY (user_id, event_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES events(id)
);

CREATE TABLE event_admins (
    event_id INT,
    user_id INT,
    PRIMARY KEY (event_id, user_id),
    FOREIGN KEY (event_id) REFERENCES events(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);