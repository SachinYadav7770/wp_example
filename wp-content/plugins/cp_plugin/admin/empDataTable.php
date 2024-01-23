<?php foreach($results as $row){ ?>
    <tr data-employee-id="<?php echo $row->e_id; ?>">
        <td><?php echo $row->first_name; ?></td>
        <td><?php echo $row->last_name; ?></td>
        <td><?php echo (!empty($row->status) && $row->status == 1) ? 'Active' : 'Inactive'; ?></td>
        <td><button type="button" class='edit-employee'>Edit</button> <button class='delete-employee' type="button">Delete</button></td>
    </tr>
<?php } ?>