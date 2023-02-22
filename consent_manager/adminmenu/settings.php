<?php

use JTL\Helpers\Form;

$tableName = 'consent_manager_settings';
$action    = Shop::getAdminURL() . '/plugin.php?kPlugin=' . $oPlugin->getID();
if (!empty($_POST) && Form::validateToken()) {
    try {
        Shop::Container()->getDB()->beginTransaction();
        foreach ($_POST as $settings_key => $value) {
            if ($settings_key === 'jtl_token') {
                continue;
            }

            // Serialize value to be sure it will be saved
            $settings_value = base64_encode(serialize($value));
            if (!empty(Shop::Container()->getDB()->select($tableName, 'settings_key', $settings_key))) {
                // Update existing key
                Shop::Container()->getDB()->update(
                    $tableName,
                    'settings_key',
                    $settings_key,
                    (object)compact('settings_key', 'settings_value')
                );
                continue;
            }

            // Insert new key
            Shop::Container()->getDB()->insert(
                $tableName,
                (object)compact('settings_key', 'settings_value')
            );
        }
        Shop::Container()->getDB()->commit();
        $_SESSION['consent_manager_status'] = [
            'success' => 'Saved!'
        ];
    } catch (Exception $exception) {
        Shop::Container()->getDB()->rollback();
        $_SESSION['consent_manager_status'] = [
            'fail' => 'Data doesn\'t saved'
        ];
    }
    header('Location: ' . $action);
    exit;
}

$data = Shop::Container()->getDB()->selectAll($tableName, [], []);
if (isset($_SESSION['consent_manager_status'])) {
    if (isset($_SESSION['consent_manager_status']['success'])) {
        Shop::Container()->getAlertService()->addAlert(
            \JTL\Alert\Alert::TYPE_SUCCESS,
            $_SESSION['consent_manager_status']['success'],
            'testInfo'
        );
    } else {
        Shop::Container()->getAlertService()->addAlert(
            \JTL\Alert\Alert::TYPE_DANGER,
            $_SESSION['consent_manager_status']['fail'],
            'testInfo'
        );
    }
    unset($_SESSION['consent_manager_status']);
}

foreach ($data as $row) {
    $smarty->assign($row->settings_key, unserialize(base64_decode($row->settings_value)));
}
$smarty
    ->assign('action', $action)
    ->display(
        __DIR__ .
        DIRECTORY_SEPARATOR . 'tpl' .
        DIRECTORY_SEPARATOR . 'settings.tpl'
    );
