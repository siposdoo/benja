<!-- =========================================================================================
  File Name: AddNewDataSidebar.vue
  Description: Add New Data - Sidebar component
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <vs-sidebar
    click-not-close
    position-right
    parent="body"
    default-index="1"
    color="primary"
    class="add-new-data-sidebar items-no-padding"
    spacer
    v-model="isSidebarActiveLocal"
  >
    <div class="mt-6 flex items-center justify-between px-6">
      <h4>
        {{
          Object.entries(this.data).length === 0 ? "Dodaj" : "Izmjeni"
        }}
        Nalog
      </h4>
      <feather-icon
        icon="XIcon"
        @click.stop="isSidebarActiveLocal = false"
        class="cursor-pointer"
      ></feather-icon>
    </div>
    <vs-divider class="mb-0"></vs-divider>

    <component
      :is="scrollbarTag"
      class="scroll-area--data-list-add-new"
      :settings="settings"
      :key="$vs.rtl"
    >
      <div class="p-6  flex w-full bg-img vx-row ">
           <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-2/4">
          <vs-input
            label="Naziv naloga"
            v-model="proizvodjac"
            placeholder="Tura SLO"

            class="mt-5 w-full"
             v-validate="'required'"
          />
           </div>
            <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-2/4">
          <vs-input
            label="Broj vozila"
            v-model="brvozila"
            placeholder="10"

            class="mt-5 w-full"
             v-validate="'required'"
          />
           <span class="text-danger text-sm" v-show="errors.has('brvozila')">{{
            errors.first("brvozila")
          }}</span>
           </div>
          <vx-card
          class="mt-2"
    title="Utovar"
    title-color="primary"
     >
        <div  class="flex p-4 w-full bg-img vx-row" v-for="(input,k) in kompod" :key="k">
             <div class="vx-col sm:w-1/3 md:w-2/5 lg:w-2/5">
           <v-select
            label="name"
            placeholder="Kompanija"
            v-model="input.lokacija"
            :value="input.lokacija"
            :options="kompanije"
            class="mt-6 w-full tet"
          >
          </v-select>
           </div>
            <div class="vx-col sm:w-1/3 md:w-2/5 lg:w-2/5">
          <vs-input
            label="Broj vozila - utovar"
            v-model="input.vozila"
            placeholder=""

            class=" w-full"
             v-validate="'required'"
          />
           </div>
           <div class="p-3 mt-5 vx-colsm:w-1/3 md:w-1/5 lg:w-1/5">
<vs-button size="small"  class="bg-warning" @click="removeod(k)" v-show="k || ( !k && kompod.length > 1)">-</vs-button>
<vs-button size="small"  @click="addod(k)" v-show="k == kompod.length-1">+</vs-button>
           </div>
           </div>
          </vx-card>
            <vx-card
          class="mt-2"
    title="Istovar"
    title-color="primary"
     >
        <div  class="flex p-4 w-full bg-img vx-row" v-for="(input,k) in kompdo" :key="k">

             <div class="vx-col sm:w-1/3 md:w-2/5 lg:w-2/5">
           <v-select
            label="name"
            placeholder="Kompanija"
            v-model="input.lokacija"
            :value="input.lokacija"
            :options="kompanije"
            class="mt-6 w-full tet"
          >
          </v-select>
           </div>
            <div class="vx-col sm:w-1/3 md:w-2/5 lg:w-2/5">
          <vs-input
            label="Broj vozila - istovar"
            v-model="input.vozila"
            placeholder=""

            class=" w-full"
             v-validate="'required'"
          />
           </div>
           <div class="p-3 mt-5 vx-col sm:w-1/3 md:w-1/5 lg:w-1/5">
