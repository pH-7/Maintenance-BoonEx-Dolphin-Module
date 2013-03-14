<?php
/**
 * @category         Maintenance module for BoonEx Dolphin.
 *
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2013, Pierre-Henry Soria. All Rights Reserved.
 * @link             http://github.com/pH-7
 * @license          GNU General Public License <http://www.gnu.org/licenses/gpl.html>
 */

bx_import('BxDolTwigModule');

class PhMaintenanceModule extends BxDolTwigModule
{
    private $_sDbTitle, $_sDbMsg;

    public function __construct($aModule)
    {
        parent::__construct($aModule);

        $this->_sDbTitle = $this->_oDb->get(PhMaintenanceDb::TITLE_COLUMN);
        $this->_sDbMsg = $this->_oDb->get(PhMaintenanceDb::MSG_COLUMN);
    }

    public function actionHome()
    {
        $this->_oTemplate->pageStart();

        if ($this->_oDb->getParam('ph_maintenance_enable_custom_text') == 'on')
        {
            $sTitle = $this->_sDbTitle;
            $sMsg = $this->_sDbMsg;
        }
        else
        {
            $sTitle = _t('_ph_maintenance_title');
            $sMsg = MsgBox(_t('_ph_maintenance_msg'));
        }

        $this->setHttpMaintenanceCodes($this->_oDb->getParam('ph_maintenance_delay'));

        echo $this->_oTemplate->parseHtmlByName('maintenance', array('msg' => $sMsg));
        $sFullTitle = $sTitle . ' | ' . $this->_oDb->getParam('site_title');
        $this->_oTemplate->pageCode($sFullTitle, true);
    }

    public function actionAdministration()
    {
        if (!$this->checkIsAdmin()) return; // Stop it

        $this->_oTemplate->pageStart(); // All the code below will be wrapped by the admin design

        $iId = $this->_oDb->getSettingsCategory();
        if (empty($iId))
        {
            // If category is not found
            echo MsgBox(_t('_Empty'));
        }
        else
        {
            bx_import('BxDolAdminSettings');

            //----- Settings -----//
            $mResult = ''; // Default value
            if (isset($_POST['save'], $_POST['cat']))
            {
                $oSettings = new BxDolAdminSettings($iId);
                $mResult = $oSettings->saveChanges($_POST);
            }

            $oSettings = new BxDolAdminSettings($iId);
            $sResult = $oSettings->getForm();

            if ($mResult !== true && !empty($mResult))
                $sResult = $mResult . $sResult;

            echo DesignBoxAdmin(_t('_ph_maintenance'), $sResult);

            //----- Add a custom text -----//
            echo DesignBoxAdmin(_t('_ph_maintenance_form_caption_custom_text'),  $this->getPostForm());
        }

        $this->_oTemplate->pageCodeAdmin(_t('_ph_maintenance'));
    }

    protected function getPostForm()
    {
        $aForm = array(
            'form_attrs' => array(
                'name'     => 'form_maintenance',
                'action'   => '',
                'method'   => 'post',
            ),

            'params' => array(
                'db' => array(
                    'table' => 'ph_maintenance_msg',
                    'key' => 'id',
                    'submit_name' => 'submit_form',
                ),
            ),

            'inputs' => array(
                'title' => array(
                    'type' => 'text',
                    'name' => 'title',
                    'caption' => _t('_ph_maintenance_form_caption_title'),
                    'value' => $this->_sDbTitle,
                    'required' => true,
                    'checker' => array(
                        'func' => 'length',
                        'params' => array(4,150),
                        'error' => _t('_ph_maintenance_form_err_title'),
                    ),
                    'db' => array(
                        'pass' => 'Xss',
                    ),
                ),

                'msg' => array(
                    'type' => 'textarea',
                    'html' => 2,
                    'name' => 'msg',
                    'caption' => _t('_ph_maintenance_form_caption_text'),
                    'value' => $this->_sDbMsg,
                    'required' => true,
                    'html' => 2,
                    'checker' => array(
                        'func' => 'length',
                        'params' => array(10,64000),
                        'error' => _t('_ph_maintenance_form_err_text'),
                    ),
                    'db' => array(
                        'pass' => 'XssHtml',
                    ),
                ),

                'submit' => array(
                    'type' => 'submit',
                    'name' => 'submit_form',
                    'value' => _t('_ph_maintenance_edit'),
                    'colspan' => true,
                ),

            ),
        );

        $oForm = new BxTemplFormView($aForm);
        $oForm->initChecker();
        if ($oForm->isSubmittedAndValid())
        {
            // Update database
            $oForm->update(1);
            $sCode = MsgBox(_t('_ph_maintenance_edited_success'), 3);
        }

        return $sCode . $oForm->getCode();
    }

    /**
     * Check if the admin is logged.
     *
     * @return boolean
     */
    protected function checkIsAdmin()
    {
        if (!$this->isAdmin())
        {
            $this->_oTemplate->displayAccessDenied();
            return false;
        }
        return true;
    }

    protected function setHttpMaintenanceCodes($iDelay)
    {
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        header('Status: 503 Service Temporarily Unavailable');
        header('Retry-After: ' . (int)$iDelay);
    }
}
