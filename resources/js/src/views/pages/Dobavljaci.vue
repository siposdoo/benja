 

<template>
  <div id="ag-grid-demo">
       <vx-card  title="Novi unos" class="mycard" v-if="popupActive">
               
                       
      <form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" :title="null" :subtitle="null" finishButtonText="Submit">
        <tab-content title="Step 1" class="mb-5" icon="feather icon-home" :before-change="validateStep1">

          <!-- tab 1 content -->
          <form data-vv-scope="step-1">
          <div class="vx-row">
             <div class="vx-row md:w-1/3 w-full mt-5">
            <vs-upload limit="1" :headers="{ 
      'Authorization':'Bearer' + lct}" :show-upload-button="false" automatic action="/api/auth/image/"  text="Dodaj sliku proizvoda" fileName="photo" @on-delete="deleteUpload" @on-success="successUpload" />
        </div>
          <div class="vx-row md:w-2/3 w-full mt-5">
            <div class="vx-col md:w-1/2 w-full ">
              <vs-input label="First Name" v-model="firstName" class="w-full" name="first_name" v-validate="'required|alpha'" />
              <span class="text-danger">{{ errors.first('step-1.first_name') }}</span>
            </div>
            <div class="vx-col md:w-1/2 w-full ">
              <vs-input label="Last Name"  v-model="lastName" class="w-full" name="last_name" v-validate="'required|alpha'" />
              <span class="text-danger">{{ errors.first('step-1.last_name') }}</span>
            </div>
            <div class="vx-col md:w-1/2 w-full ">
              <vs-input type="email" label="Email"  v-model="email" class="w-full" name="email" v-validate="'required|email'" />
              <span class="text-danger">{{ errors.first('step-1.email') }}</span>
            </div>
            <div class="vx-col md:w-1/2 w-full ">
              <vs-select v-model="city" class="w-full select-large" label="City">
                <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="(item,index) in cityOptions" class="w-full" />
              </vs-select>
            </div>
          </div>
          </div>
          </form>
        </tab-content>

        <!-- tab 2 content -->
        <tab-content title="Step 2" class="mb-5" icon="feather icon-briefcase" :before-change="validateStep2">
          <form data-vv-scope="step-2">
          <div class="vx-row">
            <div class="vx-col md:w-1/2 w-full">
              <vs-input label="Proposal Title" v-model="proposalTitle" class="w-full mt-4" name="proposal_title" v-validate="'required|alpha_spaces'" />
              <span class="text-danger">{{ errors.first('step-2.proposal_title') }}</span>

              <vs-input label="Job Title"  v-model="jobTitle" class="w-full mt-4" name="job_title" v-validate="'required|alpha_spaces'" />
              <span class="text-danger">{{ errors.first('step-2.job_title') }}</span>
            </div>
            <div class="vx-col md:w-1/2 w-full">
              <vs-textarea v-model="textarea" label="Short discription" class="md:mt-10 mt-6 mb-0" rows="3" />
            </div>
          </div>
          </form>
        </tab-content>

        <!-- tab 3 content -->
        <tab-content title="Step 3" class="mb-5" icon="feather icon-image" :before-change="validateStep3">
          <form data-vv-scope="step-3">
          <div class="vx-row">
            <div class="vx-col md:w-1/1 w-full">
               <div id="editor">
  <p>Hello World!</p>
  <p>Some initial <strong>bold</strong> text</p>
  <p><br></p>
</div>
               
            </div>
          </div>
          </form>
        </tab-content>
         <template slot="custom-buttons-left" >
     <vs-button class="mb-4 md:mb-0 bg-danger"  v-if="popupActive" @click="popupActive=false">Odustani</vs-button>
      </template>
      </form-wizard>
     
    
                  </vx-card>
    <vx-card>

      <!-- TABLE ACTION ROW -->
      <div class="flex flex-wrap justify-between items-center">

        <!-- ITEMS PER PAGE -->
        <div class="mb-4 md:mb-0 mr-4 ag-grid-table-actions-left">
          <vs-dropdown vs-trigger-click class="cursor-pointer">
            <div class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium">
              <span class="mr-2">{{ currentPage * paginationPageSize - (paginationPageSize - 1) }} - {{ products.length - currentPage * paginationPageSize > 0 ? currentPage * paginationPageSize : products.length }} of {{ products.length }}</span>
              <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
            </div>
            <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
            <vs-dropdown-menu>

              <vs-dropdown-item @click="gridApi.paginationSetPageSize(20)">
                <span>20</span>
              </vs-dropdown-item>
              <vs-dropdown-item @click="gridApi.paginationSetPageSize(50)">
                <span>50</span>
              </vs-dropdown-item>
              <vs-dropdown-item @click="gridApi.paginationSetPageSize(100)">
                <span>100</span>
              </vs-dropdown-item>
              <vs-dropdown-item @click="gridApi.paginationSetPageSize(150)">
                <span>150</span>
              </vs-dropdown-item>
            </vs-dropdown-menu>
          </vs-dropdown>
        </div>

        <!-- TABLE ACTION COL-2: SEARCH & EXPORT AS CSV -->
        <div class="flex flex-wrap items-center justify-between ag-grid-table-actions-right">
          <vs-input class="mb-4 md:mb-0 mr-4" v-model="searchQuery" @input="updateSearchQuery" placeholder="Pretraga..." />
          <vs-button class="mb-4 md:mb-0 mr-4" @click="gridApi.exportDataAsCsv()">Izvezi kao CSV</vs-button>
          <vs-button class="mb-4 md:mb-0 bg-warning"  v-if="!popupActive" @click="popupActive=true">Dodaj dobavljača</vs-button>
      
        </div>
      </div>
       
             
          
       
      <ag-grid-vue
        ref="agGridTable"
        :gridOptions="gridOptions"
         class="ag-theme-material w-100 my-4 ag-grid-table"
        :columnDefs="columnDefs"
        :defaultColDef="defaultColDef"
        :rowData="products"
        :localeText="localeText"
        rowSelection="multiple"
        colResizeDefault="shift"
        :animateRows="true"
        :floatingFilter="true"
        :pagination="true"
        :paginationPageSize="paginationPageSize"
        :suppressPaginationPanel="true"
        :enableRtl="$vs.rtl">
      </ag-grid-vue>
      <vs-pagination
        :total="totalPages"
        :max="maxPageNumbers"
        v-model="currentPage" />

    </vx-card>
  </div>
