<?php
function smarty_function_i18n($params, $template)
{
	return (isset($params['cut']) && $params['cut']) ? preg_replace("/.*_/", '', __($params['var'], $params)) : __($params['var'], $params);
}

if ( ! function_exists('__'))
{
	function __($string, array $values = NULL)
	{
		return null;
	}
}