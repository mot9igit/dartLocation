<?php
class dartLocationCityDuplicateProcessor extends modObjectCreateProcessor {
    public $classKey = 'dartLocationCity';
    
    /**
     * var modX
     */
    public function beforeSet() {
		$key = trim($this->getProperty('key'));
		if(trim($this->getProperty('default'))){
			$sql = "UPDATE {$this->modx->getTableName($this->classKey)} SET `default` = 0 WHERE 1";
			$query = $this->modx->query($sql);
		}
        if ($this->modx->getCount($this->classKey, array('key' => $key))) {
            $this->modx->error->addField('key', $this->modx->lexicon('dartlocation_err_name_ae'));
        }
        return parent::beforeSet();
    }
    
    /**
     * var modX
     */
    public function afterSave() {
        $this->modx->dartLocation->duplicateFields($this->getProperty('id'), $this->object->get('id'));
        
        return parent::afterSave();
    }
}

return "dartLocationCityDuplicateProcessor";