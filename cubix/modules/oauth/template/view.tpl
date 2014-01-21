{php}
$this->assign("left_menu", $left_menu);

$js_url = $this->_tpl_vars['js_url'];
$theme_js_url = $this->_tpl_vars['theme_js_url'];
$css_url = $this->_tpl_vars['css_url'];

Openbiz\Openbiz::$app->getClientProxy()->includeCalendarScripts();
Openbiz\Openbiz::$app->getClientProxy()->includeCKEditorScripts();
$includedScripts = Openbiz\Openbiz::$app->getClientProxy()->getAppendedScripts();
$includedScripts .= "
<script type=\"text/javascript\" src=\"$js_url/cookies.js\"></script>
<script type=\"text/javascript\" src=\"$js_url/general_ui.js\"></script>
";
if (OPENBIZ_JSLIB_BASE!='JQUERY') {
	$includedScripts .= "
	<script src=\"".OPENBIZ_JS_URL."/jquery.js\"></script>
	<script>try{var \$j=jQuery.noConflict();}catch(e){}</script>
	<script src=\"".OPENBIZ_JS_URL."/jquery-ui-1.8.12.custom.min.js\"></script>
	";
}
$this->_tpl_vars['scripts'] = $includedScripts;

$appendStyle = Openbiz\Openbiz::$app->getClientProxy()->getAppendedStyles();
$appendStyle .= "\n"."
<link rel=\"stylesheet\" href=\"$css_url/general.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_backend.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_menu_icons.css\" type=\"text/css\" />
";
$this->_tpl_vars['style_sheets'] = $appendStyle;

$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}
