<?php

require_once 'vendor/autoload.php';

function rrmdir($src) {
    if (file_exists($src)) {
        $dir = opendir($src);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $full = $src . '/' . $file;
                if (is_dir($full)) {
                    rrmdir($full);
                } else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($src);
    }
}


$response = [
    'status' => 'error',
    'message' => 'No file uploaded.',
    'downloadLink' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['latex_file'])) {
    if ($_FILES['latex_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['latex_file']['tmp_name'];
        $fileName = $_FILES['latex_file']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        if ($fileExtension === 'tex') {
            try {
                $outputDirectory = 'converted/';
                rrmdir($outputDirectory);

                $uploadDirectory = 'uploaded_latex/';
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);
                }

                $uploadedTexFilePath = $uploadDirectory . $fileName;

                if (move_uploaded_file($fileTmpPath, $uploadedTexFilePath)) {
                    if (!is_dir($outputDirectory)) {
                        mkdir($outputDirectory, 0777, true);
                    }

                    $outputPdfPath = $outputDirectory . pathinfo($fileName, PATHINFO_FILENAME) . '-' . uniqid() . '.pdf';

                    $latex = new PhpLatex_PdfLatex();
                    $generatedPdfPath = $latex->compile("{$_SERVER['DOCUMENT_ROOT']}/$uploadedTexFilePath");
                    copy($generatedPdfPath, "{$_SERVER['DOCUMENT_ROOT']}/$outputPdfPath");
                    rrmdir($uploadDirectory);

                    $response['status'] = 'success';
                    $response['message'] = 'Conversion successful!';
                    $response['downloadLink'] = $outputPdfPath;
                } else {
                    $response['message'] = "Error saving the uploaded .tex file.";
                }
            } catch (Exception $e) {
                $response['message'] = 'Error during conversion: ' . $e->getMessage();
            } finally {
                @unlink($uploadedTexFilePath);
            }
        } else {
            $response['message'] = "Only .tex files are allowed.";
        }
    } else {
        $response['message'] = "Error uploading the file.";
    }
}

header('Content-Type: application/json');
echo json_encode($response);
