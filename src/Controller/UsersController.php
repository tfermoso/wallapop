<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login', 'register']);

    }

    public function login()
    {
        // In the add, login, and logout methods
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            // redirect to /articles after login success
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Products',
                'action' => 'index',
            ]);

            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    public function register()
    {
        // Registro = acción pública

        $this->request->allowMethod(['get', 'post']);

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Avatar upload
            $avatar = $data['avatar'] ?? null;
            if ($avatar && $avatar->getError() === UPLOAD_ERR_OK) {
                $filename = uniqid() . '-' . $avatar->getClientFilename();
                $targetPath = WWW_ROOT . 'img' . DS . 'avatars' . DS . $filename;

                $avatar->moveTo($targetPath);

                $data['avatar'] = 'avatars/' . $filename;
            } else {
                unset($data['avatar']);
            }

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('User registered successfully'));
                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error(__('Registration failed'));
        }

        $this->set(compact('user'));
    }

    public function logout()
    {
        // In the add, login, and logout methods
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $this->Authentication->logout();

            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }


}
