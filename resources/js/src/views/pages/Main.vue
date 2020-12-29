
<template>
  <gmap-map :center="center" :zoom="6" style="width: 100%; height: 500px">
    <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false">
     <h5>{{contentInfo}}</h5> 
     <h6>Utovari:0</h6>
     <h6>Istovari:0</h6>
     <p>Lokacije:</p>

    </gmap-info-window>
    <gmap-marker :key="m.id" v-for="m in kompanije" :position="{lat:parseFloat(m.lat),lng:parseFloat(m.lng)}" :clickable="true" @click="toggleInfoWindow(m)"></gmap-marker>
  </gmap-map>
</template>

<script>
export default {
  data() {
    return {
      center: { lat: 47.403568, lng:  14.1531833},
      infoContent: '',
      kompanije:[],
      contentInfo:'',
      infoWindowPos: null,
      infoWinOpen: false,
      currentMidx: null,
      //optional: offset infowindow so it visually sits nicely on top of our marker
      infoOptions: {
      pixelOffset: { width: 0, height: -35 }
      },
      markers: [
        { position: { lat: 47.376332, lng: 8.547511 }, infoText: 'Marker 1' },
        { position: { lat: 47.374592, lng: 8.548867 }, infoText: 'Marker 2' },
        { position: { lat: 47.379592, lng: 8.549867 }, infoText: 'Marker 3' }
      ]
    }
  },
  methods: {
    
     
      getKompanije(){

     this.$http.get('/api/auth/kompanije', { headers:{
      'Authorization':"Bearer" + localStorage.getItem('accessToken')
    }})
      .then((response) => { this.kompanije=response.data.results 
      console.log(this.kompanije)
      })
      .catch((error)   => { console.log(error) })
      
    },
    toggleInfoWindow(marker) {
      console.log(marker)
      this.infoWindowPos = {lat:parseFloat(marker.lat),lng:parseFloat(marker.lng)};
      this.infoContent = marker.name;
      this.contentInfo=marker.name
      //check if its the same marker that was selected if yes toggle
      if (this.currentMidx == marker.name) {
        this.infoWinOpen = !this.infoWinOpen;
      }
      //if different marker set infowindow to open and reset current marker index
      else {
        this.infoWinOpen = true;
        this.currentMidx = marker.name;
      }
    }
  },
  created(){
    this.getKompanije()
  }
}
</script>
      