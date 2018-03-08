<?php
/**
 * Description of ttgtabsadmin
 *
 * @author juanantonio
 */
class ttgTabsAdmin {
    
    /**
     *
     * @var ttgGestor $ttggestor 
     */
    private $ttggestor;
    private $data=array();

    /**
     * 
     * @param ttgGestor $ttggestor
     */
    public function __construct(ttgGestor $ttggestor){
        $this->ttggestor = $ttggestor;
        $this->init();
        $this->initData();
    }
    
    private function init(){
        add_action( 'admin_menu', array($this,'ttgCreateAdminMenu'));
    }
    
    private function initData(){
        foreach ($this->ttggestor->getCamps() as $camp) {
            $this->data['camps'][$camp->getIdCamp()]=new stdClass();
            $this->data['camps'][$camp->getIdCamp()]->id=$camp->getIdCamp();
            $this->data['camps'][$camp->getIdCamp()]->name=$camp->getName();
            $this->data['camps'][$camp->getIdCamp()]->phone=$camp->getPhone();
            $this->data['camps'][$camp->getIdCamp()]->state=$camp->getState();
            $this->data['camps'][$camp->getIdCamp()]->town=$camp->getTown();
            $this->data['camps'][$camp->getIdCamp()]->holes=$camp->getHoles();          
        }
    }

    
    public function ttgCreateAdminMenu() {

	add_menu_page ( 'Tus Torneos Gestor', 'Campos y Resultados', 'manage_options', 'ttg-gestor', array($this,'ttgAdminOption'), 'dashicons-clipboard' );

    //add_submenu_page ( 'ttg-gestor', 'TTG Resultados', 'Rankings', 'manage_options', 'ttg-results', array($this,'ttgAdminOptionResult'));
    add_submenu_page ( 'ttg-gestor', 'TTG Resultados', 'Rankings', 'edit_pages', 'edit.php?post_type=ranking');

    }

    public function ttgAdminOption() {
        $tpl = new ttgViewBase(TTG_PLUGIN_TEMPLATES.'tabs-template.php');
        $tpl->setVars($this->data);
        echo $tpl->parse();
    }
    public function ttgAdminOptionResult() {
        $tpl = new ttgViewBase(TTG_PLUGIN_TEMPLATES.'rankings-template.php');
        $tpl->setVars($this->data);
        echo $tpl->parse();
    }
}
