--
--
-- Title:         Maintenance module for BoonEx Dolphin.
--
-- Author:        Pierre-Henry Soria <ph7software@gmail.com>
-- Copyright:     (c) 2013, Pierre-Henry Soria. All Rights Reserved.
-- Link:          http://github.com/pH-7
-- License:       GNU General Public License <http://www.gnu.org/licenses/gpl.html>
--
--

DROP TABLE ph_maintenance_msg;

-- settings
SET @iCategId = (SELECT ID FROM sys_options_cats WHERE name = 'pH7 Maintenance' LIMIT 1);
DELETE FROM sys_options WHERE kateg = @iCategId;
DELETE FROM sys_options_cats WHERE ID = @iCategId;
DELETE FROM sys_options WHERE Name = '[db_prefix]_permalinks';

-- permalinks
DELETE FROM sys_permalinks WHERE `check` = '[db_prefix]_permalinks';

-- admin menu
DELETE FROM sys_menu_admin WHERE name = '[db_prefix]';
