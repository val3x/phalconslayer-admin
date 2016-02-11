<?php
namespace Daison\Admin\App\Controllers;

use Components\Model\User;

class UserController extends Controller
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setVar('left_navigation', 'userLists');

        $this->view->setVar(
            'is_pjax',
            request()->getHeader('X-PJAX') ? true : false
        );
    }

    public function listsAction()
    {
        $users = User::find();

        return view('user.lists')
               ->withUsers($users);
    }

    private function _getUser($id)
    {
        $user = User::findFirst($id);

        if ( $user === false ) {
            return redirect(route('daison_showUsers'))
                   ->withError("User id [$id] not found.");
        }

        return $user;
    }

    public function viewAction($id)
    {
        if ( request()->getHeader('X-PJAX') ) {
            $is_pjax = true;
        }

        return view('user.view')->withTargetUser($this->_getUser($id));
    }

    public function editAction($id)
    {
        return view('user.edit')->withTargetUser($this->_getUser($id));
    }

    public function deleteAction($id)
    {
        if ( request()->isPost() === false ) {
            return view('user.delete')->withTargetUser($this->_getUser($id));
        }
    }

    public function resendConfirmationAction($id)
    {
        if ( request()->isPost() === false ) {
            return view('user.resend_confirmation')->withTargetUser($this->_getUser($id));
        }
    }
}
