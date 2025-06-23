function ambilNotifikasi() {
    $.ajax({
        url: "/notifikasi",
        type: "GET",
        success: function (res) {
            console.log("Respon:", res);

            // Update jumlah notifikasi
            $(".allnotitifkasi").text(res.jumlah);

            // Update konten notifikasi
            $(".notifkasi-list").html(res.html);
        },
        error: function (err) {
            console.error("Gagal ambil notifikasi", err);
        }
    });
}

// Panggil saat halaman load pertama kali
$(document).ready(function () {
    ambilNotifikasi();

    // Set interval untuk refresh otomatis setiap 30 detik (opsional)
    setInterval(ambilNotifikasi, 30000);
});

// Saat ikon lonceng diklik - JANGAN langsung mark as read
$("#alertsDropdown").on("click", function (e) {
    // Hanya refresh data notifikasi saat dropdown dibuka
    ambilNotifikasi();
});

// Tambahkan fungsi untuk mark all as read (bisa dipanggil dari button terpisah)
function markAllAsRead() {
    $.ajax({
        url: "/notifikasi/read-all",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            console.log("Semua notifikasi ditandai sudah dibaca", res);

            // Refresh notifikasi setelah mark as read
            ambilNotifikasi();
        },
        error: function (err) {
            console.error("Gagal mark as read", err);
        }
    });
}
