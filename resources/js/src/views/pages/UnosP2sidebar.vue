<!-- =========================================================================================
  File Name: AddNewDataSidebar.vue
  Description: Add New Data - Sidebar component
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>

  <vs-sidebar click-not-close position-right parent="body" default-index="1" color="primary" class="add-new-data-sidebar items-no-padding" spacer v-model="isSidebarActiveLocal">
    <div class="mt-6 flex items-center justify-between px-6">

        <h4>{{ Object.entries(this.data).length === 0 ? "Dodaj" : "Izmjeni" }} Kompaniju</h4>
        <feather-icon icon="XIcon" @click.stop="isSidebarActiveLocal = false" class="cursor-pointer"></feather-icon>
    </div>
    <vs-divider class="mb-0"></vs-divider>

    <component :is="scrollbarTag" class="scroll-area--data-list-add-new" :settings="settings" :key="$vs.rtl">
   <form autocomplete="off" @submit.prevent="addclient" v-if="!success" method="post">
                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.name }">
                        <label for="name">Naziv</label>
                        <input type="text" id="name" class="form-control" placeholder="Korisnik" v-model="name">
                        <span class="help-block" v-if="has_error && errors.name">{{ errors.name }}</span>
                    </div>
                      <div class="row">
              <div class="col-md-12">
                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.email }">
                        <label for="adrress">Adresa</label>
                        <input type="text" id="address" class="form-control" placeholder="Dunajska cesta 2" v-model="address">
                        <span class="help-block" v-if="has_error && errors.address">{{ errors.address }}</span>
                    </div>
                    </div>
   <div class="col-md-12">
                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.email }">
                        <label for="city">Adresa</label>
                        <input type="text" id="city" class="form-control" placeholder="Ljubljana" v-model="city">
                        <span class="help-block" v-if="has_error && errors.city">{{ errors.city }}</span>
                    </div>
                    </div>

   <div class="col-md-12">
                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.email }">
                        <label for="state">Država</label>
                        <input type="text" id="state" class="form-control" placeholder="Slovenija" v-model="state">
                        <span class="help-block" v-if="has_error && errors.state">{{ errors.state }}</span>
                    </div>
                    </div>
                    </div>
                       <div class="p-6">

    

        
         <v-select label="label" v-model="result" :options="optionsCountry"   class="mt-5 w-full" >
           </v-select>
          <p>Izabrana:{{result.value}}</p>
        
         
      
      </div>

                     

                    <button type="submit" v-if="provjera" class="btn btn-primary">Dodaj klijenta</button>
                    <a v-on:click="provjeraAdrese" class="btn btn-warning">Provjeri</a>
                </form>
   
    </component>

    <div class="flex flex-wrap items-center p-6" slot="footer">
      <vs-button class="mr-6" @click="submitData" :disabled="!isFormValid">Submit</vs-button>
      <vs-button type="border" color="danger" @click="isSidebarActiveLocal = false">Cancel</vs-button>
    </div>
  </vs-sidebar>
</template>

<script>
import VuePerfectScrollbar from 'vue-perfect-scrollbar'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

