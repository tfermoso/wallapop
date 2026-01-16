<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Products->find()
            ->contain(['Users']);
        $products = $this->paginate($query);

        $this->set(compact('products'));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userId = $this->request->getAttribute('identity')->getIdentifier();

        $product = $this->Products->find()
            ->where([
                'Products.id' => $id,
                'Products.user_id' => $userId,
            ])
            ->contain(['Purchases'])
            ->firstOrFail();

        $this->set(compact('product'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // 👤 Usuario logueado
            $identity = $this->request->getAttribute('identity');
            $data['user_id'] = $identity->getIdentifier(); // id del usuario

            // 📸 Imagen
            $image = $data['image'] ?? null;

            if ($image && $image->getError() === UPLOAD_ERR_OK) {
                $filename = time() . '_' . $image->getClientFilename();
                $image->moveTo(WWW_ROOT . 'img' . DS . 'products' . DS . $filename);
                $data['image'] = $filename;
            } else {
                unset($data['image']);
            }

            $product = $this->Products->patchEntity($product, $data);

            if ($this->Products->save($product)) {
                $this->Flash->success(__('Product created'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Product could not be created'));
        }

        $this->set(compact('product'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userId = $this->request->getAttribute('identity')->getIdentifier();

        // 🔒 Cargar SOLO si es del usuario
        $product = $this->Products->find()
            ->where([
                'Products.id' => $id,
                'Products.user_id' => $userId,
            ])
            ->firstOrFail();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // 🔒 Evitar cambio de propietario
            unset($data['user_id']);

            // 📸 Imagen (opcional)
            $image = $data['image'] ?? null;

            if ($image && $image->getError() === UPLOAD_ERR_OK) {
                $filename = time() . '_' . $image->getClientFilename();
                $image->moveTo(WWW_ROOT . 'img' . DS . 'products' . DS . $filename);
                $data['image'] = $filename;
            } else {
                unset($data['image']); // mantiene la anterior
            }

            $product = $this->Products->patchEntity($product, $data);

            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been updated.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The product could not be updated. Please, try again.'));
        }

        $this->set(compact('product'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function delete($id = null)
{
    $this->request->allowMethod(['post', 'delete']);

    $userId = $this->request->getAttribute('identity')->getIdentifier();

    // 🔒 Solo si el producto es del usuario
    $product = $this->Products->find()
        ->where([
            'Products.id' => $id,
            'Products.user_id' => $userId,
        ])
        ->firstOrFail();

    if ($this->Products->delete($product)) {
        $this->Flash->success(__('The product has been deleted.'));
    } else {
        $this->Flash->error(__('The product could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
}

}
