<h3>Daftar pengguna telah dibuat. Segera simpan halaman ini karena halaman ini tidak dapat dibuat kembali</h3>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Fullname</th>
            <th>Email</th>
            <th>Password</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($generatedUsers as $i => $user):;?>
        <tr class="<?php echo (($i % 2 == 1) ? 'odd' : 'even');?>">
            <td><?php echo ($i + 1);?></td>
            <td><?php echo ($user['username']);?></td>
            <td><?php echo ($user['full_name']);?></td>
            <td><?php echo ($user['email']);?></td>
            <td><?php echo ($user['password']);?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>