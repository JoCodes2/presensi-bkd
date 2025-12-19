class ProfileService {
    // Gunakan appUrl dari global jika tersedia, atau lewat parameter
    getProfile(userId) {
        return $.ajax({
            url: `${appUrl}/presensi/pegawai/get/${userId}`,
            method: 'GET'
        });
    }

    updateProfile(userId, formData) {
        return $.ajax({
            url: `${appUrl}/presensi/pegawai/update/${userId}`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
}
export default ProfileService;
