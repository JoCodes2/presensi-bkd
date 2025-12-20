// notifService.js

class notifService {

    // Metode AJAX Request (tidak berubah)
    ajaxRequest(url, method, data = null) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url,
                method,
                data,
                processData: method !== 'GET' ? false : undefined,
                contentType: method !== 'GET' ? false : undefined,
                success: (response) => resolve(response),
                error: (error) => reject(error),
            });
        });
    }

    /**
     * Fungsi helper untuk menentukan ikon, warna, dan JUDUL DETAIL. (Tidak Berubah)
     */
    getNotificationStyle(notif) {
        const jenis = notif.jenis;
        const metadata = notif.metadata || {};
        const status = metadata.status;
        const userName = notif.user ? notif.user.name : 'Sistem';

        let icon = 'fas fa-info-circle';
        let colorClass = 'timeline-info';
        let title = 'Pemberitahuan Sistem';

        if (jenis === 'verifikasi_akun') {
            if (status === 'active') {
                icon = 'fas fa-check-circle';
                colorClass = 'timeline-success';
                title = `Akun Pegawai ${userName} Diaktifkan`;
            } else if (status === 'rejected') {
                icon = 'fas fa-times-circle';
                colorClass = 'timeline-danger';
                title = `Verifikasi Akun ${userName} Ditolak`;
            } else if (status === 'pending') {
                icon = 'fas fa-user-clock';
                colorClass = 'timeline-warning';
                title = `Akun Baru Menunggu Persetujuan: ${userName}`;
            }
        } else if (jenis === 'pengajuan_cuti') {
            if (status === 'approved') {
                icon = 'fas fa-calendar-check';
                colorClass = 'timeline-success';
                title = `Cuti ${userName} Disetujui`;
            } else if (status === 'rejected') {
                icon = 'fas fa-calendar-times';
                colorClass = 'timeline-danger';
                title = `Cuti ${userName} Ditolak`;
            } else {
                icon = 'fas fa-calendar-plus';
                colorClass = 'timeline-primary';
                title = `Pengajuan Cuti Baru: ${userName}`;
            }
        } else if (jenis === 'terlambat') {
            icon = 'fas fa-clock';
            colorClass = 'timeline-warning';
            title = `${userName} Terlambat Absen`;
        } else if (jenis === 'alpha') {
            icon = 'fas fa-user-slash';
            colorClass = 'timeline-danger';
            title = `${userName} Terdeteksi Alpha`;
        } else if (jenis === 'sistem') {
            icon = 'fas fa-server';
            colorClass = 'timeline-secondary';
            title = 'Pesan Sistem/Maintenance';
        }

        return { icon, colorClass, title };
    }

    // ===============================================================
    // FUNGSI UTAMA UNTUK BADGE COUNT & MARK AS READ
    // ===============================================================

    /**
     * Memperbarui badge notifikasi.
     * @param {number} count
     */
    updateNotifBadge(count) {
        const $badge = $('#notifCountBadge');
        $badge.text(count);

        if (count > 0) {
            $badge.addClass('visible').removeClass('d-none');
        } else {
            $badge.removeClass('visible').addClass('d-none');
        }
    }

    /**
     * Menandai semua notifikasi sebagai sudah dibaca (melalui API yang berbeda).
     * Ini dipanggil saat dropdown dibuka.
     */
    async markAllAsRead() {
        try {
            // Asumsi: Kita tetap perlu API terpisah untuk POST/PUT mark-all-read
            // Karena tidak mungkin API GET /presensi/notifikasi/ memiliki efek samping mengubah data.
            await this.ajaxRequest(`${appUrl}/presensi/notifikasi/mark-all-read`, 'POST');

            // Langsung update badge ke 0 setelah sukses
            this.updateNotifBadge(0);
        } catch (error) {
            console.error('Gagal menandai semua sudah dibaca:', error);
        }
    }


    // ===============================================================
    // FUNGSI KHUSUS DROPDOWN (Filter Frontend untuk Hari Ini)
    // ===============================================================

    /**
     * Merender notifikasi ke dalam elemen #notifDropdownContent.
     */
    renderDropdownNotifications(notifications) {
        const $content = $('#notifDropdownContent');
        let html = '';

        // --- FILTER FRONTEND: HANYA HARI INI ---
        const today = moment().startOf('day');
        const todayNotifications = notifications.filter(notif => {
            return moment(notif.created_at).isSameOrAfter(today);
        });
        // --- END FILTER ---

        const notificationsToDisplay = todayNotifications.slice(0, 7);

        if (notificationsToDisplay.length === 0) {
            $content.html('<div class="text-center p-3 text-muted small">Tidak ada notifikasi baru hari ini.</div>');
            return;
        }

        notificationsToDisplay.forEach(notif => {
            const style = this.getNotificationStyle(notif);
            const time = moment(notif.created_at).fromNow();
            const dibacaClass = notif.is_dibaca ? '' : 'unread-item';

            html += `
                <a href="{{ route('notifikasi.index') }}?id=${notif.id}"
                   data-id="${notif.id}"
                   class="dropdown-item d-flex align-items-start ${dibacaClass} border-bottom px-3 py-2">

                    <div class="notif-icon mr-3 mt-1">
                        <i class="${style.icon} ${style.colorClass.replace('timeline-', 'text-')} fa-lg"></i>
                    </div>

                    <div class="notif-content flex-grow-1">

                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <span class="subject text-dark font-weight-bold small">${style.title}</span>
                            <span class="time text-muted small">${time}</span>
                        </div>

                        <p class="text-muted mb-0 text-xs text-wrap" style="line-height: 1.3;">
                            ${notif.pesan.substring(0, 55)}...
                        </p>
                    </div>
                </a>
            `;
        });

        $content.html(html);
    }

    /**
     * Mengambil data notifikasi menggunakan API tunggal, filter di frontend,
     * dan merender ke dropdown.
     */
    async getLatestDropdownData() {
        const $content = $('#notifDropdownContent');

        $content.html(`
            <div class="text-center p-3 text-muted small">
                <i class="fas fa-sync-alt fa-spin mr-1"></i> Memuat...
            </div>
        `);

        try {
            const responseData = await this.ajaxRequest(`${appUrl}/presensi/notifikasi/`, 'GET');
            const notifications = responseData.data;

            if (notifications && Array.isArray(notifications)) {

                // 1. FILTER HANYA HARI INI
                const today = moment().startOf('day');
                const todayNotifications = notifications.filter(notif => {
                    return moment(notif.created_at).isSameOrAfter(today);
                });

                // 2. UPDATE BADGE (Hanya berdasarkan jumlah notifikasi hari ini)
                // Jika hari berganti dan belum ada notif baru, angka otomatis jadi 0
                this.updateNotifBadge(todayNotifications.length);

                // 3. RENDER DROPDOWN
                this.renderDropdownNotifications(todayNotifications);

            } else {
                $content.html('<div class="text-center p-3 text-muted small">Tidak ada data notifikasi.</div>');
                this.updateNotifBadge(0);
            }
        } catch (error) {
            console.error('Error saat mengambil data notifikasi:', error);
            $content.html('<div class="text-center p-3 text-danger small">Gagal memuat data.</div>');
            this.updateNotifBadge(0);
        }
    }
}

export default notifService;
