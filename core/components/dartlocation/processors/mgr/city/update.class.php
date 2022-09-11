<?php
class dartLocationCityUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'dartLocationCity';
    
    /**
     * var modX
     */
	public function beforeSet() {
		if(trim($this->getProperty('default'))){
			$sql = "UPDATE {$this->modx->getTableName($this->classKey)} SET `default` = 0 WHERE 1";
			$query = $this->modx->query($sql);
		}

		return parent::beforeSet();
	}
}

return "dartLocationCityUpdateProcessor";