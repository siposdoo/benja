 

<template>
  <div id="ag-grid-demo">
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
          <vs-button class="mb-4 md:mb-0 bg-danger"  @click="popupActive=true">Dodaj proizvod</vs-button>
        </div>
      </div>
       
             
            <vs-popup fullscreen title="Novi proizvod" :active.sync="popupActive">
               
                   <vx-card title="Default" code-toggler>

        <p>You can upload files to the server with the <code>vs-upload</code> component, the requested parameter is <code>action</code> which is the URL of the server</p>

        <vs-alert color="primary" icon="new_releases" active="true" class="mt-5">
            <p>For the title of each tab the <code>vs-label</code> property is implemented in the <code>vs-tab</code> component</p>
        </vs-alert>

        <div class="mt-5">
            <vs-upload limit="1" show-upload-button="false" action="/api/auth/image/"  text="Dodaj sliku proizvoda" fileName="photo" @on-success="successUpload" />
        </div>

    

    </vx-card>
                 </vs-popup>
       
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
 
import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'
import {AG_GRID_LOCALE_EN} from './local';
export default {
  components: {
    AgGridVue
  },
  data () {
    return {
      popupActive:false,
      searchQuery: '',
      gridOptions: {},
      maxPageNumbers: 7,
      gridApi: null,
      products:[],
      localeText:{},
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
  watch: {
    '$store.state.windowWidth' (val) {
      if (val <= 576) {
        this.maxPageNumbers = 4
        this.gridOptions.columnApi.setColumnPinned('id', null)
      } else this.gridOptions.columnApi.setColumnPinned('id', 'left')
    }
  },
  created () {
    this.localeText=AG_GRID_LOCALE_EN
     //  User Reward Card
    this.$http.get('/api/auth/products')
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
    successUpload (event) {
       this.$vs.notify({ color: 'success', title: 'Upload Success', text: 'Lorem ipsum dolor sit amet, consectetur' })
    },
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
