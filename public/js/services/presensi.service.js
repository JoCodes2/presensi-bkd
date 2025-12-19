// presensi.service.js

class PresensiService {
    constructor() {
        this.calendar = null;
        this.jamKerja = null;
        this.hariLiburNasional = [];
    }

    /**
     * MENGAMBIL DAFTAR PEGAWAI UNTUK DROPDOWN
     */
    async loadUsers() {
        try {
            const response = await $.ajax({
                url: `${appUrl}/presensi/bkd/`,
                type: 'GET'
            });

            const allData = response.data || [];
            const userSelect = $('#filterUser');
            const uniqueUsers = [];
            const map = new Map();

            for (const item of allData) {
                // Pastikan hanya role pegawai
                if (item.user?.role !== 'pegawai') continue;

                if (!map.has(item.id_user)) {
                    map.set(item.id_user, true);
                    uniqueUsers.push({
                        id: item.id_user,
                        name: item.user?.name || 'Unknown'
                    });
                }
            }

            userSelect.empty().append('<option value="">-- Pilih Pegawai --</option>');
            uniqueUsers.forEach(user => {
                userSelect.append(`<option value="${user.id}">${user.name}</option>`);
            });
        } catch (error) {
            console.error("Gagal load daftar pegawai:", error);
        }
    }

    /**
     * AMBIL DATA JAM KERJA (DARI DB)
     */
    async fetchJamKerja() {
        try {
            const response = await $.ajax({ url: `${appUrl}/presensi/jam/`, type: 'GET' });
            this.jamKerja = response.data && response.data.length > 0 ? response.data[0] : null;
        } catch (error) { console.error("Gagal load jam kerja:", error); }
    }

    /**
     * AMBIL DATA LIBUR NASIONAL (DARI API LUAR)
     */
    async fetchLiburNasional() {
        try {
            const response = await fetch('https://api-harilibur.vercel.app/api');
            this.hariLiburNasional = await response.json();
        } catch (error) { console.error("Gagal load API libur:", error); }
    }

    /**
     * KONFIGURASI WARNA & ICON STATUS
     */
    getStatusConfig(type, status) {
        const isM = type === 'masuk';
        let conf = {
            icon: isM ? 'fas fa-sign-in-alt' : 'fas fa-sign-out-alt',
            color: '#e11d48', bg: '#fff1f2', border: '#fb7185', label: isM ? 'Masuk: Alpha' : 'Pulang: Alpha'
        };

        if (['tepat_waktu', 'hadir', 'pulang_tepat_waktu'].includes(status)) {
            conf = { ...conf, color: isM ? '#059669' : '#2563eb', bg: isM ? '#ecfdf5' : '#eff6ff', border: isM ? '#34d399' : '#60a5fa', label: isM ? 'Masuk: Tepat Waktu' : 'Pulang: Tepat Waktu' };
        } else if (['terlambat', 'pulang_cepat'].includes(status)) {
            conf = { ...conf, color: '#d97706', bg: '#fffbeb', border: '#fbbf24', label: status === 'terlambat' ? 'Masuk: Terlambat' : 'Pulang: Cepat' };
        } else if (!status && !isM) {
            conf = { ...conf, color: '#4b5563', bg: '#f9fafb', border: '#d1d5db', label: 'Pulang: Belum Absen' };
        }
        return conf;
    }

    /**
     * INITIALIZE FULLCALENDAR
     */
    async initCalendar() {
        const self = this;
        const calendarEl = document.getElementById('presensiCalendar');
        if (!calendarEl) return;

        // Ambil semua data pendukung
        await Promise.all([this.fetchJamKerja(), this.fetchLiburNasional()]);

        this.calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            height: 'auto',
            fixedWeekCount: false,
            headerToolbar: { left: 'prev,next today', center: 'title', right: '' },

            // Menandai Hari Libur
            // Menandai Hari Libur
            dayCellDidMount: function (info) {
                const dateStr = info.date.toLocaleDateString('en-CA');
                const libur = self.hariLiburNasional.find(h => h.holiday_date === dateStr);

                // Hapus label holiday lama jika ada (mencegah double)
                const oldLabel = info.el.querySelector('.holiday-label');
                if (oldLabel) oldLabel.remove();

                if (libur) {
                    info.el.classList.add('bg-libur-nasional');

                    // Buat elemen label baru
                    let label = document.createElement('div');
                    label.className = 'holiday-label';
                    label.innerText = libur.holiday_name;

                    // Masukkan ke dalam cell
                    info.el.appendChild(label);
                } else if (self.jamKerja) {
                    const days = ['minggu_kerja', 'senin_kerja', 'selasa_kerja', 'rabu_kerja', 'kamis_kerja', 'jumat_kerja', 'sabtu_kerja'];
                    if (!self.jamKerja[days[info.date.getDay()]]) {
                        info.el.classList.add('bg-libur-weekend');
                    }
                }
            },

            // Tampilan Event Modern
            eventContent: function (arg) {
                let card = document.createElement('div');
                card.className = 'modern-event-card';
                card.style.backgroundColor = arg.event.backgroundColor;
                card.style.color = arg.event.textColor;
                card.style.borderLeft = `3px solid ${arg.event.borderColor}`;
                card.innerHTML = `
                    <i class="${arg.event.extendedProps.icon}"></i>
                    <div class="event-text">
                        <span class="type">${arg.event.extendedProps.tipe}</span>
                        <span class="time">${arg.event.extendedProps.jam}</span>
                    </div>
                `;
                return { domNodes: [card] };
            },

            // Fetch Events (Presensi)
            events: async function (info, successCallback) {
                const userId = $('#filterUser').val();
                if (!userId) return successCallback([]);

                const res = await $.ajax({ url: `${appUrl}/presensi/bkd/`, type: 'GET' });
                const filtered = (res.data || []).filter(item => String(item.id_user) === String(userId));
                const events = [];

                filtered.forEach(item => {
                    ['masuk', 'keluar'].forEach(type => {
                        const status = type === 'masuk' ? item.status_masuk : item.status_keluar;
                        const conf = self.getStatusConfig(type, status);
                        events.push({
                            start: item.tanggal,
                            backgroundColor: conf.bg,
                            borderColor: conf.border,
                            textColor: conf.color,
                            extendedProps: {
                                tipe: type.toUpperCase(),
                                icon: conf.icon,
                                jam: (type === 'masuk' ? item.jam_masuk : item.jam_keluar)?.substring(0, 5) || '--:--',
                                statusText: conf.label,
                                nama: item.user?.name
                            }
                        });
                    });
                });
                successCallback(events);
            },

            eventDidMount: function (info) {
                tippy(info.el, {
                    content: `<strong>${info.event.extendedProps.statusText}</strong><br>Jam: ${info.event.extendedProps.jam}`,
                    allowHTML: true,
                    theme: 'light-border'
                });
            }
        });
        this.calendar.render();
    }

    reloadCalendar() { if (this.calendar) this.calendar.refetchEvents(); }
}

export default PresensiService;
