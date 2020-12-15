<template>
  <div>
    <vs-input
        v-validate="'required|email|min:3'"
        data-vv-validate-on="blur"
        name="email"
        icon-no-border
        icon="icon icon-user"
        icon-pack="feather"
        label-placeholder="Email"
        v-model="email"
        class="w-full"/>
    <span class="text-danger text-sm">{{ errors.first('email') }}</span>

    <vs-input
        data-vv-validate-on="blur"
        v-validate="'required|min:6'"
        type="password"
        name="password"
        icon-no-border
        icon="icon icon-lock"
        icon-pack="feather"
        label-placeholder="Password"
        v-model="password"
        class="w-full mt-6" />
    <span class="text-danger text-sm">{{ errors.first('password') }}</span>

    <div class="flex flex-wrap justify-between my-5">
        
        <router-link v-if="1==2" to="/pages/forgot-password">Zaboravljena šifra?</router-link>
    </div>
    <div class="flex flex-wrap justify-between mb-3">
      
      <vs-button :disabled="!validateForm" @click="loginJWT">Prijava</vs-button>
       <router-link   to="/" class="vx-logo cursor-pointer mx-auto flex items-center">
        
        <span class="vx-logo-text text-primary">OFFER-X</span>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      email: '',
      password: '',
      checkbox_remember_me: false
    }
  },
  computed: {
    validateForm () {
      return !this.errors.any() && this.email !== '' && this.password !== ''
    }
  },
  methods: {
    checkLogin () {
      // If user is already logged in notify
      if (this.$store.state.auth.isUserLoggedIn()) {

        // Close animation if passed as payload
        // this.$vs.loading.close()


        this.$vs.notify({
          title: 'Pokušaj prijave',
          text: 'Već ste prijavljeni!',
          iconPack: 'feather',
          icon: 'icon-alert-circle',
          color: 'warning'
        })
  this.$router.push('/').catch(() => {})
        return false
      }
      return true
    },
    loginJWT () {

      if (!this.checkLogin()) return

      // Loading
      this.$vs.loading()

      const payload = {
        checkbox_remember_me: this.checkbox_remember_me,
        userDetails: {
          email: this.email,
          password: this.password
        }
      }

      this.$store.dispatch('auth/loginJWT', payload)
        .then(() => { 
          this.$vs.loading.close()
              this.$router.push('/narudzbe')
              return false
          
           })
        .catch(error => {
          this.$vs.loading.close()
          this.$vs.notify({
            title: 'Error',
            text: error.message,
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          })
        })
        
    },
    registerUser () {
      if (!this.checkLogin()) return
      this.$router.push('/pages/register').catch(() => {})
    }
  }
}

</script>

