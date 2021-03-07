
<template ref="content">
  <div ref="document1" id="invoice-page">
    <!-- INVOICE CONTENT -->
    <div v-if="products[0]" class="p-base">
      <h3 style="text-align: center">NALOG ZA UTOVAR</h3>
      <div class="flex flex-wrap">
        <div
          class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-4 bg-grid-color"
        >
          <div class="contact__info flex flex-col truncate w-5/6">
            <h5 class="font-semibold">Datum utovara:</h5>
            <span class="truncate">{{ products[0].datumutovara }}</span>
          </div>
        </div>
        <div
          class="w-full flex justify-end sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-4 bg-grid-color"
        >
          <div class="contact__info flex flex-col truncate w-3/6">
            <h5 style="text-align: end" class="font-semibold">Kamion:</h5>
            <span class="truncate">{{ products[0].kamion }}</span>
          </div>
        </div>
        <div
          class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-4 bg-grid-color"
        >
          <div class="contact__info flex flex-col truncate w-5/6">
            <h5 v-if="products[0].vozac2 !== '-'" class="font-semibold">
              Vozači:
            </h5>
            <h5 v-if="products[0].vozac2 == '-'" class="font-semibold">
              Vozač:
            </h5>
            <span class="truncate">1. {{ products[0].vozac1 }}</span>
            <span v-if="products[0].vozac2" class="truncate"
              >2. {{ products[0].vozac2 }}</span
            >
          </div>
        </div>

        <div
          class="w-full flex justify-end sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-4 bg-grid-color"
        >
          <div class="contact__info flex flex-col truncate w-3/6">
            <h5 style="text-align: end" class="font-semibold">Prikolica:</h5>
            <span class="truncate">{{ products[0].prikolica }}</span>
          </div>
        </div>
        <div
          class="w-full sm:w-1/1 md:w-1/1 lg:w-1/1 xl:w-1/1 mb-4 bg-grid-color"
        >
          <div class="contact__info flex flex-col truncate w-5/6">
            <h5 class="font-semibold">Br. vozila:</h5>
            <span class="truncate">{{ products[0].vozila }}</span>
          </div>
        </div>
        <div
          class="w-full sm:w-1/1 md:w-1/1 lg:w-1/1 xl:w-1/1 mb-4 bg-grid-color"
        >
          <h5 class="font-semibold">Utovar:</h5>
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Broj vozila</th>
                <th scope="col">Adresa</th>
                <th scope="col">Grad</th>
                <th scope="col">Drzava</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="(utovar, index) in utovari">
                <tr :key="index">
                  <th scope="row">{{ index + 1 }}.</th>
                  <td>{{ utovar.vozila }}</td>
                  <td>{{ utovar.adresa }}</td>
                  <td>{{ utovar.grad }}</td>
                  <td>{{ utovar.drzava }}</td>
                </tr>
                <tr :key="index + 10000">
                  <td colspan="5">
                    <div v-html="utovar.napomena" />
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <div
          class="w-full sm:w-1/1 md:w-1/1 lg:w-1/1 xl:w-1/1 mb-4 bg-grid-color"
        >
          <h5 class="font-semibold">Istovar:</h5>
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Broj vozila</th>
                <th scope="col">Adresa</th>
                <th scope="col">Grad</th>
                <th scope="col">Drzava</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="(utovar, index) in istovari">
                <tr :key="index">
                  <th scope="row">{{ index + 1 }}.</th>
                  <td>{{ utovar.vozila }}</td>
                  <td>{{ utovar.adresa }}</td>
                  <td>{{ utovar.grad }}</td>
                  <td>{{ utovar.drzava }}</td>
                </tr>
                <tr :key="index + 100000">
                  <td colspan="5">
                    <div v-html="utovar.napomena" />
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <div
          class="w-full sm:w-1/1 md:w-1/1 lg:w-1/1 xl:w-1/1 mb-4 bg-grid-color"
        >
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Izvozno carinjenje</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">{{ products[0].izvoznocarinjenje }}</th>
              </tr>
            </tbody>
          </table>
        </div>
        <div
          class="w-full sm:w-1/1 md:w-1/1 lg:w-1/1 xl:w-1/1 mb-4 bg-grid-color"
        >
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Granični prijelaz (špedicija)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">{{ products[0].grprelaz }}</th>
              </tr>
            </tbody>
          </table>
        </div>
        <div
          class="w-full sm:w-1/1 md:w-1/1 lg:w-1/1 xl:w-1/1 mb-4 bg-grid-color"
        >
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Uvozno carinjenje</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">{{ products[0].uvoznocarinjenje }}</th>
              </tr>
            </tbody>
          </table>
        </div>
        <div
          class="w-full sm:w-1/1 md:w-1/1 lg:w-1/1 xl:w-1/1 mb-4 bg-grid-color"
        >
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Google Maps</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">
                  <a :href="products[0].gmaplink">{{ products[0].gmaplink }}</a>
                </th>
              </tr>
            </tbody>
          </table>
        </div>

        <div
          class="w-full sm:w-1/1 md:w-1/1 lg:w-1/1 xl:w-1/1 mb-4 bg-grid-color"
        >
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Napomena:</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row"><div v-html="products[0].napomene" /></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div v-if="!printing" class="flex flex-wrap items-center justify-between">
        <div class="flex items-center btnss">
          <vs-button
            class="preuzmibtn1 mb-base mr-3"
            type="border"
            icon-pack="feather"
            icon="icon icon-download"
            @click="generatePdf"
            >Preuzmi</vs-button
          >
          <vs-button
            class="mb-base mr-3 d-none d-lg-block d-xl-block"
            icon-pack="feather"
            icon="icon icon-file"
            @click="printInvoice"
            >Printaj</vs-button
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import html2pdf from "html2pdf.js";
import VueHtml2pdf from "vue-html2pdf";
import jsPDF from "jspdf";

export default {
  data() {
    return {
      mailTo: "",
      printing: false,
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
          this.parseUtoIsto();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    generatePdf() {
      this.printing = true;
      let app=this
      const doc = new jsPDF("l", "pt", "a4", false);
      doc.html(document.body, {
        callback: function (doc) {
          doc.setFontSize(10);
          doc.save();
          app.printing = false
        },
        margin: [0, 0, 0, 0],
        x: 0,
        y: 0,
      });

      // doc.save('myPdf')
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
    VueHtml2pdf,
  },
  created() {},
  beforeMount() {
    this.getNalozi();
  },
};
</script>

<style lang="scss">
#invoice-page {
  max-width: 791px;
}
[dir] p {
  margin-top: 0;
  margin-bottom: 0rem;
}
@media print {
  #invoice-page {
  max-width: 1280px;
}
  .btnss {
    display: none !important;
  }
  .thead-dark th {
    background-color: #000 !important;
    color: white !important;
    -webkit-print-color-adjust: exact;
  }
}

@media print {
  @page {
    size: auto;
    margin: 0;
  }
  .vendorListHeading th {
    color: white !important;
  }
}

@page {
  size: auto;
}
</style>
