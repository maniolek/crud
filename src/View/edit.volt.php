<div class="row widget recruiter-new">
    <div class="col-xs-12">
        <div class="widget widget-default-spacer">
            <div class="spacer spacer30"></div>
        </div>
        <div class="widget widget-page-header">
            <h3>Update record</h3>
        </div>
        <div class="widget widget-default-spacer">
            <div class="spacer spacer22"></div>
        </div>
        <div class="widget widget-default-page">
            <div class="row widget">
                <div class="col-xs-12">
                    <div class="widget widget-content">                            
                        <div class="form-edit">
                            <form action="<?php echo $this->url->get(array('for' => $this->router->getMatchedRoute()->getName(), 'action' => 'update', 'params' => $record->_id)); ?>" method="POST" role="form">
                                <?php foreach ($form as $element) { ?>
                                    <?php $hasErrors = $form->hasMessagesFor($element->getName()); ?>
                                    <div class="clearfix form-group<?php if ($hasErrors) { ?> has-error<?php } ?>">
                                        <?php if ($element->getLabel()) { ?>
                                            <label for="<?php echo $element->getName(); ?>"><?php echo $element->getLabel(); ?></label>
                                        <?php } ?>
                                        <?php if ($hasErrors) { ?>
                                            <span class="help-block">
                                                <?php foreach ($form->getMessagesFor($element->getName()) as $error) { ?>
                                                    <?php echo $error; ?>
                                                <?php } ?>
                                            </span>
                                        <?php } ?>
                                        <?php echo $element; ?>
                                    </div>
                                <?php } ?>

                                <div class="clearfix form-group">
                                    <button type="submit" class="btn btn-flat success">Update</button>
                                    <a href="<?php echo $this->url->get(array('for' => $this->router->getMatchedRoute()->getName(), 'action' => 'index')); ?>" class="btn pull-right">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
