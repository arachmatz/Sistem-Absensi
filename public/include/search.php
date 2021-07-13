<?php 

class Search{
    private $fields = array();
    private $value = '';
    private $delimiter = '';
    private $delimiterColumn = '';
    
    public function setField($fields){
        $this->fields = $fields;
    }

    public function getField(){
        return $this->fields;
    }

    public function setValue($value){
        $this->value = $value;
    }

    public function getValue(){
        return $this->value;
    }

    // delimiter untuk pemisah field dan nilai
    public function setDelimiter($delimiter){
        $this->delimiter = $delimiter;
    }

    public function getDelimiter(){
        return $this->delimiter;
    }

    // delimiter untuk pemisah field dan nilai yang berbeda
    public function setDelimiterColumn($delimiter){
        $this->delimiterColumn = $delimiter;
    }

    public function getDelimiterColumn(){
        return $this->delimiterColumn;
    }

    public function matchingColumn($column){
        $columnArray = explode($this->delimiter,$column);
        if(count($columnArray) > 1){
            for ($i=0; $i < count($this->fields); $i++){ 
                if($this->fields[$i] == $columnArray[0]){
                    return $columnArray;
                }
            }
        }
        
    }
}
?>