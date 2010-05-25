<?php

class Content {
	
	public function deleteContent($content_id) {
		$content_id = (int) $content_id;
		$database = Zend_Db_Table::getDefaultAdapter ();
		$database->delete('content', "content_id = '$content_id'");
		
		return true;
	}
	
}