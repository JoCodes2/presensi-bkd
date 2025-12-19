class authService {
    ajaxRequest(url, method, data = null) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url,
                method,
                data,
                processData: false,
                contentType: false,
                success: (response) => resolve(response),
                error: (error) => reject(error),
            });
        });
    }

    async register(e) {
        e.preventDefault();

        let submitButton = $(e.target).find(':submit');
        submitButton.prop('disabled', true);

        try {
            const formData = new FormData(e.target);

            const response = await this.ajaxRequest(
                `${appUrl}/presensi/pegawai/create`,
                'POST',
                formData
            );
            console.log(response);

        } catch (error) {
            submitButton.prop('disabled', false);

            if (error.status === 422) {
                let errors = error.responseJSON.data;
                let validator = $('#formRegister').validate();
                validator.resetForm();

                $.each(errors, (field, messages) => {
                    validator.showErrors({ [field]: messages[0] });
                });
                return;
            }

            errorAlert();
        }
    }

}
export default authService;