<vs-button size="small"  class="bg-warning" @click="removedo(k)" v-show="k || ( !k && kompdo.length > 1)">-</vs-button>
<vs-button size="small"  @click="adddo(k)" v-show="k == kompdo.length-1">+</vs-button>
           </div>
           </div>
            </vx-card>
             <div class="vx-col sm:w-1/3 md:w-1/3 lg:w-1/3">
          <vs-input
            label="Broj fakture"
            v-model="brfak"
            placeholder="INV-123222"

            class="mt-5 w-full"
             v-validate="'required'"
          />
           </div>
             <div class="vx-col sm:w-1/3 md:w-1/3 lg:w-1/3">
          <vs-input
            label="Iznos KM"
            v-model="iznoskm"
            @change="changeKM()"
            placeholder="3211"

            class="mt-5 w-full"
             v-validate="'required'"
          /> 
           </div>
            <div class="vx-col sm:w-1/3 md:w-1/3 lg:w-1/3">
          <vs-input
            label="Iznos EUR"
            v-model="iznosuer"
             @change="changeEUR()"
            placeholder="3211"

            class="mt-5 w-full"
             v-validate="'required'"
          /> 
           </div>
                       <div class="vx-col w-full">

            <vs-textarea
            label="Vozila"
            v-model="vozila"
            placeholder="Reference, vozilo, broj šasije, tablice"
             class="mt-5 w-full"
             v-validate="'required'"
          />
          <span class="text-danger text-sm" v-show="errors.has('vozila')">{{
            errors.first("vozila")
          }}</span>
                     </div>
                       <div class="vx-col w-full">

            <vs-textarea
            label="Izvozno carinjenje"
            v-model="izvoznocarinjenje"
            placeholder="Upute za izvozno carinjenje"
             class="mt-5 w-full"
             v-validate="'required'"
          />
          <span class="text-danger text-sm" v-show="errors.has('izvoznocarinjenje')">{{
            errors.first("izvoznocarinjenje")
          }}</span>
                     </div>
                             <div class="vx-col w-full">

            <vs-textarea
            label="Granični prijelaz (špedicija)"
            v-model="grprelaz"
            placeholder="Upute za Granični prijelaz (špedicija)"
             class="mt-5 w-full"
             v-validate="'required'"
          />
          <span class="text-danger text-sm" v-show="errors.has('grprelaz')">{{
            errors.first("grprelaz")
          }}</span>
                     </div>
                           <div class="vx-col w-full">

            <vs-textarea
            label="Uvozno carinjenje"
            v-model="uvoznocarinjenje"
            placeholder="Upute za uvozno carinjenje"
             class="mt-5 w-full"
             v-validate="'required'"
          />
          <span class="text-danger text-sm" v-show="errors.has('uvoznocarinjenje')">{{
            errors.first("uvoznocarinjenje")
          }}</span>
                     </div>
                                            <div class="vx-col w-full">

  <vs-input
            label="Kontakt"
            v-model="kontakt"
            placeholder="kontakt"

            class="mt-5 w-full"
             v-validate="'required'"
          />
           </div>
             
           <div class="vx-col w-full">

  <vs-input
            label="GMAP ruta - link"
            v-model="gmaplink"
            placeholder="Kopiran URL sa google map"

            class="mt-5 w-full"
             v-validate="'required'"
          />
           </div>
              <div class="vx-col w-full">

            <vs-textarea
            label="Napomene"
            v-model="napomene"
            placeholder="Dodatne napomene"
             class="mt-5 w-full"
             v-validate="'required'"
          />
          <span class="text-danger text-sm" v-show="errors.has('napomene')">{{
            errors.first("napomene")
          }}</span>
                     </div>
           
 
         

           

           

        
        
      </div>
    </component>

    <div class="flex flex-wrap items-center p-6" slot="footer">
   

      <vs-button class="mr-3" @click="addclient()" :disabled="!isFormValid"
        >Snimi</vs-button
      >
          
      <vs-button
        type="border"
        class=""
        color="danger"
        @click="isSidebarActiveLocal = false; initValues()"
        >Odustani</vs-button
      >
    </div>
  </vs-sidebar>
</template>

<script>
import VuePerfectScrollbar from "vue-perfect-scrollbar";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

