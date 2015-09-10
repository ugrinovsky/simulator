<?php include_once('_menu.php') ?>
   <h3>
      Список заказов и деталей
   </h3>
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               Заказы
            </div>
            <div class="table-responsive">
              <table class="table table-bordered">
                 <thead>
                    <tr>
                       <th>id</th>
                       <th>Название</th>
                       <th>Цена, р.</th>
                       <th>Исполнитель</th>
                       <th>Заказчик</th>
                       <th>Статус</th>
                       <th width="50" class="text-center"><span class="glyphicon glyphicon-edit"></span></th>
                       <th width="50" class="text-center"><span class="glyphicon glyphicon-remove-circle"></span></th>
                    </tr>
                 </thead>
                 <tbody>
                    <?php if (!empty($data['orders'])): ?>
                       <?php foreach ($data['orders'] as $key => $order): ?>
                          <tr>
                             <td class="order-key"><?php print $order['id'] ?></td>
                             <td class="order-name"><?php print $order['name'] ?></td>
                             <td class="order-price"><?php print $order['price'] ?></td>
                             <td>
                                <?php print $order['team'] ?>
                             </td>
                             <td>
                                Заказчик №<?php print $order['customer_id'] ?>
                             </td>
                             <td>
                                <?php
                                   $state_text = '';
                                   switch ($order['state']) {
                                      case 0:
                                         $state_text = 'не определен';
                                         break;
                                      case 1:
                                         $state_text = 'на исполнении';
                                         break;
                                      case 2:
                                         $state_text = 'выполнен';
                                         break;
                                      case 3:
                                        $state_text = 'просрочен';
                                        break;
                                   }
                                   print $state_text;
                                ?>
                             </td>
                             <td>
                                <button class="btn-order-edit btn btn-default" data-id="<?php print $order['id'] ?>"  data-toggle="modal" data-target="#editOrder">
                                   <span class="glyphicon glyphicon-edit"></span>
                                </button>
                             </td>
                             <td>
                                <form action="/admin/delete_order" method="post">
                                   <input name="order_id" type="hidden" value="<?php print $order['id'] ?>">
                                   <button type="submit" class="btn-order-delete btn btn-danger">
                                      <span class="glyphicon glyphicon-remove-circle"></span>
                                   </button>
                                </form>
                             </td>
                          </tr>
                       <?php endforeach ?>
                    <?php else: ?>
                    <tr>
                       <td colspan="9">
                          пусто
                       </td>
                    </tr>
                    <?php endif ?>
                 </tbody>
              </table>
            </div>
         </div>
         <button class="btn btn-default" data-toggle="modal" data-target="#addOrder">Добавить новый</button>
         <hr>
      </div>
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               Детали
            </div>
            <div class="table-responsive">
              
              <table class="table table-bordered">
                 <thead>
                    <tr>
                       <th>id</th>
                       <th>Название</th>
                       <th>Цена, р.</th>
                       <th width="200">Поставщик</th>
                <!--        <th>Кто купил</th>
                       <th>Статус</th> -->
                       <th width="50" class="text-center"><span class="glyphicon glyphicon-edit"></span></th>
                       <th width="50" class="text-center"><span class="glyphicon glyphicon-remove-circle"></span></th>
                    </tr>
                 </thead>
                 <tbody>
                    <?php if (!empty($data['parts'])): ?>
                       <?php foreach ($data['parts'] as $key => $part): ?>
                          <tr>
                             <td class="part-key"><?php print $part['id'] ?></td>
                             <td class="part-name"><?php print $part['name'] ?></td>
                             <td class="part-price"><?php print $part['price'] ?></td>
                             <td>
                               Поставщик №<?php print $part['provider_id'] ?>
                             </td>
                             <!-- <td>
                                <?php print $part['team'] ?>
                             </td>
                             <td>
                                <?php
                                  if ($part['state'] == PART_NOBUY)
                                    print 'не куплено';
                                  elseif($part['state'] == PART_BUY)
                                    print 'куплено';
                                ?>
                             </td> -->
                             <td>
                                <button class="btn-part-edit btn btn-default" data-id="<?php print $part['id'] ?>" data-toggle="modal" data-target="#editPart">
                                   <span class="glyphicon glyphicon-edit"></span>
                                </button>
                             </td>
                             <td>
                                <form action="/admin/delete_part" method="post">
                                   <input name="part_id" type="hidden" value="<?php print $part['id'] ?>">
                                   <button type="submit" class="btn-part-delete btn btn-danger">
                                      <span class="glyphicon glyphicon-remove-circle"></span>
                                   </button>
                                </form>
                             </td>
                          </tr>
                       <?php endforeach ?>
                    <?php else: ?>
                    <tr>
                       <td colspan="7">
                          пусто
                       </td>
                    </tr>
                    <?php endif ?>
                 </tbody>
              </table>
            </div>
         </div>
         <button class="btn btn-default" data-toggle="modal" data-target="#addPart">Добавить новый</button>
      </div>
   </div>
