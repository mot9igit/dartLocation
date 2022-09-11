<?php

class dartLocationCityRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'dartLocationCity';
    public $classKey = 'dartLocationCity';
    public $languageTopics = array('dartlocation');
    //public $permission = 'remove';
    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }
        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (!$ids) {
            return $this->failure($this->modx->lexicon('error'));
        }
        foreach ($ids as $id) {
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('error'));
            }
            $object->remove();
        }
        return $this->success();
    }
}
return 'dartLocationCityRemoveProcessor';