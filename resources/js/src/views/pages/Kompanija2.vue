 

<template>
  <div id="data-list-thumb-view" class="data-list-container">
       <vx-card  :title=" 'Novi unos'"  class="mycard" v-if="popupActive">
               
                       
      <form-wizard 
         finish-button-text="Snimi"  title=""  subtitle=""  next-button-text="Sledeća"  back-button-text="Prethodna" color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)"   finishButtonText="Submit">
        <tab-content title="Generalno" class="mb-5" icon="feather icon-star" :before-change="validateStep1">

          <!-- tab 1 content -->
          <form data-vv-scope="step-1">
            <h5 class="mt-5 wiztitle">Generalno</h5>
          <div class="vx-row">
           
           <div class="vx-col md:w-1/2 w-full ">
              <vs-input type="naslov" label="Naslov za web"  v-model="dataform.naslovweb" class="w-full" name="naslov" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.naslov') }}</span>
            </div>
            <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Šifra dobavljača" v-model="dataform.sifradobavljaca" class="w-full" name="sifradobavljaca" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.sifradobavljaca') }}</span>
            </div>
            <div class="vx-col md:w-1/4 w-full ">
              <vs-input  type="number" label="Količina" v-model="dataform.kolicina" class="w-full" name="kolicina" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.kolicina') }}</span>
            </div>
              <div class="vx-col md:w-1/1 w-full ">
              <vs-input type="naslov" label="Podnaslov"  v-model="dataform.podnaslovweb" class="w-full" name="podnaslov" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.podnaslov') }}</span>
            </div>
          </div>
               <h5 class="mt-5 wiztitle">Cijene</h5>
            <div class="vx-row">

           <div class="vx-col md:w-1/4 w-full ">
                       <label for="" class="vs-input--label">Preporucena javna cijena</label>
              <vs-input-number :step="0.5"  v-validate="'required'" v-model="dataform.pjcijena" class="w-full" name="pjcijena"  />
              <span class="text-danger">{{ errors.first('step-1.pjcijena') }}</span>
            </div>
             <div class="vx-col md:w-1/4 w-full ">
                       <label for="" class="vs-input--label">Stara javna cijena</label>
              <vs-input-number :step="0.5"  v-validate="" v-model="dataform.starapjcijena" class="w-full" name="starapjcijena"   />
              <span class="text-danger">{{ errors.first('step-1.starapjcijena') }}</span>
            </div>
             <div class="vx-col md:w-1/4 w-full ">
                       <label for="" class="vs-input--label">Cijena prema šopu</label>
              <vs-input-number :step="0.5" v-validate="'required'"  v-model="dataform.shopcijena" class="w-full" name="shopcijena"   />
              <span class="text-danger">{{ errors.first('step-1.shopcijena') }}</span>
            </div>
             <div class="vx-col md:w-1/4 w-full ">
                       <label for="" class="vs-input--label">Minimalna cijena</label>
              <vs-input-number :step="0.5" v-validate="'required'"  v-model="dataform.mincijena" class="w-full" name="mincijena" />
              <span class="text-danger">{{ errors.first('step-1.mincijena') }}</span>
              
            </div>
              <div class="vx-col md:w-1/4 w-full mt-5">
                       <label for="" class="vs-input--label">Fixna cijena</label>
                <span>
      <vs-checkbox v-model="dataform.fixcijena">{{dataform.fixcijena?'DA':'NE'}}</vs-checkbox>
    </span>
            </div>
            <div class="vx-col md:w-1/4 w-full mt-5">
                       <label for="" class="vs-input--label">Premijum artikal</label>
                <span>
      <vs-checkbox v-model="dataform.premium">{{dataform.premium?'DA':'NE'}}</vs-checkbox>
    </span>
            </div>
             
            
 
           </div>
            <h5 class="mt-5 wiztitle">Multimedija</h5>
                        <div class="vx-row">
                            <div class="vx-col md:w-1/1 w-full mt-5">
                 <label for="" class="vs-input--label">Naslovna fotografija(max 5)</label>
        
        <vue-dropzone     v-on:vdropzone-success="successUpload"  @vdropzone-removed-file="deleteUpload1"  ref="myVueDropzone" id="dropzone" :options="dropzoneOptions1"></vue-dropzone>

        </div>
        <div class="vx-col md:w-1/1 w-full mt-5">
                         <label for="" class="vs-input--label">Fotografije iz uglova(max 5)</label>

                    <vue-dropzone   v-on:vdropzone-success="successUpload"  @vdropzone-removed-file="deleteUpload2"  ref="myVueDropzone" id="dropzone" :options="dropzoneOptions2"></vue-dropzone>

