<?php
/* ============================================================
   KKKT Usharika wa Wazo – website settings
   1. Copy this file to config.php
   2. Fill in the database details from your hosting (cPanel → MySQL Databases)
   ============================================================ */
return [
  'db_host' => 'localhost',
  'db_name' => 'kkkt_wazo',
  'db_user' => 'kkkt_user',
  'db_pass' => 'CHANGE_ME',
  // Folder for uploaded photos (must be writable by the web server)
  'upload_dir' => __DIR__ . '/uploads',
  'upload_url' => 'uploads',
];
