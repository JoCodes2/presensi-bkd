class authService {
    // Helper untuk request AJAX (POST/FILE)
    ajaxRequest(url, method, data = null) {
        return $.ajax({
            url: url,
            method: method,
            data: data,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    // Helper khusus GET data
    ajaxGet(url) {
        return $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json'
        });
    }

    async getJabatan() {
        return await this.ajaxGet(`${appUrl}/presensi/jabatan/`);
    }

    async getKantor() {
        return await this.ajaxGet(`${appUrl}/presensi/kantor/`);
    }

    async register(formElement) {
        // ... kode register Anda tetap sama ...
        const $form = $(formElement);
        let submitButton = $form.find(':submit');
        submitButton.prop('disabled', true);

        try {
            const formData = new FormData(formElement);
            const response = await this.ajaxRequest(
                `${appUrl}/presensi/pegawai/create`,
                'POST',
                formData
            );

            if (response.code === 200 || response.status === 'success') {
                await successAlert("Pendaftaran berhasil! Silakan login.");
                window.location.href = `${appUrl}/login`;
            } else {
                warningAlert(response.message || "Pendaftaran gagal.");
                submitButton.prop('disabled', false);
            }
        } catch (error) {
            submitButton.prop('disabled', false);
            Swal.close();
            if (error.status === 422) {
                let errors = error.responseJSON.data || error.responseJSON.errors;
                let validator = $form.validate();
                let errorMessages = {};
                $.each(errors, (field, messages) => { errorMessages[field] = messages[0]; });
                validator.showErrors(errorMessages);
                warningAlert("Data yang Anda masukkan tidak valid.");
                return;
            }
            errorAlert();
        }
    }
}
export default authService;
