<?php
/**
 * @version     1.0
 * @package     Advanced Search Manager for Hikashop
 * @copyright   Copyright (C) 2016 JoomDev. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      JoomDev <info@joomdev.com> - http://www.joomdev.com/
 */
// No direct access

defined('_JEXEC') or die;
jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of order records.
 *
 * @since  1.6
 */
class AshsModelOrders extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
	
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'order_id','a.order_id','a.order_id',
				'order_number','a.order_number', 
				'product_sku',
				'produt_name',
				'order_status','a.order_status',
				'payment_method',
				'shipping_method',
				'email','vou.email','vpeg.payment_name','payment_method','vpege.shipping_name','shipping_method','order_created','order_modified',
				'a.modified_on','a.created_on','order_total',
				'first_name','name','last_name','address',
				'city','state','country','zip','from','to',
			);
		}
		
		parent::__construct($config);
	}


	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return  JDatabaseQuery
	 *
	 * @since   1.6
	 */
	public function getListQuery()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.order_id,a.order_number,a.order_created,a.order_modified,a.order_status,a.order_full_price as order_total,CONCAT(ha.address_firstname," ",ha.address_lastname) as name,hu.user_email as email,hp.payment_name as payment_method,hs.shipping_name as shipping_method,a.order_billing_address_id,a.order_shipping_address_id'
			)
		);
		$query->from($db->quoteName('#__hikashop_order') . ' AS a')
		 ->join('LEFT', $db->quoteName('#__hikashop_address', 'ha') . ' ON (' . $db->quoteName('a.order_billing_address_id') . ' = ' . $db->quoteName('ha.address_id') . ')')
		 
		 ->join('LEFT', $db->quoteName('#__hikashop_order_product', 'hop') . ' ON (' . $db->quoteName('a.order_id') . ' = ' . $db->quoteName('hop.order_id') . ')')
		 
		 
		 ->join('LEFT', $db->quoteName('#__hikashop_user', 'hu') . ' ON (' . $db->quoteName('a.order_user_id') . ' = ' . $db->quoteName('hu.user_id') . ')')
		 
		 

		 ->join('LEFT', $db->quoteName('#__hikashop_payment', 'hp') . ' ON (' . $db->quoteName('a.order_payment_method') . ' = ' . $db->quoteName('hp.payment_type') . ')')
		 
		 ->join('LEFT', $db->quoteName('#__hikashop_shipping', 'hs') . ' ON (' . $db->quoteName('a.order_shipping_method') . ' = ' . $db->quoteName('hs.shipping_type') . ')');
		 
		 
		 $query->group('a.order_id');
		 
		$orderNumber = $this->getState('filter.order_number');
		if (!empty($orderNumber)){
			$query->where("a.order_number LIKE ".$db->quote("%".$orderNumber."%"));
		}
		$orderId = $this->getState('filter.order_id');		
		if (trim($orderId) != ''){
			$query->where("a.order_id = ".$db->quote($orderId));
		}	
		$orderStatus = $this->getState('filter.order_status');		
		
		if ($orderStatus){
			$orstatus = '';			
			foreach($orderStatus as $k=>$os){
				if($k == 0){
					$orstatus .= "a.order_status = ".$db->quote($os);
				}else{
					$orstatus .= " OR a.order_status = ".$db->quote($os);
				}
				
			}			
			$query->where($orstatus);
		}
		
		$paymentMethod = $this->getState('filter.payment_method');		
		if ($paymentMethod){
			$pM = implode(',',$paymentMethod);			
			$query->where("order_payment_id IN($pM) ");
		}
		 
		$shippingtMethod = $this->getState('filter.shipping_method');	
		if ($shippingtMethod){
			$pM = implode(',',$shippingtMethod);			
			$query->where("order_shipping_id IN($pM) ");
		}
		
		
		$produtName = $this->getState('filter.produt_name');		
		$productSku = $this->getState('filter.product_sku');		
		if(($produtName)){
			if(is_array($produtName)){
				$proname = '';
				foreach($produtName as $i=>$prov){
					$proname .= $db->quote($prov).",";
				}
			}
			else{
				$proname = $produtName;
			}
			$proname = trim($proname,",");			
			$query->where("hop.product_id IN ( ".$proname." )");
		}
		if(($productSku)){
			if(is_array($productSku)){
				$proname = '';
				foreach($productSku as $i=>$prov){
					$proname .= $db->quote($prov).",";
				}
			}
			else{
				$proname = $productSku;
			}
			$proname = trim($proname,",");			
			$query->where("hop.order_product_code IN ( ".$proname." )");
		}
		
		$from = $this->getState('filter.from');
		if (!empty($from)){
			$from = strtotime($from);
			$query->where("a.order_created >= ".$db->quote($from));
		}
		
		$to = $this->getState('filter.to');
		if (!empty($to)){
			$str = strtotime($to)+86400;			
			$query->where("a.order_created <= ". $db->quote($str));
		}
		
		$firstName = $this->getState('filter.first_name');
		if($firstName){
			$query->where("ha.address_firstname LIKE ".$db->quote("%".$firstName."%"));
		}
		$lastName = $this->getState('filter.last_name');
		if($lastName){
			$query->where("ha.address_lastname LIKE ".$db->quote("%".$lastName."%"));
		}
		
		$city = $this->getState('filter.city');
		if($city){
			$query->where("ha.address_city LIKE ".$db->quote("%".$city."%"));
		}
		
		$state = $this->getState('filter.state');
		if($state){
			$sql = "SELECT `zone_namekey` FROM `#__hikashop_zone` WHERE zone_type = 'state' AND `zone_name_english` LIKE ".$db->quote("%".$state."%");
			$db->setQuery($sql);
			$rows = $db->loadColumn();
			$subquery = '';
				foreach($rows as $i=>$prov){
					$subquery .= $db->quote($prov).",";
				}
			$subquery = trim($subquery,",");
			if($subquery)
			$query->where(" ha.address_state IN ( " . $subquery ." )" );
		}
		$country = $this->getState('filter.country');	
		if($country){
			if(is_array($country)){
				$subquery = '';
				foreach($country as $i=>$prov){
					$subquery .= $db->quote($prov).",";
				}
			}
			else{
				$subquery = $country;
			}
			$subquery = trim($subquery,",");				
			$query->where("ha.address_country IN ( " . $subquery ." )" );
		}
		
		$zip = $this->getState('filter.zip');
		if($zip){
			$query->where("ha.address_post_code LIKE ".$db->quote("%".$zip."%"));
		}
		$address = $this->getState('filter.address');
		if($address){
			$query->where("ha.address_street LIKE ".$db->quote("%".$address."%"));
		}
		
		$email = $this->getState('filter.email');
		if($email){
			$query->where("hu.user_email = ".$db->quote($email));
		}
		
		$orderCol = $this->state->get('list.ordering', 'a.order_id');
		$orderDirn = $this->state->get('list.direction', 'DESC');
		
		$query->order($db->escape($orderCol . ' ' . $orderDirn));
		
		$session = JFactory::getSession();
		$session->set('orderquery',$query);
		return $query;
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.access');
		$id .= ':' . $this->getState('filter.state');
		$id .= ':' . $this->getState('filter.category_id');
		$id .= ':' . $this->getState('filter.language');

		return parent::getStoreId($id);
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   string  $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable    A database object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Order', $prefix = 'AsvmTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Load the filter state.
		$app = JFactory::getApplication('administrator');
		$search = (isset($_REQUEST['search'])) ? $_REQUEST['search'] : '';
		$this->setState('filter.search', $search);

		$orderId = (isset($_REQUEST['filter']['order_id'])) ? $_REQUEST['filter']['order_id'] : '';
		$this->setState('filter.order_id', $orderId);

		$orderNumber = (isset($_REQUEST['filter']['order_number'])) ? $_REQUEST['filter']['order_number'] : '';
		$this->setState('filter.order_number', $orderNumber);

		$productSku = (isset($_REQUEST['filter']['product_sku'])) ? $_REQUEST['filter']['product_sku'] : '';
		$this->setState('filter.product_sku', $productSku);

		$produtName = (isset($_REQUEST['filter']['produt_name'])) ? $_REQUEST['filter']['produt_name'] : '';
		$this->setState('filter.produt_name', $produtName);
		
		
		$orderStatus = (isset($_REQUEST['filter']['order_status'])) ? $_REQUEST['filter']['order_status'] : '';
		$this->setState('filter.order_status','');

		$paymentMethod = (isset($_REQUEST['filter']['payment_method'])) ? $_REQUEST['filter']['payment_method'] : '';
		$this->setState('filter.payment_method', $paymentMethod);

		$email = (isset($_REQUEST['filter']['email'])) ? $_REQUEST['filter']['email'] : '';
		$this->setState('filter.email', $email);
		
		$firstName = (isset($_REQUEST['filter']['first_name'])) ? $_REQUEST['filter']['first_name'] : '';
		$this->setState('filter.first_name', $firstName);
		
		$lastName = (isset($_REQUEST['filter']['last_name'])) ? $_REQUEST['filter']['last_name'] : '';
		$this->setState('filter.last_name', $lastName);
		
		$state = (isset($_REQUEST['filter']['state'])) ? $_REQUEST['filter']['state'] : '';
		$this->setState('filter.state', $state);
		
		$city = (isset($_REQUEST['filter']['city'])) ? $_REQUEST['filter']['city'] : '';
		$this->setState('filter.city', $city);
		
		$address = (isset($_REQUEST['filter']['address'])) ? $_REQUEST['filter']['address'] : '';
		$this->setState('filter.address', $address);
		
		$country = (isset($_REQUEST['filter']['country'])) ? $_REQUEST['filter']['country'] : '';
		$this->setState('filter.country', $country);
		
		$zip = (isset($_REQUEST['zip'])) ? $_REQUEST['zipzip'] : '';
		$this->setState('filter.zip', $zip);		

		// Load the parameters.
		$params = JComponentHelper::getParams('com_ashs');
        $this->setState('params', $params);

		// List state information.
		parent::populateState('a.order_id', 'DESC');
	}
	
	public function getItems() {
        $items = parent::getItems();
        
        return $items;
    }
	
}
