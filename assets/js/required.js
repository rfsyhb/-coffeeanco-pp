document.addEventListener('DOMContentLoaded', function() {
    var requiredInputs = document.querySelectorAll('input[required], textarea[required], select[required]');

    requiredInputs.forEach(function(input) {
        var asterisk = input.parentElement.querySelector('.required-asterisk');

        // Tampilkan atau sembunyikan asterisk berdasarkan isi input saat halaman dimuat
        toggleAsterisk(input.value, asterisk);

        // Tambahkan event listener untuk setiap perubahan pada input
        input.addEventListener('input', function() {
            toggleAsterisk(this.value, asterisk);
        });
    });

    // Fungsi untuk menampilkan atau menyembunyikan asterisk
    function toggleAsterisk(value, asterisk) {
        if(value === '') {
            asterisk.style.display = 'inline';
        } else {
            asterisk.style.display = 'none';
        }
    }
});