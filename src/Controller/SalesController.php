<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Sales Controller
 *
 * @property \App\Model\Table\SalesTable $Sales
 *
 * @method \App\Model\Entity\Sale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel('Users');
        $auth = $this->request->session()->read('Auth.User');

        $users = $this->Users->find('all', [
            'contain' => ['Sales' => [
                'conditions' => [
                    '`Sales`.`created` >=' => date('Y-m-d 00:00:00'),
                    '`Sales`.`created` <=' => date('Y-m-d 23:59:59'),
                ]
                ], 'Sales.SaleItems'],
            'conditions' => [
                'Users.branch_id' => $auth['branch_id'],
                'Users.role' => 'cashier',
            ],
        ]);
        // pr($sales->toArray());
        
        $this->set(compact('users'));
    }

    public function reports()
    {
        $this->loadModel('Users');
        $this->loadModel('Orders');
        $this->loadModel('Branches');
        $auth = $this->request->session()->read('Auth.User');

        $users = $this->Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'username',
            'conditions' => [
                'role' => 'cashier'
            ]
        ])->toArray();

        $branches = $this->Branches->find('list',[
            'conditions' => [
                'is_main' => 0
            ]
        ]);

        if ($this->request->is('post')) {
            // pr($_POST);
            if (isset($this->request->data['sales'])) {
                $condition = null;
                if ($this->request->data['users'] != 'All') {
                    $condition = ['Users.id' => $this->request->data['users']];
                }
                $reportUsers = $this->Users->find('all', [
                    'contain' => ['Sales' => [
                        'conditions' => [
                            '`Sales`.`created` >=' => date('Y-m-d 00:00:00', strtotime($this->request->data['start_date'])),
                            '`Sales`.`created` <=' => date('Y-m-d 23:59:59', strtotime($this->request->data['end_date'])),
                        ]
                        ], 'Sales.SaleItems'],
                    'conditions' => [
                        'Users.branch_id' => $auth['branch_id'],
                        'Users.role' => 'cashier',
                        $condition
                    ],
                ]);
            } elseif (isset($this->request->data['bills'])) {
                $orders = $this->Orders->find('all', [
                    'contain' => ['Cart.Products', 'Users.Branches'],
                    'conditions' => [
                        'Orders.created >=' => date('Y-m-d 00:00:00', strtotime($this->request->data['start_date'])),
                        'Orders.created <=' => date('Y-m-d 23:59:59', strtotime($this->request->data['end_date'])),
                        'Users.branch_id' => $this->request->data['branch']
                    ]
                    
                ]);
            }
            
        // pr($orders->toArray());exit;
        }

        $this->set(compact('users', 'branches', 'reportUsers', 'orders'));
    }

    public function reportXls()
    {
        $this->loadModel('Users');
        $auth = $this->request->session()->read('Auth.User');
        
        $condition = null;
        if ($this->request->data['users'] != 'All') {
            $condition = ['Users.id' => $this->request->data['users']];
        }
        $users = $this->Users->find('all', [
            'contain' => ['Sales' => [
                'conditions' => [
                    '`Sales`.`created` >=' => date('Y-m-d 00:00:00', strtotime($this->request->data['start_date'])),
                    '`Sales`.`created` <=' => date('Y-m-d 23:59:59', strtotime($this->request->data['end_date'])),
                ]
                ], 'Sales.SaleItems'],
            'conditions' => [
                'Users.branch_id' => $auth['branch_id'],
                'Users.role' => 'cashier',
                $condition
            ],
        ]);
        // pr($sales->toArray());
        $auditTable = TableRegistry::get('Audit');
        $audit = $auditTable->newEntity();
        $audit->user_id = $auth['id'];
        $audit->type = 'Generated Sales Report';
        $auditTable->save($audit);

        $this->set(compact('users'));
    }

    public function billingXls()
    {
        $this->loadModel('Orders');
        $orders = $this->Orders->find('all', [
            'contain' => ['Cart.Products', 'Users.Branches'],
            'conditions' => [
                'Orders.created >=' => date('Y-m-d 00:00:00', strtotime($this->request->data['start_date'])),
                'Orders.created <=' => date('Y-m-d 23:59:59', strtotime($this->request->data['end_date'])),
                'Users.branch_id' => $this->request->data['branch']
            ]
            
        ]);
        // pr($orders->toArray());exit;
        $auth = $this->request->session()->read('Auth.User');
        $auditTable = TableRegistry::get('Audit');
        $audit = $auditTable->newEntity();
        $audit->user_id = $auth['id'];
        $audit->type = 'Generated Billing Report';
        $auditTable->save($audit);

        $this->set(compact('orders'));
    }
}
