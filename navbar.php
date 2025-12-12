  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link" href="prescricaoAddEdit.php">Prescrição</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link" href="atestadoAddEdit.php">Atestado</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link" href="sadtAddEdit.php">SADT</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link" href="reciboAddEdit.php">Recibo</a>
      </li>      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" href="aniversariantesCSV.php">
          <i class="fad fa-birthday-cake"></i>
        </a>                
      </li>      
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="modal" data-target="#evolucoesModal">
          <i class="fad fa-star"></i>
        </a>                
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="modal" data-target="#rastModal">
          <i class="fad fa-flask"></i>
        </a>                
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fad fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><?= $_SESSION['USER']['NOME'] ?></span>
          <div class="dropdown-divider"></div>          
          <a class="dropdown-item dropdown-footer" data-url="login.php?deslogar"  href="login.php?deslogar" data-toggle="tooltip" data-placement="top" data-title="Logout"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fad fa-bookmark mr-2"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Protocolos</span>
          <div class="dropdown-divider"></div>          
          <a class="dropdown-item dropdown-footer" data-toggle="modal" data-target="#lupusModal" data-placement="top" data-title="Lupus"><i class="fad fa-temperature-high mr-2"></i>Lupus</a>
          <div class="dropdown-divider"></div>          
          <a class="dropdown-item dropdown-footer" data-toggle="modal" data-target="#febrereumaticaModal" data-placement="top" data-title="Lupus"><i class="fad fa-temperature-high mr-2"></i>Febre Reumática</a>
        </div>
      </li>
      <?php
        if(!empty($_SESSION['cart'])){
          echo '<li class="nav-item">
                <a class="nav-link" href="alimentacaoViewChart.php">
                  <i class="fad fa-utensils"></i>
                  <span class="badge badge-warning navbar-badge">'. count($_SESSION['cart']). '</span>
                </a>
              </li>';
        } else {
          echo '';
        }
      ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fad fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->


  <!-- Modal -->
  <div class="modal fade bd-example-modal-xl" id="rastModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Códigos de RAST</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="embed-responsive embed-responsive-1by1">
            <iframe class="embed-responsive-item" src="rast.php"></iframe>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade bd-example-modal-xl" id="evolucoesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Evoluções</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="embed-responsive embed-responsive-1by1">
            <iframe class="embed-responsive-item" src="evolucoes_atalho.php"></iframe>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

    <!-- Modal -->
  <div class="modal fade bd-example-modal-lg" id="lupusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Lupus Eritematoso Sistêmico</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="embed-responsive embed-responsive-1by1">
            <iframe class="embed-responsive-item" src="../algoritmos/lupus.php"></iframe>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

    <!-- Modal -->
  <div class="modal fade bd-example-modal-lg" id="febrereumaticaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Febre Reumática</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="embed-responsive embed-responsive-1by1">
            <iframe class="embed-responsive-item" src="../algoritmos/febrereumatica.php"></iframe>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>  