export default {
  props: {
    isSidebarActive: {
      type: Boolean,
      required: true,
    },
    data: {
      type: Object,
      default: () => {},
    },
  },
  components: {
    VuePerfectScrollbar,
    "v-select": vSelect,
  },
  data() {
    return {
      provjera: false,
      provjera2: false,
      iznoskm:null,
      kompanije:[],
      kompod:[{vozila:'',lokacije:''}],
      kompdo:[{vozila:'',lokacije:''}],
      iznosuer:null,
      location:{lng:null,lat:null},
      proizvodjac: "",
      model: "",
      tablica: "",
      state: "",
      has_error: false,
      error: "",
      success: false,
      dataId: null,
      dataName: "",
      dataCategory: null,
      result: { value: "", label: "" },
      dataImg: null,
      dataOrder_status: "pending",
      dataPrice: 0,

      category_choices: [
        { text: "Audio", value: "audio" },
        { text: "Computers", value: "computers" },
        { text: "Fitness", value: "fitness" },
        { text: "Appliance", value: "appliance" },
      ],

      order_status_choices: [
        { text: "Pending", value: "pending" },
        { text: "Canceled", value: "canceled" },
        { text: "Delivered", value: "delivered" },
        { text: "On Hold", value: "on_hold" },
      ],
      settings: {
        // perfectscrollbar settings
        maxScrollbarLength: 60,
        wheelSpeed: 0.6,
      },
    };
  },
  watch: {
    isSidebarActive(val) {
      if (!val) return;
      if (Object.entries(this.data).length === 0) {
        this.initValues();
        this.$validator.reset();
      } else {
        console.log(this.data)
        const {  id, proizvodjac, model, tablica } = JSON.parse(
          JSON.stringify(this.data)
        );
        this.dataId = id;
        this.proizvodjac = proizvodjac;
        this.model = model;
        this.tablica = tablica;
        
       this.provjera=true
        //this.initValues();
      }
      // Object.entries(this.data).length === 0 ? this.initValues() : { this.dataId, this.dataName, this.dataCategory, this.dataOrder_status, this.dataPrice } = JSON.parse(JSON.stringify(this.data))
    },
  },
  computed: {
    isSidebarActiveLocal: {
      get() {
        return this.isSidebarActive;
      },
      set(val) {
        if (!val) {
          this.$emit("closeSidebar");
          // this.$validator.reset()
          // this.initValues()
        }
      },
    },
    isFormValid() {
      return (
       
        this.proizvodjac &&
        this.model &&
        this.tablica  
        
      );
    },
    scrollbarTag() {
      return this.$store.getters.scrollbarTag;
    },
  },
  created () {
        
    
       this.getKompanije()
  },
  methods: {
      addod () {
      this.kompod.push({
        lokacije: '',
        vozila: ''
      })
      console.log(this.kompod)
    },
 adddo () {
      this.kompdo.push({
        lokacije: '',
        vozila: ''
      })
      console.log(this.kompdo)
    },
    removeod (index) {
      this.kompod.splice(index, 1)
    },
      removedo (index) {
      this.kompdo.splice(index, 1)
    },
     getKompanije(){

     this.$http.get('/api/auth/kompanije', { headers:{
      'Authorization':"Bearer" + localStorage.getItem('accessToken')
    }})
      .then((response) => { this.kompanije=response.data.results 
      console.log(this.kompanije)
      })
      .catch((error)   => { console.log(error) })
      
    },
   changeKM(){
this.iznosuer=(this.iznoskm/1.95).toFixed(2)
   }, changeEUR(){
this.iznoskm=this.iznosuer * 1.95
   },
  addclient() {
      let app = this;
      let url="/api/auth/addkamion"
      if(app.dataId !== null){
        url="/api/auth/updatekamion"
      }
      this.$http
        .post(url, {
          id:app.dataId,
          proizvodjac: app.proizvodjac,
          model: app.model,
          tablica: app.tablica,
          
        })
        .then(function (response) {
          app.success = true;
          app.initValues()
          app.isSidebarActive=false
          location.reload();

           
        })
        .catch(function (res) {
          console.log(res.response.data.errors);
          app.has_error = true;
          app.error = res.response.data.error;
          app.errors = res.response.data.errors || {};
        });
      
    },
    initValues() {
      
      
      this.proizvodjac = "";
      this.model = "";
     
      this.tablica = "";
      
      
    },
    
  },
};
</script>

<style lang="scss" scoped>
.add-new-data-sidebar {
  ::v-deep .vs-sidebar--background {
    z-index: 52010;
  }

  ::v-deep .vs-sidebar {
    z-index: 52010;
    width: 800px;
    max-width: 90vw;

    .img-upload {
      margin-top: 2rem;

      .con-img-upload {
        padding: 0;
      }

      .con-input-upload {
        width: 100%;
        margin: 0;
      }
    }
  }
}

.scroll-area--data-list-add-new {
  // height: calc(var(--vh, 1vh) * 100 - 4.3rem);
  height: calc(var(--vh, 1vh) * 100 - 16px - 45px - 82px);

  &:not(.ps) {
    overflow-y: auto;
  }
}
</style>
