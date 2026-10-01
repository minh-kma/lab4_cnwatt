<?php
const COOKIE_DAYS    = 30;
const FAV_COOKIE     = 'favourites';
const FAV_MAX_LINKS  = 20;
const FAV_MAX_TITLE  = 50;
const FAV_MAX_URL    = 200;

function catChuoi(string $s, int $n): string
{
    if (function_exists('mb_substr')) {
        return mb_substr($s, 0, $n, 'UTF-8');
    }
    return preg_match('/^.{0,' . $n . '}/su', $s, $m) ? $m[0] : substr($s, 0, $n);
}

function doDaiChuoi(string $s): int
{
    if (function_exists('mb_strlen')) {
        return mb_strlen($s, 'UTF-8');
    }
    return preg_match_all('/./su', $s) ?: 0;
}

function datCookie(string $name, string $value, int $days = COOKIE_DAYS): void
{
    setcookie($name, $value, [
        'expires'  => time() + 60 * 60 * 24 * $days,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

function hopLeUrl(string $url): bool
{
    if ($url === '' || strlen($url) > FAV_MAX_URL) {
        return false;
    }
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }
    $scheme = strtolower((string)parse_url($url, PHP_URL_SCHEME));
    return in_array($scheme, ['http', 'https'], true);
}

// Cookie do client gửi lên nên có thể bị sửa: luôn kiểm tra lại từng phần tử khi đọc.
function layYeuThich(): array
{
    $raw = $_COOKIE[FAV_COOKIE] ?? '';
    if (!is_string($raw) || $raw === '') {
        return [];
    }
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        return [];
    }
    $ds = [];
    foreach ($data as $item) {
        if (!is_array($item) || !isset($item['t'], $item['u']) || !is_string($item['t']) || !is_string($item['u'])) {
            continue;
        }
        if (!hopLeUrl($item['u'])) {
            continue;
        }
        $ds[] = ['t' => catChuoi($item['t'], FAV_MAX_TITLE), 'u' => $item['u']];
        if (count($ds) >= FAV_MAX_LINKS) {
            break;
        }
    }
    return $ds;
}

function luuYeuThich(array $ds): void
{
    $json = json_encode(array_values($ds), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    datCookie(FAV_COOKIE, $json);
    $_COOKIE[FAV_COOKIE] = $json;
}
