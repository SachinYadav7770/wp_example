<?php foreach($results as $row){ ?>
    <tr>
        <td><?php echo $row->first_name; ?></td>
        <td><?php echo $row->last_name; ?></td>
        <td><?php echo (!empty($row->status) && $row->status == 1) ? 'Active' : 'Inactive'; ?></td>
        <td><button type="button">Edit</button> <button type="button">Delete</button></td>
    </tr>
<?php } ?>