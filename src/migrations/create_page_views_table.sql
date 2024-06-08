CREATE TABLE IF NOT EXISTS page_views (
    id INT AUTO_INCREMENT,
    client_id VARCHAR(36) NOT NULL,
    user_uuid VARCHAR(36) NOT NULL,
    pathname VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_client FOREIGN KEY (client_id)
    REFERENCES clients (id)
    ON DELETE CASCADE
);