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
        {{ Object.entries(this.data).length === 0 ? "Dodaj" : "Izmjeni" }}
        Nalog
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
      <vx-card class="mt-2" title="Info" title-color="primary">
        <div class="p-6 flex w-full bg-img vx-row">
          <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-1/4">
            <label for="example-datepicker">Naziv naloga</label>
            <vs-input
              v-model="nalogdata.naziv"
              placeholder="Tura SLO"
              class="w-full"
              v-validate="'required'"
            />
          </div>

          <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-1/4">
            <label for="example-datepicker">Polazište</label>
            <vs-input
              v-model="nalogdata.polaziste"
              placeholder="npr. Klokotnica"
              class="w-full"
              v-validate="'required'"
            />
          </div>
          <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-1/4">
            <label for="datepicker-lg">Datum utovara</label>
            <b-form-datepicker
              id="datepicker-lg"
              placeholder="Izaberi datum"
              :date-format-options="{
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
              }"
              v-model="nalogdata.datumutovara"
              size="lg"
              locale="hr-HR"
            ></b-form-datepicker>
          </div>
          <div class="vx-col sm:w-1/4 md:w-1/4 lg:w-1/8">
            <label for="example-datepicker">LF</label>
            <vs-input
              v-model="nalogdata.vozila"
              class="w-full"
              readonly
              v-validate="'required'"
            />
          </div>
          <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-1/4">
            <label for="example-datepicker">Vozač 1</label>
            <vs-input
              v-model="nalogdata.vozac1"
              placeholder="npr. Ime i Prezime"
              class="w-full"
              v-validate="'required'"
            />
          </div>
          <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-1/4">
            <label for="example-datepicker">Vozač 2</label>
            <vs-input
              v-model="nalogdata.vozac2"
              placeholder="npr. Ime i Prezime"
              class="w-full"
              v-validate="'required'"
            />
          </div>
          <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-1/4">
            <label for="example-datepicker">Kamion</label>
            <vs-input
              v-model="nalogdata.kamion"
              placeholder="npr. Man 11t-O-112"
              class="w-full"
              v-validate="'required'"
            />
          </div>
          <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-1/4">
            <label for="example-datepicker">Prikolica</label>
            <vs-input
              v-model="nalogdata.prikolica"
              placeholder=""
              class="w-full"
              v-validate="'required'"
            />
          </div>
        </div>
      </vx-card>
      <vx-card class="mt-2" title="Utovar" title-color="primary">
        <div
          class="flex p-4 w-full bg-img vx-row"
          v-for="(input, k) in nalogdata.kompod"
          :key="k"
        >
          <div class="flex w-full bg-img vx-row vx-utoist">
            <div class="vx-col sm:w-1/3 md:w-2/5 lg:w-1/12">
              <vs-input
                label="#LF"
                v-model="input.vozila"
                v-on:change="addVozila(input.vozila)"
                placeholder=""
                class="w-full"
                v-validate="'required'"
              />
            </div>
            <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-1/5">
              <vs-input
                label="Adresa"
                v-model="input.adresa"
                placeholder=""
                class="w-full"
                v-validate="'required'"
              />
            </div>
            <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-1/5">
              <vs-input
                label="Grad"
                v-model="input.grad"
                placeholder=""
                class="w-full"
                v-validate="'required'"
              />
            </div>
            <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-4/12">
              <label for="datepicker-lg">Država</label>
              <v-select
                label="label"
                placeholder="Drzava"
                v-model="input.drzava"
                size="lg"
                :value="optionsCountry.value"
                :options="optionsCountry"
                class="lg w-full tet"
              >
              </v-select>
            </div>

            <div class="vx-col w-10/12">
              <label for="datepicker-lg">Napomena</label>
              <vs-textarea
                v-model="input.napomena"
                placeholder="Reference, vozilo, broj šasije, tablice"
                class="w-full"
                v-validate="'required'"
              />
            </div>
            <div class="vx-col w-2/12">
              <vs-button
                size="small"
                class="bg-warning"
                @click="removeod(k)"
                v-show="k || (!k && nalogdata.kompod.length > 1)"
                >-</vs-button
              >
              <vs-button
                size="small"
                @click="addod(k)"
                v-show="k == nalogdata.kompod.length - 1"
                >+</vs-button
              >
            </div>
          </div>
        </div>
      </vx-card>
      <vx-card class="mt-2" title="Istovar" title-color="primary">
        <div
          class="flex p-4 w-full bg-img vx-row vx-utoist"
          v-for="(input, k) in nalogdata.kompdo"
          :key="k"
        >
          <div class="flex w-full bg-img vx-row">
            <div class="vx-col sm:w-1/3 md:w-2/5 lg:w-1/12">
              <vs-input
                label="#LF"
                v-model="input.vozila"
                placeholder=""
                class="w-full"
                v-validate="'required'"
              />
            </div>
            <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-1/5">
              <vs-input
                label="Adresa"
                v-model="input.adresa"
                placeholder=""
                class="w-full"
                v-validate="'required'"
              />
            </div>
            <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-1/5">
              <vs-input
                label="Grad"
                v-model="input.grad"
                placeholder=""
                class="w-full"
                v-validate="'required'"
              />
            </div>
            <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-4/12">
              <label for="datepicker-lg">Država</label>
              <v-select
                label="label"
                placeholder="Drzava"
                v-model="input.drzava"
                size="lg"
                :value="optionsCountry.value"
                :options="optionsCountry"
                class="lg w-full tet"
              >
              </v-select>
            </div>

            <div class="vx-col w-10/12">
              <label for="datepicker-lg">Napomena</label>
              <vs-textarea
                v-model="input.napomena"
                placeholder="Reference, vozilo, broj šasije, tablice"
                class="w-full"
                v-validate="'required'"
              />
            </div>
            <div class="vx-col w-2/12">
              <vs-button
                size="small"
                class="bg-warning"
                @click="removedo(k)"
                v-show="k || (!k && nalogdata.kompdo.length > 1)"
                >-</vs-button
              >
              <vs-button
                size="small"
                @click="adddo(k)"
                v-show="k == nalogdata.kompdo.length - 1"
                >+</vs-button
              >
            </div>
          </div>
        </div>
      </vx-card>
      <vx-card class="mt-2" title="Komitent/Finansije" title-color="primary">
        <div class="p-6 flex w-full bg-img vx-row">
          <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-4/12">
            <label for="datepicker-lg">Komitent</label>
            <v-select
              label="name"
              placeholder="Komitent"
              v-model="nalogdata.komitent"
              @input="changedValue"
              size="lg"
              :value="kompanije.id"
              :options="kompanije"
              class="lg w-full tet"
            >
            </v-select>
          </div>
          <div class="vx-col sm:w-1/3 md:w-1/3 lg:w-2/12">
            <vs-input
              label="Broj fakture"
              v-model="nalogdata.brfak"
              placeholder="INV-123222"
              class="w-full"
              v-validate="'required'"
            />
          </div>
          <div class="vx-col sm:w-1/3 md:w-1/3 lg:w-2/12">
            <vs-input
              label="Iznos KM"
              v-model="nalogdata.iznoskm"
              @change="changeKM()"
              placeholder="3211"
              class="w-full"
              v-validate="'required'"
            />
          </div>
          <div class="vx-col sm:w-1/3 md:w-1/3 lg:w-2/12">
            <vs-input
              label="Iznos EUR"
              v-model="nalogdata.iznoseur"
              @change="changeEUR()"
              placeholder="3211"
              class="w-full"
              v-validate="'required'"
            />
          </div>
          <div class="vx-col sm:w-1/3 md:w-1/3 lg:w-1/12">
            <vs-input
              type="checkbox"
              label="Plaćena"
              v-model="nalogdata.placena"
            />
          </div>

          <div class="vx-col mt-5 w-full">
            <vs-textarea
              label="Izvozno carinjenje"
              v-model="nalogdata.izvoznocarinjenje"
              placeholder="Upute za izvozno carinjenje"
              class="w-full"
              v-validate="'required'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('izvoznocarinjenje')"
              >{{ errors.first("izvoznocarinjenje") }}</span
            >
          </div>
          <div class="vx-col w-full">
            <vs-textarea
              label="Granični prijelaz (špedicija)"
              v-model="nalogdata.grprelaz"
              placeholder="Upute za Granični prijelaz (špedicija)"
              class="w-full"
              v-validate="'required'"
            />
            <span class="text-danger text-sm" v-show="errors.has('grprelaz')">{{
              errors.first("grprelaz")
            }}</span>
          </div>
          <div class="vx-col w-full">
            <vs-textarea
              label="Uvozno carinjenje"
              v-model="nalogdata.uvoznocarinjenje"
              placeholder="Upute za uvozno carinjenje"
              class="w-full"
              v-validate="'required'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('uvoznocarinjenje')"
              >{{ errors.first("uvoznocarinjenje") }}</span
            >
          </div>
          <div class="vx-col w-full">
            <v-select
              v-if="kontaktiLista"
              v-model="nalogdata.kontakt"
              :options="kontaktiLista"
            />
          </div>
        </div>
      </vx-card>
      <vx-card class="mt-2" title="Detalji" title-color="primary">
        <div class="p-6 flex w-full bg-img vx-row">
          <div class="vx-col w-full">
            <vs-input
              label="GMAP ruta - link"
              v-model="nalogdata.gmaplink"
              placeholder="Kopiran URL sa google map"
              class="mt-5 w-full"
              v-validate="'required'"
            />
          </div>
          <div class="vx-col w-full">
            <vs-textarea
              label="Napomene"
              v-model="nalogdata.napomene"
              placeholder="Dodatne napomene"
              class="mt-5 w-full"
              v-validate="'required'"
            />
            <span class="text-danger text-sm" v-show="errors.has('napomene')">{{
              errors.first("napomene")
            }}</span>
          </div>
        </div>
      </vx-card>
    </component>

    <div class="flex flex-wrap items-center p-6" slot="footer">
      <vs-button class="mr-3" @click="addNalog()" :disabled="!isFormValid"
        >Snimi</vs-button
      >

      <vs-button
        type="border"
        class=""
        color="danger"
        @click="
          isSidebarActiveLocal = false;
          initValues();
        "
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
      value: "",
      formatted: "",
      kontaktiLista: [],
      selected: "",
      provjera: false,
      provjera2: false,
      iznoskm: null,
      kompanije: [],
      nalozi: [],

      iznoseur: null,
      location: { lng: null, lat: null },
      nalogdata: {
        vozila: 0,
        naziv: null,
        vozac1: "",
        vozac2: "",
        kamion: "",
        komitent: null,
        prikolica: "",
        placena: null,
        polaziste: null,
        iznoskm: null,
        iznoseur: null,
        brfak: "",
        izvoznocarinjenje: "",
        grprelaz: "",
        uvoznocarinjenje: "",
        kontakt: "",
        napomene: "",
        gmaplink: "",
        proizvodjac: "",
        datumutovara: null,
        brvozila: null,
        kompod: [
          {
            vozila: "",
            lokacija: "",
            adresa: "",
            grad: "",
            drzava: "",
            napomena: "",
          },
        ],
        kompdo: [
          {
            vozila: "",
            lokacija: "",
            adresa: "",
            grad: "",
            drzava: "",
            napomena: "",
          },
        ],
      },
      model: "",
      tablica: "",
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

      settings: {
        // perfectscrollbar settings
        maxScrollbarLength: 60,
        wheelSpeed: 0.6,
      },
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
    };
  },
  watch: {
    isSidebarActive(val) {
      if (!val) return;
      if (Object.entries(this.data).length === 0) {
        this.initValues();
        this.$validator.reset();
      } else {
        console.log(this.data);
        const {
          id,
          grprelaz,
          utovaristovar,
          brvozila,
          gmaplink,
          kompanija,
          datumutovara,
          brfak,
          iznoskm,
          iznoseur,
          izvoznocarinjenje,
          prikolica,
          polaziste,
          placena,
          napomene,
          kontakt,
          vozila,
          naziv,
          vozac1,
          vozac2,
          kamion,
          uvoznocarinjenje,
          proizvodjac,
          model,
          tablica,
        } = JSON.parse(JSON.stringify(this.data));
        this.dataId = id;

        this.nalogdata.vozila = vozila;
        this.nalogdata.naziv = naziv;
        this.nalogdata.vozac1 = vozac1;
        this.nalogdata.vozac2 = vozac2;
        this.nalogdata.kamion = kamion;
        this.nalogdata.komitent = kompanija;
        this.nalogdata.prikolica = prikolica;
        this.nalogdata.placena = placena;
        this.nalogdata.polaziste = polaziste;
        this.nalogdata.iznoskm = iznoskm;
        let app = this;
        let ut = 0;
        let is = 0;
        app.nalogdata.kompod = [];
        app.nalogdata.kompdo = [];
        utovaristovar.forEach(function (message) {
          if (message.tip == 0) {
            app.nalogdata.kompod.push({
              lokacije: "",
              vozila: message.vozila,
              adresa: message.adresa,
              grad: message.grad,
              drzava: { value: message.drzava, label: message.drzava },
              napomena: message.napomena,
            });
            ut++;
          } else {
            app.nalogdata.kompdo.push({
              lokacije: "",
              vozila: message.vozila,
              adresa: message.adresa,
              grad: message.grad,
              drzava: { value: message.drzava, label: message.drzava },
              napomena: message.napomena,
            });
            is++;
          }
        });
        if (ut == 0) {
          app.addod();
        }
        if (is == 0) {
          app.adddo();
        }
        this.nalogdata.iznoseur = iznoseur;
        this.nalogdata.brfak = brfak;
        this.nalogdata.izvoznocarinjenje = izvoznocarinjenje;
        this.nalogdata.grprelaz = grprelaz;
        this.nalogdata.uvoznocarinjenje = uvoznocarinjenje;
        this.nalogdata.kontakt = kontakt;
        this.nalogdata.napomene = napomene;
        this.nalogdata.gmaplink = gmaplink;
        this.nalogdata.proizvodjac = proizvodjac;
        this.nalogdata.datumutovara = datumutovara;
        this.nalogdata.brvozila = brvozila;

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
        this.nalogdata.naziv &&
        this.nalogdata.datumutovara &&
        this.nalogdata.vozila &&
        this.nalogdata.vozac1 &&
        this.nalogdata.kamion &&
        this.nalogdata.prikolica &&
        this.nalogdata.prikolica &&
        this.nalogdata.komitent &&
        this.nalogdata.iznoskm &&
        this.nalogdata.kompod.length > 0 &&
        this.nalogdata.polaziste
      );
    },
    scrollbarTag() {
      return this.$store.getters.scrollbarTag;
    },
  },
  created() {
    this.getKompanije();
    this.getNaloge();
  },
  methods: {
    changedValue(value) {
      this.kontaktiLista = value.kontakt.split(";");
      console.log(this.kontaktiLista);
    },
    addVozila(k) {
      this.nalogdata.vozila = Number(k) + Number(this.nalogdata.vozila);
    },
    onContext(ctx) {
      // The date formatted in the locale, or the `label-no-date-selected` string
      this.formatted = ctx.selectedFormatted;
      // The following will be an empty string until a valid date is entered
      this.selected = ctx.selectedYMD;
    },
    addod() {
      this.nalogdata.kompod.push({
        lokacije: "",
        vozila: "",
        adresa: "",
        grad: "",
        drzava: "",
        napomena: "",
      });
    },
    adddo() {
      this.nalogdata.kompdo.push({
        lokacije: "",
        vozila: "",
        adresa: "",
        grad: "",
        drzava: "",
        napomena: "",
      });
    },
    removeod(index) {
      this.nalogdata.kompod.splice(index, 1);
    },
    removedo(index) {
      this.nalogdata.kompdo.splice(index, 1);
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
          console.log(this.kompanije);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getNaloge() {
      this.$http
        .get("/api/auth/nalozi", {
          headers: {
            Authorization: "Bearer" + localStorage.getItem("accessToken"),
          },
        })
        .then((response) => {
          this.nalozi = response.data.results;
          console.log(this.nalozi);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    changeKM() {
      this.nalogdata.iznoseur = (this.nalogdata.iznoskm / 1.95).toFixed(2);
    },
    changeEUR() {
      this.nalogdata.iznoskm = this.nalogdata.iznoseur * 1.95;
    },
    addNalog() {
      let app = this;
      let url = "/api/auth/addnalog";
      if (app.dataId !== null) {
        url = "/api/auth/updatenalog";
      }
      this.$http
        .post(url, {
          id: app.dataId,
          data: app.nalogdata,
        })
        .then(function (response) {
           app.success = true;
           app.initValues();
            app.isSidebarActive = false;
           location.reload();
        })
        .catch(function (res) {
          console.log(res.response.data.errors);
          app.has_error = true;
          app.error = res.response.data.error;
          app.errors = res.response.data.errors || {};
        });
    },
    initValues() {},
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
    width: 70%;
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
