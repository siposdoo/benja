
<template>
  <div>
    <div class="p-6 flex w-full bg-img vx-row">
      <div class="vx-col sm:w-1/1 md:w-1/2 lg:w-1/2">
        <div class="p-6 flex w-full bg-img vx-row">
          <div
            class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base"
          >
            <div :id="getNaloziCount" class="truncate">
              <h2 class="mb-1 font-bold">{{ kompanijacount }}</h2>
              <span>Kompanija</span>
            </div>
          </div>
          <div
            class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base"
          >
            <div class="truncate">
              <h2 class="mb-1 font-bold">{{ utovari.length }}</h2>
              <span>Naloga</span>
            </div>
          </div>
          <div
            class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base"
          >
            <div class="truncate">
              <h2 class="mb-1 font-bold">{{ utovari.length }}</h2>
              <span>Utovara</span>
            </div>
          </div>

          <div
            class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base"
          >
            <div class="truncate">
              <h2 class="mb-1 font-bold">{{ istovari.length }}</h2>
              <span>Istovara</span>
            </div>
          </div>
        </div>
        <div class="flex flex-wrap justify-between items-center">
          <!-- ITEMS PER PAGE -->
          <div class="mb-4 md:mb-0 mr-4 ag-grid-table-actions-left">
            <vs-dropdown vs-trigger-click class="cursor-pointer">
              <div
                class="p-1 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium"
              >
                <span class="mr-2"
                  >{{
                    currentPage * paginationPageSize - (paginationPageSize - 1)
                  }}
                  -
                  {{
                    kompanije.length - currentPage * paginationPageSize > 0
                      ? currentPage * paginationPageSize
                      : kompanije.length
                  }}
                  od {{ kompanije.length }}</span
                >
                <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
              </div>
              <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
              <vs-dropdown-menu>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(10)">
                  <span>10</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(20)">
                  <span>20</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(50)">
                  <span>50</span>
                </vs-dropdown-item>
              </vs-dropdown-menu>
            </vs-dropdown>
          </div>
          <div class="mb-4 md:mb-0 mr-4 ag-grid-table-actions-right">
            <vs-dropdown vs-trigger-click class="cursor-pointer mb-4">
              <div
                class="p-1 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium"
              >
                Radius :<span class="mr-2">{{ radius }} km </span>
                <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
              </div>

              <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
              <vs-dropdown-menu>
                <vs-dropdown-item @click="setKilometreRadiusa(100)">
                  <span>100</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="setKilometreRadiusa(200)">
                  <span>200</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="setKilometreRadiusa(500)">
                  <span>500</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="setKilometreRadiusa(1000)">
                  <span>1000</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="setKilometreRadiusa(2000)">
                  <span>2000</span>
                </vs-dropdown-item>
              </vs-dropdown-menu>
            </vs-dropdown>
            <vs-checkbox color="danger" v-model="isRadius"
              >Pokazi radius</vs-checkbox
            >
          </div>

          <!-- TABLE ACTION COL-2: SEARCH & EXPORT AS CSV -->
          <div
            class="flex flex-wrap items-center justify-between ag-grid-table-actions-right"
          >
            <vs-input
              class="mb-4 md:mb-0 mr-4"
              v-model="searchQuery"
              @input="updateSearchQuery"
              placeholder="Traži..."
            />
          </div>
        </div>
        <ag-grid-vue
          ref="agGridTable"
          :gridOptions="gridOptions"
          class="ag-theme-material w-100 my-4 ag-grid-table"
          :columnDefs="columnDefs"
          :defaultColDef="defaultColDef"
          :postSort="infoOptionsSort"
          @selection-changed="onSelectionChanged"
          rowSelection="single"
          :rowData="kompanije"
          colResizeDefault="shift"
          :animateRows="true"
          :floatingFilter="true"
          :pagination="true"
          :paginationPageSize="paginationPageSize"
          :suppressPaginationPanel="true"
          :enableRtl="$vs.rtl"
        >
        </ag-grid-vue>
        <vs-pagination
          :total="totalPages"
          :max="maxPageNumbers"
          v-model="currentPage"
        />
      </div>
      <div class="vx-col sm:w-1/1 md:w-1/2 lg:w-1/2">
        <gmap-map
          ref="map"
          :center="center"
          :zoom="zoom"
          style="width: 100%; height: 700px"
        >
          <GmapCircle
            v-if="isRadius"
            ref="circleRef"
            :center="center"
            :radius="radius * 1000"
            :visible="false"
            :options="{ fillColor: 'red', fillOpacity: 0.1 }"
          ></GmapCircle>
          <gmap-marker
            :key="m.id"
            v-for="m in kompanijeTemp"
            :position="{ lat: parseFloat(m.lat), lng: parseFloat(m.lng) }"
            :clickable="true"
            @click="toggleInfoWindow(m)"
          ></gmap-marker>
          <gmap-info-window
            :options="infoOptions"
            :position="infoWindowPos"
            :opened="infoWinOpen"
            @closeclick="infoWinOpen = false"
          >
            <h5>{{ contentInfo }}</h5>
            <h5>Naloga:{{ currMarker.nalozi.length }}</h5>
            <h6>Utovari:{{ currMarker.utovara }}</h6>
            <h6>Istovari:{{ currMarker.istovara }}</h6>
            <div class="flex w-full">
