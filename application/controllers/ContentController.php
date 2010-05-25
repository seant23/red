<?php

class ContentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
//

    
    public function indexAction()
    {
    	$vote = Red_User::isLoggedIn();
    	if ($vote) {
    		$this->_helper->redirector('vote', 'content');
    	}
    	
        $database = Zend_Db_Table::getDefaultAdapter ();
        
    	if(isset($_POST['searched'])) {
				$search = $_POST['searched'];
				$sort = $_POST['sort'];
				$this->view->last_search = $search;
				$this->view->last_sort = $sort;
        		$this->view->contents = Red_Content::getContents($search, $sort);
			
		} else {
	        $this->view->contents = Red_Content::getContents();
		}
    }


    public function testAction()
    {
        
    }

    public function itemAction()
    {
    	$vote = Red_User::isLoggedIn();
    	if ($vote) {
    		$this->_helper->redirector('vote', 'content');
    	}
    	
        $content_id = $this->getRequest()->getParam('content_id');

        $this->view->content = Red_Content::getContent($content_id);

        $this->view->user = Red_User::selectProfile($this->view->content['user_id']);
    }

    public function addAction()
    {
    	$vote = Red_User::isLoggedIn();
    	if ($vote) {
    		$this->_helper->redirector('vote', 'content');
    	}
    	
        $form = $this->getAddContentForm('Add Content!');
        

		if($this->getRequest()->isPost()) {
			/**
			 * Form Posted ????
			 */

			if($form->isValid($_POST)) {
				$content = $form->getValues();
                                
				$contentID = Red_Content::addContent($content['title'], $content['description']);
                                if($contentID) {
				$this->_helper->redirector('profile', 'user');
                                }
				
			}
		}

		$this->view->form = $form;
    }

    public function getAddContentForm($submitLabel, $contentTitle = null, $contentDescription = null)
    {
            $database = Zend_Db_Table::getDefaultAdapter ();

            $content = $database->select()->from('content')
                    ->order('content_id DESC')
                    ->query()->fetch();
            $imageName = $content['content_id']+1;

            $form = new Zend_Form();
            $form->setMethod('post');
            if ($submitLabel == 'Add Content!'){
            
            $form->setAttrib('enctype', 'multipart/form-data');

            
            $image = new Zend_Form_Element_File('foo');
   
            $image->setLabel('Upload an image:')
                    ->setDestination('../images');
            $image->addFilter('Rename', array('target'=>$imageName.'.jpg', 'overwrite'=>TRUE));
            $image->addValidator('Count', false, 1);
            $image->addValidator('Extension', false, 'jpg,png,gif');
            $form->addElement($image, 'foo');
            }
            
            $title = $form->createElement('text', 'title');
            $title->setRequired(true);
            $title->setValue($contentTitle);
            $title->setLabel('Title');
            $form->addElement($title);

            $description = $form->createElement('textarea', 'description', array('rows'=>10));
            $description->setRequired(true);
            $description->setValue($contentDescription);
            $description->setLabel('Description');
            $form->addElement($description);
            $form->addElement('submit', 'submit', array('label'=>$submitLabel));

            return $form;
    }

    public function editAction()
    {
        $contentID = $this->getRequest()->getParam('content');
        $content = Red_Content::getContent($contentID);
        $form = $this->getAddContentForm( 'Edit This Content!', $content['title'], $content['description']);
				

		if($this->getRequest()->isPost()) {
			/**
			 * Form Posted ????
			 */

			if($form->isValid($_POST)) {
				$content = $form->getValues();
                                
				$contentID = Red_Content::editContent($content['title'], $content['description'], $contentID);
                                if($contentID) {
				$this->_helper->redirector('profile', 'user');
                                }

			}
		}

		$this->view->form = $form;
    }
    
    public function thumbupAction()
    {
    	$purchase_id = $this->getRequest()->getParam('purchase');
    	$content_id = $this->getRequest()->getParam('content');
    	Red_Content::thumbUp($purchase_id, $content_id);
    	$this->_helper->redirector('index', 'content');
    }
    
    public function thumbdownAction()
    {
    	$purchase_id = $this->getRequest()->getParam('purchase');
    	$content_id = $this->getRequest()->getParam('content');
    	Red_Content::thumbDown($purchase_id, $content_id);
    	$this->_helper->redirector('index', 'content');
    }

	public function voteAction() 
	{
		$purchase = Red_User::getNeedsVote($_SESSION['user']['user_id']);
			foreach ($purchase as $check) {
				if ($check['positive'] == ''){
					$this->view->vote = Red_Content::getContent($check['content_id']);
					$this->view->purchase_id = $check['purchase_id'];
				}
			}
	}

}

