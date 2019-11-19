
      <?php foreach ($parameter[0] as $key => $User): ?>
        <tr>
          <td><?php echo $User["names"] ?></td>
          <td><?php echo $User["email"] ?></td>
          <td><?php echo $User["phone"] ?></td>
          <td><?php echo $User["rol"] ?></td>
          <td><?php echo $User["state"] ?></td>
          <td>
            <button type="button" class="btn btn-primary" onclick='EditUsers(<?php echo $User["id_user"] ?>)'><i class="fas fa-pen"></i></button>
            <button type="button" class="btn btn-primary" onclick='DeleteUsers(<?php echo $User["id_user"] ?>)'><i class="fas fa-user-minus"></i></button>
          </td>
        </tr>
      <?php endforeach ?>