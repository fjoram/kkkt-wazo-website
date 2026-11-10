-- KKKT Usharika wa Wazo – database tables
-- Import this file first (phpMyAdmin → Import), then install/sample-data.sql.
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(60) NOT NULL UNIQUE,
  name VARCHAR(120) NOT NULL DEFAULT '',
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS settings (
  k VARCHAR(60) PRIMARY KEY,
  v TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sunday services (shown on the home page and the Ibada page)
CREATE TABLE IF NOT EXISTS services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  time_sw VARCHAR(20) NOT NULL, period_sw VARCHAR(20) NOT NULL DEFAULT 'asubuhi',
  time_en VARCHAR(20) NOT NULL, period_en VARCHAR(20) NOT NULL DEFAULT 'AM',
  name_sw VARCHAR(120) NOT NULL, name_en VARCHAR(120) DEFAULT '',
  short_sw VARCHAR(255) DEFAULT '', short_en VARCHAR(255) DEFAULT '',
  desc_sw TEXT, desc_en TEXT,
  sort INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Weekday activities (Ibada page timeline)
CREATE TABLE IF NOT EXISTS schedule (
  id INT AUTO_INCREMENT PRIMARY KEY,
  day_sw VARCHAR(30) NOT NULL, day_en VARCHAR(30) DEFAULT '',
  time_sw VARCHAR(40) NOT NULL, time_en VARCHAR(40) DEFAULT '',
  activity_sw VARCHAR(160) NOT NULL, activity_en VARCHAR(160) DEFAULT '',
  icon VARCHAR(20) NOT NULL DEFAULT 'cross',
  sort INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Weekly announcements: each row belongs to a Sunday date. The newest Sunday is "this week".
CREATE TABLE IF NOT EXISTS announcements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sunday_date DATE NOT NULL,
  label VARCHAR(40) DEFAULT '',
  title_sw VARCHAR(200) NOT NULL, title_en VARCHAR(200) DEFAULT '',
  body_sw TEXT, body_en TEXT,
  sort INT NOT NULL DEFAULT 0,
  INDEX (sunday_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Long-term notices (Mavuno, building, registration...) shown between start and end dates
CREATE TABLE IF NOT EXISTS notices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  label VARCHAR(40) DEFAULT '',
  title_sw VARCHAR(200) NOT NULL, title_en VARCHAR(200) DEFAULT '',
  body_sw TEXT, body_en TEXT,
  start_date DATE NOT NULL, end_date DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  event_date DATE NOT NULL,
  time_sw VARCHAR(40) DEFAULT '', time_en VARCHAR(40) DEFAULT '',
  title_sw VARCHAR(200) NOT NULL, title_en VARCHAR(200) DEFAULT '',
  INDEX (event_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS sermons (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sermon_date DATE NOT NULL,
  title_sw VARCHAR(200) NOT NULL, title_en VARCHAR(200) DEFAULT '',
  ref_sw VARCHAR(80) DEFAULT '', ref_en VARCHAR(80) DEFAULT '',
  preacher VARCHAR(120) DEFAULT '',
  youtube VARCHAR(255) DEFAULT '',
  INDEX (sermon_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS albums (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title_sw VARCHAR(200) NOT NULL, title_en VARCHAR(200) DEFAULT '',
  desc_sw VARCHAR(255) DEFAULT '', desc_en VARCHAR(255) DEFAULT '',
  album_date DATE NOT NULL,
  category ENUM('ibada','kwaya','watoto','matukio','uongozi') NOT NULL DEFAULT 'matukio',
  INDEX (album_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- path: a file path such as uploads/albums/12/abc.jpg, or "ikoni:music" for a sample frame
CREATE TABLE IF NOT EXISTS photos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  album_id INT NOT NULL,
  path VARCHAR(255) NOT NULL,
  caption_sw VARCHAR(255) DEFAULT '', caption_en VARCHAR(255) DEFAULT '',
  sort INT NOT NULL DEFAULT 0,
  FOREIGN KEY (album_id) REFERENCES albums(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS leaders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  role_sw VARCHAR(120) NOT NULL, role_en VARCHAR(120) DEFAULT '',
  photo VARCHAR(255) DEFAULT '',
  tier ENUM('pastor','staff') NOT NULL DEFAULT 'staff',
  sort INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS fellowships (
  id INT AUTO_INCREMENT PRIMARY KEY,
  icon VARCHAR(20) NOT NULL DEFAULT 'music',
  name_sw VARCHAR(120) NOT NULL, name_en VARCHAR(120) DEFAULT '',
  desc_sw TEXT, desc_en TEXT,
  meet_sw VARCHAR(120) DEFAULT '', meet_en VARCHAR(120) DEFAULT '',
  sort INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