</div>
        <div class="vx-col md:w-1/1 w-full mt-5">
       <label for="" class="vs-input--label">Fotografije upakovanog proizvoda(max 5)</label>
               <vue-dropzone  v-on:vdropzone-success="successUpload"  @vdropzone-removed-file="deleteUpload3"  ref="myVueDropzone" id="dropzone" :options="dropzoneOptions3"></vue-dropzone>

</div>
  <div class="vx-col md:w-1/1 w-full mt-5">
          <vs-input label="Video link proizvoda" size="large" v-validate="'url:require_protocol'" data-vv-as="field"   name="videoproizvoda" v-model="dataform.videoproizvoda" class="mt-5 w-full" />
  <span class="text-danger">{{ errors.first('step-1.videoproizvoda') }}</span>
            </div>
            <div class="vx-col md:w-1/1 w-full mt-5">
                      <vs-input label="Link proizvodjača" size="large" v-validate="'url:require_protocol'" data-vv-as="field"   name="linkproizvodjaca" v-model="dataform.linkproizvodjaca" class="mt-5 w-full" />

               <span class="text-danger">{{ errors.first('step-1.linkproizvodjaca') }}</span>
            </div>
            

                        </div>

          <h5 class="mt-5 wiztitle">Opisi</h5>
            <div class="vx-row">

                 

            <div class="vx-col md:w-1/1 w-full ">
            <label for="" class="vs-input--label">Opis proizvoda</label>
                     <quill-editor   :style="{'min-height': '150px'}"  v-model="dataform.opis"></quill-editor>

            </div>
                   
           </div>

                       <div class="vx-row">

 
 
            <div class="vx-col md:w-1/1 w-full mt-5">
            <label for="" class="vs-input--label">Predlozeni text za socijalne mreze</label>
                     <quill-editor  :style="{'min-height': '150px'}"  v-model="dataform.predlozenimreze"></quill-editor>

            </div>
            </div>
          </form>
        </tab-content>

        <!-- tab 2 content -->
        <tab-content title="Tehničke karakteristike" class="mb-5" icon="feather icon-settings" :before-change="validateStep2">
          <form data-vv-scope="step-2">
          <div class="vx-row">
              <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Težina" v-model="dataform.tezina" class="w-full" name="tezina" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.zapremina') }}</span>
            </div>
            <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Broj modela"  v-model="dataform.brojmodela" class="w-full" name="brojmodela" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.brojmodela') }}</span>
            </div>

            <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Dimenizije" v-model="dataform.dimenizije" class="w-full" name="dimenizije" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.dimenizije') }}</span>
            </div>
            <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Snaga" v-model="dataform.snaga" class="w-full" name="sifradobavljaca" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.snaga') }}</span>
            </div>
            <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Napon" v-model="dataform.napon" class="w-full" name="napon" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.napon') }}</span>
            </div>
            <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Zapremina" v-model="dataform.zapremina" class="w-full" name="zapremina" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.zapremina') }}</span>
            </div>

             <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Duzina kabla" v-model="dataform.duzinakabla" class="w-full" name="duzinakabla" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.duzinakabla') }}</span>
            </div>
             <div class="vx-col md:w-1/1 w-full mt-5">
            <label for="" class="vs-input--label">Ostale tehničke karakteristike</label>
                     <quill-editor   v-model="dataform.tehnckekar"></quill-editor>

            </div>
            
          </div>
          </form>
        </tab-content>

        <!-- tab 3 content -->
        <tab-content title="Garancija,pakovanje i ostalo" class="mb-5" icon="feather icon-package" :before-change="validateStep3">
          <form data-vv-scope="step-3">
          <div class="vx-row">
         <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Period garancija" v-model="dataform.periodgarancije" class="w-full" name="periodgarancije" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.periodgarancije') }}</span>
            </div>
              <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Poruka za garanciju" v-model="dataform.porukagarancija" class="w-full" name="porukagarancija" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.porukagarancija') }}</span>
            </div>
             <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Posebne napomene" v-model="dataform.posebnanapomena" class="w-full" name="posebnanapomena" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.posebnanapomena') }}</span>
            </div>
             <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Poruka za shop" v-model="dataform.porukazasop" class="w-full" name="porukazasop" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.porukazasop') }}</span>
            </div>
            <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Napomena za shop" v-model="dataform.napomenazasop" class="w-full" name="napomenazasop" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.napomenazasop') }}</span>
            </div>
             <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Poruka za tovarni" v-model="dataform.porukatovarni" class="w-full" name="porukatovarni" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.porukatovarni') }}</span>
            </div>
             <div class="vx-col md:w-1/4 w-full ">
              <vs-input label="Lokacija u skladistu" v-model="dataform.lokacijausklad" class="w-full" name="lokacijausklad" v-validate="''" />
              <span class="text-danger">{{ errors.first('step-1.lokacijausklad') }}</span>
            </div>
               <div class="vx-col md:w-1/1 w-full mt-5">
                       <label for="" class="vs-input--label">Otvoriti prije preuzimanja</label>
                <span>
      <vs-checkbox v-model="dataform.otvoritiprije">{{dataform.otvoritiprije?'DA':'NE'}}</vs-checkbox>
    </span>
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
      <!--div class="flex flex-wrap justify-between items-center">

        <!-- ITEMS PER PAGE -->
        <!--div class="mb-4 md:mb-0 mr-4 ag-grid-table-actions-left">
          <vs-dropdown vs-trigger-click class="cursor-pointer">
            <div class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium">
              <span class="mr-2">{{ currentPage * paginationPageSize - (paginationPageSize - 1) }} - {{ products.length - currentPage * paginationPageSize > 0 ? currentPage * paginationPageSize : products.length }} of {{ products.length }}</span>
              <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
            </div>
            <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
            <!--vs-dropdown-menu>

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

       
      </div-->
       
             
          
       
      

 
 <data-view-sidebar :isSidebarActive="addNewDataSidebar" @closeSidebar="toggleDataSidebar" :data="sidebarData" />

    <vs-table ref="table" multiple v-model="selected" pagination :max-items="itemsPerPage" search :data="products">

      <div slot="header" class="flex flex-wrap-reverse items-center flex-grow justify-between">

        <div class="flex flex-wrap-reverse items-center">

          <!-- ACTION - DROPDOWN -->
          <!--vs-dropdown vs-trigger-click class="cursor-pointer mr-4 mb-4">

            <div class="p-4 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer flex items-center justify-center text-lg font-medium w-32">
              <span class="mr-2">Actions</span>
              <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
            </div>

            <vs-dropdown-menu>

              <vs-dropdown-item>
                <span class="flex items-center">
                  <feather-icon icon="TrashIcon" svgClasses="h-4 w-4" class="mr-2" />
                  <span>Delete</span>
                </span>
              </vs-dropdown-item>

              <vs-dropdown-item>
                <span class="flex items-center">
                  <feather-icon icon="ArchiveIcon" svgClasses="h-4 w-4" class="mr-2" />
                  <span>Archive</span>
                </span>
              </vs-dropdown-item>

              <vs-dropdown-item>
                <span class="flex items-center">
                  <feather-icon icon="FileIcon" svgClasses="h-4 w-4" class="mr-2" />
                  <span>Print</span>
                </span>
              </vs-dropdown-item>

              <vs-dropdown-item>
                <span class="flex items-center">
                  <feather-icon icon="SaveIcon" svgClasses="h-4 w-4" class="mr-2" />
                  <span>Another Action</span>
                </span>
              </vs-dropdown-item>

            </vs-dropdown-menu>
          </vs-dropdown-->

          <!-- ADD NEW -->
          <div class="p-3 mb-4 mr-4 rounded-lg cursor-pointer flex items-center justify-between text-lg font-medium text-base text-primary border border-solid border-primary" @click="setToken()">
              <feather-icon icon="PlusIcon" svgClasses="h-4 w-4" />
              <span  v-if="!popupActive" class="ml-2 text-base text-primary">Dodaj novi</span>
          </div>
        </div>


        <!-- ITEMS PER PAGE -->
        <vs-dropdown vs-trigger-click class="cursor-pointer mb-4 mr-4">
          <div class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium">
            <span class="mr-2">{{ currentPage * itemsPerPage - (itemsPerPage - 1) }} - {{ products.length - currentPage * itemsPerPage > 0 ? currentPage * itemsPerPage : products.length }} of {{ queriedItems }}</span>
            <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
          </div>
          <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
          <vs-dropdown-menu>

            
            <vs-dropdown-item @click="itemsPerPage=10">
              <span>10</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=15">
              <span>15</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=20">
              <span>20</span>
            </vs-dropdown-item>
          </vs-dropdown-menu>
        </vs-dropdown>
      </div>

      <template slot="thead">
        <vs-th>Slika</vs-th>
        <vs-th sort-key="ida">#ID</vs-th>
        <vs-th sort-key="naslovweb">Naziv</vs-th>
         <vs-th sort-key="kolicina">Količina</vs-th>
        <vs-th sort-key="pjcijena">Cijena(javna)</vs-th>
        <vs-th sort-key="shopcijena">Cijena(shop)</vs-th>
        <vs-th sort-key="mincijena">Cijena(min)</vs-th>
        
        
        
        <vs-th>Akcije</vs-th>
      </template>

      <template slot-scope="{data}">
        <tbody>
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">

            <vs-td class="img-container">
              <img :src="getProfileImage(tr.pictures)" class="product-img" />
            </vs-td>
 <vs-td>
              <p class="product-name font-medium truncate">{{ tr.ida }}</p>
            </vs-td>
            <vs-td>
              <p class="product-name font-small truncate">{{ tr.naslovweb }}</p>
            </vs-td>

             
 <vs-td>
              <p class="product-category">{{ tr.kolicina }}</p>
            </vs-td>

             
            <vs-td>
              <p class="product-price">{{ tr.pjcijena }} KM</p>
            </vs-td>
 
            <vs-td>
              <p class="product-price">{{ tr.shopcijena }} KM</p>
            </vs-td>
             
            <vs-td>
              <p class="product-price">{{ tr.mincijena }} KM</p>
            </vs-td>
            <vs-td class="whitespace-no-wrap">
              <!--feather-icon icon="EditIcon" svgClasses="w-5 h-5 hover:text-primary stroke-current" @click.stop="editData(tr)" /-->
              <feather-icon icon="TrashIcon" svgClasses="w-5 h-5 hover:text-danger stroke-current" class="ml-2" @click.stop="deleteData(tr.id)" />
            </vs-td>

          </vs-tr>
        </tbody>
      </template>
    </vs-table>
       </vx-card>
  </div>
