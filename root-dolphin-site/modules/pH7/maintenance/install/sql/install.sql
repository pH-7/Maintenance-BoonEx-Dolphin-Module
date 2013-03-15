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

CREATE TABLE [db_prefix]_msg (
    id tinyint(1) unsigned NOT NULL,
    title VARCHAR(150) NOT NULL,
    msg TEXT NOT NULL,
    PRIMARY KEY (id)
);

-- sample data
INSERT INTO [db_prefix]_msg VALUES (1, 'We\'ll be back soon!', '<p style="font-weight:bold; font-size:14px; text-align:center">Whoops! Website is currently down for maintenance!</p>
<p style="text-align:center"><em>Please check back later</em> <img src="./modules/pH7/maintenance/templates/base/images/demo/smile.gif" alt="Smile" /></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="text-align:center"><img src="./modules/pH7/maintenance/templates/base/images/demo/under_construction_animated.gif" alt="Under Construction" /></p>');

-- admin menu
SET @iMax = (SELECT MAX(`order`) FROM sys_menu_admin WHERE parent_id = 2);
INSERT IGNORE INTO sys_menu_admin (parent_id, name, title, url, description, icon, `order`) VALUES
(2, '[db_prefix]', '_ph_maintenance', '{siteUrl}modules/?r=maintenance/administration/settings', 'pH7 Maintenance','modules/pH7/maintenance/|maintenance.png', @iMax+1);

-- permalink
INSERT INTO sys_permalinks(standard, permalink, `check`) VALUES('modules/?r=maintenance/', 'm/maintenance/', '[db_prefix]_permalinks');

-- settings
SET @iMaxOrder = (SELECT menu_order + 1 FROM sys_options_cats ORDER BY menu_order DESC LIMIT 1);
INSERT INTO sys_options_cats (name, menu_order) VALUES ('pH7 Maintenance', @iMaxOrder);

SET @iCategId = (SELECT LAST_INSERT_ID());

INSERT INTO sys_options (Name, VALUE, kateg, `desc`, Type, `check`, err_text, order_in_kateg, AvailableValues) VALUES
('[db_prefix]_permalinks', 'on', 26, 'Enable friendly permalinks for maintenance', 'checkbox', '', '', 0, ''),
('[db_prefix]_enable', '', @iCategId, 'Enabled Maintenance mode', 'checkbox', '', '', 1, ''),
('[db_prefix]_enable_custom_text', 'on', @iCategId, 'Use custom text', 'checkbox', '', '', 2, ''),
('[db_prefix]_delay', 3600, @iCategId, 'The estimated time that the site is down for maintenance (in seconds)', 'digit', '', '', 3, '');
