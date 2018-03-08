<?php
/**
 * Description of viewbase
 *
 * @author juanantonio
 */
class ttgViewBase {
    private $tpl  = "";
    private $data = array();

    function __construct($tpl_name) {
         $this->tpl = $tpl_name;
    }

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    public function setVars($values) {
        $this->data = $values;
    }

    public function parse() {
        ob_start();
        extract($this->data);
        include $this->tpl;
        ob_end_flush();
        return ob_get_clean();
    }
}