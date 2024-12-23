<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard')}}" class="brand-link bg-primary">
      <!-- <img src="/images/expat.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light">Expat-Dakar-Food</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
              <p>
                 Menus
                <i class="fas fa-angle-left pull-right"></i>
              </p>
            </a>
            <ul class="treeview-menu menu-open" style="display: block;">
              <li class="nav-item">
                <a href="{{ route('admin.menus.index') }}" class="nav-link">
                  <p>Liste Menus</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.menu_items.index') }}" class="nav-link">
                  <p>Menu du Jour</p>
                </a>
              </li>
            </ul>
          </li>


        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
              <p>
                 Traiteurs
                <i class="fas fa-angle-left pull-right"></i>
              </p>
            </a>
            <ul class="treeview-menu menu-open" style="display: block;">
              <li class="nav-item">
                <a href="{{ route('admin.restaurants.index') }}" class="nav-link">
                  <p>Liste Traiteurs</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-folder"></i>
              <p>
                 Plats
                <i class="fas fa-angle-left pull-right"></i>
              </p>
            </a>
            <ul class="treeview-menu menu-open" style="display: block;">
              <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link">
                  <p>Category Plats</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.items.index') }}" class="nav-link">
                  <p>Listes Plats</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
              <p>
                 Commandes
                <i class="fas fa-angle-left pull-right"></i>
              </p>
            </a>
            <ul class="treeview-menu menu-open" style="display: block;">
            <li class="nav-item">
                 <a href="{{ route('admin.order_items.index') }}" class="nav-link">
                  <p>Commandes du Jour</p>
                </a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.order_items.listingOrder') }}" class="nav-link">
                  <p>Commandes Totales</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
              <p>
                 Reporting
                <i class="fas fa-angle-left pull-right"></i>
              </p>
            </a>
            <ul class="treeview-menu menu-open" style="display: block;">
            <li class="nav-item">
                 <a href="{{ route('admin.reports.monthly') }}" class="nav-link">
                  <p>Commandes mensuelles</p>
                </a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.reportRestaurants.monthly')}}" class="nav-link">
                  <p>Rapports</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                 Employées
                <i class="fas fa-angle-left pull-right"></i>
              </p>
            </a>
            <ul class="treeview-menu menu-open" style="display: block;">
              <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                  <p>Liste Employées</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.users.create') }}" class="nav-link">
                  <p>Ajout Employées</p>
                </a>
              </li>
            </ul>
          </li> 
          
          <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                        {{ __('Paramètres') }}
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="treeview-menu menu-open" style="display: block;">
                    <li class="nav-item">
                        <a href="{{ route('admin.settings.index') }}" class="nav-link">
                            <p>{{ __('Voir les paramètres') }}</p>
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