DROP DATABASE IF EXISTS tfg_mediupp_local;
CREATE DATABASE IF NOT EXISTS tfg_mediupp_local;
USE tfg_mediupp_local;

DROP TABLE IF EXISTS user_events;
DROP TABLE IF EXISTS chats;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS tokens;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(40),
    usern VARCHAR(20) NOT NULL UNIQUE,
    passw VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    pfp_src TEXT
);

INSERT INTO users (first_name, last_name, usern, passw, email, pfp_src) 
VALUES ('Marcos', 'Almorox', 'malmorox', '$2y$10$t1A.8rwWep3rPp5zvCQ1DOyyw7ZALnglQYSl6/qHvU8Blt.hXflSy', 'malmorox@mediupp.es', '');
INSERT INTO users (first_name, last_name, usern, passw, email, pfp_src) 
VALUES ('Samuel', 'Macias', 'smacias', '$2y$10$yUBkHQfKhJlMDek0wxOm.uII0CIGr1Uzf/WO6ymtqBew8liGhJCn6', 'smacias@mediupp.es', '');
INSERT INTO users (first_name, last_name, usern, passw, email, pfp_src)
VALUES ('Sergio', 'Cáceres', 'scaceres', '$2y$10$O3L7jmSn6INjJYiW0rhK4e73rZFM2MheMt7mu39tEXMvO9TdJXsQa', 'scaceres@mediupp.es', '');

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    type ENUM('Default', 'Boda', 'Vacaciones') DEFAULT 'Default' NOT NULL,
    location TEXT,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    is_public TINYINT(1) DEFAULT 0 NOT NULL CHECK (is_public IN (0, 1)),
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 10),
    CONSTRAINT check_event_dates CHECK (start_date <= end_date)
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    file_src TEXT NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE chats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    message TEXT NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE user_events (
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    is_admin TINYINT(1) DEFAULT 0 NOT NULL CHECK (is_admin IN (0, 1)),
    join_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (user_id, event_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE tokens (
    token VARCHAR(255) PRIMARY KEY,
    user_id INT NOT NULL,
    expiry_date DATETIME NOT NULL,
    consumed TINYINT(1) NOT NULL DEFAULT 0 CHECK (consumed IN (0, 1)),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);