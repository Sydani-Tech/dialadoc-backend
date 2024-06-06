-- User Authentication and Authorization
CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  role ENUM('patient', 'doctor', 'nurse', 'lab', 'hospital', 'pharmacy', 'admin') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Specializations, Locations, and Reviews
CREATE TABLE specializations (
  specialization_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE locations (
  location_id INT AUTO_INCREMENT PRIMARY KEY,
  city VARCHAR(100) NOT NULL,
  state VARCHAR(100) NOT NULL,
  country VARCHAR(100) NOT NULL,
  postal_code VARCHAR(20)
);

CREATE TABLE doctors (
  doctor_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  specialization_id INT,
  location_id INT,
  experience_years INT,
  mdcn_license VARCHAR(100),
  cpd_annual_license VARCHAR(100),
  bank_details VARCHAR(255),
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (specialization_id) REFERENCES specializations(specialization_id),
  FOREIGN KEY (location_id) REFERENCES locations(location_id)
);

CREATE TABLE reviews (
  review_id INT AUTO_INCREMENT PRIMARY KEY,
  doctor_id INT,
  patient_id INT,
  rating INT CHECK (rating >= 1 AND rating <= 5),
  review_text TEXT,
  review_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id),
  FOREIGN KEY (patient_id) REFERENCES users(user_id)
);

-- Pharmacies, Medications, Prescriptions, and Orders
CREATE TABLE pharmacies (
  pharmacy_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  location_id INT,
  FOREIGN KEY (location_id) REFERENCES locations(location_id)
);

CREATE TABLE medications (
  medication_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT
);

CREATE TABLE prescriptions (
  prescription_id INT AUTO_INCREMENT PRIMARY KEY,
  doctor_id INT,
  patient_id INT,
  date_issued DATE,
  created_by INT,
  FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id),
  FOREIGN KEY (patient_id) REFERENCES users(user_id)
);

CREATE TABLE prescription_medications (
  prescription_medication_id INT AUTO_INCREMENT PRIMARY KEY,
  prescription_id INT,
  medication_id INT,
  dosage VARCHAR(100),
  frequency VARCHAR(100),
  FOREIGN KEY (prescription_id) REFERENCES prescriptions(prescription_id),
  FOREIGN KEY (medication_id) REFERENCES medications(medication_id)
);

CREATE TABLE orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  prescription_id INT,
  pharmacy_id INT,
  consultation_id INT,
  user_id INT,
  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  order_type ENUM('consultation', 'prescription') NOT NULL,
  status ENUM('pending', 'completed', 'cancelled') NOT NULL,
  FOREIGN KEY (prescription_id) REFERENCES prescriptions(prescription_id),
  FOREIGN KEY (pharmacy_id) REFERENCES pharmacies(pharmacy_id)
);

-- Appointments, Consultations, and Messages/Chat
CREATE TABLE appointments (
  appointment_id INT AUTO_INCREMENT PRIMARY KEY,
  doctor_id INT,
  patient_id INT,
  appointment_date DATETIME,
  created_by INT,
  status ENUM('scheduled', 'completed', 'cancelled') NOT NULL,
  FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id),
  FOREIGN KEY (patient_id) REFERENCES users(user_id)
);

CREATE TABLE consultations (
  consultation_id INT AUTO_INCREMENT PRIMARY KEY,
  appointment_id INT,
  notes TEXT,
  created_by INT,
  consultation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id)
);

CREATE TABLE messages (
  message_id INT AUTO_INCREMENT PRIMARY KEY,
  consultation_id INT,
  sender_id INT,
  receiver_id INT,
  message_text TEXT,
  sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (consultation_id) REFERENCES consultations(consultation_id),
  FOREIGN KEY (sender_id) REFERENCES users(user_id),
  FOREIGN KEY (receiver_id) REFERENCES users(user_id)
);

-- Patients, Medical Records, and Test Results
CREATE TABLE patients (
  patient_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  date_of_birth DATE,
  gender ENUM('male', 'female', 'other'),
  blood_group VARCHAR(10),
  genotype VARCHAR(10),
  location_id INT,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (location_id) REFERENCES locations(location_id)
);

CREATE TABLE medical_records (
  record_id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT,
  doctor_id INT,
  created_by INT,
  record_type ENUM('consultation', 'test', 'treatment'),
  description TEXT,
  date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
  FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
);

CREATE TABLE test_results (
  test_result_id INT AUTO_INCREMENT PRIMARY KEY,
  record_id INT,
  test_name VARCHAR(100),
  result TEXT,
  date_performed DATE,
  created_by INT,
  FOREIGN KEY (record_id) REFERENCES medical_records(record_id)
);

-- Health Metrics, Treatment Plans, and Progress Reports
CREATE TABLE health_metrics (
  metric_id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT,
  metric_type VARCHAR(100),
  value VARCHAR(100),
  measurement_date DATE,
  created_by INT,
  FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
);

CREATE TABLE treatment_plans (
  plan_id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT,
  doctor_id INT,
  description TEXT,
  start_date DATE,
  end_date DATE,
  created_by INT,
  FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
  FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
);

CREATE TABLE progress_reports (
  report_id INT AUTO_INCREMENT PRIMARY KEY,
  plan_id INT,
  created_by INT,
  report_date DATE,
  progress_description TEXT,
  FOREIGN KEY (plan_id) REFERENCES treatment_plans(plan_id)
);

-- Payment Transactions
CREATE TABLE payments (
  payment_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  order_id INT,
  amount DECIMAL(10, 2),
  currency VARCHAR(10),
  payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status ENUM('pending', 'completed', 'failed') NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

-- Notifications and Reminders
CREATE TABLE notifications (
  notification_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  message TEXT,
  is_read BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Insurance Information
CREATE TABLE insurances (
  insurance_id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT,
  provider_name VARCHAR(100),
  policy_number VARCHAR(50),
  coverage_details TEXT,
  FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
);

-- Two-Factor Authentication (2FA)
CREATE TABLE two_factor_auth (
  auth_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  auth_code VARCHAR(10),
  expiration_time TIMESTAMP,
  is_used BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Consent Management
CREATE TABLE consents (
  consent_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  doctor_id INT,
  consent_type ENUM('view_records', 'share_info'),
  granted BOOLEAN DEFAULT FALSE,
  consent_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
);
