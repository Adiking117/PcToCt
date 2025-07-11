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

$returnurl = 'encounter_top.php';

?>
<html>
<head>
    <title><?php echo xlt("SOAP Notes"); ?></title>
    <?php Header::setupHeader(); ?>
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