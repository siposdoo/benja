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
        Kompaniju
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
            label="Naziv"
            v-model="name"
            class="mt-5 w-full"
            name="name"
            v-validate="'required'"
          />
          <span class="text-danger text-sm" v-show="errors.has('name')">{{
            errors.first("name")
          }}</span>

          <vs-input
            label="Adresa"
            v-model="address"
            placeholder="Dunajska cesta 2"
            class="mt-5 w-full"
            name="name"
            v-validate="'required'"
          />
          <span class="text-danger text-sm" v-show="errors.has('address')">{{
            errors.first("address")
          }}</span>
 
          <vs-input
            label="Grad"
            v-model="city"
            placeholder="Ljubljana"
            class="mt-5 w-full"
            name="city"
            v-validate="'required'"
          />
          <span class="text-danger text-sm" v-show="errors.has('city')">{{
            errors.first("city")
          }}</span>

           <label for="" class="vs-input--label">Država</label>
          <v-select
            label="label"
            placeholder="Država"
            v-model="lokacija"
            :value="lokacija"
            :options="optionsCountry"
            class="mt-5 w-full tet"
          >
          </v-select>

            <vs-input
            label="Kontakt"
            v-model="kontakt"
            placeholder="065123122, email@email.com..."
            class="mt-5 w-full"
            name="kontakt"
            
          />
          <i>Za vise kontakata razdvojite ih znakom ';'</i>
          <span class="text-danger text-sm" v-show="errors.has('kontakt')">{{
            errors.first("kontakt")
          }}</span>

         </form>
         <gmap-map v-if="provjera" class="mt-5 w-full tet" :center="location" :zoom="15" style="width: 100%; height: 300px">
   
    <gmap-marker :position="location" :clickable="true" @click="provjera2=true"></gmap-marker>
  </gmap-map>
      </div>
    </component>

    <div class="flex flex-wrap items-center p-6" slot="footer">
      <vs-button
        type="border"
        class="mr-3"
        color="warning"
        :disabled="!isFormValid"
        @click="provjeraAdrese"
        >Provjeri</vs-button>

      <vs-button class="mr-3" @click="addclient()" :disabled="!provjera2"
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
      lokacija:null,
      location:{lng:null,lat:null},
      name: "",
      kompanija: "",
      kontakt:"",
      address: "",
      city: "",
      state: "",
      has_error: false,
      error: "",
      success: false,
      optionsCountry: [
        { value: "AF", label: "Afghanistan" },
        { value: "AX", label: "Åland Islands" },
        { value: "AL", label: "Albania" },
        { value: "DZ", label: "Algeria" },
        { value: "AS", label: "American Samoa" },
        { value: "AD", label: "Andorra" },
        { value: "AO", label: "Angola" },
        { value: "AI", label: "Anguilla" },
        { value: "AQ", label: "Antarctica" },
        { value: "AG", label: "Antigua and Barbuda" },
        { value: "AR", label: "Argentina" },
        { value: "AM", label: "Armenia" },
        { value: "AW", label: "Aruba" },
        { value: "AU", label: "Australia" },
        { value: "AT", label: "Austria" },
        { value: "AZ", label: "Azerbaijan" },
        { value: "BS", label: "Bahamas" },
        { value: "BH", label: "Bahrain" },
        { value: "BD", label: "Bangladesh" },
        { value: "BB", label: "Barbados" },
        { value: "BY", label: "Belarus" },
        { value: "BE", label: "Belgium" },
        { value: "BZ", label: "Belize" },
        { value: "BJ", label: "Benin" },
        { value: "BM", label: "Bermuda" },
        { value: "BT", label: "Bhutan" },
        { value: "BO", label: "Bolivia, Plurinational State of" },
        { value: "BQ", label: "Bonaire, Sint Eustatius and Saba" },
        { value: "BA", label: "Bosnia and Herzegovina" },
        { value: "BW", label: "Botswana" },
        { value: "BV", label: "Bouvet Island" },
        { value: "BR", label: "Brazil" },
        { value: "IO", label: "British Indian Ocean Territory" },
        { value: "BN", label: "Brunei Darussalam" },
        { value: "BG", label: "Bulgaria" },
        { value: "BF", label: "Burkina Faso" },
        { value: "BI", label: "Burundi" },
        { value: "KH", label: "Cambodia" },
        { value: "CM", label: "Cameroon" },
        { value: "CA", label: "Canada" },
        { value: "CV", label: "Cape Verde" },
        { value: "KY", label: "Cayman Islands" },
        { value: "CF", label: "Central African Republic" },
        { value: "TD", label: "Chad" },
        { value: "CL", label: "Chile" },
        { value: "CN", label: "China" },
        { value: "CX", label: "Christmas Island" },
        { value: "CC", label: "Cocos (Keeling) Islands" },
        { value: "CO", label: "Colombia" },
        { value: "KM", label: "Comoros" },
        { value: "CG", label: "Congo" },
        { value: "CD", label: "Congo, the Democratic Republic of the" },
        { value: "CK", label: "Cook Islands" },
        { value: "CR", label: "Costa Rica" },
        { value: "CI", label: "Côte d'Ivoire" },
        { value: "HR", label: "Croatia" },
        { value: "CU", label: "Cuba" },
        { value: "CW", label: "Curaçao" },
        { value: "CY", label: "Cyprus" },
        { value: "CZ", label: "Czech Republic" },
        { value: "DK", label: "Denmark" },
        { value: "DJ", label: "Djibouti" },
        { value: "DM", label: "Dominica" },
        { value: "DO", label: "Dominican Republic" },
        { value: "EC", label: "Ecuador" },
        { value: "EG", label: "Egypt" },
        { value: "SV", label: "El Salvador" },
        { value: "GQ", label: "Equatorial Guinea" },
        { value: "ER", label: "Eritrea" },
        { value: "EE", label: "Estonia" },
        { value: "ET", label: "Ethiopia" },
        { value: "FK", label: "Falkland Islands (Malvinas)" },
        { value: "FO", label: "Faroe Islands" },
        { value: "FJ", label: "Fiji" },
        { value: "FI", label: "Finland" },
        { value: "FR", label: "France" },
        { value: "GF", label: "French Guiana" },
        { value: "PF", label: "French Polynesia" },
        { value: "TF", label: "French Southern Territories" },
        { value: "GA", label: "Gabon" },
        { value: "GM", label: "Gambia" },
        { value: "GE", label: "Georgia" },
        { value: "DE", label: "Germany" },
        { value: "GH", label: "Ghana" },
        { value: "GI", label: "Gibraltar" },
        { value: "GR", label: "Greece" },
        { value: "GL", label: "Greenland" },
        { value: "GD", label: "Grenada" },
        { value: "GP", label: "Guadeloupe" },
        { value: "GU", label: "Guam" },
        { value: "GT", label: "Guatemala" },
        { value: "GG", label: "Guernsey" },
        { value: "GN", label: "Guinea" },
        { value: "GW", label: "Guinea-Bissau" },
        { value: "GY", label: "Guyana" },
        { value: "HT", label: "Haiti" },
        { value: "HM", label: "Heard Island and McDonald Islands" },
        { value: "VA", label: "Holy See (Vatican City State)" },
        { value: "HN", label: "Honduras" },
        { value: "HK", label: "Hong Kong" },
        { value: "HU", label: "Hungary" },
        { value: "IS", label: "Iceland" },
        { value: "IN", label: "India" },
        { value: "ID", label: "Indonesia" },
        { value: "IR", label: "Iran, Islamic Republic of" },
        { value: "IQ", label: "Iraq" },
        { value: "IE", label: "Ireland" },
        { value: "IM", label: "Isle of Man" },
        { value: "IL", label: "Israel" },
        { value: "IT", label: "Italy" },
        { value: "JM", label: "Jamaica" },
        { value: "JP", label: "Japan" },
        { value: "JE", label: "Jersey" },
        { value: "JO", label: "Jordan" },
        { value: "KZ", label: "Kazakhstan" },
        { value: "KE", label: "Kenya" },
        { value: "KI", label: "Kiribati" },
        { value: "KP", label: "Korea, Democratic People's Republic of" },
        { value: "KR", label: "Korea, Republic of" },
        { value: "KW", label: "Kuwait" },
        { value: "KG", label: "Kyrgyzstan" },
        { value: "LA", label: "Lao People's Democratic Republic" },
        { value: "LV", label: "Latvia" },
        { value: "LB", label: "Lebanon" },
        { value: "LS", label: "Lesotho" },
        { value: "LR", label: "Liberia" },
        { value: "LY", label: "Libya" },
        { value: "LI", label: "Liechtenstein" },
        { value: "LT", label: "Lithuania" },
        { value: "LU", label: "Luxembourg" },
        { value: "MO", label: "Macao" },
        { value: "MK", label: "Macedonia, the Former Yugoslav Republic of" },
        { value: "MG", label: "Madagascar" },
        { value: "MW", label: "Malawi" },
        { value: "MY", label: "Malaysia" },
        { value: "MV", label: "Maldives" },
        { value: "ML", label: "Mali" },
        { value: "MT", label: "Malta" },
        { value: "MH", label: "Marshall Islands" },
        { value: "MQ", label: "Martinique" },
        { value: "MR", label: "Mauritania" },
        { value: "MU", label: "Mauritius" },
        { value: "YT", label: "Mayotte" },
        { value: "MX", label: "Mexico" },
        { value: "FM", label: "Micronesia, Federated States of" },
        { value: "MD", label: "Moldova, Republic of" },
        { value: "MC", label: "Monaco" },
        { value: "MN", label: "Mongolia" },
        { value: "ME", label: "Montenegro" },
        { value: "MS", label: "Montserrat" },
        { value: "MA", label: "Morocco" },
        { value: "MZ", label: "Mozambique" },
        { value: "MM", label: "Myanmar" },
        { value: "NA", label: "Namibia" },
        { value: "NR", label: "Nauru" },
        { value: "NP", label: "Nepal" },
        { value: "NL", label: "Netherlands" },
        { value: "NC", label: "New Caledonia" },
        { value: "NZ", label: "New Zealand" },
        { value: "NI", label: "Nicaragua" },
        { value: "NE", label: "Niger" },
        { value: "NG", label: "Nigeria" },
        { value: "NU", label: "Niue" },
        { value: "NF", label: "Norfolk Island" },
        { value: "MP", label: "Northern Mariana Islands" },
        { value: "NO", label: "Norway" },
        { value: "OM", label: "Oman" },
        { value: "PK", label: "Pakistan" },
        { value: "PW", label: "Palau" },
        { value: "PS", label: "Palestine, State of" },
        { value: "PA", label: "Panama" },
        { value: "PG", label: "Papua New Guinea" },
        { value: "PY", label: "Paraguay" },
        { value: "PE", label: "Peru" },
        { value: "PH", label: "Philippines" },
        { value: "PN", label: "Pitcairn" },
        { value: "PL", label: "Poland" },
        { value: "PT", label: "Portugal" },
        { value: "PR", label: "Puerto Rico" },
        { value: "QA", label: "Qatar" },
        { value: "RE", label: "Réunion" },
        { value: "RO", label: "Romania" },
        { value: "RU", label: "Russian Federation" },
        { value: "RW", label: "Rwanda" },
        { value: "BL", label: "Saint Barthélemy" },
        { value: "SH", label: "Saint Helena, Ascension and Tristan da Cunha" },
        { value: "KN", label: "Saint Kitts and Nevis" },
        { value: "LC", label: "Saint Lucia" },
        { value: "MF", label: "Saint Martin (French part)" },
        { value: "PM", label: "Saint Pierre and Miquelon" },
        { value: "VC", label: "Saint Vincent and the Grenadines" },
        { value: "WS", label: "Samoa" },
        { value: "SM", label: "San Marino" },
        { value: "ST", label: "Sao Tome and Principe" },
        { value: "SA", label: "Saudi Arabia" },
        { value: "SN", label: "Senegal" },
        { value: "RS", label: "Serbia" },
        { value: "SC", label: "Seychelles" },
        { value: "SL", label: "Sierra Leone" },
        { value: "SG", label: "Singapore" },
        { value: "SX", label: "Sint Maarten (Dutch part)" },
        { value: "SK", label: "Slovakia" },
        { value: "SI", label: "Slovenia" },
        { value: "SB", label: "Solomon Islands" },
        { value: "SO", label: "Somalia" },
        { value: "ZA", label: "South Africa" },
        { value: "GS", label: "South Georgia and the South Sandwich Islands" },
        { value: "SS", label: "South Sudan" },
        { value: "ES", label: "Spain" },
        { value: "LK", label: "Sri Lanka" },
        { value: "SD", label: "Sudan" },
        { value: "SR", label: "Suriname" },
        { value: "SJ", label: "Svalbard and Jan Mayen" },
        { value: "SZ", label: "Swaziland" },
        { value: "SE", label: "Sweden" },
        { value: "CH", label: "Switzerland" },
        { value: "SY", label: "Syrian Arab Republic" },
        { value: "TW", label: "Taiwan, Province of China" },
        { value: "TJ", label: "Tajikistan" },
        { value: "TZ", label: "Tanzania, United Republic of" },
        { value: "TH", label: "Thailand" },
        { value: "TL", label: "Timor-Leste" },
        { value: "TG", label: "Togo" },
        { value: "TK", label: "Tokelau" },
        { value: "TO", label: "Tonga" },
        { value: "TT", label: "Trinidad and Tobago" },
        { value: "TN", label: "Tunisia" },
        { value: "TR", label: "Turkey" },
        { value: "TM", label: "Turkmenistan" },
        { value: "TC", label: "Turks and Caicos Islands" },
        { value: "TV", label: "Tuvalu" },
        { value: "UG", label: "Uganda" },
        { value: "UA", label: "Ukraine" },
        { value: "AE", label: "United Arab Emirates" },
        { value: "GB", label: "United Kingdom" },
        { value: "US", label: "United States" },
        { value: "UM", label: "United States Minor Outlying Islands" },
        { value: "UY", label: "Uruguay" },
        { value: "UZ", label: "Uzbekistan" },
        { value: "VU", label: "Vanuatu" },
        { value: "VE", label: "Venezuela, Bolivarian Republic of" },
        { value: "VN", label: "Viet Nam" },
        { value: "VG", label: "Virgin Islands, British" },
        { value: "VI", label: "Virgin Islands, U.S." },
        { value: "WF", label: "Wallis and Futuna" },
        { value: "EH", label: "Western Sahara" },
        { value: "YE", label: "Yemen" },
        { value: "ZM", label: "Zambia" },
        { value: "ZW", label: "Zimbabwe" },
      ],
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
        const {  id, name, address, city,state,lat,lng,kontakt } = JSON.parse(
          JSON.stringify(this.data)
        );
        this.dataId = id;
         this.kontakt = kontakt;
        this.name = name;
        this.address = address;
        this.city = city;
        this.result.value = state;
        let obj = this.optionsCountry.find(o => o.value === state);
        this.result.label = obj.label;
        this.location.lng = parseFloat(lng);
        this.location.lat = parseFloat(lat);
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
       
        this.kontakt &&
        this.address &&
        this.city &&
        this.result.value
        
      );
    },
    scrollbarTag() {
      return this.$store.getters.scrollbarTag;
    },
  },
  methods: {
    provjeraAdrese() {
      var app = this;
      this.$geocoder.setDefaultMode("address"); // this is default
      var addressObj = {
        address_line_1: app.address,
        address_line_2: "",
        city: app.city,
        state: app.result.value, // province also valid
        zip_code: "", // postal_code also valid
        country: app.result.label,
      };
      this.$geocoder.send(addressObj, (response) => {
        if(response.status == "OK"){
          this.provjera=true
          this.location=response.results[0].geometry.location
        }
        console.log( this.location.lat)
        
      });
      /* this.$http
      .get('https://maps.googleapis.com/maps/api/geocode/json?address=Vojvode%20Misica%2032c%2F11%20Doboj%2C%20Bosna%20i%20Hercegovina%2C&key=AIzaSyDB4XahmDBU2vfMiZk4Auw_odUh9OIF7q0')
      .then(response => (
        console.log(response.results)
        )
        )
        this.provjera=true/*/
    },
    addclient() {
      let app = this;
      let url="/api/auth/addclient"
      if(app.dataId !== null){
        url="/api/auth/updateclient"
      }
      this.$http
        .post(url, {
          id:app.dataId,
          address: app.address,
          city: app.city,
          name: app.name,
          kontakt: app.kontakt,
          kompanija: app.kompanija,
          state: app.result.value,
          lng: app.location.lng,
          lat: app.location.lat,
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
      this.kompanija = "";
      this.result = {value:'',label:''};
      this.city = "";
      this.dataId=null;
      this.location = {lat:null,lng:null};
      
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
