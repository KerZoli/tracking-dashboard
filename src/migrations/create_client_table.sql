CREATE TABLE IF NOT EXISTS clients (
    id VARCHAR(36),
    domain_name VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);