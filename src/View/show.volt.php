<div class="table-wrapper products-table section">
    <div class="row header">
        <div class="col-md-12">
            <h3>Record details</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <tbody>
                <?php foreach ($fields as $key => $field) { ?>
                    <tr>
                        <th><?php echo $field; ?></th>
                        <td><?php echo $record->readMapped($key); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
