DROP DATABASE IF EXISTS tfg_mediupp_local;
CREATE DATABASE IF NOT EXISTS tfg_mediupp_local;
USE tfg_mediupp_local;

DROP TABLE IF EXISTS event_admins;
DROP TABLE IF EXISTS user_events;
DROP TABLE IF EXISTS content;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS tokens;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(40) NOT NULL,
    username VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    pfp_src TEXT
);

INSERT INTO users (first_name, last_name, username, password, email, pfp_src) 
VALUES ('Marcos', 'Almorox', 'malmorox', '$2y$10$t1A.8rwWep3rPp5zvCQ1DOyyw7ZALnglQYSl6/qHvU8Blt.hXflSy', 'malmorox@mediupp.es', '');

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    created_at DATE DEFAULT CURRENT_TIMESTAMP NOT NULL,
    type ENUM('Default', 'Boda', 'Vacaciones') DEFAULT 'Default',
    location VARCHAR(255),
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    is_public BOOLEAN DEFAULT FALSE NOT NULL,
    FOREIGN KEY (event_type_id) REFERENCES event_types(id) ON DELETE CASCADE,
    CONSTRAINT check_event_dates CHECK (start_date <= end_date)
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    user_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    content_array JSON,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT,
    src TEXT,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE user_events (
    user_id INT,
    event_id INT,
    PRIMARY KEY (user_id, event_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE event_admins (
    event_id INT,
    user_id INT,
    PRIMARY KEY (event_id, user_id),
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE tokens (
    token VARCHAR(255) PRIMARY KEY,
    user_id INT NOT NULL,
    expiry_date DATETIME NOT NULL,
    consumed BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);