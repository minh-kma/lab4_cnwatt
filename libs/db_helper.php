<?php
/**
 * Nhiệm vụ 11 - Kết nối CSDL + CRUD bảng LOP, HOSO
 * Dùng PDO, prepared statement, không nối chuỗi vào SQL.
 */

function dbConnect() {
    static $pdo = null;
    if ($pdo !== null) return $pdo;

    $host   = 'localhost';
    $dbname = 'quanlyhocsinh';
    $user   = 'root';
    $pass   = '';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $e) {
        die('Kết nối CSDL thất bại. Kiểm tra XAMPP/MySQL và database quanlyhocsinh.');
    }
    return $pdo;
}

/* ---------- Redirect an toàn (dùng chung output buffer của router) ---------- */
function redirect($url) {
    while (ob_get_level() > 0) ob_end_clean();
    header('Location: ' . $url);
    exit;
}

/* ---------- CSRF cho nhiệm vụ 11 ---------- */
function csrfDbToken() {
    if (empty($_SESSION['csrf_db'])) {
        $_SESSION['csrf_db'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_db'];
}

function csrfDbCheck($t) {
    return !empty($_SESSION['csrf_db'])
        && hash_equals($_SESSION['csrf_db'], (string)$t);
}

/* ==================== LOP ==================== */

function lopAll() {
    $stmt = dbConnect()->query("SELECT * FROM LOP ORDER BY MALOP");
    return $stmt->fetchAll();
}

function lopFind($malop) {
    $stmt = dbConnect()->prepare("SELECT * FROM LOP WHERE MALOP = :m");
    $stmt->execute([':m' => $malop]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function lopInsert($data) {
    $sql = "INSERT INTO LOP (MALOP, TENLOP, KHOAHOC, GVCN)
            VALUES (:malop, :tenlop, :khoahoc, :gvcn)";
    $stmt = dbConnect()->prepare($sql);
    return $stmt->execute([
        ':malop'   => $data['MALOP'],
        ':tenlop'  => $data['TENLOP'],
        ':khoahoc' => $data['KHOAHOC'],
        ':gvcn'    => $data['GVCN'],
    ]);
}

function lopUpdate($malop, $data) {
    $sql = "UPDATE LOP SET TENLOP = :tenlop, KHOAHOC = :khoahoc, GVCN = :gvcn
            WHERE MALOP = :malop";
    $stmt = dbConnect()->prepare($sql);
    return $stmt->execute([
        ':tenlop'  => $data['TENLOP'],
        ':khoahoc' => $data['KHOAHOC'],
        ':gvcn'    => $data['GVCN'],
        ':malop'   => $malop,
    ]);
}

function lopDelete($malop) {
    $stmt = dbConnect()->prepare("DELETE FROM LOP WHERE MALOP = :m");
    return $stmt->execute([':m' => $malop]);
}

function lopOptions() {
    $stmt = dbConnect()->query("SELECT MALOP, TENLOP FROM LOP ORDER BY MALOP");
    $kq = [];
    foreach ($stmt->fetchAll() as $r) {
        $kq[$r['MALOP']] = $r['TENLOP'];
    }
    return $kq;
}

/* ==================== HOSO ==================== */

function hosoCount() {
    $stmt = dbConnect()->query("SELECT COUNT(*) AS c FROM HOSO");
    return (int)$stmt->fetch()['c'];
}

function hosoPaged($offset, $limit) {
    $sql  = "SELECT * FROM HOSO ORDER BY MAHS LIMIT :lim OFFSET :off";
    $stmt = dbConnect()->prepare($sql);
    $stmt->bindValue(':lim', $limit,  PDO::PARAM_INT);
    $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function hosoFind($mahs) {
    $stmt = dbConnect()->prepare("SELECT * FROM HOSO WHERE MAHS = :m");
    $stmt->execute([':m' => $mahs]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function hosoInsert($data) {
    $sql = "INSERT INTO HOSO
              (MAHS, HOTEN, NGAYSINH, DIACHI, LOP, DIEMTOAN, DIEMLY, DIEMHOA)
            VALUES
              (:mahs, :hoten, :ngaysinh, :diachi, :lop, :dt, :dl, :dh)";
    $stmt = dbConnect()->prepare($sql);
    return $stmt->execute([
        ':mahs'     => $data['MAHS'],
        ':hoten'    => $data['HOTEN'],
        ':ngaysinh' => $data['NGAYSINH'],
        ':diachi'   => $data['DIACHI'],
        ':lop'      => $data['LOP'],
        ':dt'       => $data['DIEMTOAN'],
        ':dl'       => $data['DIEMLY'],
        ':dh'       => $data['DIEMHOA'],
    ]);
}

function hosoUpdate($mahs, $data) {
    $sql = "UPDATE HOSO SET
              HOTEN = :hoten, NGAYSINH = :ngaysinh, DIACHI = :diachi,
              LOP = :lop, DIEMTOAN = :dt, DIEMLY = :dl, DIEMHOA = :dh
            WHERE MAHS = :mahs";
    $stmt = dbConnect()->prepare($sql);
    return $stmt->execute([
        ':hoten'    => $data['HOTEN'],
        ':ngaysinh' => $data['NGAYSINH'],
        ':diachi'   => $data['DIACHI'],
        ':lop'      => $data['LOP'],
        ':dt'       => $data['DIEMTOAN'],
        ':dl'       => $data['DIEMLY'],
        ':dh'       => $data['DIEMHOA'],
        ':mahs'     => $mahs,
    ]);
}

function hosoDelete($mahs) {
    $stmt = dbConnect()->prepare("DELETE FROM HOSO WHERE MAHS = :m");
    return $stmt->execute([':m' => $mahs]);
}