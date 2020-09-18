<template>
  <div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
      <div class="sb-sidenav-menu">
        <div class="nav">
          <div class="sb-sidenav-menu-heading">Core</div>
          <router-link to="/" class="nav-link" exact>
            
              <div class="sb-nav-link-icon">
                <i class="fas fa-tachometer-alt"></i>
              </div>Dashboard
         
          </router-link>
      

          <div class="sb-sidenav-menu-heading">Addons</div>
            <router-link  to="/category" class="nav-link" exact>
              
                    <div class="sb-nav-link-icon">
                     <i class="fas fa-chart-area"></i>
                    </div>Categories
            </router-link>

          
           <router-link to="/chat-dashboard" class="nav-link" exact>
                    <div class="sb-nav-link-icon">
                    <i class="fas fa-chart-area"></i>
                    </div>Chat Board
          </router-link>
           <!-- <router-link to="/telescope" class="nav-link" exact>
                    <div class="sb-nav-link-icon">
                    <i class="fas fa-chart-area"></i>
                    </div>Telescope
          </router-link> -->
        </div>
      </div>
     
    </nav>
  </div>
</template>