</div>

<div class="modal fade" id="addOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/add_order" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Добавление заказа</h4>
      </div>
      <div class="modal-body">
         <div class="form-group">
            <label for="recipient-name" class="control-label">Название:</label>
            <input type="text" name="order_name" class="form-control">
         </div>
         <div class="form-group">
            <label for="recipient-name" class="control-label">Цена:</label>
            <input type="text" name="order_price" class="form-control">
         </div>
         <div class="form-group">
            <label for="recipient-name" class="control-label">Заказчик:</label>
            <select class="form-control" name="order_customer_id" id="">
              <option value=""></option>
              <?php foreach ($customers as $key => $customer): ?>
                <option value="<?php print $customer['id'] ?>">Заказчик №<?php print $customer['id'] ?></option>
              <?php endforeach ?>
            </select>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary">Добавить</button>
      </div>
     </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/edit_order" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Редактирование записи <span id="title-order-id"></span></h4>
      </div>
      <div class="modal-body">
      <input type="hidden" name="order_id">
      <div class="form-group">
         <label for="recipient-name" class="control-label">Название:</label>
         <input type="text" name="order_name" class="form-control">
      </div>
      <div class="form-group">
         <label for="recipient-name" class="control-label">Цена:</label>
         <input type="text" name="order_price" class="form-control">
      </div>
      <div class="form-group">
         <label for="recipient-name" class="control-label">Заказчик:</label>
         <select class="form-control" name="order_customer_id" id="">
           <option value=""></option>
           <?php foreach ($customers as $key => $customer): ?>
             <option value="<?php print $customer['id'] ?>">Заказчик №<?php print $customer['id'] ?></option>
           <?php endforeach ?>
         </select>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary">Сохранить</button>
      </div>
     </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addPart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/add_part" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Добавление детали</h4>
      </div>
      <div class="modal-body">
         <div class="form-group">
            <label for="recipient-name" class="control-label">Название:</label>
            <input type="text" name="part_name" class="form-control">
         </div>
         <div class="form-group">
            <label for="recipient-name" class="control-label">Цена:</label>
            <input type="text" name="part_price" class="form-control">
         </div>
         <div class="form-group">
            <label for="recipient-name" class="control-label">Поставщик:</label>
            <select class="form-control" name="part_provider_id" id="">
              <option value=""></option>
              <?php foreach ($providers as $key => $provider): ?>
                <option value="<?php print $provider['id'] ?>">Поставщик №<?php print $provider['id'] ?></option>
              <?php endforeach ?>
            </select>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary">Добавить</button>
      </div>
     </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editPart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/edit_part" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Редактирование записи <span id="title-part-id"></span></h4>
      </div>
      <div class="modal-body">
      <input type="hidden" name="part_id">
      <div class="form-group">
         <label for="recipient-name" class="control-label">Название:</label>
         <input type="text" name="part_name" class="form-control">
      </div>
      <div class="form-group">
         <label for="recipient-name" class="control-label">Цена:</label>
         <input type="text" name="part_price" class="form-control">
      </div>
      <div class="form-group">
         <label for="recipient-name" class="control-label">Поставщик:</label>
         <select class="form-control" name="part_provider_id" id="">
           <option value=""></option>
           <?php foreach ($providers as $key => $provider): ?>
             <option value="<?php print $provider['id'] ?>">Поставщик №<?php print $provider['id'] ?></option>
           <?php endforeach ?>
         </select>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary">Сохранить</button>
      </div>
     </form>
    </div>
  </div>
</div>