
<template>
  <div ref="document1" id="invoice-page">
   
      <!-- INVOICE CONTENT -->
      <div ref="content" class="p-base">
        <div class="p-3 vx-row p-3">
          <div class="vx-col p-0 w-1/4 boxn-data">
            <p class="bg-titme">Br. Vozila</p>
            <p class="bg-cont">{{ ukupnoVozila }}</p>
          </div>

          <div
            v-if="products[0].polaziste"
            class="vx-col pl-1 p-0 w-1/4 boxn-data"
          >
            <p class="bg-titme">Polaziste</p>
            <p class="bg-cont">{{ products[0].polaziste }}</p>
          </div>
          <div
            v-if="products[0].vozac1"
            class="pl-1 vx-col p-0 w-1/4 boxn-data"
          >
            <p class="bg-titme">Datum utovara</p>
            <p class="bg-cont">{{ products[0].datumutovara }}</p>
          </div>
        </div>

        <div class="p-3 vx-row">
          <div v-if="products[0].vozac1" class="vx-col p-0 w-1/4 boxn-data">
            <p class="bg-titme">Vozač 1</p>
            <p class="bg-cont">{{ products[0].vozac1 }}</p>
          </div>
          <div
            v-if="products[0].vozac2"
            class="vx-col p-0 w-1/4 pl-1 boxn-data"
          >
            <p class="bg-titme">Vozač 2</p>
            <p class="bg-cont">{{ products[0].vozac2 }}</p>
          </div>
          <div
            v-if="products[0].kamion"
            class="vx-col p-0 w-1/4 pl-1 boxn-data"
          >
            <p class="bg-titme">Kamion</p>
            <p class="bg-cont">{{ products[0].kamion }}</p>
          </div>
          <div
            v-if="products[0].prikolica"
            class="vx-col p-0 w-1/4 pl-1 boxn-data"
          >
            <p class="bg-titme">Prikolica</p>
            <p class="bg-cont">{{ products[0].prikolica }}</p>
          </div>
        </div>
        <div ref="utovar" class="vx-col w-full mt-3">
          <h4>Utovar</h4>
          <vs-table hoverFlat :data="invoiceData.tasks">
            <!-- HEADER -->
            <template slot="thead">
              <vs-th class="pointer-events-none">#</vs-th>
              <vs-th class="pointer-events-none">Broj vozila</vs-th>
              <vs-th class="pointer-events-none">Adresa</vs-th>
              <vs-th class="pointer-events-none">Grad</vs-th>
              <vs-th class="pointer-events-none">Drzava</vs-th>
            </template>

            <!-- DATA -->

            <template
              :class="(index + 2) % 2 === 0 ? 'sverow' : ''"
              v-for="(utovar, index) in utovari"
            >
              <vs-tr
                :class="
                  (index + 1) % 2 === 0
                    ? 'rowui'
                    : '' && (index + 2) % 2 === 0
                    ? 'prva'
                    : ''
                "
                :key="utovar.id"
              >
                <vs-td utovar:index="">{{ index + 1 }}.</vs-td>
                <vs-td utovar:utovar.vozila="">{{ utovar.vozila }}</vs-td>
                <vs-td utovar:utovar.adresa="">{{ utovar.adresa }}</vs-td>
                <vs-td utovar:utovar.grad="">{{ utovar.grad }}</vs-td>
                <vs-td utovar:utovar.drzava="">{{ utovar.drzava }}</vs-td>
              </vs-tr>

              <vs-tr
                :class="(index + 1) % 2 === 0 ? 'rowui zadnja' : 'zadnja'"
                :key="index+100"
              >
                <vs-td colspan="5" utovar:utovar.drzava="">
                  <feather-icon
                    icon="AlertIcon"
                    svgClasses="h-4 w-4"
                  ></feather-icon
                  >Napomena: {{ utovar.napomena }}</vs-td
                >
              </vs-tr>
            </template>
          </vs-table>
        </div>
        <div class="vx-col w-full mt-3">
          <h4>Istovar</h4>
          <vs-table hoverFlat :data="invoiceData.tasks">
            <!-- HEADER -->
            <template slot="thead">
              <vs-th class="pointer-events-none">#</vs-th>
              <vs-th class="pointer-events-none">Broj vozila</vs-th>
              <vs-th class="pointer-events-none">Adresa</vs-th>
              <vs-th class="pointer-events-none">Grad</vs-th>
              <vs-th class="pointer-events-none">Drzava</vs-th>
            </template>

            <!-- DATA -->

            <template
              :class="(index + 2) % 2 === 0 ? 'sverow' : ''"
              v-for="(utovar, index) in istovari"
            >
              <vs-tr
                :class="
                  (index + 1) % 2 === 0
                    ? 'rowui'
                    : '' && (index + 2) % 2 === 0
                    ? 'prva'
                    : ''
                "
                :key="utovar.id"
              >
                <vs-td utovar:index="">{{ index + 1 }}.</vs-td>
                <vs-td utovar:utovar.vozila="">{{ utovar.vozila }}</vs-td>
                <vs-td utovar:utovar.adresa="">{{ utovar.adresa }}</vs-td>
                <vs-td utovar:utovar.grad="">{{ utovar.grad }}</vs-td>
                <vs-td utovar:utovar.drzava="">{{ utovar.drzava }}</vs-td>
              </vs-tr>

              <vs-tr
                :class="(index + 1) % 2 === 0 ? 'rowui zadnja' : 'zadnja'"
                :key="utovar.id+2000"
              >
                <vs-td colspan="5" utovar:utovar.drzava="">
                  <feather-icon
                    icon="AlertIcon"
                    svgClasses="h-4 w-4"
                  ></feather-icon
                  >Napomena: {{ utovar.napomena }}</vs-td
                >
              </vs-tr>
            </template>
          </vs-table>
        </div>
        <!-- INVOICE TASKS TABLE -->
        <div class="p-3 vx-row">
          <div class="vx-col p-0 w-full boxn-data">
            <p class="bg-titme">Izvozno carinjenje</p>
            <p class="bg-cont">{{ products[0].izvoznocarinjenje }}</p>
          </div>
        </div>
        <div class="p-3 vx-row">
          <div class="vx-col p-0 w-full boxn-data">
            <p class="bg-titme">Granični prijelaz (špedicija)</p>
            <p class="bg-cont">{{ products[0].grprelaz }}</p>
          </div>
        </div>
        <div class="p-3 vx-row">
          <div class="vx-col p-0 w-full boxn-data">
            <p class="bg-titme">Uvozno uvoznocarinjenje</p>
            <p class="bg-cont">{{ products[0].grprelaz }}</p>
          </div>
        </div>

        <div class="p-3 vx-row">
          <div class="vx-col p-0 w-full boxn-data">
            <p class="bg-titme">Kontakt</p>
            <p class="bg-cont">{{ products[0].kontakt }}</p>
          </div>
        </div>
        <div class="p-3 vx-row">
          <div class="vx-col p-0 w-full boxn-data">
            <p class="bg-titme">Google Maps</p>
            <p class="bg-cont">
              <a :href="'http://maps.google.com'">{{ products[0].gmaplink }}</a>
            </p>
          </div>
        </div>

        <div class="p-3 vx-row">
          <div class="vx-col p-0 w-full boxn-data">
            <p class="bg-titme">Napomena</p>
            <p class="bg-cont">{{ products[0].napomene }}</p>
          </div>
        </div>

        <div class="p-3 vx-row">
          <div class="vx-col p-0 w-full boxn-data">
            <p class="bg-titme">Komitent</p>
            <p class="bg-cont">
              {{ products[0].kompanija.name }} -
              {{ products[0].kompanija.address }},
              {{ products[0].kompanija.city }} {{ products[0].kompanija.state }}
            </p>
          </div>
        </div>

        <div class="p-3 vx-row">
          <div class="vx-col p-0 w-full boxn-data">
            <p class="bg-titme">Iznos</p>
            <p class="bg-cont">
              {{ products[0].iznoseur }} EUR / {{ products[0].iznoskm }} KM
            </p>
          </div>
        </div>
        <div class="flex flex-wrap items-center justify-between">
          <div class="flex items-center">
            <vs-button
              class="	d-none d-sm-block d-md-none mb-base mr-3"
              type="border"
              icon-pack="feather"
              icon="icon icon-download"
              @click="downloadWithCSS"
              >Preuzmi</vs-button
            >
            <vs-button
              class="mb-base mr-3"
              icon-pack="feather"
              icon="icon icon-file"
              @click="printInvoice"
              >Printaj</vs-button
            >
          </div>
        </div>
      </div>
     <div>
     <vue-html2pdf
        :show-layout="false"
        :float-layout="true"
        :enable-download="true"
        :preview-modal="true"
        :paginate-elements-by-height="1400"
        filename="hee hee"
        :pdf-quality="2"
        :manual-pagination="false"
        pdf-format="a4"
        pdf-orientation="landscape"
        pdf-content-width="800px"

        @progress="onProgress($event)"
        @hasStartedGeneration="hasStartedGeneration()"
        @hasGenerated="hasGenerated($event)"
        ref="html2Pdf"
    >
        <section slot="pdf-content">
           <div class="vx-col w-full mt-3">
          <h4>Istovar</h4>
          <vs-table hoverFlat :data="invoiceData.tasks">
            <!-- HEADER -->
            <template slot="thead">
              <vs-th class="pointer-events-none">#</vs-th>
              <vs-th class="pointer-events-none">Broj vozila</vs-th>
              <vs-th class="pointer-events-none">Adresa</vs-th>
              <vs-th class="pointer-events-none">Grad</vs-th>
              <vs-th class="pointer-events-none">Drzava</vs-th>
            </template>

            <!-- DATA -->

            <template
              :class="(index + 2) % 2 === 0 ? 'sverow' : ''"
              v-for="(utovar, index) in istovari"
            >
              <vs-tr
                :class="
                  (index + 1) % 2 === 0
                    ? 'rowui'
                    : '' && (index + 2) % 2 === 0
                    ? 'prva'
                    : ''
                "
                :key="utovar.id"
              >
                <vs-td utovar:index="">{{ index + 1 }}.</vs-td>
                <vs-td utovar:utovar.vozila="">{{ utovar.vozila }}</vs-td>
                <vs-td utovar:utovar.adresa="">{{ utovar.adresa }}</vs-td>
                <vs-td utovar:utovar.grad="">{{ utovar.grad }}</vs-td>
                <vs-td utovar:utovar.drzava="">{{ utovar.drzava }}</vs-td>
              </vs-tr>

              <vs-tr
                :class="(index + 1) % 2 === 0 ? 'rowui zadnja' : 'zadnja'"
                :key="utovar.id+2000"
              >
                <vs-td colspan="5" utovar:utovar.drzava="">
                  <feather-icon
                    icon="AlertIcon"
                    svgClasses="h-4 w-4"
                  ></feather-icon
                  >Napomena: {{ utovar.napomena }}</vs-td
                >
              </vs-tr>
            </template>
          </vs-table>
        </div>
        </section>
    </vue-html2pdf>
   </div>
  </div>
  
