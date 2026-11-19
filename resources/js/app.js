// Tampilkan nama file yang dipilih pada input upload berkas.
document.querySelectorAll('[data-file-input]').forEach((input) => {
    input.addEventListener('change', () => {
        const target = document.querySelector(input.dataset.fileInput);
        if (target) {
            target.textContent = input.files.length ? input.files[0].name : 'Belum ada file dipilih';
        }
    });
});
