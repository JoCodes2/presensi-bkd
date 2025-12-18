// absensiService.js

class absensiService {
    ajaxRequest(url, method, data = null) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url,
                method,
                data,
                success: (response) => resolve(response),
                error: (error) => reject(error),
            });
        });
    }

    updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        };

        // Menghasilkan format: Rabu, 17 Des 2025
        const formattedDate = new Intl.DateTimeFormat('id-ID', options).format(now);

        $('#current-date').text(formattedDate);
    }

    async loadJamKerja() {
        this.updateDateTime();

        try {
            const response = await this.ajaxRequest(`${appUrl}/presensi/jam/`, 'GET');
            const jamKerja = response.data && response.data.length > 0 ? response.data[0] : null;

            if (jamKerja) {
                $('#display-jadwal-masuk').text(jamKerja.jam_masuk.substring(0, 5));
                $('#display-jadwal-pulang').text(jamKerja.jam_keluar.substring(0, 5));
            }
        } catch (error) {
            console.error("Gagal memuat jam kerja", error);
        }
    }
}

export default absensiService;
