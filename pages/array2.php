<h2>Upload nhiều file sử dụng mảng kết hợp</h2>
<p>Upload tối đa 10 file (jpg, jpeg, png, gif, pdf, txt, doc, docx; mỗi file tối đa 2 MB).</p>
<form method="post" action="index.php?page=uploadprocess" enctype="multipart/form-data">
    <?php for ($i = 1; $i <= 10; $i++): ?>
        File <?= $i ?>: <input type="file" name="files[]"><br>
    <?php endfor; ?>
    <br>
    <input type="submit" name="submit" value="Upload">
</form>
