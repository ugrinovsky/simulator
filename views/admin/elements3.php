<?php include_once('_menu.php') ?>
  <h3>
    Список штрафов и поощрений
  </h3>
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          Штрафы
        </div>
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>id</th>
                <th>Название</th>
                <th>% от заказа</th>
                <th width="50" class="text-center"><span class="glyphicon glyphicon-edit"></span></th>
                <th width="50" class="text-center"><span class="glyphicon glyphicon-remove-circle"></span></th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($data['cust_fines'])): ?>
                <?php foreach ($data['cust_fines'] as $key => $cust_fine): ?>
                  <tr>
                    <td class="cust-fine-key"><?php print $cust_fine['id'] ?></td>
                    <td class="cust-fine-name"><?php print $cust_fine['name'] ?></td>
                    <td class="cust-fine-price"><?php print $cust_fine['price'] ?></td>
                    <td>
                    <button class="btn-cust-fine-edit btn btn-default" data-id="<?php print $cust_fine['id'] ?>"  data-toggle="modal" data-target="#editCustFine">
                      <span class="glyphicon glyphicon-edit"></span>
                    </button>
                    <td>
                      <form action="/admin/delete_cust_fine" method="post">
                        <input name="cust_fine_id" type="hidden" value="<?php print $cust_fine['id'] ?>">
                        <button type="submit" class="btn-cust-fine-delete btn btn-danger">  
                          <span class="glyphicon glyphicon-remove-circle"></span>
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach ?>
              <?php else: ?>
              <tr>
                <td colspan="5">
                  пусто
                </td>
              </tr>
              <?php endif ?>
            </tbody>
          </table>
        </div>
      </div>
      <button class="btn btn-default" data-toggle="modal" data-target="#addCustFine">Добавить новый</button>
    </div>
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          Поощрения
        </div>
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>id</th>
                <th>Название</th>
                <th>% от заказа</th>
                <th width="50" class="text-center"><span class="glyphicon glyphicon-edit"></span></th>
                <th width="50" class="text-center"><span class="glyphicon glyphicon-remove-circle"></span></th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($data['proms'])): ?>
                <?php foreach ($data['proms'] as $key => $prom): ?>
                  <tr>
                    <td class="prom-key"><?php print $prom['id'] ?></td>
                    <td class="prom-name"><?php print $prom['name'] ?></td>
                    <td class="prom-price"><?php print $prom['price'] ?></td>
                    <td>
                      <button class="btn-prom-edit btn btn-default" data-id="<?php print $prom['id'] ?>"  data-toggle="modal" data-target="#editProm">
                        <span class="glyphicon glyphicon-edit"></span>
                      </button>
                    </td>
                    <td>
                      <form action="/admin/delete_prom" method="post">
                        <input name="prom_id" type="hidden" value="<?php print $prom['id'] ?>">
                        <button type="submit" class="btn-prom-delete btn btn-danger">
                          <span class="glyphicon glyphicon-remove-circle"></span>
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach ?>
              <?php else: ?>
              <tr>
                <td colspan="5">
                  пусто
                </td>
              </tr>
              <?php endif ?>
            </tbody>
          </table>
        </div>
      </div>
      <button class="btn btn-default" data-toggle="modal" data-target="#addProm">Добавить новый</button>
    </div>
  </div>
</div>

<div class="modal fade" id="addCustFine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/add_cust_fine" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Добавление штрафа</h4>
      </div>
      <div class="modal-body">
      <div class="form-group">
        <label for="recipient-name" class="control-label">Название:</label>
        <input type="text" name="cust_fine_name" class="form-control">
      </div>
      <div class="form-group">
        <label for="recipient-name" class="control-label">Процент от заказа:</label>
        <div class="input-group">
          <div class="input-group-addon">%</div>
          <input type="text" name="cust_fine_price" class="form-control">
        </div>
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

<div class="modal fade" id="editCustFine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/edit_cust_fine" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Редактирование записи <span id="title-cust-fine-id"></span></h4>
      </div>
      <div class="modal-body">
    <input type="hidden" name="cust_fine_id">
    <div class="form-group">
      <label for="recipient-name" class="control-label">Название:</label>
      <input type="text" name="cust_fine_name" class="form-control">
    </div>
    <div class="form-group">
      <label for="recipient-name" class="control-label">Процент от заказа:</label>
      <div class="input-group">
        <div class="input-group-addon">%</div>
        <input type="text" name="cust_fine_price" class="form-control">
      </div>
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

<div class="modal fade" id="addProm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/add_prom" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Добавление поощрения</h4>
      </div>
      <div class="modal-body">
      <div class="form-group">
        <label for="recipient-name" class="control-label">Название:</label>
        <input type="text" name="prom_name" class="form-control">
      </div>
      <div class="form-group">
        <label for="recipient-name" class="control-label">Процент от заказа:</label>
        <div class="input-group">
          <div class="input-group-addon">%</div>
          <input type="text" name="prom_price" class="form-control">
        </div>
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

<div class="modal fade" id="editProm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/edit_prom" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Редактирование записи <span id="title-prom-id"></span></h4>
      </div>
      <div class="modal-body">
    <input type="hidden" name="prom_id">
    <div class="form-group">
      <label for="recipient-name" class="control-label">Название:</label>
      <input type="text" name="prom_name" class="form-control">
    </div>
    <div class="form-group">
      <label for="recipient-name" class="control-label">Процент от заказа:</label>
      <div class="input-group">
        <div class="input-group-addon">%</div>
        <input type="text" name="prom_price" class="form-control">
      </div>
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