-- MySQL version of the database schema for phpMyAdmin

CREATE TABLE case_items (
    cases_id_case  INT NOT NULL,
    items_id_item  INT NOT NULL,
    drop_rate      FLOAT NOT NULL,
    PRIMARY KEY (cases_id_case, items_id_item)
);

CREATE TABLE cases (
    id_case               INT NOT NULL AUTO_INCREMENT,
    name                  VARCHAR(100) NOT NULL,
    price                 DECIMAL(10, 2) NOT NULL,
    description           TEXT,
    image_url             VARCHAR(255),
    order_number          INT NOT NULL,
    sections_id_sections  INT NOT NULL,
    PRIMARY KEY (id_case)
);

CREATE TABLE drops (
    id_drop        INT NOT NULL AUTO_INCREMENT,
    drop_date      DATETIME NOT NULL,
    users_id_user  INT NOT NULL,
    cases_id_case  INT NOT NULL,
    items_id_item  INT NOT NULL,
    PRIMARY KEY (id_drop, cases_id_case)
);

CREATE TABLE items (
    id_item    INT NOT NULL AUTO_INCREMENT,
    name       VARCHAR(100) NOT NULL,
    rarity     VARCHAR(20) NOT NULL,
    price      INT NOT NULL,
    image_url  VARCHAR(255),
    PRIMARY KEY (id_item)
);

CREATE TABLE roles (
    id_role     INT NOT NULL AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL,
    active      CHAR(1) NOT NULL,
    created_at  DATETIME NOT NULL,
    expired_at  DATETIME,
    PRIMARY KEY (id_role)
);

CREATE TABLE sections (
    id_sections   INT NOT NULL AUTO_INCREMENT,
    section_name  VARCHAR(100) NOT NULL,
    order_numbe   INT NOT NULL,
    created_at    DATETIME NOT NULL,
    updated_at    DATETIME,
    created_by    INT NOT NULL,
    updated_by    INT NOT NULL,
    PRIMARY KEY (id_sections)
);

CREATE TABLE users (
    id_user     INT NOT NULL AUTO_INCREMENT,
    username    VARCHAR(255) NOT NULL,
    email       VARCHAR(255) NOT NULL,
    password    VARCHAR(255) NOT NULL,
    balance     DECIMAL(10, 2) NOT NULL,
    steam_id    INT,
    created_at  DATETIME NOT NULL,
    updated_at  DATETIME NOT NULL,
    created_by  INT NOT NULL,
    updated_by  INT NOT NULL,
    image_url   VARCHAR(255),
    PRIMARY KEY (id_user)
);

CREATE TABLE users_roles (
    users_id_user  INT NOT NULL,
    roles_id_role  INT NOT NULL,
    assigned_at    DATETIME NOT NULL,
    assigned_by    INT NOT NULL,
    PRIMARY KEY (users_id_user, roles_id_role)
);

-- Foreign key constraints
ALTER TABLE case_items
    ADD CONSTRAINT case_items_cases_fk FOREIGN KEY (cases_id_case)
        REFERENCES cases (id_case);

ALTER TABLE case_items
    ADD CONSTRAINT case_items_items_fk FOREIGN KEY (items_id_item)
        REFERENCES items (id_item);

ALTER TABLE cases
    ADD CONSTRAINT cases_sections_fk FOREIGN KEY (sections_id_sections)
        REFERENCES sections (id_sections);

ALTER TABLE drops
    ADD CONSTRAINT drops_cases_fk FOREIGN KEY (cases_id_case)
        REFERENCES cases (id_case);

ALTER TABLE drops
    ADD CONSTRAINT drops_items_fk FOREIGN KEY (items_id_item)
        REFERENCES items (id_item);

ALTER TABLE drops
    ADD CONSTRAINT drops_users_fk FOREIGN KEY (users_id_user)
        REFERENCES users (id_user);

ALTER TABLE users_roles
    ADD CONSTRAINT users_roles_roles_fk FOREIGN KEY (roles_id_role)
        REFERENCES roles (id_role);

ALTER TABLE users_roles
    ADD CONSTRAINT users_roles_users_fk FOREIGN KEY (users_id_user)
        REFERENCES users (id_user);