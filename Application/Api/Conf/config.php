<?php
return array(
		// 预先加载的标签库
		'TAGLIB_PRE_LOAD'     =>    'OT\\TagLib\\Article,OT\\TagLib\\Think',
		'URL_MODEL' => 2,
		/* 主题设置 */
		'DEFAULT_THEME' =>  'default',  // 默认模板主题名称
		'HTML_CACHE_ON' => true,
		/* 数据缓存设置 */
		'DATA_CACHE_PREFIX' => 'onethink_', // 缓存前缀
		'DATA_CACHE_TYPE'   => 'File', // 数据缓存类型
		'TMPL_ACTION_ERROR'     =>  'Public/error', // 默认错误跳转对应的模板文件
		'TMPL_ACTION_SUCCESS'   =>  'Public/success', // 默认成功跳转对应的模板文件
		'LOG_EXCEPTION_RECORD'  =>  true,    // 是否记录异常信息日志
		'TD_SECRET_KEY'  =>  'da29ew17',    // 加密秘钥
		//本地上传文件驱动配置
		'UPLOAD_LOCAL_CONFIG'=>array(),
		
		/* 模板相关配置 */
		'TMPL_PARSE_STRING' => array(
				'__STATIC__' => __ROOT__ . '/Public/static',
				'__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons',
				'__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
				'__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
				'__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
		),
		
		/* SESSION 和 COOKIE 配置 */
		'SESSION_PREFIX' => 'onethink_home', //session前缀
		'COOKIE_PREFIX'  => 'onethink_home_', // Cookie前缀 避免冲突
);
?>