</template>

<script>
import DataViewSidebar from './UnosP2sidebar.vue'
import moduleDataList from '@/store/data-list/moduleDataList.js'



import { AgGridVue } from 'ag-grid-vue'
 import {AG_GRID_LOCALE_EN} from '../../i18n/tableLocale'
import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

import { quillEditor } from 'vue-quill-editor'
import Prism from 'vue-prism-component'
// For custom error message
import { Validator } from 'vee-validate'
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
 

const dict = {
  custom: {
    naslov: {
      required: 'Naziv je obavezan',
     },
    podnaslov: {
      required: 'Podnaslov je obavezan',
     },
     shopcijena:{
required: 'Polje cijena prema shopu je obavezno',
      },
     mincijena:{
       required: 'Polje min cijena je obavezno',
      },
     starapjcijena:{
      },
     pjcijena:{
      required: 'Polje preporucena javna cijena je obavezno',
     },
     kolicina:{
      required: 'Polje kolicina je obavezno',
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
Validator.localize('ba', dict)

 export default {
  components: {
    AgGridVue,
     FormWizard,
    TabContent,

    DataViewSidebar,
    quillEditor,
    Prism,
    vueDropzone: vue2Dropzone

  },
  data () {
    return {
           dropzoneOptions3: {
              url: '/api/auth/image/',
                  maxFilesize: 5,
                  dictRemoveFile: 'Obriši',
                  dictDefaultMessage: "Izaberite slike za upload",
                  params:
                  {
                randPath:null,
                type:3
                },
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       headers: {
               'Authorization':'Bearer' + localStorage.getItem('accessToken')
               }
          },
         dropzoneOptions2: {
              url: '/api/auth/image/',
                dictDefaultMessage: "Izaberite slike za upload",

                  maxFilesize: 5,
              dictRemoveFile: 'Obriši',
                  params:
                  {
                randPath:null,
                type:2
                },
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       headers: {
               'Authorization':'Bearer' + localStorage.getItem('accessToken')
               }
          },
       dropzoneOptions1: {
              url: '/api/auth/image/',
              dictDefaultMessage: "Izaberite slike za upload",

                  maxFilesize: 5,
                  dictRemoveFile: 'Obriši',
                  params:
                  {
                randPath:null,
                type:1
                },
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       headers: {
               'Authorization':'Bearer' + localStorage.getItem('accessToken')
               }
          },
        dataform:{  
      rand:null,
      sifradobavljaca:null,
            kategorija:null,
            images:[],
            subkategorija:null,
            proizvodjac:null,
           brojmodela:null,
           naslovweb:null,
           podnaslovweb:null,
           opis:null,          
            tehnckekar:null,
           dimenizije:null,
           snaga:null,
           napon:null,
           zapremina:null,
           duzinakabla:null,
           tezina:null,
           periodgarancije:' ',
           porukagarancija:' ',
            videoproizvoda:null,
            kolicina:null,
           pjcijena:null,
           starapjcijena:null,
           shopcijena:null,
           mincijena:null,
            fixcijena:false,
            otvoritiprije:false,
            posebnanapomena:' ',
            napomenazasop:' ',
            porukatovarni:' ',
            predlozenimreze:null,
           linkproizvodjaca:null,
            premium:false,
           lokacijausklad:' ',
            porukazasop:' ',
            },
      popupActive:false,
      searchQuery: '',
             selected: [],

      gridOptions: {},
      maxPageNumbers: 7,
      gridApi: null,
      lct:null,
      products:[],
       itemsPerPage: 10,
      isMounted: false,
      addNewDataSidebar: false,
      sidebarData: {},
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
        }, {
          headerName: 'IDA',
          field: 'ida',
           filter: true,
          },
        
        {
          headerName: 'Naziv',
          field: 'naslovweb',
           filter: true,
          },
        {
          headerName: 'Kratak opis',
          field: 'podnaslovweb',
          filter: true,
         },
        {
          headerName: 'Kolicina',
          field: 'kolicina',
          filter: true,
         },
          {
          headerName: 'Cijena JAVNA',
          field: 'pjcijena',
          filter: true,
         },
         {
          headerName: 'Cijena prema SOPU',
          field: 'shopcijena',
          filter: true,
         },
          {
          headerName: 'Min Cijena',
          field: 'mincijena',
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
    this.getRandomString(25)


    this.localeText = AG_GRID_LOCALE_EN;
         this.lct=localStorage.getItem('accessToken')


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
    currentPage () {
      if (this.isMounted) {
        return this.$refs.table.currentx
      }
      return 0
    },
     
    queriedItems () {
      return this.$refs.table ? this.$refs.table.queriedResults.length : this.products.length
    },
  
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
    setToken(){
      this.popupActive=true;
      this.getRandomString(25);
        this.dropzoneOptions1.params.randPath=this.dataform.rand
    this.dropzoneOptions2.params.randPath=this.dataform.rand
    this.dropzoneOptions3.params.randPath=this.dataform.rand

    },
    validateStep1 () {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll('step-1').then(result => {
          if (result) {
            resolve(true)
          } else {
            alert(result)
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
            console.log(this.dataform)
             this.$http.post('/api/auth/addproduct',this.dataform, { headers:{
      'Authorization':"Bearer" + localStorage.getItem('accessToken')
    }}).then(function (response) {
                  if(response.data.success=="1"){
                    location.reload()
                  }

       })
             resolve(true)
          } else {
            reject('correct all values')
          }
        })
      })
    },
    deleteUpload1(file){
      let vm=this
        this.$http.post('/api/auth/deleteimage',{filen: file.name,type:1,randPath: this.dataform.rand}, { headers:{
      'Authorization':"Bearer" + localStorage.getItem('accessToken')
    }}).then(function (response) {
     const index = vm.dataform.images.findIndex(obj => obj.path === response.data.path);
vm.dataform.images = [
    ...vm.dataform.images.slice(0, index),
    ...vm.dataform.images.slice(index + 1)
]
   })

    }, deleteUpload2(file){
        this.$http.post('/api/auth/deleteimage',{filen: file.name,type:2,randPath: this.dataform.rand}, { headers:{
      'Authorization':"Bearer" + localStorage.getItem('accessToken')
    }}).then(function (response) {
     const index = vm.dataform.images.findIndex(obj => obj.path === response.data.path);
vm.dataform.images = [
    ...vm.dataform.images.slice(0, index),
    ...vm.dataform.images.slice(index + 1)
]
   })

    } ,deleteUpload3(file){
        this.$http.post('/api/auth/deleteimage',{filen: file.name,type:3,randPath: this.rand}, { headers:{
      'Authorization':"Bearer" + localStorage.getItem('accessToken')
    }}).then(function (response) {
     const index = vm.dataform.images.findIndex(obj => obj.path === response.data.path);
vm.dataform.images = [
    ...vm.dataform.images.slice(0, index),
    ...vm.dataform.images.slice(index + 1)
]
   })

    },
    getRandomString2(){
      return this.dataform.rand;
    },
    getRandomString(length) {
    var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var result = '';
    for ( var i = 0; i < length; i++ ) {
        result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
    }
         localStorage.setItem('randPath', result)
         this.dataform.rand=result

     return result;
},
    successUpload (event) {
      var res = JSON.parse(event.xhr.response)
 this.dataform.images =  this.dataform.images.concat(res);
console.log(this.dataform.images)
               localStorage.setItem('randPath', res.randPath)

          this.$vs.notify({ color: 'success', title: 'Upload Success', text:res.success})
 
    },
     
    updateSearchQuery (val) {
      this.gridApi.setQuickFilter(val)
    },
      getProfileImage(pictures){
 
    var result= pictures.filter(function (picture) {  return picture.type === 1 });
 if(result.length>0){
return result[0].urlImage
}else
{
    return 'images/pages/404.png'
}
      },
    getProducts(){

     this.$http.get('/api/auth/products', { headers:{
      'Authorization':"Bearer" + localStorage.getItem('accessToken')
    }})
      .then((response) => { this.products=response.data.products })
      .catch((error)   => { console.log(error) })
      
    },
    addNewData () {
      this.sidebarData = {}
      this.toggleDataSidebar(true)
    },
    deleteData (id) {
      this.$store.dispatch('dataList/removeItem', id).catch(err => { console.error(err) })
    },
    editData (data) {
      // this.sidebarData = JSON.parse(JSON.stringify(this.blankData))
      this.sidebarData = data
      this.toggleDataSidebar(true)
    },
    getOrderStatusColor (status) {
      if (status === 'on_hold')   return 'warning'
      if (status === 'delivered') return 'success'
      if (status === 'canceled')  return 'danger'
      return 'primary'
    },
    getPopularityColor (num) {
      if (num > 90)  return 'success'
      if (num > 70)  return 'primary'
      if (num >= 50) return 'warning'
      if (num < 50)  return 'danger'
      return 'primary'
    },
    toggleDataSidebar (val = false) {
      this.addNewDataSidebar = val
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

<style lang="scss">
#data-list-thumb-view {
  .vs-con-table {

    .product-name {
      max-width: 23rem;
    }

    .vs-table--header {
      display: flex;
      flex-wrap: wrap-reverse;
      margin-left: 1.5rem;
      margin-right: 1.5rem;
      > span {
        display: flex;
        flex-grow: 1;
      }

      .vs-table--search{
        padding-top: 0;

        .vs-table--search-input {
          padding: 0.9rem 2.5rem;
          font-size: 1rem;

          &+i {
            left: 1rem;
          }

          &:focus+i {
            left: 1rem;
          }
        }
      }
    }

    .vs-table {
      border-collapse: separate;
      border-spacing: 0 1.3rem;
      padding: 0 1rem;


      tr{
          box-shadow: 0 4px 20px 0 rgba(0,0,0,.05);
          td{
            padding: 10px;
            &:first-child{
              border-top-left-radius: .5rem;
              border-bottom-left-radius: .5rem;
            }
            &:last-child{
              border-top-right-radius: .5rem;
              border-bottom-right-radius: .5rem;
            }
            &.img-container {
              // width: 1rem;
              // background: #fff;

              span {
                display: flex;
                justify-content: flex-start;
              }

              .product-img {
                height: 110px;
              }
            }
          }
          td.td-check{
            padding: 20px !important;
          }
      }
    }

    .vs-table--thead{
      th {
        padding-top: 0;
        padding-bottom: 0;

        .vs-table-text{
          text-transform: uppercase;
          font-weight: 600;
        }
      }
      th.td-check{
        padding: 0 15px !important;
      }
      tr{
        background: none;
        box-shadow: none;
      }
    }

    .vs-table--pagination {
      justify-content: center;
    }
  }
}
</style>

