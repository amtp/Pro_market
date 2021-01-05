<?php
/**
 * @package   FL Yandex Turbo Plugin
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die;

class FLYandexTurboCoreK2 extends FLYandexTurboCore {

	// Get COM_K2 Content

	public function getContent($page = 1)
	{	
		// make sure K2 exist
		jimport('joomla.filesystem.file');
		if (!JFile::exists(JPATH_ADMINISTRATOR.'/components/com_k2/k2.php')
				|| !JComponentHelper::getComponent('com_k2', true)->enabled) {
			return;
		}

		require_once(JPATH_SITE.'/components/com_k2/helpers/route.php');
		require_once(JPATH_SITE.'/components/com_k2/helpers/utilities.php');

		$result 	= array();
		$items 		= $this->getItems($page);
		$image 		= $this->params->get('k2_options')->k2_add_image;
		$imageSize	= $this->params->get('k2_options')->k2_image_size;

		if(!empty($items)) {
			foreach ($items as $item) {	
				$date 		   	= new JDate($item->created);
				$item->link 	= JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($item->categoryalias)), false, $this->ssl);
				$item->image 	= $image ? $this->getImage($item->id, $imageSize) : '';

				$result[] = array(
					'title' 		=> htmlspecialchars($item->title),
					'image' 		=> $item->image,
					'link' 			=> $item->link,
					'date' 			=> $date->toRFC822(true),
					'author' 		=> $this->getAuthor($item->created_by),
					'content' 		=> $this->prepareContent($item->introtext.$item->fulltext),
					'related'		=> array()
				);
			}
		}

		return $result;
	}

	// Get Content Items

	public function getItems($page = 1)
	{
		$items 			= array();
		$options 		= $this->params->get('k2_options');
		$catFilter 		= $options->k2_cat_filter;
		$limit 			= isset($options->k2_count) ? (int) $options->k2_count : 500;
		$catId 			= isset($options->k2_catid) ? $options->k2_catid : '';
		$getChildren 	= $options->k2_get_children;
		$featured 		= $options->k2_show_featured;
		$image 			= $options->k2_add_image;

		$jnow 			= JFactory::getDate();
		$now 			= $jnow->toSql();
		$nullDate 		= $this->db->getNullDate();

		$query 			= "SELECT DISTINCT i.*,";
		$query 			.= "c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams";
		$query 			.= " FROM #__k2_items as i RIGHT JOIN #__k2_categories c ON c.id = i.catid";
		$query 	 		.= " WHERE i.published = 1 AND i.trash = 0 AND c.published = 1";
		$query 			.= " AND ( i.publish_up = ".$this->db->Quote($nullDate)." OR i.publish_up <= ".$this->db->Quote($now)." )";
		$query 			.= " AND ( i.publish_down = ".$this->db->Quote($nullDate)." OR i.publish_down >= ".$this->db->Quote($now)." )";


		if ($catFilter) {

			if (!is_null($catId)) {

				if (is_array($catId)) {

					if ($getChildren) {
						$itemListModel = K2Model::getInstance('Itemlist', 'K2Model');
						$categories = $itemListModel->getCategoryTree($catId);
						$sql = @implode(',', $categories);
						$query .= " AND i.catid IN ({$sql})";
					} else {
						JArrayHelper::toInteger($cid);
						$query .= " AND i.catid IN(".implode(',', $catId).")";
					}
				} else {
					if ($getChildren) {
						$itemListModel = K2Model::getInstance('Itemlist', 'K2Model');
						$categories = $itemListModel->getCategoryTree($catId);
						$sql = @implode(',', $categories);
						$query .= " AND i.catid IN ({$sql})";
					} else {
						$query .= " AND i.catid=".(int)$catId;
					}
				}
			}
		}
			
		if ($featured == '0') {
			$query .= " AND i.featured != 1";
		}

		if ($featured == '1') {
			$query .= " AND i.featured = 1";
		}

		$this->db->setQuery($query, ($page - 1)*$limit, $limit);
		$items = $this->db->loadObjectList();

		return $items;
	}

	// Get K2 Image Function

	public function getImage($id, $size)
	{
		$result = '';

		switch ($size) {
			case 'xsmall':
				if (JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image".$id).'_XS.jpg')) {
					$result = '<figure><img src="'.JURI::root().'/media/k2/items/cache/'.md5("Image".$id).'_XS.jpg" /></figure>';
				}
				break;

			case 'small':
				if (JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image".$id).'_S.jpg')) {
					$result = '<figure><img src="'.JURI::root().'/media/k2/items/cache/'.md5("Image".$id).'_S.jpg" /></figure>';
				}
				break;

			case 'medium':
				if (JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image".$id).'_M.jpg')) {
					$result = '<figure><img src="'.JURI::root().'/media/k2/items/cache/'.md5("Image".$id).'_M.jpg" /></figure>';
				}
				break;

			case 'large':
				if (JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image".$id).'_L.jpg')) {
					$result = '<figure><img src="'.JURI::root().'/media/k2/items/cache/'.md5("Image".$id).'_L.jpg" /></figure>';
				}
				break;

			case 'xlarge':
				if (JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image".$id).'_XL.jpg')) {
					$result = '<figure><img src="'.JURI::root().'media/k2/items/cache/'.md5("Image".$id).'_XL.jpg" /></figure>';
				}
				break;
		}

		return $result;
	}
}