<?php

class Red_Content {
    public static function getContents($search = null, $sort = null, $user_id = null) {
        $database = Zend_Db_Table::getDefaultAdapter ();
        if($sort == null){
            $sort = 'content_id';
        }
        $contents = $database->select()->from('content_view')
                ->where('title LIKE ?', '%'.$search.'%')
                ->where('user_id LIKE ?', '%'.$user_id.'%')
                ->order($sort.' DESC')
                ->query()->fetchAll();
        return $contents;
    }
    public static function getContent($content_id) {
        $database = Zend_Db_Table::getDefaultAdapter ();

        $content = $database->select()->from('content_view')
                ->where('content_id = ?', $content_id)
                ->query()->fetch();
        return $content;
    }

    public static function getPlus($content_id) {
        $database = Zend_Db_Table::getDefaultAdapter ();

        $plus = $database->select()->from('purchase')
                ->where('content_id = ?', $content_id)
                ->where('positive = ?', TRUE)
                ->query()->fetchAll();
        return $plus;
    }

    public static function getMinus($content_id) {
        $database = Zend_Db_Table::getDefaultAdapter ();

        $minus = $database->select()->from('purchase')
                ->where('content_id = ?', $content_id)
                ->where('positive = ?', FALSE)
                ->query()->fetchAll();
        return $minus;
    }

    public static function getViews($content_id) {
        $database = Zend_Db_Table::getDefaultAdapter ();

        $views = $database->select()->from('purchase')
                ->where('content_id = ?', $content_id)
                ->query()->fetchAll();
        return $views;
    }

    public static function thumbUp($purchase_id, $content_id) {
        $database = Zend_Db_Table::getDefaultAdapter ();
		
        $update = array('positive'=>1);
        $database->update('purchase', $update, "purchase_id = $purchase_id");
        
        $content= Red_Content::getContent($content_id);
        $oldprice = $content['price'];
        
        $update = array('price'=>$oldprice+.10);
        $database->update('content', $update, "content_id = $content_id");
        
        return true;
        
    }
    
    public static function thumbDown($purchase_id, $content_id) {
        $database = Zend_Db_Table::getDefaultAdapter ();
		
        $update = array('positive'=>0);
        $database->update('purchase', $update, "purchase_id = $purchase_id");
        
        $content= Red_Content::getContent($content_id);
        $oldprice = $content['price'];
    	if ($oldprice > 1){
	        $update = array('price'=>$oldprice-.10);
        	$database->update('content', $update, "content_id = $content_id");
        }
        
        return true;
        
    }
    
    public function purchaseContent($user_id, $content_id) {
        $database = Zend_Db_Table::getDefaultAdapter ();
    	
    	$newPurchase = array(
                'user_id' 	=> $user_id,
                'content_id' 	=> $content_id,
        );

        /**
         * Check for duplicate title
         */

        $database->insert('purchase', $newPurchase);

        return $newPurchase;
    	
    }
	
	public static function emailPurchase($user) {
		if(is_array($user)) {
			$mailer = new Zend_Mail();
			$mailer->setBodyText('Test');
			
			$view = new Zend_View();
			$view->setScriptPath( APPLICATION_PATH . '/views/email/user/');
			$view->user = $user;
			
			$mailer->setBodyHtml('This Is A TEST!');
			$mailer->addTo($user['email']);
			$mailer->setSubject('Welcome Sucker');
			$mailer->send();
		}
	}
	
    public function editContent($title, $description, $contentID) {
        $database = Zend_Db_Table::getDefaultAdapter ();

        $update = array('title'=>$title, 'description'=>$description);
        $database->update('content', $update, "content_id = $contentID");
        return true;
    }

    public function addContent($title, $description) {
        $database = Zend_Db_Table::getDefaultAdapter ();

        $newContent = array(
                'title' 	=> $title,
                'description' 	=> $description,
                'user_id'  	=> $_SESSION['user']['user_id'],
                'content_type_id'	=> '1',
                'date_added' 	=> new Zend_Db_Expr ( "NOW()" )
        );

        /**
         * Check for duplicate title
         */
        $content = $database->select()->from( 'content' )->where('title = ?', $title)->query()->fetch();

        if($content) {
                $front = Zend_Controller_Front::getInstance();


                echo "Email Already Exists";
                exit;
        }

        $database->insert('content', $newContent);

        return $newContent;
    }


}
