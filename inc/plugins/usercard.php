<?php

if (!defined("IN_MYBB"))
{
    die("Direct initialization of this file is not allowed.");
}

global $mybb;

if ($mybb->settings["usercard_enabled"] == 1)
{
    $plugins->add_hook("index_start", "usercard_index_start");
}

/**
 * @function Return plugin information
 * @return array
 */
function usercard_info()
{
    return [
        "name"          => "UserCard",
        "description"   => "Display user card.",
        "author"        => "volca780",
        "authorsite"    => "https://github.com/volca780",
        "version"       => "1.0",
        "compatibility" => "18*"
    ];
}

/**
 * @function Plugin installation
 * @return mixed
 */
function usercard_install()
{
    global $db;

    $gid = $db->insert_query("settinggroups", [
        "name"          => "usercard_sg",
        "title"         => "UserCard",
        "description"   => "Configuration of UserCard",
        "disporder"     => 1,
        "isdefault"     => 0
    ]);

    $settings = [
        "usercard_enabled"         => [
            "title"         => "Enabled",
            "description"   => "If the yes box is checked, the plugin will be activated.",
            "optionscode"   => "yesno",
            "value"         => 1,
            "disporder"     => 1
        ]
    ];

    foreach ($settings as $name => $setting) {
        $setting["name"]    = $name;
        $setting["gid"]     = $gid;

        $db->insert_query("settings", $setting);
    }

    $templates = [
        "usercard_tpl"  => [
            "template"  => $db->escape_string('
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
    <tr>
		<td class="thead">
			<b>UserCard</b>
		</td>
	</tr>
	<tr>
        <td class="trow2">
			<div class="author_avatar" style="float: left;">
				<a href="member.php?action=profile&uid={$user[\'uid\']}">
					<img src="./uploads/avatars/avatar_{$user[\'uid\']}.jpg" alt="" width="75px" height="">
				</a>
			</div>
			<div class="author_information" style="float: right; text-align: right;">
				<strong>
					<span class="largetext">{$user[\'formatted\']}</span>
				</strong>
				<span class="smalltext">
					<br /><b>{$user[\'usertitle\']}</b>
					<br />Discussion: <b>{$user[\'threadnum\']}</b>
					<br />Message: <b>{$user[\'postnum\']}</b>
				</span>
			</div>
		</td>
	</tr>
</table>
            ')
        ]
    ];

    foreach ($templates as $title => $template) {
        $template["title"]      = $title;
        $template["dateline"]   = time();
        $template["sid"]        = "-1";
        $template["version"]    = "";

        $db->insert_query("templates", $template);
    }

    rebuild_settings();
}


/**
 * @function Plugin is installed
 * @return bool
 */
function usercard_is_installed()
{
    global $mybb;

    return isset($mybb->settings['usercard_enabled']);
}

/**
 * @function Plugin uninstall
 * @return mixed
 */
function usercard_uninstall()
{
    global $db;

    $db->delete_query("settinggroups", "name=\"usercard_sg\"");
    $db->delete_query("settings", "name LIKE \"usercard_%\"");

    rebuild_settings();
}

function usercard_index_start()
{
    global $templates, $theme, $mybb, $usercard;

    $user = $mybb->user;

    $user["formatted"] = format_name(
        htmlspecialchars_uni($user['username']),
        $user['usergroup'],
        $user['displaygroup']
    );

    $usercard = $templates->get("usercard_tpl");

    eval('$usercard  = "' . $usercard . '";');
}