USE imo_system;

DROP TABLE IF EXISTS password_resets;

CREATE TABLE password_resets (
     id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
     user_id INT(11) UNSIGNED NOT NULL,
     token_hash VARCHAR(255) NOT NULL, 
     expires_at DATETIME NOT NULL, 
     used_at DATETIME NULL, 
     created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     INDEX (user_id), 
     INDEX (expires_at), 
     CONSTRAINT fk_password_resets_user FOREIGN KEY (user_id) REFERENCES utilizadores(id) );