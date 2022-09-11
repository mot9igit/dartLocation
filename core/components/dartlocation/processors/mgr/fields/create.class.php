<?php
class dartLocationFieldsCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'dartLocationFields';
    
    /**
     * var modX
     */
    public function beforeSet() {
        $city = trim($this->getProperty('city'));
        $key = trim($this->getProperty('key'));
        
        if (array_search($key, $this->modx->dartLocation->fields())) {
            $this->modx->error->addField('key', $this->modx->lexicon('dartlocation_err_key_ae'));
        }
        
        if ($this->modx->getCount($this->classKey, array('city' => $city, 'key' => $key))) {
            $this->modx->error->addField('key', $this->modx->lexicon('dartlocation_err_key_ae'));
        }
        
        return parent::beforeSet();
    }
}

return "dartLocationFieldsCreateProcessor";