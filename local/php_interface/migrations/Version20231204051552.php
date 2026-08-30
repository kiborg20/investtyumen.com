<?php

namespace Sprint\Migration;

use Tyumip\Main\model\IconDirectoryTable;
use Bitrix\Main\Application;

class Version20231204051552 extends Version
{
    protected $description = "Таблица tyumip_icons_array";

    protected $moduleVersion = "4.3.1";

    public function up()
    {
        IconDirectoryTable::getEntity()->createDbTable();
    }

    public function down()
    {
        $connection = Application::getConnection();
        $connection->dropTable(IconDirectoryTable::getTableName());
    }
}
