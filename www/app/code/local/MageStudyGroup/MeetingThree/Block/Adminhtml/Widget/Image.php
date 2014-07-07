<?php
/**
 * @category	MageStudyGroup
 * @package		MageStudyGroup_MeetingThree
 */

class MageStudyGroup_MeetingThree_Block_Adminhtml_Widget_Image extends Mage_Adminhtml_Block_Template
{

    /**
     * Add chooser block content to element output.
     *
     * This is not rendered during toHtml(), but is a utility method
     * that is called when the element is rendered in the widget wizard form.
     * This block itself is rendered when the widget elements "Select Images"
     * button is clicked (via ajax).
     *
     * @param Varien_Data_Form_Element_Label $element
     * @return Varien_Data_Form_Element_Label
     * @see Mcd_Meeting03_Adminhtml_Mcd_Meeting03_WidgetController::imageChooserAction()
     */
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        /* @var $element Varien_Data_Form_Element_Label */
        $uniqId = Mage::helper('core')->uniqHash($element->getId());

        $sourceUrl = $this->getUrl('*/mcd_meeting03_widget/imageChooser', array(
            'uniq_id' => $uniqId,
        ));

        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
                ->setElement($element)
                ->setTranslationHelper($this->getTranslationHelper())
                ->setConfig($this->getConfig())
                ->setFieldsetId($this->getFieldsetId())
                ->setSourceUrl($sourceUrl)
                ->setUniqId($uniqId);

        // Set data needed for preview image javascript
        // Need to set it here using getConfig() in order to preserve value
        $chooser->getConfig()->addData(array(
            'image_preview_html_id' => $this->_getImagePreviewHtmlId(),
            'media_dir_url' => Mage::helper('mcd_meeting03')->getWidgetMediaUrl()
        ));

        $value = $element->getValue();
        if ($value) {
            $chooser->setLabel($value);
        }
        $element->setData('after_element_html', $chooser->toHtml() . $this->_getImageThumbHtml($value));
        return $element;
    }

    /**
     * @param string $value
     * @return string
     */
    protected function _getImageThumbHtml($value)
    {
        $html = '';
        if ($value) {
            $html .= sprintf('<img src="%s" height="40"></div>',
                Mage::helper('mcd_meeting03')->getWidgetMediaUrl($value)
            );
        }
        $html = sprintf('<div id="%s">%s</div>', $this->_getImagePreviewHtmlId(), $html);
        return $html;
    }

    protected function _getImagePreviewHtmlId()
    {
        return $this->getFieldsetId() . '_imagePreviewContainer';
    }

    /**
     * Prepare uploader child block and set template
     *
     * @return Mcd_Meeting03_Block_Adminhtml_Widget_Chooser_Image
     */
    protected function _prepareLayout()
    {
        $this->setTemplate('mcd/meeting03/widget/image.phtml');

        $uploader = $this->getLayout()->createBlock('adminhtml/media_uploader')
                ->setTemplate('mcd/meeting03/widget/uploader.phtml');

        $uploader->getConfig()
                ->setUrl(Mage::getModel('adminhtml/url')->addSessionParam()->getUrl('*/mcd_meeting03_widget/imageUpload'))
                ->setFileField('image')
                ->setImagePreviewHtmlId($this->_getImagePreviewHtmlId())
                ->setFilters(array(
            'images' => array(
                'label' => Mage::helper('adminhtml')->__('Images (.gif, .jpg, .png)'),
                'files' => array('*.gif', '*.jpg', '*.jpeg', '*.png')
            )
        ));

        $this->setChild('uploader', $uploader);

        return parent::_prepareLayout();
    }

}