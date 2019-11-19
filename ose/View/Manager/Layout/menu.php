<?php 
$MenuUser='';
foreach ($Menu as $key => $Accion) {
    switch ($Accion['module']) {
      case 'usuario':
        $MenuUser.='<li class="nav-item active">
                     <a class="nav-link" href="/OSE-skynet/ose/User/">Usuario <span class="sr-only">(current)</span></a>
                     <input type="text" style="display:none;" id="functionMenuUser" value="'.$Accion['funcionts'].'">
                    </li>';
      break;
      case 'roles':
      $MenuUser.='<li class="nav-item active">
                    <a class="nav-link" href="/OSE-skynet/ose/Permission/">Permisos <span class="sr-only">(current)</span></a>
                </li>';
      case 'resumen':
      $MenuUser.='<li class="nav-item active">
                    <a class="nav-link" href="/OSE-skynet/ose/Summary/">Resumen diario <span class="sr-only">(current)</span></a>
                </li>';
      break;
    }
}
$MainMenu='<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="/OSE-skynet/ose/">Principal</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
    '.$MenuUser.'
    <li class="nav-item active">
        <a class="nav-link" href="/OSE-skynet/ose/User/CloseSession/">Salir <span class="sr-only">(current)</span></a>
    </li>
  </ul>
</div>
</nav>';
  
setcookie('MainMenu', $MainMenu, time() + (86400 * 1), "/"); 
?>