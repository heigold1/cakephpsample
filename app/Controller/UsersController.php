<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Users controller:  This is the main application controller for adding/editing/deleting/viewing users.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {
	public $uses = array();

/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function index() 
	{
	    //retrieve all users
    	$this->set('users', $this->User->find('all'));

	}  // end of display function


public function add(){
 
/*echo "inside add<br>";
die(); */

    //check if it is a post request
    //this way, we won't have to do if(!empty($this->request->data))
    if ($this->request->is('post')){
        //save new user
        if ($this->User->save($this->request->data)){
         
            //set flash to user screen
            $this->Session->setFlash('User was added.');
            //redirect to user list
            $this->redirect(array('action' => 'index'));
             
        }else{
            //if save failed
            $this->Session->setFlash('Unable to add user. Please, try again.');
             
        }
    }
} // end of add function


public function edit() {
    //get the id of the user to be edited
    $id = $this->request->params['pass'][0];
     
    //set the user id
    $this->User->id = $id;
     
    //check if a user with this id really exists
    if( $this->User->exists() ){
     
        if( $this->request->is( 'post' ) || $this->request->is( 'put' ) ){
            //save user
            if( $this->User->save( $this->request->data ) ){
             
                //set to user's screen
                $this->Session->setFlash('User was edited.');
                 
                //redirect to user's list
                $this->redirect(array('action' => 'index'));
                 
            }else{
                $this->Session->setFlash('Unable to edit user. Please, try again.');
            }
             
        }else{
         
            //we will read the user data
            //so it will fill up our html form automatically
            $this->request->data = $this->User->read();
        }
         
    }else{
        //if not found, we will tell the user that user does not exist
        $this->Session->setFlash('The user you are trying to edit does not exist.');
        $this->redirect(array('action' => 'index'));
             
        //or, since it we are using php5, we can throw an exception
        //it looks like this
        //throw new NotFoundException('The user you are trying to edit does not exist.');
    }

} // end of edit function

public function delete() {
    $id = $this->request->params['pass'][0];
     
    //the request must be a post request 
    //that's why we use postLink method on our view for deleting user
    if( $this->request->is('get') ){
     
        $this->Session->setFlash('Delete method is not allowed.');
        $this->redirect(array('action' => 'index'));
         
        //since we are using php5, we can also throw an exception like:
        //throw new MethodNotAllowedException();
    }else{
     
        if( !$id ) {
            $this->Session->setFlash('Invalid id for user');
            $this->redirect(array('action'=>'index'));
             
        }else{
            //delete user
            if( $this->User->delete( $id ) ){
                //set to screen
                $this->Session->setFlash('User was deleted.');
                //redirect to users's list
                $this->redirect(array('action'=>'index'));
                 
            }else{  
                //if unable to delete
                $this->Session->setFlash('Unable to delete user.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }
}  // end of delete function

}
