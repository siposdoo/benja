<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div class="h-screen flex w-full bg-img vx-row no-gutter items-center justify-center" id="page-login">
    <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4">
      <vx-card>
        <div slot="no-body" class="full-page-bg-color">

          <div class="vx-row no-gutter justify-center items-center">

            <div class="vx-col hidden lg:block lg:w-1/2">
             <div class="carousel-example">
        <swiper :options="swiperOption" :dir="$vs.rtl ? 'rtl' : 'ltr'" :key="$vs.rtl">
            
            <swiper-slide>
              <img class="responsive" src="@assets/images/pages/loginslide/slide2.jpg" alt="banner">
            </swiper-slide>
             <swiper-slide>
              <img class="responsive" src="@assets/images/pages/loginslide/slide5.jpg" alt="banner">
            </swiper-slide>
            <div class="swiper-pagination" slot="pagination"></div>
            <div class="swiper-button-prev" slot="button-prev"></div>
            <div class="swiper-button-next" slot="button-next"></div>
        </swiper>
    </div>
              <!--img src="@assets/images/pages/login.jpg" alt="login" class="mx-auto"-->
            </div>

            <div class="vx-col sm:w-full md:w-full lg:w-1/2 d-theme-dark-bg">
              <div class="px-8 pt-8 login-tabs-container">

                <div class="vx-card__title mb-4">
                  <h4 class="mb-4">Prijava</h4>
                  <p>Dobrodošli, molimo Vas da se prijavite.</p>
                </div>

                <vs-tabs>
                  <vs-tab label="">
                    <login-jwt></login-jwt>
                  </vs-tab>

                  
                </vs-tabs>

              </div>
            </div>
          </div>
        </div>
      </vx-card>
    </div>
  </div>
</template>


<script>
import 'swiper/dist/css/swiper.min.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import LoginJwt from './LoginJWT.vue'
 
export default {
    data() {
        return {
            swiperOption: {
                autoplay: {
                    delay: 5500,
                    disableOnInteraction: false
                },
               
                
            }
        }
        },
        components: {
          LoginJwt,
            swiper,
            swiperSlide
        }
    
}
</script>

<style lang="scss">
.login-tabs-container {
  min-height: 505px;

  .con-tab {
    padding-bottom: 14px;
  }

  .con-slot-tabs {
    margin-top: 1rem;
  }
}
 
  .swiper-img{
    width: 100%;

  }
  .wrapper >>> .swiper-pagination-bullet-active{
    background:#fff !important
  }
  .swiper-button-prev{
    display: none;
  }
   .swiper-button-next{
    display: none;
  }
  .wrapper{
    overflow :hidden;
    width:100%;
    height:0;
    padding-bottom :31.25%;
  }
</style>
