<?php
/**
 * @category         Maintenance module for BoonEx Dolphin.
 *
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2013, Pierre-Henry Soria. All Rights Reserved.
 * @link             http://github.com/pH-7
 * @license          GNU General Public License <http://www.gnu.org/licenses/gpl.html>
 */

bx_import('BxDolModuleDb');

class PhMaintenanceDb extends BxDolModuleDb
{
    const TITLE_COLUMN = 'title', MSG_COLUMN = 'msg';

    public function __construct($oConfig)
    {
        parent::__construct();
        $this->_sPrefix = $oConfig->getDbPrefix() . '_';
    }

    public function getSettingsCategory()
    {
        return $this->getOne("SELECT ID FROM sys_options_cats WHERE name = 'pH7 Maintenance' LIMIT 1");
    }

    public function get($sWhat)
    {
        $this->check($sWhat);

        return $this->getOne('SELECT ' . $sWhat . ' FROM ' . $this->_sPrefix . 'msg WHERE id = 1 LIMIT 1');
    }

    protected function check($sWhat)
    {
        if ($sWhat != self::TITLE_COLUMN && $sWhat != self::MSG_COLUMN) exit;
    }
}
