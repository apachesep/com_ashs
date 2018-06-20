<?php
/**
 * @version     1.0
 * @package     Advanced Search Manager for Hikashop
 * @copyright   Copyright (C) 2016 JoomDev. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      JoomDev <info@joomdev.com> - http://www.joomdev.com/
 */
defined('JPATH_BASE') or die;
use Joomla\Registry\Registry;
$data = array();
// Receive overridable options
$data['options'] = !empty($data['options']) ? $data['options'] : array();
if (is_array($data['options']))
{
	$data['options'] = new Registry($data['options']);
}
// Options
$filterButton = $data['options']->get('filterButton', true);
$searchButton = $data['options']->get('searchButton', true);

$jinput = JFactory::getApplication()->input;
$active_tab = $jinput->get('active_tab');

$form = JForm::getInstance('form', JPATH_ROOT.'/administrator/components/com_ashs/models/forms/filter_orders.xml');
JHtml::_('behavior.tooltip');
$activetab = (isset($active_tab) && !empty($active_tab)) ? $active_tab : "searchbyorder";
$data = $this->items; 
?>
 <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => $activetab)); ?>
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'searchbyorder', JText::_('COM_ASHS_ORDER_SEARCH_BY_ORDER', true)); ?>				
		<!--Search by Order -->
		<div>	
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('order_number','filter'); ?>
				</span>
			   <?php echo $form->getInput('order_number','filter',$this->state->get('filter.order_number')); ?>
			  </div>
			</div>
			
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('order_id','filter'); ?>
				</span>
			   <?php echo $form->getInput('order_id','filter',$this->state->get('filter.order_id')); ?>
			  </div>
			</div>
			
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('product_sku','filter'); ?>
				</span>
			   <?php echo $form->getInput('product_sku','filter',$this->state->get('filter.product_sku')); ?>
			  </div>
			</div>
			
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('produt_name','filter'); ?>
				</span>
			   <?php echo $form->getInput('produt_name','filter',$this->state->get('filter.produt_name')); ?>
			  </div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div>
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('order_status','filter'); ?>
				</span>
			   <?php echo $form->getInput('order_status','filter',$this->state->get('filter.order_status')); ?>
			  </div>
			</div>
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('payment_method','filter'); ?>
				</span>
			   <?php echo $form->getInput('payment_method','filter',$this->state->get('filter.payment_method')); ?>
			  </div>
			</div>
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('shipping_method','filter'); ?>
				</span>
			   <?php echo $form->getInput('shipping_method','filter',$this->state->get('filter.shipping_method')); ?>
			  </div>
			</div>
		</div>
		
   <?php echo JHtml::_('bootstrap.endTab'); ?>
   
   <!--Search by date -->
   <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'searchbydate', JText::_('COM_ASHS_ORDER_SEARCH_BY_DATE')); ?>
		<div>
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('from','filter'); ?>
				</span>
			   <?php echo $form->getInput('from','filter',$this->state->get('filter.from')); ?>
			  </div>
			</div>
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('to','filter'); ?>
				</span>
			   <?php echo $form->getInput('to','filter',$this->state->get('filter.to')); ?>
			  </div>
			</div>
		</div>
   <?php echo JHtml::_('bootstrap.endTab'); ?>
   
   <!--Search by Customer -->
   <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'searchbycustomer', JText::_('COM_ASHS_ORDER_SEARCH_BY_CUSTOMER')); ?>
		<div>
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('first_name','filter'); ?>
				</span>
			   <?php echo $form->getInput('first_name','filter',$this->state->get('filter.first_name')); ?>
			  </div>
			</div>
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('last_name','filter'); ?>
				</span>
			   <?php echo $form->getInput('last_name','filter',$this->state->get('filter.last_name')); ?>
			  </div>
			</div>
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('email','filter'); ?>
				</span>
			   <?php echo $form->getInput('email','filter',$this->state->get('filter.email')); ?>
			  </div>
			</div>
			
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('address','filter'); ?>
				</span>
			   <?php echo $form->getInput('address','filter',$this->state->get('filter.address')); ?>
			  </div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div>
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('city','filter'); ?>
				</span>
			   <?php echo $form->getInput('city','filter',$this->state->get('filter.city')); ?>
			  </div>
			</div>
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('state','filter'); ?>
				</span>
			   <?php echo $form->getInput('state','filter',$this->state->get('filter.state')); ?>
			  </div>
			</div>
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('country','filter'); ?>
				</span>
			   <?php echo $form->getInput('country','filter',$this->state->get('filter.country')); ?>
			  </div>
			</div>
			<div class="span3">
			  <div class="input-group">
				<span class="input-group-addon">
				  <?php echo $form->getLabel('zip','filter'); ?>
				</span>
			   <?php echo $form->getInput('zip','filter',$this->state->get('filter.zip')); ?>
			  </div>
			</div>
		</div>
   <?php echo JHtml::_('bootstrap.endTab'); ?>
	<input type="hidden" name="active_tab" id="active_tab" value="<?php echo $activetab; ?>" />
  <?php echo JHtml::_('bootstrap.endTab'); ?>
<div class="clearfix"></div><div class="clearfix"></div>
<br>
<button  type="submit" class="btn btn-info" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><span class="icon-search"></span><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
<?php if($jinput->get('order_selection')){ ?>
<a id="toolbar-reset" href="javascript:void(0);" class="btn btn-info clearbtnnew" title="<?php echo JText::_('COM_ASHS_RESET_BUTTON'); ?>"><span class="icon-loop"></span><?php echo JText::_('COM_ASHS_RESET_BUTTON'); ?></a>
<?php } ?>
<?php if(isset($data) && count($data) > 0){ ?>
<button id="toolbar-download" type="button" class="btn btn-warning" title="<?php echo JText::_('COM_ASHS_EXPORT_BUTTON'); ?>"><span class="icon-download"></span><?php echo JText::_('COM_ASHS_EXPORT_BUTTON'); ?></button>
<?php } ?>
<hr>
<script>
	jQuery(function(){
		jQuery('.clearbtnnew').click(function(){
			jQuery('#adminForm input.clr').val('');
			jQuery('#adminForm select').val('');
			jQuery('#adminForm').submit();
		});
		jQuery('#myTabTabs li').live('click',function(){
			var activeTab 	= jQuery(this).find('a').attr('href');	
			var activeTabId = activeTab.replace("#", "");
			jQuery('#active_tab').val(activeTabId);
		}); 
	})
</script>