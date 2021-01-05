<?php
/**
 * @package RSForm! Pro
 * @copyright (C) 2007-2015 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die('Restricted access');
require_once JPATH_ADMINISTRATOR . '/components/com_rsform/helpers/field.php';
require_once JPATH_ADMINISTRATOR . '/components/fwork/picture.php';

class RSFormProFieldFileUpload extends RSFormProField
{
    // backend preview
    public function getPreviewInput()
    {

        $caption = $this->getProperty('CAPTION', '');
        $isimg = $this->getIsImage();
        $htmld = '';
        if ($isimg == '1') {
            $htmld .= '<div class="s516-galery" style="width: max-content;background-color: #ffffff00;"> <div class="glry-image" style="width: 130px;">
				         <div class="b-image">
				        <img class="b-image__image" style="object-fit: fill;" alt="" src="/media/com_rsform/images/glrydemo.jpg"  id="imglpstgallerylst_00"></div>
				        </div>
			            </div>';
        }
        $html = '<td>' . $caption . '</td><td>' . $htmld . '<input type="file" /></td>';
        return $html;
    }

    // functions used for rendering in front view
    public function getFormInput()
    {
        $name = $this->getName();
        $id = $this->getId();
        $attr = $this->getAttributes();
        $isimg = $this->getIsImage();
        $type = 'file';
        $additional = '';

        // MAX_FILE_SIZE is no longer used, didn't provide anything useful
        $html = '';
        // Start building the HTML input
        if ($isimg == '1') {
            $value = (array)$this->getValue();
            $valt = $this->getValue();

            if (count($value) > 0) {
                $perarr = $value[0];
                if (is_array($perarr)) {
                    $img = DIRECTORY_SEPARATOR . substr($value[0][0], 0, 2) . DIRECTORY_SEPARATOR . $value[0][0];
                    $image_intro = "/orgimg/logo" . $img;
                } else {
                    $value = $this->getValue();
                    $image_intro = $value;
                }

            } else {
                $image_intro = '/citytmpl/images/none_img.png';
            }


            $html .= '<div class="s516-galery" style="width: max-content;background-color: #ffffff00;"> <div class="glry-image" style="width: 130px;">
				         <div class="b-image">
				        <img class="b-image__image" style="object-fit: fill;" alt="" src="' . $image_intro . '"  id="' . $this->escape($id) . '"></div>
				        </div>
			            </div>';

        }


        $html .= '<input';
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
        // Set the type
        $html .= ' type="' . $this->escape($type) . '"';
        if ($isimg == '1')
            $html .= ' accept="image/jpeg,image/png,image/gif"';

        // Name & id
        $html .= ' name="' . $this->escape($name) . '"' .
            ' id="' . $this->escape($id) . '"';
        // Additional HTML
        $html .= $additional;
        // Close the tag
        $html .= ' />';


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
        $isglry = false;
        if (!isset($files[$this->name])) {
            return false;
        }


        global $database;


        $actualFile = $files[$this->name];
        if ($actualFile['error'] != UPLOAD_ERR_OK) {
            return false;
        }

        $prefixProperty = $this->getProperty('PREFIX', '');
        $destination = $this->getProperty('DESTINATION', '');
        $isimg = $this->getIsImage();
        // Prefix
        $prefix = uniqid('') . '-';
        if (strlen(trim($prefixProperty)) > 0) {
            $prefix = RSFormProHelper::isCode($prefixProperty);
        }

        // Path
        $realpath = realpath($destination . DIRECTORY_SEPARATOR);
        if (substr($realpath, -1) != DIRECTORY_SEPARATOR) {
            $realpath .= DIRECTORY_SEPARATOR;
        }
        $ext = mb_strtolower(pathinfo($actualFile['name'], PATHINFO_EXTENSION));


        // Filename
        if ($prefix == "md5") {
            $newname = md5($actualFile['name']);
            $realpath = $realpath . substr($newname, 0, 2) . DIRECTORY_SEPARATOR;
            $file = $realpath . $newname . $ext;
            $dfilename = $newname . $ext;
        } else {
            $file = $realpath . $prefix . $actualFile['name'];
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

        if ($isimg == '1') {
            $new_image = new picture($actualFile['tmp_name'], $ext);
            $new_image->autoimageresize(400, 400);
            $new_image->imagesave(true, $realpath, 90,  $newname);
            $new_image->imageout();
            $ztype = $new_image->typerimage();
            $dfilename = $newname . '.' . $ztype;


            eval($ScriptProcessFile);


            JFactory::getApplication()->triggerEvent('rsfp_f_onAfterFileUpload', array(array('formId' => $this->formId, 'fieldname' => $this->name, 'file' => $file, 'name' => $dfilename)));

            //  $database->insert("object_file", ["object" =>"object_company_images","object_guid" =>$catid,"filename" =>$dfilename]);
        } else {
            // Upload File
            if (JFile::upload($actualFile['tmp_name'], $file, false, (bool)RSFormProHelper::getConfig('allow_unsafe'))) {
                eval($ScriptProcessFile);
                //Trigger Event - onBeforeStoreSubmissions
                JFactory::getApplication()->triggerEvent('rsfp_f_onAfterFileUpload', array(array('formId' => $this->formId, 'fieldname' => $this->name, 'file' => $file, 'name' => $prefix . $actualFile['name'])));
                if ($prefix != "md5") {
                    $db = JFactory::getDbo();
                    // Add to db (submission value)
                    $query = $db->getQuery(true)
                        ->insert($db->qn('#__rsform_submission_values'))
                        ->set($db->qn('SubmissionId') . ' = ' . $db->q($submissionId))
                        ->set($db->qn('FormId') . ' = ' . $db->q($this->formId))
                        ->set($db->qn('FieldName') . ' = ' . $db->q($this->name))
                        ->set($db->qn('FieldValue') . ' = ' . $db->q($file));

                    $db->setQuery($query)
                        ->execute();
                }

            }
        }

    }
}