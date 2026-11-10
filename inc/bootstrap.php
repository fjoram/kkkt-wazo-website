<?php
declare(strict_types=1);
mb_internal_encoding('UTF-8');
date_default_timezone_set('Africa/Dar_es_Salaam');

$cfgFile = dirname(__DIR__) . '/config.php';
if (!is_file($cfgFile)) {
    http_response_code(500);
    exit('Website not configured yet: copy config.sample.php to config.php and fill in the database details.');
}
$CONFIG = require $cfgFile;

function db(): PDO {
    static $pdo = null;
    global $CONFIG;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=' . $CONFIG['db_host'] . ';dbname=' . $CONFIG['db_name'] . ';charset=utf8mb4',
            $CONFIG['db_user'], $CONFIG['db_pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
             PDO::ATTR_EMULATE_PREPARES => false]
        );
    }
    return $pdo;
}

/** Run a query with parameters and return all rows. */
function q(string $sql, array $p = []): array { $s = db()->prepare($sql); $s->execute($p); return $s->fetchAll(); }
/** Run a query and return the first row or null. */
function q1(string $sql, array $p = []): ?array { $r = q($sql, $p); return $r[0] ?? null; }
/** Run a statement (insert/update/delete). */
function run(string $sql, array $p = []): int { $s = db()->prepare($sql); $s->execute($p); return $s->rowCount(); }

/** HTML-escape. */
function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

/** Bilingual text: Kiswahili + English (English falls back to Kiswahili). Escapes both. */
function L(?string $sw, ?string $en = null): string {
    $en = ($en === null || trim($en) === '') ? $sw : $en;
    return '<span lang="sw">' . e($sw) . '</span><span lang="en">' . e($en) . '</span>';
}
/** Bilingual text where the strings are trusted HTML written in this code (not user input). */
function Lh(string $sw, string $en): string { return '<span lang="sw">' . $sw . '</span><span lang="en">' . $en . '</span>'; }

/** Site settings from the settings table. */
function setting(string $key, string $default = ''): string {
    static $all = null;
    if ($all === null) { $all = []; foreach (q('SELECT k, v FROM settings') as $r) $all[$r['k']] = (string)$r['v']; }
    return $all[$key] ?? $default;
}

const MON_SW = ['Januari','Februari','Machi','Aprili','Mei','Juni','Julai','Agosti','Septemba','Oktoba','Novemba','Desemba'];
const MON_EN = ['January','February','March','April','May','June','July','August','September','October','November','December'];
const MON_SH = ['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Ago','Sep','Okt','Nov','Des'];
const DAY_SW = ['Jumapili','Jumatatu','Jumanne','Jumatano','Alhamisi','Ijumaa','Jumamosi'];
const DAY_EN = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

/** "8 Nov 2026" style short date. */
function dshort(string $ymd): string { $t = strtotime($ymd); return date('j', $t) . ' ' . MON_SH[(int)date('n', $t) - 1] . ' ' . date('Y', $t); }

/** Extract a YouTube video ID from a link or return the ID as-is. */
function youtube_id(?string $s): string {
    $s = trim((string)$s);
    if ($s === '') return '';
    if (preg_match('~(?:v=|youtu\.be/|/embed/|/live/|/shorts/)([A-Za-z0-9_-]{11})~', $s, $m)) return $m[1];
    return preg_match('~^[A-Za-z0-9_-]{11}$~', $s) ? $s : '';
}

/** Public URL for an uploaded or bundled image path. */
function img_url(string $path): string { return e($path); }

/* ---------- Hymn board ("Nyimbo za Jumapili") ---------- */
const HYMN_BOOKS = ['MB' => 'Mwimbieni Bwana', 'TMW' => 'Tumwabudu Mungu Wetu'];

/** One hymn per line: "148 – Chini ya bawa lako", optionally "Kuingia: 148 – ...".
    Returns [['label'=>..., 'num'=>..., 'first'=>...], ...] and fills $bad with lines it could not read. */
function hymn_lines(string $text, ?array &$bad = null): array
{
    $out = []; $bad = [];
    foreach (preg_split('/\R/u', $text) as $line) {
        $line = trim($line);
        if ($line === '') continue;
        if (preg_match('/^(?:(?<label>[^:\d][^:]{0,40}):\s*)?(?:Wimbo\s*)?(?:Na\.?|No\.?|#)?\s*(?<num>\d{1,4})\s*[-–—.,:]?\s*(?<first>.*)$/iu', $line, $m)) {
            $out[] = ['label' => trim($m['label'] ?? ''), 'num' => (int)$m['num'], 'first' => trim($m['first'])];
        } else {
            $bad[] = $line;
        }
    }
    return $out;
}

/** Creates the hymn_boards table on first use, so older databases need no manual update. */
function hymn_table_ready(): void
{
    static $ok = false;
    if ($ok) return;
    try { db()->query('SELECT 1 FROM hymn_boards LIMIT 1'); }
    catch (PDOException $e) {
        db()->exec("CREATE TABLE IF NOT EXISTS hymn_boards (
          id INT AUTO_INCREMENT PRIMARY KEY, sunday_date DATE NOT NULL, book VARCHAR(8) NOT NULL DEFAULT 'MB',
          hymns TEXT NOT NULL, note_sw VARCHAR(255) NOT NULL DEFAULT '', note_en VARCHAR(255) NOT NULL DEFAULT '',
          UNIQUE KEY uq_hymn_sunday (sunday_date)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }
    $ok = true;
}

/** The board to show now: the next Sunday that has one (today included), else last Sunday's. */
function current_hymn_board(): ?array
{
    hymn_table_ready();
    $b = q1('SELECT * FROM hymn_boards WHERE sunday_date >= CURDATE() ORDER BY sunday_date LIMIT 1');
    if ($b) { $b['past'] = false; return $b; }
    $b = q1('SELECT * FROM hymn_boards WHERE sunday_date >= CURDATE() - INTERVAL 6 DAY ORDER BY sunday_date DESC LIMIT 1');
    if ($b) $b['past'] = true;
    return $b ?: null;
}