export default {
  props: {
    isSidebarActive: {
      type: Boolean,
      required: true
    },
    data: {
      type: Object,
      default: () => {}
    }
  },
  components: {
    VuePerfectScrollbar,
        'v-select': vSelect,

  },
  data () {
    return {
       provjera:false,
        name: '',
        address: '',
        city: '',
        state: '',
        has_error: false,
        error: '',
         success: false,
optionsCountry:[{ value:'AF',label:'Afghanistan'},{ value:'AX',label:'Åland Islands'},{ value:'AL',label:'Albania'},{ value:'DZ',label:'Algeria'},{ value:'AS',label:'American Samoa'},{ value:'AD',label:'Andorra'},{ value:'AO',label:'Angola'},{ value:'AI',label:'Anguilla'},{ value:'AQ',label:'Antarctica'},{ value:'AG',label:'Antigua and Barbuda'},{ value:'AR',label:'Argentina'},{ value:'AM',label:'Armenia'},{ value:'AW',label:'Aruba'},{ value:'AU',label:'Australia'},{ value:'AT',label:'Austria'},{ value:'AZ',label:'Azerbaijan'},{ value:'BS',label:'Bahamas'},{ value:'BH',label:'Bahrain'},{ value:'BD',label:'Bangladesh'},{ value:'BB',label:'Barbados'},{ value:'BY',label:'Belarus'},{ value:'BE',label:'Belgium'},{ value:'BZ',label:'Belize'},{ value:'BJ',label:'Benin'},{ value:'BM',label:'Bermuda'},{ value:'BT',label:'Bhutan'},{ value:'BO',label:'Bolivia, Plurinational State of'},{ value:'BQ',label:'Bonaire, Sint Eustatius and Saba'},{ value:'BA',label:'Bosnia and Herzegovina'},{ value:'BW',label:'Botswana'},{ value:'BV',label:'Bouvet Island'},{ value:'BR',label:'Brazil'},{ value:'IO',label:'British Indian Ocean Territory'},{ value:'BN',label:'Brunei Darussalam'},{ value:'BG',label:'Bulgaria'},{ value:'BF',label:'Burkina Faso'},{ value:'BI',label:'Burundi'},{ value:'KH',label:'Cambodia'},{ value:'CM',label:'Cameroon'},{ value:'CA',label:'Canada'},{ value:'CV',label:'Cape Verde'},{ value:'KY',label:'Cayman Islands'},{ value:'CF',label:'Central African Republic'},{ value:'TD',label:'Chad'},{ value:'CL',label:'Chile'},{ value:'CN',label:'China'},{ value:'CX',label:'Christmas Island'},{ value:'CC',label:'Cocos (Keeling) Islands'},{ value:'CO',label:'Colombia'},{ value:'KM',label:'Comoros'},{ value:'CG',label:'Congo'},{ value:'CD',label:'Congo, the Democratic Republic of the'},{ value:'CK',label:'Cook Islands'},{ value:'CR',label:'Costa Rica'},{ value:'CI',label:'Côte d\'Ivoire'},{ value:'HR',label:'Croatia'},{ value:'CU',label:'Cuba'},{ value:'CW',label:'Curaçao'},{ value:'CY',label:'Cyprus'},{ value:'CZ',label:'Czech Republic'},{ value:'DK',label:'Denmark'},{ value:'DJ',label:'Djibouti'},{ value:'DM',label:'Dominica'},{ value:'DO',label:'Dominican Republic'},{ value:'EC',label:'Ecuador'},{ value:'EG',label:'Egypt'},{ value:'SV',label:'El Salvador'},{ value:'GQ',label:'Equatorial Guinea'},{ value:'ER',label:'Eritrea'},{ value:'EE',label:'Estonia'},{ value:'ET',label:'Ethiopia'},{ value:'FK',label:'Falkland Islands (Malvinas)'},{ value:'FO',label:'Faroe Islands'},{ value:'FJ',label:'Fiji'},{ value:'FI',label:'Finland'},{ value:'FR',label:'France'},{ value:'GF',label:'French Guiana'},{ value:'PF',label:'French Polynesia'},{ value:'TF',label:'French Southern Territories'},{ value:'GA',label:'Gabon'},{ value:'GM',label:'Gambia'},{ value:'GE',label:'Georgia'},{ value:'DE',label:'Germany'},{ value:'GH',label:'Ghana'},{ value:'GI',label:'Gibraltar'},{ value:'GR',label:'Greece'},{ value:'GL',label:'Greenland'},{ value:'GD',label:'Grenada'},{ value:'GP',label:'Guadeloupe'},{ value:'GU',label:'Guam'},{ value:'GT',label:'Guatemala'},{ value:'GG',label:'Guernsey'},{ value:'GN',label:'Guinea'},{ value:'GW',label:'Guinea-Bissau'},{ value:'GY',label:'Guyana'},{ value:'HT',label:'Haiti'},{ value:'HM',label:'Heard Island and McDonald Islands'},{ value:'VA',label:'Holy See (Vatican City State)'},{ value:'HN',label:'Honduras'},{ value:'HK',label:'Hong Kong'},{ value:'HU',label:'Hungary'},{ value:'IS',label:'Iceland'},{ value:'IN',label:'India'},{ value:'ID',label:'Indonesia'},{ value:'IR',label:'Iran, Islamic Republic of'},{ value:'IQ',label:'Iraq'},{ value:'IE',label:'Ireland'},{ value:'IM',label:'Isle of Man'},{ value:'IL',label:'Israel'},{ value:'IT',label:'Italy'},{ value:'JM',label:'Jamaica'},{ value:'JP',label:'Japan'},{ value:'JE',label:'Jersey'},{ value:'JO',label:'Jordan'},{ value:'KZ',label:'Kazakhstan'},{ value:'KE',label:'Kenya'},{ value:'KI',label:'Kiribati'},{ value:'KP',label:'Korea, Democratic People\'s Republic of'},{ value:'KR',label:'Korea, Republic of'},{ value:'KW',label:'Kuwait'},{ value:'KG',label:'Kyrgyzstan'},{ value:'LA',label:'Lao People\'s Democratic Republic'},{ value:'LV',label:'Latvia'},{ value:'LB',label:'Lebanon'},{ value:'LS',label:'Lesotho'},{ value:'LR',label:'Liberia'},{ value:'LY',label:'Libya'},{ value:'LI',label:'Liechtenstein'},{ value:'LT',label:'Lithuania'},{ value:'LU',label:'Luxembourg'},{ value:'MO',label:'Macao'},{ value:'MK',label:'Macedonia, the Former Yugoslav Republic of'},{ value:'MG',label:'Madagascar'},{ value:'MW',label:'Malawi'},{ value:'MY',label:'Malaysia'},{ value:'MV',label:'Maldives'},{ value:'ML',label:'Mali'},{ value:'MT',label:'Malta'},{ value:'MH',label:'Marshall Islands'},{ value:'MQ',label:'Martinique'},{ value:'MR',label:'Mauritania'},{ value:'MU',label:'Mauritius'},{ value:'YT',label:'Mayotte'},{ value:'MX',label:'Mexico'},{ value:'FM',label:'Micronesia, Federated States of'},{ value:'MD',label:'Moldova, Republic of'},{ value:'MC',label:'Monaco'},{ value:'MN',label:'Mongolia'},{ value:'ME',label:'Montenegro'},{ value:'MS',label:'Montserrat'},{ value:'MA',label:'Morocco'},{ value:'MZ',label:'Mozambique'},{ value:'MM',label:'Myanmar'},{ value:'NA',label:'Namibia'},{ value:'NR',label:'Nauru'},{ value:'NP',label:'Nepal'},{ value:'NL',label:'Netherlands'},{ value:'NC',label:'New Caledonia'},{ value:'NZ',label:'New Zealand'},{ value:'NI',label:'Nicaragua'},{ value:'NE',label:'Niger'},{ value:'NG',label:'Nigeria'},{ value:'NU',label:'Niue'},{ value:'NF',label:'Norfolk Island'},{ value:'MP',label:'Northern Mariana Islands'},{ value:'NO',label:'Norway'},{ value:'OM',label:'Oman'},{ value:'PK',label:'Pakistan'},{ value:'PW',label:'Palau'},{ value:'PS',label:'Palestine, State of'},{ value:'PA',label:'Panama'},{ value:'PG',label:'Papua New Guinea'},{ value:'PY',label:'Paraguay'},{ value:'PE',label:'Peru'},{ value:'PH',label:'Philippines'},{ value:'PN',label:'Pitcairn'},{ value:'PL',label:'Poland'},{ value:'PT',label:'Portugal'},{ value:'PR',label:'Puerto Rico'},{ value:'QA',label:'Qatar'},{ value:'RE',label:'Réunion'},{ value:'RO',label:'Romania'},{ value:'RU',label:'Russian Federation'},{ value:'RW',label:'Rwanda'},{ value:'BL',label:'Saint Barthélemy'},{ value:'SH',label:'Saint Helena, Ascension and Tristan da Cunha'},{ value:'KN',label:'Saint Kitts and Nevis'},{ value:'LC',label:'Saint Lucia'},{ value:'MF',label:'Saint Martin (French part)'},{ value:'PM',label:'Saint Pierre and Miquelon'},{ value:'VC',label:'Saint Vincent and the Grenadines'},{ value:'WS',label:'Samoa'},{ value:'SM',label:'San Marino'},{ value:'ST',label:'Sao Tome and Principe'},{ value:'SA',label:'Saudi Arabia'},{ value:'SN',label:'Senegal'},{ value:'RS',label:'Serbia'},{ value:'SC',label:'Seychelles'},{ value:'SL',label:'Sierra Leone'},{ value:'SG',label:'Singapore'},{ value:'SX',label:'Sint Maarten (Dutch part)'},{ value:'SK',label:'Slovakia'},{ value:'SI',label:'Slovenia'},{ value:'SB',label:'Solomon Islands'},{ value:'SO',label:'Somalia'},{ value:'ZA',label:'South Africa'},{ value:'GS',label:'South Georgia and the South Sandwich Islands'},{ value:'SS',label:'South Sudan'},{ value:'ES',label:'Spain'},{ value:'LK',label:'Sri Lanka'},{ value:'SD',label:'Sudan'},{ value:'SR',label:'Suriname'},{ value:'SJ',label:'Svalbard and Jan Mayen'},{ value:'SZ',label:'Swaziland'},{ value:'SE',label:'Sweden'},{ value:'CH',label:'Switzerland'},{ value:'SY',label:'Syrian Arab Republic'},{ value:'TW',label:'Taiwan, Province of China'},{ value:'TJ',label:'Tajikistan'},{ value:'TZ',label:'Tanzania, United Republic of'},{ value:'TH',label:'Thailand'},{ value:'TL',label:'Timor-Leste'},{ value:'TG',label:'Togo'},{ value:'TK',label:'Tokelau'},{ value:'TO',label:'Tonga'},{ value:'TT',label:'Trinidad and Tobago'},{ value:'TN',label:'Tunisia'},{ value:'TR',label:'Turkey'},{ value:'TM',label:'Turkmenistan'},{ value:'TC',label:'Turks and Caicos Islands'},{ value:'TV',label:'Tuvalu'},{ value:'UG',label:'Uganda'},{ value:'UA',label:'Ukraine'},{ value:'AE',label:'United Arab Emirates'},{ value:'GB',label:'United Kingdom'},{ value:'US',label:'United States'},{ value:'UM',label:'United States Minor Outlying Islands'},{ value:'UY',label:'Uruguay'},{ value:'UZ',label:'Uzbekistan'},{ value:'VU',label:'Vanuatu'},{ value:'VE',label:'Venezuela, Bolivarian Republic of'},{ value:'VN',label:'Viet Nam'},{ value:'VG',label:'Virgin Islands, British'},{ value:'VI',label:'Virgin Islands, U.S.'},{ value:'WF',label:'Wallis and Futuna'},{ value:'EH',label:'Western Sahara'},{ value:'YE',label:'Yemen'},{ value:'ZM',label:'Zambia'},{ value:'ZW',label:'Zimbabwe'}],
      dataId: null,
      dataName: '',
      dataCategory: null,
      result:{value:"",label:""},
      dataImg: null,
      dataOrder_status: 'pending',
      dataPrice: 0,

      category_choices: [
        {text:'Audio', value:'audio'},
        {text:'Computers', value:'computers'},
        {text:'Fitness', value:'fitness'},
        {text:'Appliance', value:'appliance'}
      ],

      order_status_choices: [
        {text:'Pending', value:'pending'},
        {text:'Canceled', value:'canceled'},
        {text:'Delivered', value:'delivered'},
        {text:'On Hold', value:'on_hold'}
      ],
      settings: { // perfectscrollbar settings
        maxScrollbarLength: 60,
        wheelSpeed: .60
      }
    }
  },
  watch: {
    isSidebarActive (val) {
      if (!val) return
      if (Object.entries(this.data).length === 0) {
        this.initValues()
        this.$validator.reset()
      } else {
        const { category, id, img, name, order_status, price } = JSON.parse(JSON.stringify(this.data))
        this.dataId = id
        this.dataCategory = category
        this.dataImg = img
        this.dataName = name
        this.dataOrder_status = order_status
        this.dataPrice = price
        this.initValues()
      }
      // Object.entries(this.data).length === 0 ? this.initValues() : { this.dataId, this.dataName, this.dataCategory, this.dataOrder_status, this.dataPrice } = JSON.parse(JSON.stringify(this.data))
    }
  },
  computed: {
    isSidebarActiveLocal: {
      get () {
        return this.isSidebarActive
      },
      set (val) {
        if (!val) {
          this.$emit('closeSidebar')
          // this.$validator.reset()
          // this.initValues()
        }
      }
    },
    isFormValid () {
      return !this.errors.any() && this.dataName && this.dataCategory && this.dataPrice > 0
    },
    scrollbarTag () { return this.$store.getters.scrollbarTag }
  },
  methods: {provjeraAdrese(){
        this.$http
      .get('https://maps.googleapis.com/maps/api/geocode/json?address=Vojvode%20Misica%2032c%2F11%20Doboj%2C%20Bosna%20i%20Hercegovina%2C&key=AIzaSyDB4XahmDBU2vfMiZk4Auw_odUh9OIF7q0')
      .then(response => (
        console.log(response.data)
        )
        )
        this.provjera=true
      },
      addclient() {
        
           let app = this;
                this.$http.post('/api/auth/addclient', {
                     address: app.address,
            city: app.city,
            name: app.name,
            state: app.state,
            lng:11,
            lat:11
                })
                .then(function (response) {
                    app.success = true
            this.$router.push({name: 'admin.dashboard', params: {successRegistrationRedirect: true}})
                })
                .catch(function (res) {
                    console.log(res.response.data.errors)
            app.has_error = true
            app.error = res.response.data.error
            app.errors = res.response.data.errors || {}
                });
       /* this.$auth.addclient({
          data: {
            address: app.address,
            city: app.city,
            name: app.name,
            state: app.state,
            lng:11,
            lat:11,
            
          },
          success: function () {
            app.success = true
            this.$router.push({name: 'admin.dashboard', params: {successRegistrationRedirect: true}})
          },
          error: function (res) {
            console.log(res.response.data.errors)
            app.has_error = true
            app.error = res.response.data.error
            app.errors = res.response.data.errors || {}
          }
        }) */
      },
    initValues () {
      if (this.data.id) return
      this.dataId = null
      this.dataName = ''
      this.dataCategory = null
      this.dataOrder_status = 'pending'
      this.dataPrice = 0
      this.dataImg = null
    },
    submitData () {
      this.$validator.validateAll().then(result => {
        if (result) {
          const obj = {
            id: this.dataId,
            name: this.dataName,
            img: this.dataImg,
            category: this.dataCategory,
            order_status: this.dataOrder_status,
            price: this.dataPrice
          }

          if (this.dataId !== null && this.dataId >= 0) {
            this.$store.dispatch('dataList/updateItem', obj).catch(err => { console.error(err) })
          } else {
            delete obj.id
            obj.popularity = 0
            this.$store.dispatch('dataList/addItem', obj).catch(err => { console.error(err) })
          }

          this.$emit('closeSidebar')
          this.initValues()
        }
      })
    },
    updateCurrImg (input) {
      if (input.target.files && input.target.files[0]) {
        const reader = new FileReader()
        reader.onload = e => {
          this.dataImg = e.target.result
        }
        reader.readAsDataURL(input.target.files[0])
      }
    }
  }
}
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
