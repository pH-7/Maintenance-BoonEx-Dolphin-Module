<?php
/**
 * @category         Maintenance module for BoonEx Dolphin.
 *
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2013, Pierre-Henry Soria. All Rights Reserved.
 * @link             http://github.com/pH-7
 * @license          GNU General Public License <http://www.gnu.org/licenses/gpl.html>
 */

bx_import ('BxDolTwigTemplate');

class PhMaintenanceTemplate extends BxDolTwigTemplate
{
    public function __construct($oConfig, $oDb)
    {
        parent::__construct($oConfig, $oDb);
    }
}
