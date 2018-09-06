function gen_qrcode(url) {
    $('#qrcode').html('');
    $('#qrcode').qrcode(url);
}