</template>

<script>
import { AgGridVue } from 'ag-grid-vue'
 import {AG_GRID_LOCALE_EN} from '../../i18n/tableLocale'
import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'

// For custom error message
import { Validator } from 'vee-validate'

 var quill = new Quill('#editor', {
    theme: 'snow'
  });

const dict = {
  custom: {
    first_name: {
      required: 'First name is required',
      alpha: 'First name may only contain alphabetic characters'
    },
    last_name: {
      required: 'Last name is required',
      alpha: 'Last name may only contain alphabetic characters'
    },
    email: {
      required: 'Email is required',
      email: 'Please enter valid email'
    },
    job_title: {
      required: 'Job title name is required',
      alpha: 'Job title may only contain alphabetic characters'
    },
    proposal_title: {
      required: 'Proposal title name is required',
      alpha: 'Proposal title may only contain alphabetic characters'
    },
    event_name: {
      required: 'Event name is required',
      alpha: 'Event name may only contain alphabetic characters'
    }
  }
}

// register custom messages
Validator.localize('en', dict)

 export default {
  components: {
    AgGridVue,
     FormWizard,
    TabContent
  },
  data () {
    return {
      popupActive:false,
      searchQuery: '',
      gridOptions: {},
      maxPageNumbers: 7,
      gridApi: null,
      lct:null,
      products:[],
      putanja1:null,
      localeText:null,
      defaultColDef: {
        sortable: true,
        editable: true,
        resizable: true,
        suppressMenu: true
      },
      columnDefs: [
        {
          headerName: '#ID',
          field: 'id',
           filter: true,
          checkboxSelection: true,
          headerCheckboxSelectionFilteredOnly: true,
          headerCheckboxSelection: true
        },
        {
          headerName: 'Naziv',
          field: 'name',
           filter: true,
          },
        {
          headerName: 'Kratak opis',
          field: 'shortdesc',
          filter: true,
         },
        {
          headerName: 'Datum dodavanja',
          field: 'created_at',
          filter: true,
             
        },
       
      ]
      
    }
  },
  beforeMount() {
    this.localeText = AG_GRID_LOCALE_EN;

  }, 
  watch: {
    '$store.state.windowWidth' (val) {
      if (val <= 576) {
        this.maxPageNumbers = 4
        this.gridOptions.columnApi.setColumnPinned('id', null)
      } else this.gridOptions.columnApi.setColumnPinned('id', 'left')
    }
  },
  created () {
    this.lct=localStorage.getItem('accessToken')
    
      //  User Reward Card
    this.$http.get('/api/auth/products', { headers:{
      'Authorization':"Bearer" + localStorage.getItem('accessToken')
    }})
      .then((response) => { this.products=response.data.products })
      .catch((error)   => { console.log(error) })
},
  computed: {
    paginationPageSize () {
      if (this.gridApi) return this.gridApi.paginationGetPageSize()
      else return 50
    },
    totalPages () {
      if (this.gridApi) return this.gridApi.paginationGetTotalPages()
      else return 0
    },
    currentPage: {
      get () {
        if (this.gridApi) return this.gridApi.paginationGetCurrentPage() + 1
        else return 1
      },
      set (val) {
        this.gridApi.paginationGoToPage(val - 1)
      }
    }
  },
  methods: {
    validateStep1 () {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll('step-1').then(result => {
          if (result) {
            resolve(true)
          } else {
            reject('correct all values')
          }
        })
      })
    },
    validateStep2 () {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll('step-2').then(result => {
          if (result) {
            resolve(true)
          } else {
            reject('correct all values')
          }
        })
      })
    },
    validateStep3 () {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll('step-3').then(result => {
          if (result) {
            alert('Form submitted!')
            resolve(true)
          } else {
            reject('correct all values')
          }
        })
      })
    },
    successUpload (event) {
       
      this.putanja1= event.currentTarget.response
       this.$vs.notify({ color: 'success', title: 'Upload Success', text: event.currentTarget.response })
    },
    deleteUpload(){
      alert(this.putanja1)
 this.$http.post('/api/auth/deleteimage',{putanja: this.putanja1}, { headers:{
      'Authorization':"Bearer" + localStorage.getItem('accessToken')
    }})},
    updateSearchQuery (val) {
      this.gridApi.setQuickFilter(val)
    }
  },
  mounted () {
    this.gridApi = this.gridOptions.api

    /* =================================================================
      NOTE:
      Header is not aligned properly in RTL version of agGrid table.
      However, we given fix to this issue. If you want more robust solution please contact them at gitHub
    ================================================================= */
    if (this.$vs.rtl) {
      const header = this.$refs.agGridTable.$el.querySelector('.ag-header-container')
      header.style.left = `-${  String(Number(header.style.transform.slice(11, -3)) + 9)  }px`
    }
  }
}

</script>
