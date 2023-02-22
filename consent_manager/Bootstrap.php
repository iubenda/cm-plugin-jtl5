<?php

namespace Plugin\consent_manager;

use JTL\Events\Dispatcher;
use JTL\Plugin\Bootstrapper;
use JTL\Shop;

class Bootstrap extends Bootstrapper
{

    /**
     * @inheritdoc
     */
    public function boot(Dispatcher $dispatcher): void
    {
        parent::boot($dispatcher);
        if (!Shop::isFrontend()) {
            return;
        }
        $dispatcher->listen(
            'shop.hook.' . \HOOK_SMARTY_OUTPUTFILTER,
            function ($args) {
                $tableName = 'consent_manager_settings';
                $data      = Shop::Container()->getDB()->selectAll($tableName, [], []);

                if (!empty($data)) {
                    $settings = [];

                    // Prepare settings data
                    foreach ($data as $row) {
                        $settings[$row->settings_key] = unserialize(base64_decode($row->settings_value));
                    }
                    if (!empty($settings['consent_manager_id'])) {
                        $tpl = 'automatic';
                        // Check is semi-automatic type selected
                        if ((int)$settings['code_type'] === 2) {
                            $tpl = 'semi_automatic';
                        }

                        $html = Shop::Smarty()
                            ->assign('consentManagerId', $settings['consent_manager_id'])
                            ->fetch(__DIR__ . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR . $tpl . '.tpl');

                        pq('head')->prepend($html);

                        // Check additional code exist
                        if (!empty(trim($settings['additional_code']))) {
                            pq('head')->prepend(trim($settings['additional_code']));
                        }
                    }
                }
            }
        );
    }

}
