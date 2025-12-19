class notifService {
    ajaxRequest(url, method, data = null) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url,
                method,
                data,
                success: (res) => resolve(res),
                error: (err) => reject(err),
            });
        });
    }

    async loadNotifPage() {
        const $container = $('#notif-page-container');
        try {
            const response = await this.ajaxRequest(`${appUrl}/presensi/notifikasi/`, 'GET');
            const notifications = response.data || [];

            // Filter: Hanya 1 Minggu Terakhir
            const oneWeekAgo = moment().subtract(7, 'days').startOf('day');
            const filteredNotif = notifications.filter(n => moment(n.created_at).isAfter(oneWeekAgo));

            if (filteredNotif.length === 0) {
                $container.html(`
                <div class="text-center py-20">
                    <i class="fas fa-bell-slash text-gray-200 text-5xl"></i>
                    <p class="text-gray-400 text-sm mt-3">Tidak ada notifikasi baru.</p>
                </div>
            `);
                return;
            }

            let html = '';
            filteredNotif.forEach(notif => {
                const style = this.getNotifStyle(notif.jenis);
                const timeAgo = moment(notif.created_at).fromNow();

                // Mengambil nama dari object user di dalam notifikasi
                const userName = notif.user ? notif.user.name : 'Sistem';

                html += `
                <div class="flex items-start gap-4 p-4 ${style.bgColor} border ${style.borderColor} rounded-xl shadow-sm relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 ${style.barColor}"></div>

                    <div class="${style.iconColor} text-xl mt-1">
                        <i class="${style.icon}"></i>
                    </div>

                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <div>
                                <p class="text-[11px] font-extrabold text-gray-800 uppercase tracking-tight">
                                    ${userName}
                                </p>
                                <span class="text-[9px] font-bold uppercase tracking-wider ${style.iconColor}">
                                    ${notif.jenis.replace('_', ' ')}
                                </span>
                            </div>
                            <span class="text-[9px] text-gray-400 font-medium bg-white px-2 py-0.5 rounded-full border border-gray-100">
                                ${timeAgo}
                            </span>
                        </div>

                        <p class="text-xs font-medium text-gray-700 leading-relaxed mt-1">
                            ${notif.pesan}
                        </p>

                        <div class="flex justify-between items-center mt-3 pt-2 border-t border-black/5">
                             <p class="text-[9px] text-gray-400">
                                <i class="far fa-calendar-alt mr-1"></i> ${moment(notif.created_at).format('DD MMM YYYY, HH:mm')}
                            </p>
                        </div>
                    </div>
                </div>
            `;
            });

            $container.html(html);

        } catch (error) {
            $container.html('<p class="text-center text-red-500 text-xs py-10">Gagal memuat notifikasi.</p>');
        }
    }

    getNotifStyle(jenis) {
        const base = {
            'terlambat': { icon: 'fas fa-clock', iconColor: 'text-orange-600', bgColor: 'bg-orange-50', borderColor: 'border-orange-100', barColor: 'bg-orange-500' },
            'alpha': { icon: 'fas fa-user-times', iconColor: 'text-red-600', bgColor: 'bg-red-50', borderColor: 'border-red-100', barColor: 'bg-red-500' },
            'face_recognition': { icon: 'fas fa-id-badge', iconColor: 'text-teal-600', bgColor: 'bg-teal-50', borderColor: 'border-teal-100', barColor: 'bg-teal-500' },
            'pengajuan_cuti': { icon: 'fas fa-calendar-plus', iconColor: 'text-blue-600', bgColor: 'bg-blue-50', borderColor: 'border-blue-100', barColor: 'bg-blue-500' },
            'sistem': { icon: 'fas fa-info-circle', iconColor: 'text-gray-600', bgColor: 'bg-gray-50', borderColor: 'border-gray-200', barColor: 'bg-gray-400' }
        };

        // Fallback jika jenis tidak terdaftar
        return base[jenis] || { icon: 'fas fa-bell', iconColor: 'text-blue-600', bgColor: 'bg-blue-50', borderColor: 'border-blue-100', barColor: 'bg-blue-500' };
    }
}

export default notifService;
