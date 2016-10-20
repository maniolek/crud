<div class="table-wrapper products-table section">
    <div class="row header">
        <div class="col-md-12">
            <h3>Records list</h3>
            <div class="btn-group pull-right">
                <a class="btn btn-flat success" href="<?php echo $this->url->get(array('for' => $this->router->getMatchedRoute()->getName(), 'action' => 'new')); ?>">
                    + New record
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <?php foreach ($fields as $field) { ?>
                        <th><?php echo $field; ?></th>
                    <?php } ?>
                    <th class="options">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php if (($page->items)) { ?>
                    <?php foreach ($page->items as $item) { ?>
                        <tr>
                            <?php foreach ($fields as $key => $field) { ?>
                                <td>
                                    <?php echo $item->readMapped($key); ?>
                                </td>
                            <?php } ?>
                            <td align="right">
                                <a class="btn btn-sm btn-default" href="<?php echo $this->url->get(array('for' => $this->router->getMatchedRoute()->getName(), 'action' => 'show', 'params' => $item->_id)); ?>">Show</a>
                                <a class="btn btn-sm btn-default" href="<?php echo $this->url->get(array('for' => $this->router->getMatchedRoute()->getName(), 'action' => 'edit', 'params' => $item->_id)); ?>">Update</a>
                                <a class="btn btn-sm confirm-delete" href="<?php echo $this->url->get(array('for' => $this->router->getMatchedRoute()->getName(), 'action' => 'delete', 'params' => $item->_id)); ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="<?php echo $this->length($fields) + 1; ?>" align="center">No records found.</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?= \Vegas\Crud\Tags::pagination($page) ?>
        </div>
    </div>
</div>
