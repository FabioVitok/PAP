USE imo_system;

DROP TABLE IF EXISTS email_verifications;

CREATE TABLE email_verifications (
     id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
     user_id INT(11) UNSIGNED NOT NULL, 
     token_hash VARCHAR(64) NOT NULL, 
     expires_at DATETIME NOT NULL, 
     used_at DATETIME NULL, 
     created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     INDEX (user_id), 
     INDEX (expires_at), 
     UNIQUE (token_hash), 
     CONSTRAINT fk_email_verifications_user FOREIGN KEY (user_id) REFERENCES utilizadores(id));