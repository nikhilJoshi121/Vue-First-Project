<template>
    <div>
        <Header />
        <div id="layoutSidenav">
            <SideBar />
            <div id="layoutSidenav_content">
                 <!-- route outlet -->
                  <!-- component matched by the route will render here -->
               <router-view></router-view>     <!--Child router-->
             <Footer />
            </div> 
        </div>
    </div>
</template>

<script>
import Header from '../components/Header.vue';
import Footer from '../components/Footer.vue';
import SideBar from '../components/SideBar.vue';
// import Header from './components/Header.vue';

export default {
    components:{
         Header,
         Footer,
         SideBar
    },
      created(){
        document.querySelector('body').style.background ="#ffffff";
    },
}
</script>