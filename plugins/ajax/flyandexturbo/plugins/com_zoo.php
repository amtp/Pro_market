<?php
/**
 * @package   FL Yandex Turbo Plugin
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die;

class FLYandexTurboCoreZoo extends FLYandexTurboCore {

	// Get COM_ZOO Content

	public function getContent($page = 1)
	{
		// make sure ZOO exist
		jimport('joomla.filesystem.file');
		if (!JFile::exists(JPATH_ADMINISTRATOR.'/components/com_zoo/config.php')
				|| !JComponentHelper::getComponent('com_zoo', true)->enabled) {
			return;
		}

		// load zoo config
		require_once (JPATH_ADMINISTRATOR.'/components/com_zoo/config.php');

		// check if Zoo > 2.4 is loaded
		if (!class_exists('App')) {
			return;
		}

		// get the ZOO App instance
		$zoo = App::getInstance('zoo');

		// register plugin path
		if ($path = $zoo->path->path('root:plugins/ajax/flyandexturbo/')) {
			$zoo->path->register($path, 'flyandexturbo');
		}

		$result 	= array();
		$image 		= $this->params->get('zoo_options')->zoo_add_image;
		$items 		= $this->getItems($page);

		// $this->params->set('order', array('_itemcreated', '_reversed'));

		if (!empty($items)) {
			foreach ($items as $key => $item) {
				$renderer = $zoo->renderer->create('item');
				$date 	  = new JDate($item->created);

				$renderer->addPath(array($zoo->path->path('component.site:'), dirname(dirname(__FILE__))));
				$renderer->checkPositions('item.default', $item);

				$content = $renderer->renderPosition('content');

				if (!empty($content)) {
					$content = $this->prepareContent($renderer->renderPosition('content'));
				}

				$result[] = array(
					'title' 		=> htmlspecialchars($item->name),
					'image' 		=> $image ? $this->getImage($renderer->getPositionElements('image')) : '',
					'link' 			=> JRoute::_($zoo->route->item($item, false), false, $this->ssl),
					'date' 			=> $date->toRFC822(true),
					'author' 		=> $this->getAuthor($item->created_by),
					'content' 		=> $content,
					'related'		=> array()
				);
			}
		}

		return $result;
	}

	// Get Zoo Items

	public function getItems($page = 1)
	{	
		$zoo 			= App::getInstance('zoo');
		$options 		= $this->params->get('zoo_options');
		$order 			= 'created DESC';
		$applications 	= isset($options->zoo_apps) ? $options->zoo_apps : array();
		$types 			= isset($options->zoo_types) ? $options->zoo_types : array();
		$limit 			= isset($options->zoo_count) ? (int) $options->zoo_count : 500;
		$offset 		= ($page - 1)*$limit;
		$conditions     = array();

		if ($applications) {
			$conditions[] = "application_id IN (".implode(',', $applications).")";
		}

		if ($types) {
			$conditions[] = "type IN ('".implode('\',\'', $types)."')";
		}

		if (!empty($conditions)) {
			$conditions = implode(' AND ', $conditions);
		}

        $result = $zoo->table->item->all(compact('conditions', 'order', 'limit', 'offset'));

        return $result;
	}

	// Get Images From Content

	public function getImage($elements = array())
	{	
		$image = array();

		if (!empty($elements)) {
			$element 	= $elements[0];
			$title 		= $this->clearText($element->getItem()->name);
			$imageData	= $element->data();

            if ($element->config->type == 'image') {
                $image = array(
					'src' 	=> $this->clearText(JURI::root() . str_replace('\\', '/', $imageData['file'])),
					'title' => $imageData['title'] ? $this->clearText($$imageData['title']) : $title,
				);
            }

            if ($element->config->type == 'jbimage' || $element->config->type == 'jbgalleryimage') {
            	$row = $imageData[0];
               
                if (isset($row['file']) && $row['file']) {

                    $image = array(
						'src' 	=> $this->clearText(JURI::root() . str_replace('\\', '/', $row['file'])),
						'title' => (isset($row['title']) && !empty($row['title'])) ? $this->clearText($row['title']) : $title,
					);
                }
            }

            if ($element->config->type == 'jbgallery') {
            	$path = JPATH_ROOT . '/' . trim($element->config->directory, '/'). '/' . trim($imageData['value'], '/');

            	$files = JFolder::files($path, '.', false, true, array('.svn', 'CVS', '.DS_Store'));
		        $files = array_filter(
		            $files, create_function('$file', 'return preg_match("#(\.bmp|\.gif|\.jpg|\.jpeg|\.png)$#i", $file);')
		        );

		        $file = $files[0];

                $image = array(
					'src' 	=> JURI::root().$this->getImageRelativeUrl($file),
					'title' => $title,
				);
        	}

            if (!empty($image)) {
            	return '<figure><img src="'.$image['src'].'" /><figcaption>'.$image['title'].'</figcaption></figure>'; 
            }
		}

		return; 
	}
}