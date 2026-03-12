SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    birth_date DATE NOT NULL,
    passport VARCHAR(20) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    email VARCHAR(50) NOT NULL,
    address VARCHAR(255) NOT NULL,
    department VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    salary DECIMAL(10, 2) NOT NULL,
    hire_date DATE NOT NULL,
    fired BOOLEAN NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

UPDATE employees SET 
    full_name = CONVERT(CAST(CONVERT(full_name USING latin1) AS BINARY) USING utf8mb4),
    address = CONVERT(CAST(CONVERT(address USING latin1) AS BINARY) USING utf8mb4),
    department = CONVERT(CAST(CONVERT(department USING latin1) AS BINARY) USING utf8mb4),
    position = CONVERT(CAST(CONVERT(position USING latin1) AS BINARY) USING utf8mb4)
WHERE 1=1;