<table class="table table-sm table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nalog</th>
      <th scope="col">Utovar</th>
      
       
    </tr>
  </thead>
  <tbody>
    <tr :key="nalog.id" v-for="nalog in currMarker.nalozi">
      <th scope="row">{{nalog.id}}</th>
      <td><a :href="'/nalog/'+nalog.hash" target="_blank" > -> {{nalog.naziv}}</a></td>
      
       <td>{{getFormatedDatum(nalog.datumutovara)}}</td>
       
    </tr>
     
  </tbody>
</table>
            </div>
          </gmap-info-window>
          
        </gmap-map>
      </div>
    </div>
  </div>
</template>

<script>
import StatisticsCardLine from "@/components/statistics-cards/StatisticsCardLine.vue";
import * as VueGoogleMaps from "vue2-google-maps";
import { AgGridVue } from "ag-grid-vue";
import moment from "moment";
import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";
export default {
  components: {
    AgGridVue,
    StatisticsCardLine,
  },
  data() {
    return {
      center: { lat: 47.403568, lng: 14.1531833 },
      currMarker: { nalozi: [], utovara: 0, istovara: 0 },
      infoContent: "",
      kompanije: [],
      kompanijeTemp: [],
      utovari: [],
      kompanijacount: 0,
      zoom: 6,
      radius: 500,
      istovari: [],
      contentInfo: "",
      isRadius: false,
      infoWindowPos: null,
      infoWinOpen: false,
      currentMidx: null,
      //optional: offset infowindow so it visually sits nicely on top of our marker
      infoOptions: {
        pixelOffset: { width: 0, height: -35 },
      },
      markers: [
        { position: { lat: 47.376332, lng: 8.547511 }, infoText: "Marker 1" },
        { position: { lat: 47.374592, lng: 8.548867 }, infoText: "Marker 2" },
        { position: { lat: 47.379592, lng: 8.549867 }, infoText: "Marker 3" },
      ],
      maxPageNumbers: 7,
      gridOptions: {},
      gridApi: null,
      defaultColDef: {
        sortable: true,
        editable: false,
        resizable: true,
        suppressMenu: false,
      },
      searchQuery: null,
      columnDefs: [
        {
          headerName: "Naziv",
          width: 220,
          field: "name",
          filter: true,
        },
        {
          headerName: "Grad",
          width: 220,
          field: "city",
          filter: true,
          cellRenderer: function (params) {
            let a = [];
            a = params.data.city.split(" ");
             return a[1];
          },
        },
        {
          headerName: "Država",
          width: 220,
          field: "state",
          filter: true,
        },
        {
          headerName: "Naloga",
          field: "nalog",
          cellRenderer: function (params) {
            // check the data exists, to avoid error

            // data exists, so we can access it
            return params.data.nalog.length;
          },
          filter: true,
        },
        {
          headerName: "Utovara",
          field: "nalog",
          cellRenderer: function (params) {
            let a = 0;
            if (params.data.nalog.length > 0) {
              params.data.nalog.forEach((element) =>
                element.utovaristovar.forEach((element2) => {
                  if (element2.tip === 0) {
                    a++;
                  }
                })
              );
              /* rowNode.data.nalog.utovaristovar.forEach(element => 
        console.log(element)
        )*/
            }
            return a;
          },
          filter: true,
        },
        {
          headerName: "Istovara",
          field: "nalog",
          cellRenderer: function (params) {
            let a = 0;
            if (params.data.nalog.length > 0) {
              params.data.nalog.forEach((element) =>
                element.utovaristovar.forEach((element2) => {
                  if (element2.tip === 1) {
                    a++;
                  }
                })
              );
              /* rowNode.data.nalog.utovaristovar.forEach(element => 
        console.log(element)
        )*/
            }
            return a;
          },
          filter: true,
        },
      ],
      frameworkComponents: null,
    };
  },
  computed: {
    getKompanijeTemp: function () {
      let app = this;
      if (this.gridApi) {
        this.gridApi.forEachNodeAfterFilterAndSort((rowNode, index) => {
          app.kompanijeTemp.push(rowNode.data);
        });
      }
      return null;
    },
    getNaloziCount: function () {
      let a = { utovari: 0, istovari: 0 };
      let app = this;

      if (this.gridApi) {
        app.kompanijacount = this.gridApi.getDisplayedRowCount();
        this.gridApi.forEachNodeAfterFilterAndSort((rowNode, index) => {
          if (rowNode.data.nalog.length > 0) {
            rowNode.data.nalog.forEach((element) =>
              element.utovaristovar.forEach((element2) => {
                if (element2.tip === 0) {
                  app.utovari.push(element2);
                } else {
                  app.istovari.push(element2);
                }
              })
            );
            /* rowNode.data.nalog.utovaristovar.forEach(element => 
        console.log(element)
        )*/
          }
          // a =  rowNode.data.nalog.length + a;
        });
      }
      return a;
    },
    getTemKm: function () {
      if (this.gridApi) {
        this.tempKm = 0;

        this.gridApi.forEachNodeAfterFilterAndSort((rowNode, index) => {
          this.tempKm = this.tempKm + Number(rowNode.data.iznoskm);
        });
        return parseFloat(this.tempKm).toFixed(2);
      }
    },
    getTempEU: function () {
      if (this.gridApi) {
        this.tempEU = 0;

        this.gridApi.forEachNodeAfterFilterAndSort((rowNode, index) => {
          this.tempEU = this.tempEU + Number(rowNode.data.iznoseur);
        });
        return parseFloat(this.tempEU).toFixed(2);
      }
    },
    getTempVozila: function () {
      if (this.gridApi) {
        this.tempVozila = 0;

        this.gridApi.forEachNodeAfterFilterAndSort((rowNode, index) => {
          this.tempVozila = this.tempVozila + Number(rowNode.data.vozila);
        });
        return this.tempVozila;
      }
    },
    paginationPageSize() {
      if (this.gridApi) return this.gridApi.paginationGetPageSize();
      else return 50;
    },
    totalPages() {
      if (this.gridApi) return this.gridApi.paginationGetTotalPages();
      else return 0;
    },
    currentPage: {
      get() {
        if (this.gridApi) return this.gridApi.paginationGetCurrentPage() + 1;
        else return 1;
      },
      set(val) {
        this.gridApi.paginationGoToPage(val - 1);
      },
    },

    queriedItems() {
      return this.$refs.agGridTable
        ? this.$refs.agGridTable.queriedResults.length
        : this.products.length;
    },
  },
  methods: {
    getFormatedDatum(date){
                   moment.locale('sr')

return moment(date).format("L", "sr")
    },
    setKilometreRadiusa(a) {
      if (a > 500 && a < 1500) {
        this.zoom = 5;
      } else if (a > 1500) {
        this.zoom = 4;
      } else if (a < 500 && a >= 200) {
        this.zoom = 7;
      } else {
        this.zoom = 8;
      }
      this.radius = a;
    },
    onSelectionChanged() {
      var selectedRows = this.gridApi.getSelectedRows();

      this.center.lng = parseFloat(selectedRows[0].lng);
      this.center.lat = parseFloat(selectedRows[0].lat);
      this.toggleInfoWindow(selectedRows[0]);
      this.zoom = 8;
     },
    infoOptionsSort() {
      this.utovari = [];
      this.istovari = [];
      this.kompanijeTemp = []; /*
              var bounds = this.$refs.map.$mapObject.getBounds();

this.kompanijeTemp.forEach(element=>{
 console.log("aatemp-"+element.data)
    var myLatLng = new VueGoogleMaps.gmapApi.maps.LatLng({lat: parseFloat(element.lat), lng: parseFloat(element.lng)});

    bounds.extend(myLatLng);
})
   
 
this.$refs.mymap.fitBounds(bounds);
*/
    },
    updateSearchQuery(val) {
      this.zoom = 6;
      this.utovari = [];
      this.istovari = [];
      this.kompanijeTemp = [];
      this.gridApi.setQuickFilter(val);
      /*
      var bounds = new this.$refs.map.$mapObject.getBounds();
this.kompanijeTemp.forEach(element=>{
 console.log("aatemp-"+element.data)
    var myLatLng = new VueGoogleMaps.gmapApi.maps.LatLng({lat: parseFloat(element.lat), lng: parseFloat(element.lng) });

    bounds.extend(myLatLng);
})
   
 
this.$refs.mymap.fitBounds(bounds);
*/
    },
    getKompanije() {
      this.$http
        .get("/api/auth/kompanije", {
          headers: {
            Authorization: "Bearer" + localStorage.getItem("accessToken"),
          },
        })
        .then((response) => {
          this.kompanije = response.data.results;
        })
        .catch((error) => {});
    },
    toggleInfoWindow(marker) {
      this.calcCurrMarker(marker);
      this.infoWindowPos = {
        lat: parseFloat(marker.lat),
        lng: parseFloat(marker.lng),
      };
      this.infoContent = marker.name;
      this.contentInfo = marker.name;
      //check if its the same marker that was selected if yes toggle
      if (this.currentMidx == marker.id) {
        this.infoWinOpen = !this.infoWinOpen;
      }
      //if different marker set infowindow to open and reset current marker index
      else {
        this.infoWinOpen = true;
        this.currentMidx = marker.id;
      }
    },
    calcCurrMarker(marker) {
      let app = this;
      this.currMarker.nalozi = marker.nalog;
      app.currMarker.utovara = 0;
      app.currMarker.utovara;
      if (marker.nalog.length > 0) {
        marker.nalog.forEach((element) =>
          element.utovaristovar.forEach((element2) => {
            if (element2.tip === 0) {
              app.currMarker.utovara++;
            } else {
              app.currMarker.istovara++;
            }
          })
        );
        /* rowNode.data.nalog.utovaristovar.forEach(element => 
        console.log(element)
        )*/
      }
    },
  },
  mounted() {
    this.gridApi = this.gridOptions.api;
    this.gridApi.paginationSetPageSize(10);
    this.isMounted = true;
  },
  created() {
    this.getKompanije();
  },
};
</script>

<style lang="scss">
.ag-grid-table {
  max-height: 500px;
  overflow-y: auto;
}
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

      .vs-table--search {
        padding-top: 0;

        .vs-table--search-input {
          padding: 0.9rem 2.5rem;
          font-size: 1rem;

          & + i {
            left: 1rem;
          }

          &:focus + i {
            left: 1rem;
          }
        }
      }
    }

    .vs-table {
      border-collapse: separate;
      border-spacing: 0 1.3rem;
      padding: 0 1rem;

      tr {
        box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.05);
        td {
          padding: 10px;
          &:first-child {
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
          }
          &:last-child {
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
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
        td.td-check {
          padding: 20px !important;
        }
      }
    }

    .vs-table--thead {
      th {
        padding-top: 0;
        padding-bottom: 0;

        .vs-table-text {
          text-transform: uppercase;
          font-weight: 600;
        }
      }
      th.td-check {
        padding: 0 15px !important;
      }
      tr {
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

      