<!-- =========================================================================================
  File Name: DataListThumbView.vue
  Description: Data List - Thumb View
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="data-list-thumb-view" class="data-list-container">
    <vx-card>
      <!-- TABLE ACTION ROW -->
      <div class="flex flex-wrap justify-between items-center">
        <!-- ITEMS PER PAGE -->
        <div class="mb-4 md:mb-0 mr-4 ag-grid-table-actions-left">
          <div
            class="p-3 mb-4 mr-4 rounded-lg cursor-pointer flex items-center justify-between text-lg font-medium text-base text-theme border border-solid text-theme"
            @click="addNewData"
          >
            <feather-icon icon="PlusIcon" svgClasses="h-4 w-4" />
            <span class="ml-2 text-base text-theme">Dodaj</span>
          </div>
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
                  products.length - currentPage * paginationPageSize > 0
                    ? currentPage * paginationPageSize
                    : products.length
                }}
                od {{ products.length }}</span
              >
              <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
            </div>
            <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
            <vs-dropdown-menu>
              <vs-dropdown-item @click="gridApi.paginationSetPageSize(3)">
                <span>3</span>
              </vs-dropdown-item>
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
        <div
          class="flex flex-wrap items-center justify-between ag-grid-table-actions-right"
        >
          <vs-input
            class="mb-4 md:mb-0 mr-4"
            v-model="searchQuery"
            @input="updateSearchQuery"
            placeholder="Traži..."
          />
          <vs-button class="mb-4 md:mb-0" @click="exportCsv()"
            >Izvezi kao CSV</vs-button
          >
        </div>
        
      </div>
      
   <div
          class="flex flex-wrap items-center justify-end ag-grid-table-actions-right"
        >
        
           <vs-button v-if="product" @click="editData()" class="vs-component vs-button mr-3 vs-button-warning vs-button-borderbtn-sm" 
            >Izmjeni</vs-button
          >
        </div>
      <ag-grid-vue
      
        ref="agGridTable"
        :gridOptions="gridOptions"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        :columnDefs="columnDefs"
        :defaultColDef="defaultColDef"
        rowSelection="single"
        @selection-changed="onSelectionChanged"
        :rowData="products"
        colResizeDefault="shift"
        :animateRows="true"
        :floatingFilter="true"
        :localeText="localeText"
        :pagination="true"
        :paginationPageSize="paginationPageSize"
        :suppressPaginationPanel="true"
        :enableRtl="$vs.rtl"
      >
      </ag-grid-vue>
            <div class="flex flex-wrap justify-between items-center">
              <p><b>Ukupno vozila: {{getTempVozila}}</b></p>
              <p><b>Ukupno KM: {{getTemKm}}</b></p>
              <p><b>Ukupno EUR: {{getTempEU}}</b></p>
            </div>
      <vs-pagination
        :total="totalPages"
        :max="maxPageNumbers"
        v-model="currentPage"
      />
    </vx-card>
    <data-view-sidebar
      :isSidebarActive="addNewDataSidebar"
      @closeSidebar="toggleDataSidebar"
      :data="sidebarData"
    />

    
  </div>
</template>

<script>
import DataViewSidebar from "./NaloziSidebar";

import moduleDataList from "@/store/data-list/moduleDataList.js";
import { AgGridVue } from "ag-grid-vue";
import BtnCellRenderer from "./btn-cell-renderer.js";
import AG_GRID_LOCALE_EN from "./locale.sr.js";
import OptionsComponent from './OptionsComponent.js'
import moment from "moment";
import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";

