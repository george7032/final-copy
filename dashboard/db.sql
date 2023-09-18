-- Active: 1693658882446@@127.0.0.1@3306@tms
drop DATABASE tMS;
CREATE DATABASE tms;
USE tms;
DROP TABLE owners;

CREATE TABLE owners (
    apartmentID INT NOT NULL PRIMARY KEY,
    apartment_name VARCHAR(255) NOT NULL,
    apartment_location VARCHAR(255) NOT NULL,
    ownerName VARCHAR(255) NOT NULL,
    ownerID VARCHAR(20) NOT NULL,
    ownerPhoneNumber VARCHAR(15) NOT NULL,
    ownerEmail VARCHAR(255) NOT NULL,
    ownerPassword VARCHAR(255) NOT NULL
    
);
DROP TABLE tenants;

CREATE TABLE tenants (
    tenantID INT AUTO_INCREMENT PRIMARY KEY,
    apartmentID INT NOT NULL,
    tenantName VARCHAR(255),
    apartmentNumber VARCHAR(50),
    amountToBePaid DECIMAL(10),
    tenantEmail VARCHAR(255),
    tenantPassword VARCHAR(255),
    FOREIGN KEY (apartmentID) REFERENCES owners(apartmentID) ON DELETE CASCADE
);
CREATE TABLE payments (
    paymentID INT AUTO_INCREMENT PRIMARY KEY,
    tenantID INT NOT NULL,
    paymentDate DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    description VARCHAR(255),
    FOREIGN KEY (tenantID) REFERENCES tenants(tenantID) ON DELETE CASCADE
);