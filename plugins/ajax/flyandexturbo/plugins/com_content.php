<?php
/**
 * @package   FL Yandex Turbo Plugin
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die;

class FLYandexTurboCoreContent extends FLYandexTurboCore {

	// Get COM_CONTENT Content

	public function getContent($page = 1)
	{	
		$result = array();
		$items 	= $this->getItems($page);
		$image 	= $this->params->get('content_options')->content_add_image;

		if (!empty($items)) {
			foreach ($items as $item) {	
				$date 		   	= new JDate($item->created);
				$item->slug    	= $item->id . ':' . $item->alias;
				$item->catslug 	= $item->catid . ':' . $item->category_alias;
				$item->link 	= JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language), false, $this->ssl);
				$item->image 	= $image ? $this->getImage($item->images) : '';

				$result[] = array(
					'title' 		=> htmlspecialchars($item->title),
					'image'			=> $item->image,
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
		JLoader::register('ContentHelperRoute', JPATH_SITE . '/components/com_content/helpers/route.php');

		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

		$category = 

		$items 			= array();
		$options 		= $this->params->get('content_options');
		$catId 			= isset($options->content_catid) ? $options->content_catid : array();
		$limit 			= isset($options->content_count) ? $options->content_count : 500;

		// Get an instance of the generic articles model
		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

		// Set application parameters in model
		$app       = JFactory::getApplication();
		$appParams = $app->getParams();
		$model->setState('params', $appParams);

		// Set the filters based on the module params
		$model->setState('list.start', ($page - 1)*$limit);
		$model->setState('list.limit', $limit);
		$model->setState('filter.published', 1);

		// Access filter
		$access     = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);

		// Category filter
		$model->setState('filter.category_id', $catId);

		// Filter by language
		$model->setState('filter.language', $app->getLanguageFilter());

		//  Featured switch
		switch ($options->content_show_featured) {
			case '1' :
				$model->setState('filter.featured', 'only');
				break;
			case '0' :
				$model->setState('filter.featured', 'hide');
				break;
			default :
				$model->setState('filter.featured', 'show');
				break;
		}

		// Set ordering
		$ordering = 'a.created';
		$dir      = 'DESC';

		$model->setState('list.ordering', $ordering);
		$model->setState('list.direction', $dir);

		$items = $model->getItems();

		return $items;
	}

	// Get Content Image Function

	public function getImage($string)
	{
		// Get Images From Content
		$image 		= '';
		$json 		= json_decode($string);

		if (!empty($json->image_fulltext)) {
			$image = '<img src="'.JURI::root().$json->image_fulltext.'" alt="'.$this->clearText($json->image_fulltext_alt).'" title="'.$this->clearText($json->image_fulltext_caption).'" />';

			return $image;
		}

		if (!empty($json->image_intro)) {
			$image = '<figure><img src="'.JURI::root().$json->image_intro.'" /><figcaption>'.$this->clearText($json->image_intro_caption).'</figcaption></figure>';

			return $image;
		}


		return; 
	}
}