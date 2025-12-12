  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="assets/img/kidometer.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="border-radius: 20%;">
      <span class="brand-text font-weight-light">Consultório</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fad fa-tachometer-alt"></i>
              <p>
                Painel de Controle
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="financeiro_movimentoIndex.php" class="nav-link">
                  <i class="fad fa-money-bill nav-icon"></i>
                  <p>Financeiro</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="agendaIndex.php" class="nav-link">
                  <i class="fad fa-calendar-alt nav-icon"></i>
                  <p>Dump Agendas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="reciboIndex.php" class="nav-link">
                  <i class="fad fa-file-invoice-dollar nav-icon"></i>
                  <p>Recibos PF</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="prescricaoIndex.php" class="nav-link">
              <i class="nav-icon fad fa-prescription"></i>
              <p>
                Prescrições
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="atestadoIndex.php" class="nav-link">
              <i class="nav-icon fad fa-wheelchair"></i>
              <p>
                Atestados
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="sadtIndex.php" class="nav-link">
              <i class="nav-icon fad fa-microscope"></i>
              <p>
                SADT
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="desenhos.php" class="nav-link">
              <i class="nav-icon fad fa-palette"></i>
              <p>
                Desenhos para Colorir
              </p>
            </a>
          </li>
         <li class="nav-item">
            <a href="livroIndex.php" class="nav-link">
              <i class="nav-icon fad fa-books"></i>
              <p>
                Comprar Livros
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="aniversarianteIndex.php" class="nav-link">
              <i class="nav-icon fad fa-birthday-cake"></i>
              <p>
                Aniversariantes
              </p>
            </a>
          </li>
        <!--   <li class="nav-item">
            <a href="alimentacaoIndex.php" class="nav-link">
              <i class="nav-icon fad fa-hotdog"></i>
              <p>
                Avaliação Nutricional
              </p>
            </a>
         </li> -->
          <li class="nav-item">
            <a href="amamentacao_medicamentoIndex.php" class="nav-link">
              <i class="nav-icon fad fa-baby-carriage"></i>
              <p>
                Amamentação 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a onclick="window.open('pedz/bmi.html' , 'PediTools','width=500,height=800,scrollbars=yes,resizable=yes',true);" class="nav-link">
              <i class="nav-icon fad fa-calculator"></i>
              <p>
                PediTools
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fad fa-archive"></i>
              <p>
                Outras Calculadoras
                <i class="fas fa-angle-left right"></i>
                <sup><span class="badge badge-info right">8</span></sup>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a onclick="window.open('pedz/mph.html' , 'Estatura-Alvo','width=400,height=400,scrollbars=yes,resizable=yes',true);" class="nav-link">
                  <i class="ion ion-paper-airplane nav-icon"></i>
                  <p>Estatura Alvo</p>
                </a>
              </li>
              <li class="nav-item">
                <a onclick="window.open('pedz/neo.html' , 'Neonatal','width=400,height=750,scrollbars=yes,resizable=yes',true);" class="nav-link">
                  <i class="ion ion-ios-body nav-icon"></i>
                  <p>Neonatal</p>
                </a>
              </li>
              <li class="nav-item">
                <a onclick="window.open('pedz/gestation.html' , 'Idade Gestacional','width=400,height=400,scrollbars=yes,resizable=yes',true);" class="nav-link">
                  <i class="ion ion-information-circled nav-icon"></i>
                  <p>Idade Gestacional</p>
                </a>
              </li>
              <li class="nav-item">
                <a onclick="window.open('pedz/bili.html' , 'Bilirrubina','width=400,height=500,scrollbars=yes,resizable=yes',true);" class="nav-link">
                  <i class="ion ion-ios-lightbulb nav-icon"></i>
                  <p>Bilirrubina</p>
                </a>
              </li>
              <li class="nav-item">
                <a onclick="window.open('pedz/bp.html' , 'Pressão Arterial','width=400,height=700,scrollbars=yes,resizable=yes',true);" class="nav-link">
                  <i class="ion ion-medkit nav-icon"></i>
                  <p>Pressão Arterial</p>
                </a>
              </li>
             <!-- <li class="nav-item">
                <a onclick="window.open('kidometer/labs.php' , 'Kidometer','width=500,height=600,scrollbars=yes,resizable=yes',true);" class="nav-link">
                  <i class="ion ion-erlenmeyer-flask nav-icon"></i>
                  <p>KidLabs</p>
                </a>
              </li>
              <li class="nav-item">
                <a onclick="window.open('kidometer/hemato.php' , 'Kidometer','width=500,height=600,scrollbars=yes,resizable=yes',true);" class="nav-link">
                  <i class="ion ion-waterdrop nav-icon"></i>
                  <p>KidHemato</p>
                </a>
              </li>
              <li class="nav-item">
                <a onclick="window.open('kidometer/endocrino.php' , 'Kidometer','width=500,height=600,scrollbars=yes,resizable=yes',true);" class="nav-link">
                  <i class="ion ion-beaker nav-icon"></i>
                  <p>KidEndocrino</p>
                </a>
              </li>
            </ul>
          </li> -->
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fad fa-tools"></i>
              <p>
                Manutenção
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="amamentacao_medicamentoIndex.php" class="nav-link">
                  <i class="fas fa-user-times nav-icon"></i>
                  <p>Amam. - Medicamentos</p>
                </a>
              </li>
            <!--  <li class="nav-item">
                <a href="black_s1Index.php" class="nav-link">
                  <i class="fas fa-bible nav-icon"></i>
                  <p>Black - Capítulos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="black_s2Index.php" class="nav-link">
                  <i class="fas fa-bible nav-icon"></i>
                  <p>Black - Subcapítulos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="black_medicamentoIndex.php" class="nav-link">
                  <i class="fas fa-bible nav-icon"></i>
                  <p>Black - Medicamentos</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="convenioIndex.php" class="nav-link">
                  <i class="fas fa-heartbeat nav-icon"></i>
                  <p>Convênios Médicos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="desenhoIndex.php" class="nav-link">
                  <i class="fas fa-paint-brush nav-icon"></i>
                  <p>Desenhos - Albuns</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="imagemIndex.php" class="nav-link">
                  <i class="fas fa-paint-brush nav-icon"></i>
                  <p>Desenhos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="financeiro_catIndex.php" class="nav-link">
                  <i class="ion ion-cash nav-icon"></i>
                  <p>Financ. - Categorias</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="presc_preferidaIndex.php" class="nav-link">
                  <i class="far fa-list-alt nav-icon"></i>
                  <p>Prescrições Favoritas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="tusIndex.php" class="nav-link">
                  <i class="far fa-list-alt nav-icon"></i>
                  <p>TUSS</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>