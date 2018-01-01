<?php

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