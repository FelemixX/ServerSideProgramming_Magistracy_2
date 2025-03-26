<?php

require_once 'header.php';

$latex = new PhpLatex_PdfLatex();
?>


<form id="uploadForm" enctype="multipart/form-data">
    <div class="input-container">
        <input type="file" name="latex_file" accept=".tex" required value="">
        <button type="submit">Convert</button>
    </div>
    <div class="link-container">
        <a id="downloadLink" href="" class="hidden" target="_blank">Download PDF</a>
    </div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('uploadForm');
        const downloadLink = document.getElementById('downloadLink');

        form.addEventListener('submit', (event) => {
            downloadLink.classList.add('hidden');

            event.preventDefault();

            const formData = new FormData(form);

            fetch('convert.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    downloadLink.href = data.downloadLink;
                    downloadLink.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
</script>

<?php
require_once 'footer.php';
?>
