<?php
class dartLocationResourceCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'dartLocationResource';
    
    /**
     * var modX
     */
    public function beforeSet() {
        $city = trim($this->getProperty('city'));
        $resource = trim($this->getProperty('resource'));

        if ($this->modx->getCount($this->classKey, ['city' => $city, 'resource' => $resource])) {
            $this->modx->error->addField('city', $this->modx->lexicon('dartlocation_resource_city_ae'));
        }
        
        return parent::beforeSet();
    }
}

return "dartLocationResourceCreateProcessor";