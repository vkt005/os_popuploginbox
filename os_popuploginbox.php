<?php
/*
        Module Name: OSPopupLoginbox
        Module URI: http://opensum.com
        Description: PopUp Login box.
        Version: 1.0
        Author: vivek@opensum.com
        Author URI: http://opensum.com
        Copyright (C) 2014 opensum.com. 
*/
class Os_popuploginbox extends Module
{
	private $_html = '';
	private $_postErrors = array();
	private $errors = array();
        
        public function __construct()
	{
		$this->name = 'os_popuploginbox';
		$this->tab = 'front_office_features';
		$this->author = 'vivek kumar tripathi';
		$this->version = 1.0;
                $this->bootstrap = true;
		parent::__construct();
		
		$this->displayName = $this->l('Popup Login Box');
		$this->description = $this->l('Adds a Link at footer and left column block that allows the customer to log in through popup via Ajax');
	}
	public function install()
	{
            
             if (parent::install() == false 
                    OR !Configuration::updateValue('OS_REDURL', 'my-account.php')
                    OR $this->registerHook('header') == false
                    OR $this->registerHook('leftColumn') == false
                    OR $this->registerHook('footer') == false
                     ){return false;}
                     else return true;
        }
	/**
	* Returns module content for header
	*
	* @param array $params Parameters
	* @return string Content
	*/
	private function _postValidation() { }

        private function _postProcess(){
                Configuration::updateValue('OS_REDURL', Tools::getValue('os_redirecturl'));
		Configuration::updateValue('OS_showcreateacct', Tools::getValue('OS_showcreateacct'));
                $this->_html .= '<div class="conf confirm">'.$this->l('Settings updated').'</div>';
        }
        public function getContent()
        {
                $this->_html .= '<h2>'.$this->displayName.'</h2>';
                if (Tools::isSubmit('submit'))
                {
                        $this->_postValidation();
                        if (!sizeof($this->_postErrors))
                            $this->_postProcess();
                        else
                        {
                                foreach ($this->_postErrors AS $err)
                                {
                                        $this->_html .= '<div class="alert error">'.$err.'</div>';
                                }
                        }
                }
                $this->_displayForm();
                return $this->_html;
        }
        private function _displayForm()
        {
            $fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'switch',
						'label' => $this->l('Show Create an account'),
						'name' => 'OS_showcreateacct',
						'is_bool' => true,
						'desc' => $this->l('This will show or hide create account form in popup box.'),
						'values' => array(
									array(
										'id' => 'active_on',
										'value' => 1,
										'label' => $this->l('Enabled')
									),
									array(
										'id' => 'active_off',
										'value' => 0,
										'label' => $this->l('Disabled')
									)
								),
						),
                                    
					array(
						'type' => 'text',
						'label' => $this->l('Redirect to Page After Login'),
						'name' => 'os_redirecturl',
						'desc' => $this->l('Put the pagename for redirect after login Ex: identity.php, history.php, order.php, product.php')
					),
				),
				'submit' => array(
					'title' => $this->l('Save')
				)
			),
		);
		
		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table =  $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();

		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submit';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);
		$this->_html .=  $helper->generateForm(array($fields_form));
        }
        public function getConfigFieldsValues()
	{
		return array(
			'OS_showcreateacct' => Tools::getValue('OS_showcreateacct', Configuration::get('OS_showcreateacct')),
			'os_redirecturl' => Tools::getValue('os_redirecturl', Configuration::get('OS_REDURL'))
		);
	}
    function hookLeftColumn($params)
	{
            global $smarty, $cookie;
            $smarty->assign(array(
                    'logged' => $cookie->isLogged(),
                    'osredurl' => Configuration::get('OS_REDURL'),
                    'customerName' => ($cookie->logged ? $cookie->customer_firstname.' '.$cookie->customer_lastname : false),
                    'firstName' => ($cookie->logged ? $cookie->customer_firstname : false),
                    'OS_showcreateacct' => Configuration::get('OS_showcreateacct'),
                    'lastName' => ($cookie->logged ? $cookie->customer_lastname : false)
            ));
            return $this->display(__FILE__, 'os_popuplogin.tpl');
	}

	function hookRightColumn($params)
	{
		return $this->hookLeftColumn($params);
	}
	function hookHeader($params)
	{
		
	}
	function hookTop($params)
	{
		return $this->hookLeftColumn($params);
	}
 	function hookFooter($params)
        {
            $this->context->controller->addJS(($this->_path).'js/login_popup.js');
            return $this->hookLeftColumn($params);
        }
        function checkUser($email){
            if (!($email = trim(Tools::getValue('email_create'))) || !Validate::isEmail($email))
				$this->errors[] = Tools::displayError('Invalid email address.');
			else
			{
				$customer = new Customer();
				$customer->getByemail($email);
                                if (!Validate::isLoadedObject($customer)){}
                                else {
                                    $this->errors[]='Already Registered';
                                }
			}
                        $f = array(
				'hasError' => !empty($this->errors),
				'errors' => implode(',', $this->errors)
			);
                     return $f;
        }
}
?>