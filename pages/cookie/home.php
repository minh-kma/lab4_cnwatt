<h3>Cookies</h3>
<ul>
    <li>Cookie là đoạn dữ liệu được ghi trong máy client do trình duyệt quản lý. Trình duyệt gửi ngược lại cookie lên server mỗi khi tải một trang web từ server đó.</li>
    <li>Không dùng cookie để lưu thông tin quan trọng vì không đảm bảo an toàn.</li>
    <li>Thường dùng để ghi nhớ: username, thời điểm login cuối, danh sách link ưa thích.</li>
</ul>
<h4>Tạo cookie</h4>
<pre>setcookie("TenCookie", giá_trị, [thời điểm quá hạn tính theo s]);
setcookie("TenUser", "Pham Minh", time() + 60*60*24*30);
setcookie("lasttime", time(), time() + 60*60*24*30);</pre>
<ul>
    <li>Không chỉ định thời gian thì cookie lưu trong bộ nhớ và mất khi đóng trình duyệt.</li>
    <li>Nếu thời điểm quá hạn là một thời điểm trong quá khứ thì trình duyệt sẽ xóa cookie.</li>
</ul>
<h4>Sử dụng cookie</h4>
<pre>$_COOKIE["Ten"];</pre>
