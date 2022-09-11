<?php

class dartLocationOfficeItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'dartLocationItem';
    public $classKey = 'dartLocationItem';
    public $languageTopics = ['dartlocation'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('dartlocation_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('dartlocation_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'dartLocationOfficeItemCreateProcessor';