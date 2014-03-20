#
#<?php die("Forbidden."); ?>

2014-03-11 00:45:43 ERROR vmError: exeSortSearchListQuery Table 'alevel_shop.alevel_virtuemart_categories_zh_tw' doesn't exist SQL=SELECT  c.`virtuemart_category_id`, l.`category_description`, l.`category_name`, c.`ordering`, c.`published`, cx.`category_child_id`, cx.`category_parent_id`, c.`shared`  FROM `alevel_virtuemart_categories_zh_tw` l
				  JOIN `alevel_virtuemart_categories` AS c using (`virtuemart_category_id`)
				  LEFT JOIN `alevel_virtuemart_category_categories` AS cx
				  ON l.`virtuemart_category_id` = cx.`category_child_id`  WHERE  cx.`category_parent_id` = 0 ORDER BY category_name DESC
2014-03-11 00:55:51 ERROR vmError: exeSortSearchListQuery Table 'alevel_shop.alevel_virtuemart_categories_zh_tw' doesn't exist SQL=SELECT  c.`virtuemart_category_id`, l.`category_description`, l.`category_name`, c.`ordering`, c.`published`, cx.`category_child_id`, cx.`category_parent_id`, c.`shared`  FROM `alevel_virtuemart_categories_zh_tw` l
				  JOIN `alevel_virtuemart_categories` AS c using (`virtuemart_category_id`)
				  LEFT JOIN `alevel_virtuemart_category_categories` AS cx
				  ON l.`virtuemart_category_id` = cx.`category_child_id`  WHERE  cx.`category_parent_id` = 0 ORDER BY category_name DESC
2014-03-11 01:18:07 ERROR vmError: VmTableData SEF別名 記錄是不存在的! 沒有 SEF別名 將無法儲存記錄。
2014-03-11 01:24:22 ERROR vmError: TableStates (2) 州碼 記錄是不存在的! 沒有 (2) 州碼 將無法儲存記錄。
2014-03-11 01:24:22 ERROR vmError: VirtueMartModelState::store TableStates (2) 州碼 記錄是不存在的! 沒有 (2) 州碼 將無法儲存記錄。
2014-03-11 01:28:28 ERROR vmError: TableStates 給定的 州名稱 是空的。此欄位是必要的，請輸入您的資料和再次儲存。
2014-03-11 01:28:28 ERROR vmError: VirtueMartModelState::store TableStates 給定的 州名稱 是空的。此欄位是必要的，請輸入您的資料和再次儲存。
2014-03-11 01:28:49 ERROR vmError: TableStates (2) 州碼 記錄是不存在的! 沒有 (2) 州碼 將無法儲存記錄。
2014-03-11 01:28:49 ERROR vmError: VirtueMartModelState::store TableStates (2) 州碼 記錄是不存在的! 沒有 (2) 州碼 將無法儲存記錄。
2014-03-12 07:02:38 ERROR vmError: VmTableData SEF別名 記錄是不存在的! 沒有 SEF別名 將無法儲存記錄。
2014-03-12 09:59:11 ERROR vmError: For correct net price calculation you must update order items table. Use the button on top of the site.
2014-03-13 18:36:04 ERROR vmError: 在欄位值中的標題包含無效字元