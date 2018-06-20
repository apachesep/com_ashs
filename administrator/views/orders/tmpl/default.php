<?php
/**
 * @version     1.0
 * @package     Advanced Search Manager for Hikashop
 * @copyright   Copyright (C) 2016 JoomDev. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      JoomDev <info@joomdev.com> - http://www.joomdev.com/
 */
 
defined('_JEXEC') or die;
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
JHTML::_('behavior.formvalidator');
$language = JFactory::getLanguage();
$language->load('com_hikashop');
$language->load('com_hikashop', JPATH_ADMINISTRATOR, 'en-GB', true);
$language->load('com_hikashop', JPATH_ADMINISTRATOR.'/components/com_hikashop', 'en-GB', true);
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_ashs/assets/css/ashs.css');
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$filters 	= $this->filterForm->getGroup('filter');

$apps = JFactory::getApplication();

	$db = JFactory::getDBO();
?>
<form action="<?php echo JRoute::_('index.php?option=com_asvm&view=orders'); ?>" method="post" name="adminForm" id="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<div id="filter-bar" class="btn-toolbar" style="display:none">
				<div class="filter-search btn-group pull-left">
					<label for="filter_search" class="element-invisible"><?php echo JText::_('JSEARCH_FILTER'); ?></label>
					<?php echo $filters['filter_search']->input; ?>
				</div>
				<div class="btn-group pull-left">					
					<button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>">
						<i class="icon-search"></i>
					</button>
					<button type="button" class="btn hasTooltip js-stools-btn-clear clearbtnnew" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>">
						<?php echo JText::_('JSEARCH_FILTER_CLEAR');?>
					</button>	
				</div>
				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
					<?php //echo $this->pagination->getLimitBox(); ?>
				</div>
		</div>
		<div class="clearfix"></div>
		<div class="clearfix"></div>			
		<?php echo $this->loadTemplate('searchtabs');?>
		<div class="clearfix"></div>
		<table class="table-filter-data">
			
		</table>
		<div class="clearfix"></div>
		<?php if (empty($this->items)) : ?>
			<div class="alert alert-no-items">
				<?php echo JText::_('COM_ASHS_ORDER_RESULT_NOT_FOUND'); ?>
			</div>
		<?php else : ?>
			<table class="table table-striped" id="articleList">
				<thead>
					<tr>
						<th width="1%" class="nowrap center">
							<?php echo JHtml::_('grid.checkall'); ?>
						</th>
						<th width="15%" >
							<?php echo JHtml::_('grid.sort', 'COM_ASHS_FORM_ORDER_NUMBER', 'a.order_number', $listDirn, $listOrder); ?>
						</th>
						<th width="15%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'COM_ASHS_FORM_LBL_ORDER_NAME', 'name', $listDirn, $listOrder); ?>
						</th>
						<th width="15%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'COM_ASHS_FORM_LBL_ORDER_EMAIL', 'email', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'COM_ASHS_PAYMENT_METHOD', 'payment_method', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'COM_ASHS_SHIPMENT_METHOD', 'shipping_method', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('grid.sort', 'COM_ASHS_ORDER_DATE', 'order_created', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'COM_ASHS_LAST_MODIFIED', 'order_modified', $listDirn, $listOrder); ?>
						</th>
						<th width="12%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'COM_ASHS_ORDER_STATUS', 'a.order_status', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'COM_ASHS_ORDER_TOTAL', 'order_total', $listDirn, $listOrder); ?>
						</th>
						<th width="3%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('grid.sort', 'COM_ASHS_ORDER_ID_LABLE', 'a.order_id', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="13">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($this->items as $i => $item) :	
								
						?>
						<tr class="row<?php echo $i % 2; ?>">
							<td class="center">
									<?php echo JHtml::_('grid.id', $i, $item->order_number); ?>
							</td>
						
							<td class="small hidden-phone">
								<?php
								if($item->order_number){ ?>
									<a href="<?php echo JRoute::_('index.php?option=com_hikashop&ctrl=order&task=edit&cid[]='.$item->order_id); ?> " target="_blank">
									<?php echo $item->order_number; ?> 
									</a>			
								<?php }else{
									echo '-----';
								}	
								
								?>
							</td>
							
							<td class="small hidden-phone">
								<?php echo $item->name; ?>
							</td>
							
							<td class="small hidden-phone">
								<?php echo $item->email; ?>
							</td>
							
							<td class="small hidden-phone">
								<?php echo $item->payment_method; ?>
							</td>	
							
							<td class="small hidden-phone">
								<?php echo $item->shipping_method; ?>
							</td>
							
							<td class="small hidden-phone">
								<?php echo date('l , d F Y h:i ',$item->order_created); ?>
							</td>
							
							<td class="small hidden-phone">
								<?php echo date('l , d F Y h:i ',$item->order_modified); ?>
							</td>
							
							<td class="small hidden-phone">
								<?php echo JText::_(str_replace('com_hikashop','com_ashs',$item->order_status)) ?>
							</td>
							
							<td class="small hidden-phone">
								<?php 								
								echo number_format($item->order_total, 2);	
								?>
							</td>							
							<td class="small hidden-phone">
								<?php echo $item->order_id; ?>
							</td>
							
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>			
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />		
		<?php 
		
		echo JHtml::_('form.token'); ?>
	</div>
<input type="hidden" name="order_selection" value="1" />
</form>
<script language="javascript">
console.log(jQuery("#filter_produt_name option:selected").text());
baseurl = '<?php echo JURI::getInstance();?>';
jQuery("#adminForm").attr('action','<?php echo JURI::getInstance();?>');
jQuery(document).ready(function(){
	jQuery("button#toolbar-download").on('click',function(e){
		jQuery("#adminForm").submit();
		action = 'index.php?option=com_ashs&view=exports';
		jQuery("#adminForm").attr('action',action);
		 jQuery("#adminForm").submit();
	 });	 
	jQuery('#filter_order_id').keyup(function () { 
		this.value = this.value.replace(/[^0-9.]/g,'');
	});
});

var searchHtml = '';
var value = 0;
jQuery("#myTabContent .input-group").each(function(){
	$this = jQuery(this);
	var text = $this.find("label").text();
	value = $this.find("input").val();
	if(value){
		//
	}
	else{
		value = $this.find("select option:selected").map(function() { 
			return this.text; 
		}).get().join(',');
	}
	
	if(value){
		searchHtml += "<tr><td>"+ text +" </td><td> : " + value + "</td></tr>";
	}
	
});
jQuery(".table-filter-data").html(searchHtml);
if(searchHtml !='')
jQuery(".table-filter-data").after("<hr>");
</script>