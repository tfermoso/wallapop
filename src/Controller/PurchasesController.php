<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Purchases Controller
 *
 * @property \App\Model\Table\PurchasesTable $Purchases
 */
class PurchasesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Purchases->find()
            ->contain(['Products', 'Buyers']);
        $purchases = $this->paginate($query);

        $this->set(compact('purchases'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        //Cargar los productos que he comprado
        $identity = $this->request->getAttribute('identity');
        $buyerId = $identity->getIdentifier();

        $products = $this->fetchTable('Products')
            ->find()
            ->where(['Products.id IN' => $this->fetchTable('Purchases')->find()->select(['product_id'])->where(['Purchases.buyer_id' => $buyerId])]);   
        $this->set(compact('purchases', 'products'));


        $purchase = $this->Purchases->get($id, contain: ['Products', 'Buyers']);
        $this->set(compact('purchase'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($productId = null)
    {
        $this->request->allowMethod(['post']);

        $identity = $this->request->getAttribute('identity');
        $buyerId = $identity->getIdentifier();

        // 🔎 Cargar producto
        $product = $this->fetchTable('Products')
            ->find()
            ->where([
                'Products.id' => $productId,
            ])
            ->firstOrFail();

        // ❌ No puedes comprar tu propio producto
        if ($product->user_id === $buyerId) {
            $this->Flash->error(__('You cannot buy your own product.'));
            return $this->redirect($this->referer());
        }

        $purchase = $this->Purchases->newEmptyEntity();

        $purchase = $this->Purchases->patchEntity($purchase, [
            'product_id' => $productId,
            'buyer_id' => $buyerId,
        ]);

        if ($this->Purchases->save($purchase)) {
            $this->Flash->success(__('Purchase completed successfully.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display']);
        }

        $this->Flash->error(__('The purchase could not be completed.'));
        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $purchase = $this->Purchases->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchase = $this->Purchases->patchEntity($purchase, $this->request->getData());
            if ($this->Purchases->save($purchase)) {
                $this->Flash->success(__('The purchase has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase could not be saved. Please, try again.'));
        }
        $products = $this->Purchases->Products->find('list', limit: 200)->all();
        $buyers = $this->Purchases->Buyers->find('list', limit: 200)->all();
        $this->set(compact('purchase', 'products', 'buyers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchase = $this->Purchases->get($id);
        if ($this->Purchases->delete($purchase)) {
            $this->Flash->success(__('The purchase has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
