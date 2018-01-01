# UserCard

UserCard est un plugin MyBB qui vous permettra d'afficher une carte d'utilisateur.

![Image](https://img15.hostingpics.net/pics/658919Screenshot201811DEVSFORUM.png "Example")

## Installation

Pour installer le plugin rien de plus simple.

- Deplacer le fichier ```usercard.php``` vers le dossier ```\inc\plugins\```
- Rendez vous sur la page administration de votre forum.
- Installer le plugin disponible sur le lien suivant ```/admin/index.php?module=config-plugins```
- Rendez vous sur les templates de votre theme.
- Modifiez le template ```Index Page Templates\index``` pour y ajouter le tag ```{$usercard}```

```html
<html>
<head>
<title>{$mybb->settings['bbname']}</title>
{$headerinclude}
<script type="text/javascript">
<!--
	lang.no_new_posts = "{$lang->no_new_posts}";
	lang.click_mark_read = "{$lang->click_mark_read}";
// -->
</script>
</head>
<body>
{$header}
<div class="side" style="float: right; width: 19%">
	{$usercard}
</div>
<div class="forum" style="float: left; width: 80%;">
	{$forums}
</div>
{$boardstats}
{$footer}
</body>
</html>
```

## Theme

Le template du plugin peut être modifier à votre guise. 

- Rendez-vous sur les templates de votre theme.
- Modifier le template ```Global Template\usercard_tpl``` pour y modifier le contenu.

Quelque template:

```html
<table border="0" cellspacing="{$theme['borderwidth']}" cellpadding="{$theme['tablespace']}" class="tborder">
    <tr>
		<td class="thead">
			<b>UserCard</b>
		</td>
	</tr>
	<tr>
        <td class="trow2">
			<div class="author_avatar" style="float: left;">
				<a href="member.php?action=profile&uid={$user['uid']}">
					<img src="./uploads/avatars/avatar_{$user['uid']}.jpg" alt="" width="75px" height="">
				</a>
			</div>
			<div class="author_information" style="float: right; text-align: right;">
				<strong>
					<span class="largetext">{$user['formatted']}</span>
				</strong>
				<span class="smalltext">
					<br /><b>{$user['usertitle']}</b>
					<br />Discussion: <b>{$user['threadnum']}</b>
					<br />Message: <b>{$user['postnum']}</b>
				</span>
			</div>
		</td>
	</tr>
</table>
```

## Configuration

Pour configurer le plugin rendez-vous sur la page d'administration est modifier les parametres du plugin.

La configuration du plugin est simple.

```php
    $settings = [
        "usercard_enabled"         => [
            "title"         => "Enabled",
            "description"   => "If the yes box is checked, the plugin will be activated.",
            "optionscode"   => "yesno",
            "value"         => 1,
            "disporder"     => 1
        ]
    ];
```

