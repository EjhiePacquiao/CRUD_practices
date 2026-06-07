CREATE DATABASE IF NOT EXISTS congress_db;
USE congress_db;

CREATE TABLE IF NOT EXISTS registration(
    idNum VARCHAR(20) PRIMARY KEY,
    campus VARCHAR(100) NOT NULL,
    studFName VARCHAR(100) NOT NULL,
    studLName VARCHAR(100) NOT NULL,
    amountPaid DECIMAL(10,2) NOT NULL,
    attended VARCHAR(3) DEFAULT 'No'
);

INSERT INTO registration (idNum, campus, studFName, studLName, amountPaid, attended) 
VALUES
('001', 'MAIN', 'EJHIE', 'PACQUIAO', 200, 'No'),
('002', 'MAIN', 'JAZELLE', 'TAMAYO', 200, 'No'),
('003', 'MAIN', 'TIYA', 'HANS', 200, 'No'),
('004', 'MAIN', 'JASMIN', 'PANCHO', 200, 'No'),
('005', 'MAIN', 'MARIE', 'BELL', 200, 'No'),
('006', 'MAIN', 'TINKER', 'BELL', 200, 'No');