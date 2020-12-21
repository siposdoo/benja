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
        Vozača
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
      <div class="p-6">
        <form
          autocomplete="off"
          @submit.prevent="addclient"
          v-if="!success"
          method="post"
        >
          <vs-input
            label="Ime i prezime"
            v-model="name"
            class="mt-5 w-full"
             v-validate="'required'"
          />
          <span class="text-danger text-sm" v-show="errors.has('name')">{{
            errors.first("name")
          }}</span>

          <vs-input
            label="Puna adresa stanovanja"
            v-model="address"
            placeholder="Marsala Tita 22, Sarajevo"
            class="mt-5 w-full"
             v-validate="'required'"
          />
          <span class="text-danger text-sm" v-show="errors.has('address')">{{
            errors.first("address")
          }}</span>
 
          <vs-input
            label="Kontakt telefon"
            v-model="kontakt"
            placeholder="Kontakt telefon"
            class="mt-5 w-full"
             v-validate="'required'"
          />
          <span class="text-danger text-sm" v-show="errors.has('city')">{{
            errors.first("city")
          }}</span>

         

         </form>
        
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
      location:{lng:null,lat:null},
      name: "",
      address: "",
      kontakt: "",
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
        const {  id, name, address, kontakt } = JSON.parse(
          JSON.stringify(this.data)
        );
        this.dataId = id;
        this.name = name;
        this.address = address;
        this.kontakt = kontakt;
        
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
       
        this.name &&
        this.address &&
        this.kontakt 
         
      );
    },
    scrollbarTag() {
      return this.$store.getters.scrollbarTag;
    },
  },
  methods: {
    
    addclient() {
      let app = this;
      let url="/api/auth/addvozac"
      if(app.dataId !== null){
        url="/api/auth/updatevozac"
      }
      this.$http
        .post(url, {
          id:app.dataId,
          address: app.address,
          kontakt: app.kontakt,
          name: app.name
           
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
      
      
      this.name = "";
      this.address = "";
      
      this.kontakt = "";
      this.dataId=null;
      
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
    width: 400px;
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
