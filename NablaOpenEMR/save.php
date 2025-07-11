<?php

/**
 * dictation save.php
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2019 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

require_once(__DIR__ . "/../../globals.php");
require_once("$srcdir/api.inc.php");
require_once("$srcdir/forms.inc.php");

use OpenEMR\Common\Csrf\CsrfUtils;

if (!CsrfUtils::verifyCsrfToken($_POST["csrf_token_form"])) {
    CsrfUtils::csrfNotVerified();
}

if ($encounter == "") {
    $encounter = date("Ymd");
}

$soap_text = $_POST["soap_notes"] ?? '';

preg_match('/Subjective\s*(.*?)\s*Objective\s*/s', $soap_text, $match_subjective);
preg_match('/Objective\s*(.*?)\s*Assessment\s*/s', $soap_text, $match_objective);
preg_match('/Assessment\s*(.*?)\s*Plan\s*/s', $soap_text, $match_assessment);
preg_match('/Plan\s*(.*)/s', $soap_text, $match_plan);

$subjective = trim($match_subjective[1] ?? '');
$objective  = trim($match_objective[1] ?? '');
$assessment = trim($match_assessment[1] ?? '');
$plan       = trim($match_plan[1] ?? '');

if ($_GET["mode"] == "new") {
    $formData = [
        // "date" => date("Y-m-d H:i:s"),
        // "pid" => $_SESSION["pid"],
        // "user" => $_SESSION["authUser"],
        // "groupname" => $_SESSION["authProvider"],
        // "authorized" => $userauthorized,
        // "activity" => 1,
        "subjective" => $subjective,
        "objective" => $objective,
        "assessment" => $assessment,
        "plan" => $plan
    ];
    $newid = formSubmit("form_soap", $formData, ($_GET["id"] ?? null), $userauthorized);
    addForm($encounter, "SOAP Notes", $newid, "soap", $_SESSION["pid"], $userauthorized);
} elseif ($_GET["mode"] == "update") {
    sqlStatement(
        "UPDATE form_soap SET pid = ?, groupname = ?, user = ?, authorized = ?, activity = 1, date = NOW(), subjective = ?, objective = ?, assessment = ?, plan = ? WHERE id = ?",
        [
            $_SESSION["pid"],
            $_SESSION["authProvider"],
            $_SESSION["authUser"],
            $userauthorized,
            $subjective,
            $objective,
            $assessment,
            $plan,
            $_GET["id"]
        ]
    );
}

formHeader("Redirecting...");
formJump();
formFooter();
