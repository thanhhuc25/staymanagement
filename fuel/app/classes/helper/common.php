<?php
/**
 * STAY MANAGER
 *
 * @package    STAY MANAGER
 * @version    1.0
 * @author     Konfactory
 * @license    MIT License
 * @copyright  (c) 2016 Konfactory
 */

/**
 * 共通関数ヘルパー
 *
 * @category Helper
 */
class Helper_Common
{
	/*
	 * GRIDSサイトURL 外国語パス取得
	 */
	public static function grids_lang($lang, $dir=true)
	{
		switch ($lang)
		{
			case 'ja':
				$lang = 'jp';
				if ($dir) {
					$lang .= '/';
				}
				break;
			case 'en':
				if ($dir) {
					$lang = '';
				} else {
					$lang = 'index';
				}
				break;
			case 'ko':
				$lang = 'ko';
				if ($dir) {
					$lang .= '/';
				}
				break;
			case 'zh-tw':
				$lang = 'ct';
				if ($dir) {
					$lang .= '/';
				}
				break;
			case 'zh-cn':
				$lang = 'cs';
				if ($dir) {
					$lang .= '/';
				}
				break;
		}

		return $lang;
	}
}