</template>

<script>
 
import html2pdf from "html2pdf.js";
import VueHtml2pdf from 'vue-html2pdf'

export default {
  data() {
    return {
      mailTo: "",
      ukupnoVozila: 0,
      products: [],
      utovari: [],
      istovari: [],
      companyDetails: {
        name: "Microsion Technologies Pvt. Ltd.",
        addressLine1: "9 N. Sherwood Court",
        addressLine2: "Elyria, OH",
        zipcode: "94203",
        mailId: "hello@pixinvent.net",
        mobile: "+91 999 999 9999",
      },

      invoiceDetails: {
        invoiceNo: "001/2019",
        invoiceDate: "Mon Dec 10 2018 07:46:00 GMT+0000 (GMT)",
      },
      invoiceData: {
        tasks: [
          {
            id: 1,
            task: "Website Redesign",
            hours: 60,
            rate: 15,
            amount: 90000,
          },
          {
            id: 2,
            task: "Newsletter template design",
            hours: 20,
            rate: 12,
            amount: 24000,
          },
        ],
        subtotal: 114000,
        discountPercentage: 5,
        discountedAmount: 5700,
        total: 108300,
      },
    };
  },
  methods: {
    parseUtoIsto() {
      this.products[0].utovaristovar.forEach((element) => {
        if (element.tip === 0) {
          this.utovari.push(element);
          this.ukupnoVozila = this.ukupnoVozila + element.vozila;
        } else {
          this.istovari.push(element);
        }
      });
    },
    getNalozi() {
      this.$http
        .post("/api/auth/nalozi", {
          hsh: this.$route.params.nalogId,

          headers: {
            Authorization: "Bearer" + localStorage.getItem("accessToken"),
          },
        })
        .then((response) => {
          this.products = response.data.results;
          console.log(this.products);
          this.parseUtoIsto();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    downloadWithCSS() {
      html2pdf(this.$refs.document1, {
        margin: 1,
        filename: "nalog-" + this.$route.params.nalogId + ".pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { dpi: 192, letterRendering: true },
        jsPDF: { unit: "cm", format: "letter", orientation: "landscape" },
      });
    },
    downloadPDF() {
      window.print();
    },
    printInvoice() {
      window.print();
    },
  },
    components: {
        VueHtml2pdf
    },
  created() {
    this.getNalozi();
  },
};
</script>

<style lang="scss">
[dir] p {
  margin-top: 0;
  margin-bottom: 0rem;
}
@media print {
  .invoice-page {
    * {
      visibility: hidden;
    }

    #content-area {
      margin: 0 !important;
    }

    .vs-con-table {
      .vs-con-tbody {
        overflow: hidden !important;
      }
    }

    #invoice-container,
    #invoice-container * {
      visibility: visible;
    }
    #invoice-container {
      position: absolute;
      left: 0;
      top: 0;
      box-shadow: none;
    }
  }
}

@page {
  size: auto;
}
</style>
