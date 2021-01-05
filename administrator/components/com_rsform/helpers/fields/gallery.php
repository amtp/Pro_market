<?php
/**
 * @package RSForm! Pro
 * @copyright (C) 2007-2015 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die('Restricted access');
require_once JPATH_ADMINISTRATOR . '/components/com_rsform/helpers/field.php';
require_once JPATH_ADMINISTRATOR . '/components/fwork/picture.php';

class RSFormProFieldGallery extends RSFormProField
{
// backend preview
    public function getPreviewInput()
    {
        $value = (string)$this->getProperty('DEFAULTVALUE', '');
        $caption = $this->getProperty('CAPTION', '');
        $html = '<td>' . $caption . '</td><td>';

        $html .= '<div class="s516-galery">
<div class="bm-scroll">
	<span id="stackimg">   
		<span class="bm-scroll__item" id="imgl1">
			<div class="glry-image">
				<div class="b-image">
				<img class="b-image__image" alt="" src="/media/com_rsform/images/glrydemo.jpg"></div>
				<div class="plupload_file_action" onclick="delimg(4)" title="Удалить изоброжение">
				<div class="fa fa-window-close plupload_action_icon ui-icon ui-icon-circle-minus"> </div></div>
			</div>
		</span>
	</span>
   <a class="b-add-block-m bm-scroll__item" id="upload_link" href="" title="Выбрать изоброжение">
        <div class="glry-image with-text-link">
            <div class="b-add-block">
                <div class="b-add-blockbt">
                   <img class="b-image__image" alt="" src="/citytmpl/images/add_plus.png">                 
                </div>
            </div>
        </div>
    </a>  
    </div></div>';
        $html .= '</td>';
        return $html;
    }

// functions used for rendering in front view
    public function getFormInput()
    {
        $jdocument = JFactory::getDocument();
        $name = $this->getName();
        $value = (array)$this->getValue();
        $id = $this->getId();
        $attr = $this->getAttributes();
        $type = 'file';
        $additional = '';

// MAX_FILE_SIZE is no longer used, didn't provide anything useful

// Start building the HTML input
        $html = '<input';
// Parse Additional Attributes
        if ($attr) {
            foreach ($attr as $key => $values) {
                // @new feature - Some HTML attributes (type) can be overwritten
                // directly from the Additional Attributes area
                if ($key == 'type' && strlen($values)) {
                    ${$key} = $values;
                    continue;
                }
                $additional .= $this->attributeToHtml($key, $values);
            }
        }

        $uniid = $this->escape($id) . '_' . $jdocument->getScriptOptionsCount('glrys_id');
// Set the type

        $html .= ' type="' . $this->escape($type) . '"';
        $html .= ' accept="image/jpeg,image/png,image/gif"';
        $html .= ' style="' . $this->escape("display:none") . '"';
// Name & id
        $html .= ' name="' . $this->escape($name) . '[]"';
        $html .= ' glrdat="' . $uniid . '"';
        $html .= ' id="' . $this->escape($id) . '"';
// Additional HTML
        $html .= $additional;
// Close the tag
        $html .= ' />';


        $galleryhtml = "";

        $dopimgcount = count($value);
        $destination = $this->getProperty('DESTINATION', '');
        if (substr($destination, -1) != DIRECTORY_SEPARATOR) {
            $destination .= DIRECTORY_SEPARATOR;
        }
        $i = 0;
        if ($dopimgcount > 0) {
            foreach ($value as $data) {

                $imgm =$destination  . substr($data[0], 0, 2) . DIRECTORY_SEPARATOR . $data[0];
                $galleryhtml .= '<span class="bm-scroll__item" id="imgl' . $uniid . $data[0] . '" >
			             <div class="glry-image">
				         <div class="b-image">
				        <img class="b-image__image" alt="" src="' . $imgm . '" id="imglpst' . $uniid . $data[0] . '"></div>
				        <div class="plupload_file_action" onclick="delimg(\'' . $uniid . '\',\'' . $data[0] . '\')" title="Удалить изоброжение">
				        <div class="fa fa-window-close plupload_action_icon ui-icon ui-icon-circle-minus"  > </div></div>
			            </div>
		                </span>';

                $i++;
            }
        }


        $html .= '<div class="s516-galery" style="max-width: 560px;">
<div class="bm-scroll">
	<span id="stkim_' . $uniid . '"  class="bliglr' . $uniid . '" data-identy="' . $uniid . '">   
		' . $galleryhtml . '
	</span>
   <a class="b-add-block-m bm-scroll__item" id="uplnk_' . $uniid . '" href="" title="Выбрать изоброжение">
        <div class="glry-image with-text-link">
            <div class="b-add-block">
                <div class="b-add-blockbt">
                <div class="floatingBarsG" id="ldr_' . $uniid . '" style="display: none;">
	            <span>Загрузка..</span>
                </div>
                   <img class="b-image__image" alt="" src="citytmpl/images/add_plus.png">                 
                </div>
            </div>
        </div>
    </a>  
    </div></div>';
//
        $jdocument->addScriptOptions('glrys_id', $uniid, false, true);
        return $html;
    }

// @desc All upload fields should have a 'rsform-upload-box' class for easy styling
    public function getAttributes()
    {
        $attr = parent::getAttributes();
        if (strlen($attr['class'])) {
            $attr['class'] .= ' ';
        }
        $attr['class'] .= 'rsform-upload-box';

        return $attr;
    }

// process the upload file after form validation
    public function processBeforeStore($submissionId, &$post, &$files, $ScriptProcessFile)
    {
        $isglry = true;
        $filesb = JFactory::getApplication()->input->files->get('form', null, 'raw');
        if ($filesb['gallerylst'] == null) {
            return false;
        }
        if (!isset($filesb['gallerylst'])) {
            return false;
        }


        $filesd = JFactory::getApplication()->input->files->get('form', null, 'raw');
        if ($filesd['firm_price'] != null) {
            if (isset($filesd['firm_price'])) {

            }
        }

        $dfilename = "";
        $tfiles = $filesb['gallerylst'];
        global $database;

        $prefixProperty = $this->getProperty('PREFIX', '');
        $destination = $this->getProperty('DESTINATION', '');
        $realpath = realpath($destination . DIRECTORY_SEPARATOR);
        if (substr($realpath, -1) != DIRECTORY_SEPARATOR) {
            $realpath .= DIRECTORY_SEPARATOR;
        }

        foreach ($tfiles as $ofile) {

            $prefix = uniqid('') . '-';
            if (strlen(trim($prefixProperty)) > 0) {
                $prefix = RSFormProHelper::isCode($prefixProperty);
            }
// file name patch
            $ext =  mb_strtolower(pathinfo($ofile['name'], PATHINFO_EXTENSION));


            if ($prefix != "md5") {
                $newname = $prefix . pathinfo($ofile['name'], PATHINFO_FILENAME);
            } else {
                if ($ofile['size'] != 3) {
                    $newname = md5($ofile['name']);
                } else {
                    $newname = $ofile['name'];
                }

                $realpath = $realpath . substr($newname, 0, 2) . DIRECTORY_SEPARATOR;
            }


// на загрузку если не равно 3 кб
            if ($ofile['size'] != 3) {
                $isdel = false;
                if ($ofile['error'] != UPLOAD_ERR_OK) {
                    continue;
                }

                jimport('joomla.filesystem.file');
                $pathfor_creat = mb_substr($realpath, 0, -1);
                if (!is_dir($pathfor_creat)) {
                    if (JFolder::create($pathfor_creat)) {
                        if (!file_exists($pathfor_creat . '/index.html')) {
                            $datca = "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>";
                            JFile::write($pathfor_creat . '/index.html', $datca);
                        }
                    }
                }
                //   $db3 = JFactory::getDboC();
                //   $db3->setQuery("UPDATE [log_yii] SET [prefix]=N'" . $output . "' , [message]=N'" . $this->name . "15' WHERE  [id] = N'2'")->execute();

// Upload File
                $new_image = new picture($ofile['tmp_name'],$ext);
                $new_image->autoimageresize(400, 400);
                $new_image->imagesave(true, $realpath, 90, $newname);
                $new_image->imageout();
                $ztype = $new_image->typerimage();
                $dfilename = $newname . '.' . $ztype;

                eval($ScriptProcessFile);
                JFactory::getApplication()->triggerEvent('rsfp_f_onAfterFileUpload', array(array('formId' => $this->formId, 'fieldname' => $this->name, 'file' => $dfilename, 'name' => $dfilename, 'isdel' => '0')));
            } else {
                $isdel = true;
                if (JFile::delete($realpath . $newname)) {
                    eval($ScriptProcessFile);
                    JFactory::getApplication()->triggerEvent('rsfp_f_onAfterFileUpload', array(array('formId' => $this->formId, 'fieldname' => $this->name, 'file' => $dfilename, 'name' => $dfilename, 'isdel' => '1')));
                }
            }
        }


    }

}