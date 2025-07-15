<?php
/**
 * Save clipboard SOAP data to JSON
 *
 * @package   OpenEMR
 */

require_once(__DIR__ . "/../../globals.php");
require_once("$srcdir/api.inc.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clipboard_data'])) {

    $data = json_decode($_POST['clipboard_data'], true);

    if (!$data || !isset($data['subjective'], $data['objective'], $data['assessment'], $data['plan'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data"]);
        exit;
    }

    $formData = [
        "subjective" => $data['subjective'],
        "objective" => $data['objective'],
        "assessment" => $data['assessment'],
        "plan" => $data['plan']
    ];

    $newid = formSubmit("form_soap", $formData, ($_GET["id"] ?? null), $userauthorized);

    $jsonEntry = [
        "newid" => $newid,
        "formData" => $formData
    ];

    // Save in OpenEMR temporary directory
    $jsonFile = $GLOBALS['temp'] . "/soap_clipboard_data.json";

    // Read existing JSON if exists
    if (file_exists($jsonFile)) {
        $existing = json_decode(file_get_contents($jsonFile), true);
        if (!is_array($existing)) {
            $existing = [];
        }
    } else {
        $existing = [];
    }

    // Replace entry with same newid, or append
    $found = false;
    foreach ($existing as $index => $entry) {
        if (isset($entry['newid']) && $entry['newid'] == $newid) {
            $existing[$index] = $jsonEntry;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $existing[] = $jsonEntry;
    }

    // Save JSON file
    file_put_contents($jsonFile, json_encode($existing, JSON_PRETTY_PRINT));

    echo json_encode(["success" => true, "newid" => $newid]);
    exit;
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}
