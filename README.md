# KKKT Usharika wa Wazo – Tovuti (PHP + MySQL)

Official website of **KKKT Usharika wa Wazo** (Evangelical Lutheran Church in Tanzania, Eastern and Coastal Diocese),
Wazo, Dar es Salaam. Bilingual: Kiswahili (default) and English.

Plain PHP 8 and MySQL/MariaDB, no framework, so it runs on ordinary shared hosting (cPanel).
Church staff manage everything from the admin area at **`/admin`**: no code editing needed.

## Installing on hosting (cPanel)

1. **Create the database.** cPanel → *MySQL Databases*: create a database (e.g. `kkkt_wazo`) and a user with a
   strong password, then add the user to the database with **All privileges**.
2. **Import the tables.** cPanel → *phpMyAdmin* → choose the database → *Import*:
   first `install/schema.sql`, then `install/sample-data.sql` (current content and examples).
3. **Upload the files.** Upload everything in this folder to `public_html` (or a subfolder) with *File Manager* or FTP.
4. **Connect to the database.** Copy `config.sample.php` to `config.php` and fill in the database name, user and password.
5. **Make uploads writable.** Make sure the `uploads` folder is writable (permissions 755).
6. **Create the first admin account.** Open `https://your-domain/admin/`. The first visit asks you to create the
   administrator account. More users can be added later under *Zaidi → Watumiaji*.
7. **Switch on HTTPS** in cPanel (*SSL/TLS Status* → AutoSSL) so logins are encrypted.

Requirements: PHP 8.0+ with `pdo_mysql` and `gd` (standard on most hosts), MySQL 5.7+ or MariaDB 10.3+.

## What the admin area manages

| Menu | What it changes |
| --- | --- |
| Matangazo | Weekly announcements, grouped by Sunday. The newest Sunday is "this week"; older ones move to the archive by themselves. |
| Kumbukumbu | Long-term notices (Mavuno, building, registration) with start and end dates; they disappear after the end date. |
| Matukio | Upcoming events; past events hide themselves. |
| Mahubiri | Sermons. Paste a YouTube link and the video plays on the site. |
| Picha | Photo albums. Upload many photos at once; they are resized automatically. |
| Uongozi | Pastors and parish leaders with photos. |
| Zaidi | Sunday services, weekly schedule, fellowships, admin users. |
| Mipangilio | Phone, email, Lipa Namba, bank, verse of the week, season message, pastor's welcome, YouTube channel and live-stream times. |

## Live services (Mubashara)

Under *Mipangilio → YouTube na ibada mubashara*, enter the church's YouTube **Channel ID** (starts with `UC`) and the
Sunday live hours. During those hours the site shows a red "Mubashara" badge and plays the live stream.
To find the Channel ID: on YouTube open the channel → *About* → *Share channel* → *Copy channel ID*.
Preview live mode any time by adding `?live=1` to a page address.

## Files

| Path | Purpose |
| --- | --- |
| `*.php` | The nine public pages |
| `inc/` | Database connection, helpers, page layout (not reachable from the web) |
| `admin/` | Admin area |
| `install/` | Database tables and starting content |
| `style.css`, `site.js` | Design and page behaviour (language switch, gallery, live mode) |
| `images/` | Built-in photos |
| `uploads/` | Photos uploaded through the admin area |

## Security notes

- Passwords are stored hashed; forms are protected against cross-site requests; all database queries use prepared statements.
- `inc/`, `install/` and `config.php` are blocked from the web by `.htaccess`, and scripts cannot run from `uploads/`.
- After installing, you may delete the `install/` folder from the server.
