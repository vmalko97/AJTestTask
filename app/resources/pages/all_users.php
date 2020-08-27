<table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>ПІБ</th>
        <th>E-Mail</th>
        <th>Адреса</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $user = new User();
    $territory = new Territory();
    $users = $user->getAll();
    for ($i = 0; $i<count($users); $i++){
  echo "<tr>
        <td>".$users[$i]['id']."</td>
        <td>".$users[$i]['name']."</td>
        <td>".$users[$i]['email']."</td>
        <td>".$territory->getTerritoryName($users[$i]['territory'])."</td>
    </tr>";
 } ?>
    </tbody>
</table>