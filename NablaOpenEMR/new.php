<?php

/**
 * Dictation form
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    cfapress <cfapress>
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @author    Robert Down <robertdown@live.com>
 * @copyright Copyright (c) 2008 cfapress <cfapress>
 * @copyright Copyright (c) 2013-2017 bradymiller <bradymiller@users.sourceforge.net>
 * @copyright Copyright (c) 2017-2023 Robert Down <robertdown@live.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 **/

require_once(__DIR__ . "/../../globals.php");
require_once("$srcdir/api.inc.php");

use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Core\Header;

if (!CsrfUtils::verifyCsrfToken($_POST["csrf_token_form"])) {
    CsrfUtils::csrfNotVerified();
}
$returnurl = 'encounter_top.php';

?>
<html>
<head>
    <title><?php echo xlt("SOAP Notes"); ?></title>
    <?php Header::setupHeader(); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let populated = false;

            const subjectiveField = document.querySelector('textarea[name="soap_notes"]'); 
            const intervalId = setInterval(async () => {
                if (populated) return;

                try {
                    const text = await navigator.clipboard.readText();
                    if (text && text.trim().startsWith("Subjective")) {
                        console.log("Clipboard SOAP detected:", text);

                        const soap = parseSOAPNotes(text);
                        if (soap) {
                            
                            clearInterval(intervalId);

                            // Send SOAP data to saveinjson.php
                            let formData = new FormData();
                            formData.append('clipboard_data', JSON.stringify(soap));

                            fetch('<?php echo $rootdir;?>/forms/nabla/saveinjson.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log("Saved to JSON. newid:", data.newid);
                                } else {
                                    console.error("Error saving JSON:", data);
                                }
                            })
                            .catch(err => console.error("AJAX error:", err));

                            // Clear clipboard
                            try {
                                await navigator.clipboard.writeText("");
                                console.log("Clipboard cleared.");
                            } catch (err) {
                                console.warn("Clipboard not cleared:", err);
                            }
                        }
                    }
                } catch (err) {
                    console.error("Clipboard read error:", err);
                }
            }, 2000);

            function parseSOAPNotes(text) {
                const regex = /Subjective[:\s]*([\s\S]*?)Objective[:\s]*([\s\S]*?)Assessment[:\s]*([\s\S]*?)Plan[:\s]*([\s\S]*)$/i;

                const match = text.match(regex);
                if (match) {
                    return {
                        subjective: match[1].trim(),
                        objective: match[2].trim(),
                        assessment: match[3].trim(),
                        plan: match[4].trim()
                    };
                } else {
                    console.warn("Could not parse SOAP sections from clipboard.");
                    return null;
                }
            }
        });
</script>

</head>
<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <h2><?php echo xlt("SOAP Notes"); ?></h2>
                <p class="text-muted">
                    Please write each section starting with its label — <strong>Subjective</strong>, <strong>Objective</strong>, <strong>Assessment</strong>, <strong>Plan</strong> — for proper storage.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form name="my_form" method="post" action="<?php echo $rootdir;?>/forms/nabla/save.php?mode=new" onsubmit="return top.restoreSession()">
                    <input type="hidden" name="csrf_token_form" value="<?php echo attr(CsrfUtils::collectCsrfToken()); ?>" />
                    <fieldset>
                        <legend><?php echo xlt('SOAP Notes'); ?></legend>
                        <div class="container">
                            <div class="form-group">
                                <textarea name="soap_notes" class="form-control" cols="80" rows="12" placeholder="Subjective&#10;...&#10;&#10;Objective&#10;...&#10;&#10;Assessment&#10;...&#10;&#10;Plan&#10;..."></textarea>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group mt-3">
                        <div class="btn-group" role="group">
                            <button type="submit" onclick="top.restoreSession()" class="btn btn-primary btn-save"><?php echo xlt('Save'); ?></button>
                            <button type="button" class="btn btn-secondary btn-cancel" onclick="top.restoreSession(); parent.closeTab(window.name, false);"><?php echo xlt('Cancel');?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
