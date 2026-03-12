INSERT INTO employees (
    full_name, 
    birth_date, 
    passport, 
    phone_number, 
    email, 
    address, 
    department, 
    position, 
    salary, 
    hire_date, 
    fired
) VALUES
('Иванов Иван Иванович', '1990-05-15', '4512 345678', '+7 (999) 123-45-67', 'ivanov@company.ru', 'г. Москва, ул. Ленина, д. 10, кв. 25', 'IT', 'Senior Developer', 150000.00, '2022-03-01', false),
('Петрова Анна Сергеевна', '1985-08-22', '4512 987654', '+7 (999) 765-43-21', 'petrova@company.ru', 'г. Москва, ул. Гагарина, д. 5, кв. 12', 'HR', 'HR Manager', 120000.00, '2021-11-15', false),
('Сидоров Петр Алексеевич', '1995-12-03', '4512 456789', '+7 (999) 555-66-77', 'sidorov@company.ru', 'г. Москва, ул. Пушкина, д. 3, кв. 8', 'Sales', 'Sales Manager', 130000.00, '2023-01-10', false),
('Козлова Елена Дмитриевна', '1988-03-27', '4512 234567', '+7 (999) 222-33-44', 'kozlova@company.ru', 'г. Москва, ул. Тверская, д. 15, кв. 3', 'Marketing', 'Marketing Specialist', 110000.00, '2022-08-20', false),
('Смирнов Алексей Викторович', '1992-07-19', '4512 876543', '+7 (999) 888-99-00', 'smirnov@company.ru', 'г. Москва, ул. Арбат, д. 22, кв. 17', 'IT', 'System Administrator', 140000.00, '2021-05-05', false);

UPDATE employees SET 
    full_name = CONVERT(CAST(CONVERT(full_name USING latin1) AS BINARY) USING utf8mb4),
    address = CONVERT(CAST(CONVERT(address USING latin1) AS BINARY) USING utf8mb4),
    department = CONVERT(CAST(CONVERT(department USING latin1) AS BINARY) USING utf8mb4),
    position = CONVERT(CAST(CONVERT(position USING latin1) AS BINARY) USING utf8mb4)
WHERE 1=1;