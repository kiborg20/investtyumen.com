<?php

namespace Sprint\Migration;


use Tyumip\Main\model\IndexerTable;
use Bitrix\Main\Application;

class Version20231109015835 extends Version
{
    protected $description = "Таблица index_table";

    protected $moduleVersion = "4.3.1";

    public function up()
    {
        IndexerTable::getEntity()->createDbTable();
    }

    public function down()
    {
        $connection = Application::getConnection();
        $connection->dropTable(IndexerTable::getTableName());
    }
}