export default {
  components: {
    DataViewSidebar,
    AgGridVue,
    btnCellRenderer: BtnCellRenderer,
   },
  data() {
    return {
      selected: [],
      products: [],
      product:null,
      tempKm: 0,
      tempEU: 0,
      tempVozila: 0,
      itemsPerPage: 3,
      localeText: null,
      isMounted: false,
      addNewDataSidebar: false,
      sidebarData: {},
      searchQuery: "",
      gridOptions: {},
      maxPageNumbers: 7,
      gridApi: null,
      defaultColDef: {
        sortable: true,
        editable: false,
        resizable: true,
        suppressMenu: false,
      },
      columnDefs: [
        {
          headerName: "#ID",
          field: "id",
          width: 80,
          pinned: "left",
          filter: "agNumberColumnFilter",
          headerCheckboxSelectionFilteredOnly: true,
        },
        {
          headerName: "Naziv naloga",
          field: "naziv",
          filter: true,
          width: 250,
          pinned: "left",
        },
        {
          headerName: "Datum utovara",
          field: "datumutovara",
          filter: "agDateColumnFilter",
            filterParams: {
                // provide comparator function
                comparator: (filterLocalDateAtMidnight, cellValue) => {
                    const dateAsString = cellValue;
                     if (dateAsString == null) {
                        return 0;
                    }

                    // In the example application, dates are stored as dd/mm/yyyy
                    // We create a Date object for comparison against the filter date
                    const dateParts = dateAsString.split('-');
                    const day = Number(dateParts[2]);
                    const month = Number(dateParts[1]) - 1;
                    const year = Number(dateParts[0]);
                    const cellDate = new Date(year, month, day);

                    // Now that both parameters are Date objects, we can compare
                    if (cellDate < filterLocalDateAtMidnight) {
                        return -1;
                    } else if (cellDate > filterLocalDateAtMidnight) {
                        return 1;
                    }
                    return 0;
                }
            },
           cellRenderer: data => {
             moment.locale('sr')
    return data.value != undefined ? moment(data.value).format("L", "sr") : null;
  },
          width: 175,
        },

        {
          headerName: "Komitent",
          field: "kompanija.name",
          filter: true,
          width: 350,
        },
        {
          headerName: "Kontakt",
          field: "kontakt",
          filter: true,
          width: 175,
        },
        {
          headerName: "Vozač",
          field: "vozac1",
          filter: true,
          width: 150,
        },
        {
          headerName: "Br.Vozila",
          field: "vozila",
          filter: "agNumberColumnFilter",
          width: 110,
        },
        {
          headerName: "Iznos KM",
          field: "iznoskm",
          filter: "agNumberColumnFilter",
          enableValue: true,
          width: 120,
          pinnedRowCellRenderer: function (params) {
            return "<strong>" + params.data.iznoskm + "</strong>";
          },
          filterParams: {
            applyMiniFilterWhileTyping: true,
          },
        },
        {
          headerName: "Iznos EU",
          field: "iznoseur",
          enableValue: true,
          filter: "agNumberColumnFilter",
          width: 120,
          filterParams: {
            applyMiniFilterWhileTyping: true,
          },
        },
        {
           field: 'hash',
    headerName: 'Akcije',
    width: 250,
    colId: 'params',
    
    cellRenderer: function(params){
      let eGui = document.createElement('div');

  let editingCells = params.api.getEditingCells();
  // checks if the rowIndex matches in at least one of the editing cells
  let isCurrentRowEditing = editingCells.some((cell) => {
    return cell.rowIndex === params.node.rowIndex;
  });

  if (isCurrentRowEditing) {
    eGui.innerHTML = `
        <button  
          class="action-button update"
          data-action="update">
               update  
        </button>
        <button  
          class="action-button cancel"
          data-action="cancel">
               cancel
        </button>
        `;
  } else {
    eGui.innerHTML =  '<span class="my-css-class"><a target="_blank" href="nalog/'+params.value+'"><span class="ml-2 feather-icon select-none relative"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe w-5 h-5 hover:text-danger stroke-current"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg></span></a></span>'
 
  }

  return eGui;
    }
        }
      ],
      frameworkComponents: null,
    };
  },
  beforeMount() {
    this.localeText = {
      // Set Filter
      selectAll: "(Izaberi sve)",
      selectAllSearchResults: "(oznaci sve rezultate pretrage)",
      searchOoo: "Trazi...",
      blanks: "(Prazno)",
      noMatches: "Nema podudaranja",

      // Number Filter & Text Filter
      filterOoo: "Filter...",
      equals: "Jednak",
      notEqual: "Nije jednak",
      empty: "Izaberi jedan",

      // Number Filter
      lessThan: "Manje od",
      greaterThan: "Veće od",
      lessThanOrEqual: "Manje od ili jednako",
      greaterThanOrEqual: "Veće od ili jednako",
      inRange: "U rasponu",
      inRangeStart: "do",
      inRangeEnd: "od",

      // Text Filter
      contains: "Sadrži",
      notContains: "Ne sadrži",
      startsWith: "Počinje sa",
      endsWith: "Završava sa",

      // Date Filter
      dateFormatOoo: "yyyy-mm-dd",

      // Filter Conditions
      andCondition: "I",
      orCondition: "ILI",

      // Filter Buttons
      applyFilter: "Primjeni",
      resetFilter: "Reset",
      clearFilter: "Očisti",
      cancelFilter: "Odustani",

      // Filter Titles
      textFilter: "Text Filter",
      numberFilter: "Number Filter",
      dateFilter: "Date Filter",
      setFilter: "Set Filter",

      // Side Bar
      columns: "Columns",
      filters: "Filters",

      // columns tool panel
      pivotMode: "Pivot Mode",
      groups: "Row Groups",
      rowGroupColumnsEmptyMessage: "Drag here to set row groups",
      values: "Values",
      valueColumnsEmptyMessage: "Drag here to aggregate",
      pivots: "Column Labels",
      pivotColumnsEmptyMessage: "Drag here to set column labels",

      // Header of the Default Group Column
      group: "Group",

      // Other
      loadingOoo: "Loading...",
      noRowsToShow: "No Rows To Show",
      enabled: "Enabled",

      // Menu
      pinColumn: "Pin Column",
      pinLeft: "Pin Left",
      pinRight: "Pin Right",
      noPin: "No Pin",
      valueAggregation: "Value Aggregation",
      autosizeThiscolumn: "Autosize This Column",
      autosizeAllColumns: "Autosize All Columns",
      groupBy: "Group by",
      ungroupBy: "Un-Group by",
      resetColumns: "Reset Columns",
      expandAll: "Expand All",
      collapseAll: "Close All",
      copy: "Copy",
      ctrlC: "Ctrl+C",
      copyWithHeaders: "Copy With Headers",
      paste: "Paste",
      ctrlV: "Ctrl+V",
      export: "Export",
      csvExport: "CSV Export",
      excelExport: "Excel Export (.xlsx)",
      excelXmlExport: "Excel Export (.xml)",

      // Enterprise Menu Aggregation and Status Bar
      sum: "Sum",
      min: "Min",
      max: "Max",
      none: "None",
      count: "Count",
      avg: "Average",
      filteredRows: "Filtered",
      selectedRows: "Selected",
      totalRows: "Total Rows",
      totalAndFilteredRows: "Rows",
      more: "More",
      to: "to",
      of: "of",
      page: "Page",
      nextPage: "Next Page",
      lastPage: "Last Page",
      firstPage: "First Page",
      previousPage: "Previous Page",

      // Enterprise Menu (Charts)
      pivotChartAndPivotMode: "Pivot Chart & Pivot Mode",
      pivotChart: "Pivot Chart",
      chartRange: "Chart Range",

      columnChart: "Column",
      groupedColumn: "Grouped",
      stackedColumn: "Stacked",
      normalizedColumn: "100% Stacked",

      barChart: "Bar",
      groupedBar: "Grouped",
      stackedBar: "Stacked",
      normalizedBar: "100% Stacked",

      pieChart: "Pie",
      pie: "Pie",
      doughnut: "Doughnut",

      line: "Line",

      xyChart: "X Y (Scatter)",
      scatter: "Scatter",
      bubble: "Bubble",

      areaChart: "Area",
      area: "Area",
      stackedArea: "Stacked",
      normalizedArea: "100% Stacked",

      histogramChart: "Histogram",

      // Charts
      pivotChartTitle: "Pivot Chart",
      rangeChartTitle: "Range Chart",
      settings: "Settings",
      data: "Data",
      format: "Format",
      categories: "Categories",
      defaultCategory: "(None)",
      series: "Series",
      xyValues: "X Y Values",
      paired: "Paired Mode",
      axis: "Axis",
      navigator: "Navigator",
      color: "Color",
      thickness: "Thickness",
      xType: "X Type",
      automatic: "Automatic",
      category: "Category",
      number: "Number",
      time: "Time",
      xRotation: "X Rotation",
      yRotation: "Y Rotation",
      ticks: "Ticks",
      width: "Width",
      height: "Height",
      length: "Length",
      padding: "Padding",
      spacing: "Spacing",
      chart: "Chart",
      title: "Title",
      titlePlaceholder: "Chart title - double click to edit",
      background: "Background",
      font: "Font",
      top: "Top",
      right: "Right",
      bottom: "Bottom",
      left: "Left",
      labels: "Labels",
      size: "Size",
      minSize: "Minimum Size",
      maxSize: "Maximum Size",
      legend: "Legend",
      position: "Position",
      markerSize: "Marker Size",
      markerStroke: "Marker Stroke",
      markerPadding: "Marker Padding",
      itemSpacing: "Item Spacing",
      itemPaddingX: "Item Padding X",
      itemPaddingY: "Item Padding Y",
      layoutHorizontalSpacing: "Horizontal Spacing",
      layoutVerticalSpacing: "Vertical Spacing",
      strokeWidth: "Stroke Width",
      offset: "Offset",
      offsets: "Offsets",
      tooltips: "Tooltips",
      callout: "Callout",
      markers: "Markers",
      shadow: "Shadow",
      blur: "Blur",
      xOffset: "X Offset",
      yOffset: "Y Offset",
      lineWidth: "Line Width",
      normal: "Normal",
      bold: "Bold",
      italic: "Italic",
      boldItalic: "Bold Italic",
      predefined: "Predefined",
      fillOpacity: "Fill Opacity",
      strokeOpacity: "Line Opacity",
      histogramBinCount: "Bin count",
      columnGroup: "Column",
      barGroup: "Bar",
      pieGroup: "Pie",
      lineGroup: "Line",
      scatterGroup: "X Y (Scatter)",
      areaGroup: "Area",
      histogramGroup: "Histogram",
      groupedColumnTooltip: "Grouped",
      stackedColumnTooltip: "Stacked",
      normalizedColumnTooltip: "100% Stacked",
      groupedBarTooltip: "Grouped",
      stackedBarTooltip: "Stacked",
      normalizedBarTooltip: "100% Stacked",
      pieTooltip: "Pie",
      doughnutTooltip: "Doughnut",
      lineTooltip: "Line",
      groupedAreaTooltip: "Area",
      stackedAreaTooltip: "Stacked",
      normalizedAreaTooltip: "100% Stacked",
      scatterTooltip: "Scatter",
      bubbleTooltip: "Bubble",
      histogramTooltip: "Histogram",
      noDataToChart: "No data available to be charted.",
      pivotChartRequiresPivotMode: "Pivot Chart requires Pivot Mode enabled.",
      chartSettingsToolbarTooltip: "Menu",
      chartLinkToolbarTooltip: "Linked to Grid",
      chartUnlinkToolbarTooltip: "Unlinked from Grid",
      chartDownloadToolbarTooltip: "Download Chart",

      // ARIA
      ariaHidden: "hidden",
      ariaVisible: "visible",
      ariaChecked: "checked",
      ariaUnchecked: "unchecked",
      ariaIndeterminate: "indeterminate",
      ariaColumnSelectAll: "Toggle Select All Columns",
      ariaInputEditor: "Input Editor",
      ariaDateFilterInput: "Date Filter Input",
      ariaFilterInput: "Filter Input",
      ariaFilterColumnsInput: "Filter Columns Input",
      ariaFilterValue: "Filter Value",
      ariaFilterFromValue: "Filter from value",
      ariaFilterToValue: "Filter to value",
      ariaFilteringOperator: "Filtering Operator",
      ariaColumnToggleVisibility: "column toggle visibility",
      ariaColumnGroupToggleVisibility: "column group toggle visibility",
      ariaRowSelect: "Press SPACE to select this row",
      ariaRowDeselect: "Press SPACE to deselect this row",
      ariaRowToggleSelection: "Press Space to toggle row selection",
      ariaRowSelectAll: "Press Space to toggle all rows selection",
      ariaSearch: "Pretraga",
      ariaSearchFilterValues: "Search filter values",
    };
     this.frameworkComponents = {
      btnCellRenderer: BtnCellRenderer,
    };
  },

  computed: {
    getTemKm: function () {
      if (this.gridApi) {
      this.tempKm = 0;

      this.gridApi.forEachNodeAfterFilterAndSort((rowNode, index) => {
        this.tempKm = this.tempKm + Number(rowNode.data.iznoskm);
      });
      return parseFloat(this.tempKm).toFixed(2)
      }
    },
    getTempEU: function () {
      if (this.gridApi) {
      this.tempEU = 0;

      this.gridApi.forEachNodeAfterFilterAndSort((rowNode, index) => {
        this.tempEU = this.tempEU + Number(rowNode.data.iznoseur);
      });
      return parseFloat(this.tempEU).toFixed(2)
      }
    },
    getTempVozila: function () {
      if (this.gridApi) {
        this.tempVozila = 0;

        this.gridApi.forEachNodeAfterFilterAndSort((rowNode, index) => {
          this.tempVozila = this.tempVozila + Number(rowNode.data.vozila);
        });
        return this.tempVozila
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
    filt: function() {
      alert("vvassds")
    },
    onSelectionChanged() {
      var selectedRows = this.gridApi.getSelectedRows();
      this.product=selectedRows
      console.log(this.product)
    },
    exportCsv() {
      this.getTotal();
      this.gridApi.exportDataAsCsv({
        customFooter:
          "\nUkupno, , , ,,," +
          this.tempVozila +
          "," +
          parseFloat(this.tempKm).toFixed(2) +
          "," +
          parseFloat(this.tempEU).toFixed(2) +
          "",
      });
    },
    getTotal() {
      this.tempKm = 0;
      this.tempEU = 0;
      this.tempVozila = 0;

      this.gridApi.forEachNodeAfterFilterAndSort((rowNode, index) => {
        console.log("node " + rowNode.data.naziv + " is in the grid");
        this.tempKm = this.tempKm + Number(rowNode.data.iznoskm);
        this.tempEU = this.tempEU + Number(rowNode.data.iznoseur);
        this.tempVozila = this.tempVozila + Number(rowNode.data.vozila);
      });
    },
    updateSearchQuery(val) {
      this.gridApi.setQuickFilter(val);
    },
    getProfileImage(pictures) {
      var result = pictures.filter(function (picture) {
        return picture.type === 1;
      });
      if (result.length > 0) {
        return result[0].urlImage;
      } else {
        return "images/pages/404.png";
      }
    },
    getNalozi() {
      this.$http
        .get("/api/auth/nalozi", {
          headers: {
            Authorization: "Bearer" + localStorage.getItem("accessToken"),
          },
        })
        .then((response) => {
          this.products = response.data.results;
          console.log(this.products);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    addNewData() {
      this.sidebarData = {};
      this.toggleDataSidebar(true);
    },
    deleteData(id) {
      this.$store.dispatch("dataList/removeItem", id).catch((err) => {
        console.error(err);
      });
    },
    editData() {
      // this.sidebarData = JSON.parse(JSON.stringify(this.blankData))
      this.sidebarData = this.product[0];
      this.toggleDataSidebar(true);
    },
    getOrderStatusColor(status) {
      if (status === "on_hold") return "warning";
      if (status === "delivered") return "success";
      if (status === "canceled") return "danger";
      return "primary";
    },
    getPopularityColor(num) {
      if (num > 90) return "success";
      if (num > 70) return "primary";
      if (num >= 50) return "warning";
      if (num < 50) return "danger";
      return "primary";
    },
    toggleDataSidebar(val = false) {
      this.addNewDataSidebar = val;
    },
  },
  created() {
    this.lct = localStorage.getItem("accessToken");

    this.getNalozi();

    if (!moduleDataList.isRegistered) {
      this.$store.registerModule("dataList", moduleDataList);
      moduleDataList.isRegistered = true;
    }
    this.$store.dispatch("dataList/fetchDataListItems");
  },
  mounted() {
     let spans = document.querySelectorAll('span');

    spans.forEach(el => {
      el.addEventListener('click', this.editData);
    })
        this.gridApi = this.gridOptions.api;

    this.isMounted = true;
  },
};
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
