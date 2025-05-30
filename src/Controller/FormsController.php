<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\PrintForm;
use Cake\Cache\Engine\RedisEngine;
use Cake\Http\Cookie\Cookie;
use Cake\Utility\Inflector;

/**
 * Forms Controller
 *
 */
class FormsController extends AppController
{
   protected array $formNames;
   public function initialize(): void
   {
      parent::initialize();
      $this->formNames = ['line_1','line_2'];
   }
   public function clear($name = null)
   {
      if(in_array($name,$this->formNames)){
         $this->response = $this->getResponse()
            ->withExpiredCookie(new Cookie($name));
      }
      return $this->redirect(['action' => 'print']);
   }
   public function print()
   {

      $data = $this->request->getData();
      foreach($this->formNames as $form){
         $forms[$form] = new PrintForm();
         if(isset($data['form']) && $data['form'] === $form){
            $forms[$form]->setData($data);
         }else{
            $formCookie = $this->request->getCookie($form,'');
            parse_str($formCookie,$result);

            $forms[$form]->setData($result);
         }
      }

      if($this->request->is("POST")){
         if($forms[$data['form']]->execute($data)){
            $cookieValues = http_build_query($data);
            $cookie = new Cookie($data['form'], $cookieValues);
   
            $this->response = $this->getResponse()
               ->withCookie($cookie);
               $this->Flash->success($data['copies'] . ' copies submitted to ' . Inflector::humanize($data['form']));
         }else{
            $this->Flash->error("Validation failed ! ");
         }
      }
      $printers =[
         1 => "Printer 1",
         2 => "Printer 2",
         3 => "Printer 3",
      ];
      $this->set(compact('forms','printers'));
   }
}
