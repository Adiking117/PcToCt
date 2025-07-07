-- Create Database
CREATE DATABASE IF NOT EXISTS ehr_db;
USE ehr_db;

-- Table: doctor
CREATE TABLE IF NOT EXISTS doctor (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Table: patient
CREATE TABLE IF NOT EXISTS patient (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Table: encounter
CREATE TABLE IF NOT EXISTS encounter (
    encounter_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    FOREIGN KEY (patient_id) REFERENCES patient(patient_id),
    FOREIGN KEY (doctor_id) REFERENCES doctor(doctor_id)
);

-- Table: soap_notes
CREATE TABLE IF NOT EXISTS soap_notes (
    soap_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    encounter_id INT,
    subjective TEXT,
    objective TEXT,
    assesment TEXT,
    plan TEXT,
    FOREIGN KEY (patient_id) REFERENCES patient(patient_id),
    FOREIGN KEY (doctor_id) REFERENCES doctor(doctor_id),
    FOREIGN KEY (encounter_id) REFERENCES encounter(encounter_id)
);

-- Insert sample doctor
INSERT INTO doctor (name) VALUES ('Dr. Aarya Mehta');

-- Insert sample patient
INSERT INTO patient (name) VALUES ('Ravi Sharma');
