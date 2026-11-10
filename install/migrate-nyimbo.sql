-- Adds "Nyimbo za Jumapili" (this Sunday's hymn board).
-- Run once on an existing database (phpMyAdmin → Import). New installs get it from schema.sql.
CREATE TABLE IF NOT EXISTS hymn_boards (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sunday_date DATE NOT NULL,
  book VARCHAR(8) NOT NULL DEFAULT 'MB',
  hymns TEXT NOT NULL,
  note_sw VARCHAR(255) NOT NULL DEFAULT '',
  note_en VARCHAR(255) NOT NULL DEFAULT '',
  UNIQUE KEY uq_hymn_sunday (sunday_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
