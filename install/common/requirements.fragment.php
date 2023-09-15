<?php 
$installable = true;
$pdo    = defined('PDO::ATTR_DRIVER_NAME');
$zip    = extension_loaded('zip');
$curl   = function_exists("curl_version") ? curl_version() : false;
$exif = function_exists('exif_read_data');
?>
<div class="container">
    <div class="px-4">
        <table class="table table-theme-border">
            <thead>
                <tr>
                    <th width="30%" class="fs-sm text-muted">PHP Settings</th>
                    <th width="30%" class="fs-sm text-muted">Required</th>
                    <th width="30%" class="fs-sm text-muted">Current</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="font-weight-bold">PHP Version</span></td>
                    <td class="fs-xs">7.4.+</td>
                    <td class="fs-xs">
                        <?php if (version_compare(PHP_VERSION, '5.6.0') >= 0) { ?>
                        <div class="text-success fw-bold">
                            <?php } else { ?>
                            <div class="text-danger fw-bold">
                                <?php $installable = false; ?>
                                <?php } ?>
                                <?php echo PHP_VERSION ?>
                            </div>
                    </td>
                </tr>
                <tr>
                    <td><span class="font-weight-bold">allow_url_fopen</span></td>
                    <td class="fs-xs">On</td>
                    <td class="fs-xs">
                        <?php if (ini_get("allow_url_fopen")) { ?>
                        <div class="text-success fw-bold">
                            <?php } else { ?>
                            <?php $installable = false; ?>
                            <div class="text-danger fw-bold">
                                <?php } ?>
                                <?php echo ini_get("allow_url_fopen") ? "On" : "Off" ?>
                            </div>
                    </td>
                </tr>
                <tr>
                    <td><span class="font-weight-bold">php_intl</span></td>
                    <td class="fs-xs">On</td>
                    <td class="fs-xs">
                        <?php if (extension_loaded("intl")) { ?>
                        <div class="text-success fw-bold">
                            <?php } else { ?>
                            <?php $installable = false; ?>
                            <div class="text-danger fw-bold">
                                <?php } ?>
                                <?php echo extension_loaded("intl") ? "On" : "Off" ?>
                            </div>
                    </td>
                </tr>
                <tr>
                    <td><span class="font-weight-bold">IonCube Loader</span></td>
                    <td class="fs-xs">On</td>
                    <td class="fs-xs">
                        <?php if (extension_loaded("IonCube Loader")) { ?>
                        <div class="text-success fw-bold">
                            <?php } else { ?>
                            <?php $installable = false; ?>
                            <div class="text-danger fw-bold">
                                <?php } ?>
                                <?php echo extension_loaded("IonCube Loader") ? "On" : "Off" ?>
                            </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-theme-border">
            <thead>
                <tr>
                    <th width="30%" class="fs-sm text-muted">Name</th>
                    <th width="30%" class="fs-sm text-muted">Required</th>
                    <th width="30%" class="fs-sm text-muted">Current</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php $curl = function_exists("curl_version") ? curl_version() : false; ?>
                    <td><span class="font-weight-bold">cURL</span></td>
                    <td class="fs-xs">7.19.4+</td>
                    <td class="fs-xs">
                        <?php if (!empty($curl["version"]) && version_compare($curl["version"], '7.19.4') >= 0) { ?>
                        <div class="text-success fw-bold">
                            <?php } else { ?>
                            <?php $installable = false; ?>
                            <div class="text-danger fw-bold">
                                <?php } ?>
                                <?php echo !empty($curl["version"]) ? $curl["version"] : "Not installed"; ?>
                            </div>
                    </td>
                </tr>
                <tr>
                    <?php $pdo = defined('PDO::ATTR_DRIVER_NAME'); ?>
                    <td>PDO</td>
                    <td class="fs-xs">On</td>
                    <td class="fs-xs">
                        <?php if (isset($pdo)) { ?>
                        <div class="text-success fw-bold">
                            <?php } else { ?>
                            <?php $installable = false; ?>
                            <div class="text-danger fw-bold">
                                <?php } ?>
                                <?php echo $pdo ? "On" : "Off"; ?>
                            </div>
                    </td>
                </tr>
                <tr>
                    <?php $mbstring = extension_loaded('mbstring') && function_exists('mb_get_info') ?>
                    <td>mbstring</td>
                    <td class="fs-xs">On</td>
                    <td class="fs-xs">
                        <?php if (isset($mbstring)) { ?>
                        <div class="text-success fw-bold">
                            <?php } else { ?>
                            <?php $installable = false; ?>
                            <div class="text-danger fw-bold">
                                <?php } ?>
                                <?php echo $mbstring ? "On" : "Off"; ?>
                            </div>
                    </td>
                </tr>
                <tr>
                    <?php $exif = function_exists('exif_read_data') ?>
                    <td>exif</td>
                    <td class="fs-xs">On</td>
                    <td class="fs-xs">
                        <?php if (isset($exif)) { ?>
                        <div class="text-success fw-bold">
                            <?php } else { ?>
                            <?php $installable = false; ?>
                            <div class="text-danger fw-bold">
                                <?php } ?>
                                <?php echo $exif ? "On" : "Off"; ?>
                            </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-theme-border">
            <thead>
                <tr>
                    <th width="60%" class="fs-sm text-muted">File</th>
                    <th width="30%" class="fs-sm text-muted">Current</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="font-weight-bold">/index.php</span></td>
                    <td class="fs-xs">
                        <?php if (is_writeable(ROOTPATH."/index.php")) { ?>
                        <div class="text-success fw-bold">
                            <?php } else { ?>
                            <?php $installable = false; ?>
                            <div class="text-danger fw-bold">
                                <?php } ?>
                                <?php echo $exif ? "Writeable" : "None"; ?>
                            </div>
                    </td>
                </tr>
                <tr>
                    <td><span class="font-weight-bold">/app/config/db.config.php</span></td>
                    <td class="fs-xs">
                        <?php if (is_writeable(ROOTPATH."/app/config/db.config.php")) { ?>
                        <div class="text-success fw-bold">
                            <?php } else { ?>
                            <?php $installable = false; ?>
                            <div class="text-danger fw-bold">
                                <?php } ?>
                                <?php echo $exif ? "Writeable" : "None"; ?>
                            </div>
                    </td>
                </tr>
                <tr>
                    <td><span class="font-weight-bold">/app/config/config.php</span></td>
                    <td class="fs-xs">
                        <?php if (is_writeable(ROOTPATH."/app/config/config.php")) { ?>
                        <div class="text-success fw-bold">
                            <?php } else { ?>
                            <?php $installable = false; ?>
                            <div class="text-danger fw-bold">
                                <?php } ?>
                                <?php echo $exif ? "Writeable" : "None"; ?>
                            </div>
                    </td>
                </tr>
                <tr>
                    <?php 
                                if (!file_exists(ROOTPATH."/public/upload/")) {
                                    @mkdir(ROOTPATH."/public/upload/", "0777", true);
                                }
                            ?>
                    <td><span class="font-weight-bold">/public/upload/</span></td>
                    <td class="fs-xs">
                        <?php if (is_writeable(ROOTPATH."/public/upload/")) { ?>
                        <div class="text-success fw-bold">
                            <?php } else { ?>
                            <?php $installable = false; ?>
                            <div class="text-danger fw-bold">
                                <?php } ?>
                                <?php echo $exif ? "Writeable" : "None"; ?>
                            </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        <?php if ($installable): ?>
        <div class="d-grid">
            <a href="<?php echo APP.'/install?step=3';?>" class="btn btn-success btn-lg next-btn rounded-pill">Next</a>
        </div>
        <?php else: ?>
        <div class="bg-warning alert text-white">
            We are sorry ! Your server configuration didn't match the application requirements
        </div>
        <?php endif; ?>
    </div>
</div>