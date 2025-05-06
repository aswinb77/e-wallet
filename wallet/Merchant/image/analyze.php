<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to perform OCR (Text Extraction) using Tesseract
function performOCR($imagePath)
{
    $outputText = '';
    
    // Replace '/full/path/to/tesseract' with the actual full path on your server
    $command = "$imagePath stdout 2>&1";

    exec($command, $output);

    // Combine the output lines into a single string
    $outputText = implode(" ", $output);

    return $outputText;
}

function analyzeImage($image)
{
    // Check if the file is an image
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($image['type'], $allowedTypes)) {
        return ['status' => 'error', 'message' => 'Invalid image format'];
    }

    // Store the image in the "uploads" directory
    $uploadPath = 'uploads/' . basename($image['name']);
    if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
        return ['status' => 'error', 'message' => 'Failed to move the uploaded file'];
    }

    // Perform OCR (Text Extraction) using Tesseract
    $outputText = performOCR($uploadPath);

    // Return the result
    return [
        'status' => 'success',
        'message' => 'Image analyzed successfully',
        'text' => $outputText,
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $result = analyzeImage($_FILES['image']);
    echo json_encode($result);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'No image provided']);
