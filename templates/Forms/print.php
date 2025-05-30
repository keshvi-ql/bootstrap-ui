<?php

use Cake\Utility\Inflector;

$this->extend('../layout/TwitterBootstrap/dashboard');
// $this->extend('../layout/TwitterBootstrap/cover');
// $this->extend('../layout/TwitterBootstrap/signin');
/**
 *  @var \App\View\AppView $this
 */
?>
<?php $this->start('tb_sidebar'); ?>
<ul class="nav flex-column">
   <li class="nav-item">
      <!-- <a class="nav-link active" aria-current="page" href="#">Active</a> -->
      <?= $this->Html->link("Test Action",['action' => 'action'],[
         "class" => "nav-link"
      ]); ?>
   </li>
</ul>
<?php $this->end(); ?>

<h3 class="mt-4">Production Line print</h3>
<div class="row">
<?php foreach(array_keys($forms) as $form): ?>
   <div class="col">
      <div class="card">
         <div class="card-body">
            <h4><?= Inflector::humanize($form); ?></h4>
            <?= $this->Form->create($forms[$form],[
               'valueSources' => ['context']
            ]); ?>
            <?= $this->Form->hidden('form',[
               'value' => $form
            ]); ?>
            <?= $this->Form->control('printer', [
               'empty' => '(Please Select A Printer)',
               'required' => false
            ]); ?>
            <?= $this->Form->control('copies'); ?>
            <div class="col d-flex justify-content-between">
               <?= $this->Form->button($this->Html->icon('printer'). ' Print',[
                  'type' => 'submit',
                  'class' => 'btn btn-primary',
                  'escapeTitle' => false
               ]); ?>
               <?= $this->Form->postLink(
                  $this->Html->icon('x-circle') . ' Clear',
                  ['action' => 'clear' ,$form],
                  [
                     'class' => 'btn btn-outline-secondary',
                     'block' => true,
                     'escape' =>false
                  ]
                  ); ?>
            </div>
         
            <?= $this->Form->end(); ?> 
         </div>
      </div>
   </div>
<?php endforeach; ?>
</div>
