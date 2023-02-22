<?php


namespace Plugin\consent_manager\Migrations;


use JTL\Plugin\Migration;
use JTL\Update\IMigration;

class Migration20210717000000 extends Migration implements IMigration
{

    /**
     * @return mixed|void
     */
    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS `consent_manager_settings`");
    }

    /**
     * @return mixed|void
     */
    public function up()
    {
        $this->execute(
            "CREATE TABLE IF NOT EXISTS `consent_manager_settings` (
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `settings_key` VARCHAR(255),
    `settings_value` LONGTEXT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB COLLATE utf8_unicode_ci"
        );
    }
}
