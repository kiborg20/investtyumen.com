<?php

namespace Sprint\Migration;


class Version20230928122142 extends Version
{
    protected $description = "Новый инфоблок с картинкой и текстом разделы";

    protected $moduleVersion = "4.3.1";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $iblockId = $helper->Iblock()->getIblockIdIfExists(
            'sr_two_block',
            'sferyrosta'
        );

        $helper->Iblock()->addSectionsFromTree(
            $iblockId,
            array (
  0 => 
  array (
    'NAME' => 'Нефтесервисное оборудование и услуги',
    'CODE' => 'nefteservisnoe-oborudovanie-i-uslugi',
    'SORT' => '500',
    'ACTIVE' => 'Y',
    'XML_ID' => NULL,
    'DESCRIPTION' => '',
    'DESCRIPTION_TYPE' => 'text',
  ),
)        );
    }

    public function down()
    {
        //your code ...
    }
}
