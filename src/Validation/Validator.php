<?php

namespace src\Validation;

class Validator {

    private array $data     = array();
    private array $errors   = array();
    private array $pattern  = array();
    private array $messages = array();


    public function __construct() {
        $this->setMessages();
        $this->setPattern();
    }

    public function set(array $nameAndValue): static
    {
        $this->data['name'] = $nameAndValue[0];
        $this->data['value'] = $nameAndValue[1];
        return $this;
    }
    
    private function setMessages(): void
    {
        $this->messages = require ROOT_PATH . 'configs/validator_codes.php';
    }
    
    public function unique($array, bool $strict = false): static
    {
        if (in_array($this->data['value'] , $array , $strict)){
            $this->setError(sprintf($this->messages['is_unique'], $this->data['name']));
        }
        return $this;
    }

    
    public function setPattern($prefix = '', $suffix = ''): void
    {
        $this->pattern['prefix'] = $prefix;
        $this->pattern['suffix']  = $suffix;
    }


    protected function setError($error): void
    {
        $this->errors[$this->pattern['prefix'] . $this->data['name'] . $this->pattern['suffix']][] = $error;
    }

    public function required(): static
    {
        if (empty ($this->data['value'])){
            $this->setError(sprintf($this->messages['is_required'], $this->data['name']));
        }
        return $this;
    }
    
    public function minSymbols($length): static
    {
        $verify = strlen($this->data['value']) > $length;
        if (!$verify){
            $this->setError(sprintf($this->messages['min_length'], $this->data['name'], $length));
        }
        return $this;
    }
    
    public function maxSymbols($length): static
    {
        $verify = strlen($this->data['value']) < $length;
        if (!$verify){
            $this->setError(sprintf($this->messages['max_length'], $this->data['name'], $length));
        }
        return $this;
    }
    
    public function betweenSymbols($min, $max): static
    {
        if(strlen($this->data['value']) < $min || strlen($this->data['value']) > $max){
            $this->setError(sprintf($this->messages['between_length'], $this->data['name'], $min, $max));
        }
        return $this;
    }

    public function betweenValues($min, $max): static
    {
        if(!is_numeric($this->data['value']) || (($this->data['value'] < $min || $this->data['value'] > $max ))){
            $this->setError(sprintf($this->messages['between_values'], $this->data['name'], $min, $max));
        }
        return $this;
    }

    public function isAlphaNumeric($additional = ''): static
    {
        $pattern = '/^(\s|[a-zA-Z0-9])*$/';
        if(!$this->generateAlphaNum($pattern, $additional)){
            $this->setError(sprintf($this->messages['is_alpha_num'], $this->data['name']));
        }
        return $this;
    }

    public function isInt(): static
    {
        $verify = is_numeric($this->data['value']);
        if(!$verify){
            $this->setError(sprintf($this->messages['is_int'], $this->data['name']));
        }
        return $this;
    }

    public function inArray(array $array): static
    {
        $verify = in_array($this->data['value'], $array);
        if(!$verify){
            $this->setError(sprintf($this->messages['in_array'], $this->data['name'], implode(', ', $array)));
        }
        return $this;
    }

    private function generateAlphaNum($pattern, $additional = ''): bool
    {
        $this->data['value'] = (string)$this->data['value'];
        $clean = str_replace(str_split($additional), '', $this->data['value']);
        return ($clean !== $this->data['value'] && $clean === '') || preg_match($pattern, $clean);
    }

    public function equals($value, $valueName = ''): static
    {
        $verify = $this->data['value'] === $value;
        if(!$verify){
            $this->setError(sprintf($this->messages['is_equals'], $this->data['name'], $valueName));
        }
        return $this;
    }
    
    public function spaceless(): static
    {
        $verify = is_null($this->data['value']) || preg_match('#^\S+$#', $this->data['value']);
        if(!$verify){
            $this->setError(sprintf($this->messages['no_whitespaces'], $this->data['name']));
        }
        return $this;
    }
    public function notPregMatch(string $pattern): static
    {
        $verify = !preg_match($pattern, $this->data['value']);
        if(!$verify){
            $this->setError(sprintf($this->messages['no_preg_match'], $this->data['name']));
        }
        return $this;
    }
    
    public function validate(): bool
    {
        return !(count($this->errors) > 0);
    }
    
    public function getErrors($param = false){
        if ($param){
            return $this->errors[$this->pattern['prefix'] . $param . $this->pattern['suffix']] ?? false;
        }
        return $this->errors;
    }
}