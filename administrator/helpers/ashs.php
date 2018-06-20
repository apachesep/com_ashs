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

/**
 * Asvm helper.
 */
class AsvmHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        JHtmlSidebar::addEntry(
			JText::_('COM_ASHS_TITLE_ORDERS'),
			'index.php?option=com_ashs&view=orders',
			$vName == 'orders'
		);
		JHtmlSidebar::addEntry(
			JText::_('Export'),
			'index.php?option=com_ashs&view=exports',
			$vName == 'exports'
		);		
    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_ashs';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }
	
	
	// get product sku
	public static function getProductSkuOptions()
	{
		$options = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('product_code As value, product_code As text')
			->from('#__hikashop_product AS a')
			//->where('a.published = 1')
			->where("a.product_code != ''")
			->order('a.product_id');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		// Merge any additional options in the XML definition.
		// $options = array_merge(parent::getOptions(), $options);

		array_unshift($options, JHtml::_('select.option','0',JText::_('COM_ASHS_ORDER_SELECT_PRODUCT_SKU')));		
		return $options;	
	}
	
	
	// get product name 
	public static function getProductNameOptions()
	{
		$options = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('product_id As value, product_name As text')
			->from('#__hikashop_product AS a')			
			->order('a.product_name');
		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}
		
		array_unshift($options, JHtml::_('select.option','0',JText::_('COM_ASHS_ORDER_SELECT_PRODUCT_NAME')));		
		return $options;
	}
	
	
	// get Order Status Options
	public static function getOrderStatusOptions()
	{
		$options = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('order_status As value, order_status As text')
			->from('#__hikashop_order AS a')
			->group('a.order_status')
			->order('a.order_status');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options  = array();
			$options1 = $db->loadObjectList();
			if(!empty($options1)){
				foreach($options1 as $k=>$v){
					$text 		  =  str_replace('com_hikashop','com_ashs',$v->text);
					$v->text 	  = JText::_($text);	
					$options[$k]  = $v;
				}
			}
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		// Merge any additional options in the XML definition.
		// $options = array_merge(parent::getOptions(), $options);

		array_unshift($options, JHtml::_('select.option','0',JText::_('COM_ASHS_ORDER_SELECT_ORDER_STATUS')));

		return $options;
	}
	
	// get Payment Method Options
	public static function getPaymentMethodOptions()
	{
		$options = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('a.payment_id As value, a.payment_name As text')
			->from('#__hikashop_payment AS a')
			->where('a.payment_published = 1')
			->order('a.payment_id');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		// Merge any additional options in the XML definition.
		// $options = array_merge(parent::getOptions(), $options);

		array_unshift($options, JHtml::_('select.option','0',JText::_('COM_ASHS_ORDER_SELECT_PAYMENT_METHOD')));

		return $options;
	}
	
	
	public static function getShipmentMethodOptions()
	{
		$options = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('a.shipping_id As value, a.shipping_name As text')
			->from('#__hikashop_shipping AS a')
			->where('a.shipping_published = 1')
			->order('a.shipping_id');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		// Merge any additional options in the XML definition.
		// $options = array_merge(parent::getOptions(), $options);

		array_unshift($options, JHtml::_('select.option','0',JText::_('COM_ASHS_ORDER_SELECT_PAYMENT_METHOD')));

		return $options;
	}
	// get  Country Options
	public static function getVmCountryOptions()
	{
		$options = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('zone_namekey As value, zone_name_english As text')
			->from('#__hikashop_zone AS a')
			->where('a.zone_published = 1')
			->where('a.zone_type = "country"')
			->order('a.zone_name_english');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		// Merge any additional options in the XML definition.
		// $options = array_merge(parent::getOptions(), $options);

		array_unshift($options, JHtml::_('select.option','0',JText::_('COM_ASHS_ORDER_SELECT_COUNTRY')));

		return $options;
	}


}
